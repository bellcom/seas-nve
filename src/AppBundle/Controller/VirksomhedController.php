<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bygning;
use AppBundle\Entity\ContactPerson;
use AppBundle\Entity\VirksomhedRapport;
use AppBundle\Form\Type\VirksomhedCreateRapportType;
use AppBundle\Form\Type\VirksomhedFilterType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Virksomhed;
use AppBundle\Form\VirksomhedType;

/**
 * Virksomhed controller.
 *
 * @Route("/virksomhed")
 */
class VirksomhedController extends BaseController
{

    public function init(Request $request) {
        parent::init($request);
        $this->breadcrumbs->addItem('virksomhed.labels.plural', $this->generateUrl('virksomhed'));
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
            $em = $this->getDoctrine()->getManager();

            $bygninger = $em->getRepository(Bygning::class)->findByNumbers($entity);
            $entity->setBygninger(new ArrayCollection());
            foreach ($bygninger as $bygning) {
                $entity->addBygninger($bygning);
            }

            $em->persist($entity);
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
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
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

            $bygninger = $em->getRepository(Bygning::class)->findByNumbers($virksomhed);
            $virksomhed->setBygninger(new ArrayCollection());
            foreach ($bygninger as $bygning) {
                $virksomhed->addBygninger($bygning);
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
                    $contactPerson->setVirksomhed(null);
                    $em->persist($contactPerson);
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

            $em->persist($virksomhed);
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

            $em->remove($entity);
            $em->flush();
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
        $bygnings = $virksomhed->getBygninger();
        $message = NULL;
        if (!empty($bygnings)) {
            $message = 'virksomhed.error.in_use';
        }
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('virksomhed_delete', array('id' => $virksomhed->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'disabled' => $message,
                'attr' => array(
                    'disabled_message' => $message,
                ),
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
        return $this->redirect($this->generateUrl('virksomhed_rapport_show', array('id' => $rapport->getId())));
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

            return $this->redirect($this->generateUrl('virksomhed_rapport_show', array('id' => $virksomhed->getRapport()->getId())));
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
        $form = $this->createForm(new VirksomhedCreateRapportType(), $entity, array(
            'action' => $this->generateUrl('virksomhed_create_rapport', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('virksomhed_rapport_show', array('id' => $entity->getId())));

        return $form;
    }

}