<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Baseline;
use AppBundle\Entity\Bygning;
use AppBundle\Entity\BygningRepository;
use AppBundle\Entity\ContactPerson;
use AppBundle\Entity\User;
use AppBundle\Entity\VirksomhedRapport;
use AppBundle\Form\Type\VirksomhedCreateRapportType;
use AppBundle\Form\Type\VirksomhedFilterType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Virksomhed;
use AppBundle\Form\VirksomhedType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Virksomhed controller.
 *
 * @Route("/virksomhed")
 */
class VirksomhedController extends BaseController
{
    /**
     * @var TranslatorInterface $tranlator
     */
    private $translator;

    /**
     * @var Request $request
     */
    private $request;

    /**
     * @var PropertyAccessor
     */
    protected $accessor;

    /**
     * @inheritDoc
     */
    public function init(Request $request) {
        parent::init($request);
        $this->breadcrumbs->addItem('virksomhed.labels.plural', $this->generateUrl('virksomhed'));
        $this->translator = $this->container->get('translator');
        $this->request = $request;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Lists all Virksomhed entities.
     *
     * @Route("/", name="virksomhed")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $virksomhed = new Virksomhed();
        $form = $this->createSearchForm($virksomhed);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->breadcrumbs->addItem('Søg', $this->generateUrl('virksomhed'));
        }

        // initialize a query builder
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:virksomhed')
            ->createQueryBuilder('v');

        // build the query from the given form object
        $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

        /** @var Query $query */
        $query = $filterBuilder->getQuery();

        if ($request->query->has('json')) {
            $result = array();
            foreach ($query->getResult() as $virksomhed) {
                $result[$virksomhed->getId()] = VirksomhedType::getDatterSelskabReferenceLabel($virksomhed);
            }

            $response = new Response();
            $response->setContent(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        $pagination = $this->get('knp_paginator')->paginate(
            $filterBuilder->getQuery(),
            $request->query->get('page', 1),
            20
        );
        return $this->render(
            'AppBundle:Virksomhed:index.html.twig',
            array(
                'pagination' => $pagination,
                'form' => $form->createView(),
            )
        );

    }

    /**
     * Creates a form to search Bygning entities.
     *
     * @param Virksomhed $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSearchForm(Virksomhed $entity) {
        $form = $this->createForm(new VirksomhedFilterType(), $entity, array(
            'action' => $this->generateUrl('virksomhed'),
            'method' => 'GET',
        ));

        return $form;
    }

    /**
     * Creates a new Virksomhed entity.
     *
     * @Route("/", name="virksomhed_create")
     * @Method("POST")
     * @Template("AppBundle:Virksomhed:new.html.twig")
     *
     * @Security("has_role('ROLE_VIRKSOMHED_CREATE')")
     */
    public function createAction(Request $request)
    {
        $entity = new Virksomhed();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // Remove incompleted add more values.
            $entity->filterEmptyValues();
            $em = $this->getDoctrine()->getManager();

            /** @var BygningRepository $bygningRepository */
            $bygningRepository = $em->getRepository(Bygning::class);

            $bygninger = $bygningRepository->findBy(array('id' => array_merge(
                $entity->getBygningerByCvrNumber(),
                $entity->getBygningerByEanNumber(),
                $entity->getBygningerByPNumber()
            )));
            $entity->setBygninger(new ArrayCollection());
            /** @var Bygning $bygning */
            foreach ($bygninger as $bygning) {
                $entity->addBygninger($bygning);
                $bygning->setCvrNumber($entity->getCvrNumber());
            }

            // Creating customer user to get ability use customer URL.
            /** @var ContactPerson $contactPerson */
            $contactPerson = $entity->getContactPersons()->first();
            if (!empty($contactPerson)) {
                /** @var User $existingUser */
                $existingUser = $em->getRepository(User::class)->findOneBy(array('email' => $contactPerson->getMail()));
                if (empty($existingUser)) {
                    $user = $entity->getUser();
                    $user->setUsername($entity->getCvrNumber());
                    $user->setFirstname($entity->getCvrNumber());
                    $user->setEmail($contactPerson->getMail());
                    $user->setPassword(hash('md5', $entity->getCvrNumber()));
                    $user->setEnabled(TRUE);
                    $this->get('fos_user.user_manager')->updateUser($user);
                }
                else {
                    $entity->setUser($existingUser);
                    $this->flash->success($this->translator->trans('virksomhed.messages.attached_existing_user', array(
                        '%userMail' => $existingUser->getEmail(),
                    )));
                }
            }

            $this->flash->success('virksomhed.confirmation.created');

            $em->persist($entity);
            $em->flush();

            // Contact persons are not handled by Doctrine ORM.
            // We inserting it here.
            foreach ($entity->getContactPersons() as $contactPerson) {
              $contactPerson->setReference($entity);
              $em->persist($contactPerson);
            }
            $em->flush();

          return $this->redirect($this->generateUrl('virksomhed_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Virksomhed entity.
     *
     * @param Virksomhed $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Virksomhed $entity)
    {
        $entity->setDefaultValues();
        $form = $this->createForm(new VirksomhedType(), $entity, array(
            'action' => $this->generateUrl('virksomhed_create'),
            'method' => 'POST',
            'entityManager' => $this->getDoctrine()->getManager(),
        ));

        $this->addUpdate($form, $this->generateUrl('virksomhed'));

        return $form;
    }

    /**
     * Displays a form to create a new Virksomhed entity.
     *
     * @Route("/new", name="virksomhed_new")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_VIRKSOMHED_CREATE')")
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('virksomhed'));

        $entity = new Virksomhed();

        // It's required to have at least one contact person.
        $entity->setContactPersons(new ArrayCollection(array(new ContactPerson())));

        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Gets Virksomheds json list for datterselskab.
     *
     * @Route("/datterselskab-list", name="virksomhed_datterselskab_list")
     * @Method("GET")
     * @Security("has_role('ROLE_VIRKSOMHED_VIEW')")
     */
    public function datterselskablistAction() {
        $repository = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Virksomhed');
        $current_virksomhed = NULL;
        if ($this->request->query->get('current_id')) {
            $current_virksomhed = $repository->find($this->request->query->get('current_id'));
        }
        $virksomheder = $repository->getDatterSelskabReferenceList($current_virksomhed);
        /** @var Virksomhed $virksomhed */
        foreach ($virksomheder as $virksomhed) {
            $result[$virksomhed->getId()] = $virksomhed->getCvrReferenceLabel();
        }

        $response = new Response();
        $response->setContent(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Finds and displays a Virksomhed entity.
     *
     * @Route("/{id}", name="virksomhed_show")
     * @Method("GET")
     * @Template()
     * @Security("is_granted('VIRKSOMHED_VIEW', virksomhed)")
     */
    public function showAction(Virksomhed $virksomhed)
    {
        $this->breadcrumbs->addItem($virksomhed, $this->generateUrl('virksomhed_show', array('id' => $virksomhed->getId())));
        return array(
            'entity'      => $virksomhed,
        );
    }

    /**
     * Finds and displays a Virksomhed entity.
     *
     * @Route("/{id}/baselines", name="virksomhed_bygninger_baseline_summary")
     * @Method("GET")
     * @Template("AppBundle:Virksomhed:bygning_baseline_summary.html.twig")
     * @Security("is_granted('VIRKSOMHED_VIEW', virksomhed)")
     */
    public function bygningBaselineListAction(Virksomhed $virksomhed)
    {
        $this->breadcrumbs->addItem($virksomhed, $this->generateUrl('virksomhed_show', array('id' => $virksomhed->getId())));
        $this->breadcrumbs->addItem('appbundle.virksomhed.baseline.summary', $this->generateUrl('virksomhed_bygninger_baseline_summary', array('id' => $virksomhed->getId())));
        $bygninger = $virksomhed->getAllBygninger();
        $bygninger_baselinesummary = new Baseline();
        $properties = array(
            'elBaselineFastsatForEjendom',
            'elBaselineFastsatForEjendomKorrektion',
            'elBaselineFastsatForEjendomKorrigeret',
            'varmeGAFForbrug',
            'varmeGAFForbrugKorrektion',
            'varmeGAFForbrugKorrigeret',
            'varmeGUFForbrug',
            'varmeGUFForbrugKorrektion',
            'varmeGUFForbrugKorrigeret',
            'varmeStrafafkoelingsafgift',
            'varmeStrafafkoelingsafgiftKorrektion',
            'varmeStrafafkoelingsafgiftKorrigeret',
        );
        /** @var Bygning $bygning */
        foreach ($properties as $property_name) {
            $summ_value = 0;
            foreach ($bygninger as $bygning) {
                $baseline = $bygning->getBaseline();
                if (!empty($baseline)) {
                    $summ_value += $this->accessor->getValue($baseline, $property_name);
                }
            }
            $this->accessor->setValue($bygninger_baselinesummary, $property_name, $summ_value);
        }
        return array(
            'entity' => $bygninger_baselinesummary,
        );
    }

    /**
     * Displays a form to edit an existing Virksomhed entity.
     *
     * @Route("/{id}/edit", name="virksomhed_edit")
     * @Method("GET")
     * @Template()
     * @Security("is_granted('VIRKSOMHED_EDIT', entity)")
     */
    public function editAction(Virksomhed $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('virksomhed_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('virksomhed_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Virksomhed entity.');
        }

        if (empty($entity->getContactPersons()->first())) {
            $entity->getContactPersons()->add(new ContactPerson());
        }

        // Load already created bygning by cvr number if they are not in list.
        $bygninger = $this->getDoctrine()->getManager()->getRepository(Bygning::class)->findBy(array('cvrNumber' => $entity->getCvrNumber()));
        foreach ($bygninger as $bygning) {
            if (!in_array($bygning->getId(), $entity->getBygningerByCvrNumber())) {
                $entity->addBygningerByCvrNumber($bygning->getId());
            }
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Virksomhed entity.
    *
    * @param Virksomhed $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Virksomhed $entity)
    {
        $entity->setDefaultValues();

        $this->getDoctrine()->getManager()->getRepository(Virksomhed::class)->cleanupBygningReferences($entity);
        $form = $this->createForm(new VirksomhedType(), $entity, array(
            'action' => $this->generateUrl('virksomhed_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'entityManager' => $this->getDoctrine()->getManager(),
        ));

        $this->addUpdate($form, $this->generateUrl('virksomhed_show', array('id' => $entity->getId())));

        return $form;
    }
    /**
     * Edits an existing Virksomhed entity.
     *
     * @Route("/{id}", name="virksomhed_update")
     * @Method("PUT")
     * @Template("AppBundle:Virksomhed:edit.html.twig")
     * @Security("is_granted('VIRKSOMHED_EDIT', virksomhed)")
     */
    public function updateAction(Request $request, Virksomhed $virksomhed)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Virksomhed $originalVirksomhed */
        $originalVirksomhed = $em->getRepository(Virksomhed::class)->find($virksomhed->getId());

        $originalBygninger = new ArrayCollection();
        foreach ($originalVirksomhed->getBygninger() as $bygning) {
            $originalBygninger->add($bygning);
        }

        $originalContactPersons = new ArrayCollection();
        foreach ($originalVirksomhed->getContactPersons() as $contactPerson) {
            $originalContactPersons->add($contactPerson);
        }

        $originalDatterSelskaber = new ArrayCollection();
        foreach ($originalVirksomhed->getDatterSelskaber() as $child_virksomhed) {
            $originalDatterSelskaber->add($child_virksomhed);
        }

        $deleteForm = $this->createDeleteForm($virksomhed);
        $editForm = $this->createEditForm($virksomhed);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            // Remove incompleted add more values.
            $virksomhed->filterEmptyValues();

            /** @var BygningRepository $bygningRepository */
            $bygningRepository = $em->getRepository(Bygning::class);

            $bygninger = $bygningRepository->findBy(array('id' => array_merge(
                $virksomhed->getBygningerByCvrNumber(),
                $virksomhed->getBygningerByEanNumber(),
                $virksomhed->getBygningerByPNumber()
            )));
            $virksomhed->setBygninger(new ArrayCollection());
            /** @var Bygning $bygning */
            foreach ($bygninger as $bygning) {
                $virksomhed->addBygninger($bygning);
                $bygning->setCvrNumber($virksomhed->getCvrNumber());
            }

            /** @var Bygning $bygning */
            foreach ($originalBygninger as $bygning) {
                if (false === $virksomhed->getBygninger()->contains($bygning)) {
                    $bygning->setVirksomhed(null);
                    $em->persist($bygning);
                }
            }

            /** @var ContactPerson $contactPerson */
            foreach ($originalContactPersons as $contactPerson) {
                if (false === $virksomhed->getContactPersons()->contains($contactPerson)) {
                    $em->remove($contactPerson);
                }
            }

            /** @var Virksomhed $child_virksomhed */
            foreach ($originalDatterSelskaber as $datter_selskab) {
                if (false === $virksomhed->getDatterSelskaber()->contains($datter_selskab)) {
                    $child_virksomhed->setParent(null);
                    $em->persist($child_virksomhed);
                }
            }

            $em->getRepository(Virksomhed::class)->cleanupBygningReferences($virksomhed);

            $em->persist($virksomhed);
            $em->flush();

            // Contact persons are not handled by Doctrine ORM.
            // We have to update it here.
            foreach ($virksomhed->getContactPersons() as $contactPerson) {
              $em->persist($contactPerson);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('virksomhed_show', array('id' => $virksomhed->getId())));
        }

        return array(
            'entity'      => $virksomhed,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Virksomhed entity.
     *
     * @Route("/{id}", name="virksomhed_delete")
     * @Method("DELETE")
     * @Security("is_granted('VIRKSOMHED_EDIT', virksomhed)")
     */
    public function deleteAction(Request $request, Virksomhed $virksomhed)
    {
        $form = $this->createDeleteForm($virksomhed);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Virksomhed')->find($virksomhed->getId());

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Virksomhed entity.');
            }

            // Contact persons are not handled by Doctrine ORM.
            // We have to update it here.
            foreach ($virksomhed->getContactPersons() as $contactPerson) {
                $em->remove($contactPerson);
            }

            if (!empty($virksomhed->getBaseline())) {
                $em->remove($virksomhed->getBaseline());
            }

            if (!empty($virksomhed->getKortlaegning())) {
                $em->remove($virksomhed->getKortlaegning());
            }

            /** @var Virksomhed $datterSelskab */
            foreach ($virksomhed->getDatterSelskaber() as $datterSelskab) {
              $datterSelskab->setParent(NULL);
              $em->persist($datterSelskab);
            }

            /** @var Bygning $bygning */
            foreach ($virksomhed->getBygninger() as $bygning) {
                $bygning->setVirksomhed(NULL);
                $em->persist($bygning);
            }

            if (!empty($virksomhed->getRapport())) {
                // Removing rapport files.
                $files = $em->getRepository('AppBundle:Fil')->findByEntity($virksomhed->getRapport());
                foreach ($files as $file) {
                  $em->remove($file);
                }

                $em->remove($virksomhed->getRapport());
            }

            $em->remove($entity);
            $em->flush();
            // @TODO remove revisions.

            $this->flash->success('virksomhed.confirmation.deleted');
        }

        return $this->redirect($this->generateUrl('virksomhed'));
    }

    /**
     * Creates a form to delete a Virksomhed entity by id.
     *
     * @param Virksomhed $virksomhed
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($virksomhed)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('virksomhed_delete', array('id' => $virksomhed->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
            ))
            ->getForm()
        ;
    }

    /**
     * Get/Create Virksomhed rapport action.
     *
     * @Route("/{id}/rapport", name="virksomhed_get_rapport")
     * @Method("GET")
     * @Template("AppBundle:Virksomhed:create_rapport.html.twig")
     */
    public function reportAction(Virksomhed $virksomhed) {
        $this->breadcrumbs->addItem($virksomhed, $this->generateUrl('virksomhed_show', array('id' => $virksomhed->getId())));

        $rapport = $virksomhed->getRapport();
        if(empty($rapport)) {
            $virksomhed->setRapport(new VirksomhedRapport());
            $this->breadcrumbs->addItem('virksomhed.actions.create_rapport');
            $createForm = $this->createRapportForm($virksomhed);
            return array(
                'entity' => $virksomhed,
                'create_form' => $createForm->createView(),
            );
        }
        $params = array('id' => $rapport->getId());
        // Forwarding access by token.
        if ($this->request->query->get('token')) {
            $params['token'] = $this->request->query->get('token');
        }
        return $this->redirect($this->generateUrl('virksomhed_rapport_show', $params));
    }

    /**
     * Create Virksomhed rapport entity.
     *
     * @Route("/{id}/rapport", name="virksomhed_create_rapport")
     * @Method("PUT")
     * @Template("AppBundle:Virksomhed:create_rapport.html.twig")
     */
    public function reportCreateAction(Request $request, Virksomhed $virksomhed) {
        $this->breadcrumbs->addItem($virksomhed, $this->generateUrl('virksomhed_show', array('id' => $virksomhed->getId())));
        $this->breadcrumbs->addItem('virksomhed.actions.create_rapport');

        if(!$virksomhed->getRapport()) {
            $rapport = new VirksomhedRapport();
            $rapport->setVirksomhed($virksomhed);
        }

        $editForm = $this->createRapportForm($virksomhed);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->flash->success('virksomhed.confirmation.rapport_created');
            $params = array('id' => $virksomhed->getRapport()->getId());
            // Forwarding access by token.
            if ($this->request->query->get('token')) {
                $params['token'] = $this->request->query->get('token');
            }
            return $this->redirect($this->generateUrl('virksomhed_rapport_show', $params));
        }

        $this->flash->error('common.form_error');

        return array(
            'entity' => $virksomhed,
            'create_form' => $editForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Virksomhed entity.
     *
     * @param Virksomhed $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createRapportForm(Virksomhed $entity) {
        $params = array('id' => $entity->getId());
        // Forwarding access by token.
        if ($this->request->query->get('token')) {
            $params['token'] = $this->request->query->get('token');
        }
        $form = $this->createForm(new VirksomhedCreateRapportType(), $entity, array(
            'action' => $this->generateUrl('virksomhed_create_rapport', $params),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('virksomhed_rapport_show', $params));

        return $form;
    }

    //---------------- Baseline -------------------//

    /**
     * Creates a new Baseline entity.
     *
     * @Route("/{id}/new", name="baseline_create")
     * @Method("POST")
     * @Template("AppBundle:Baseline:new.html.twig")
     * @Security("is_granted('VIRKSOMHED_EDIT', virksomhed)")
     */
    public function newBaselineAction(Request $request, Virksomhed $virksomhed) {
        if ($virksomhed) {
            $baseline = $virksomhed->getBaseline();
            if(!$baseline) {
                $em = $this->getDoctrine()->getManager();

                $baseline = new Baseline();
                $baseline->setArealdataPrimaerAreal($virksomhed->getBygningerErhvervsareal());
                $virksomhed->setBaseline($baseline);

                $em->persist($baseline);
                $em->flush();
            }

            $this->flash->success( 'baseline.confirmation.created');

            return $this->redirect($this->generateUrl('baseline_edit', array('id' => $baseline->getId())));
        } else {
            throw $this->createNotFoundException('Unable to find Virksomhed entity.');
        }
    }

}
