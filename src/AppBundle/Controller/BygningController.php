<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\DataExport\ExcelExport;
use AppBundle\DBAL\Types\BygningStatusType;
use AppBundle\Entity\BygningRepository;
use AppBundle\Entity\ContactPerson;
use AppBundle\Entity\Tiltag;
use AppBundle\Entity\Virksomhed;
use AppBundle\Form\Type\BygningRapportType;
use AppBundle\Form\VirksomhedType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\ButtonBuilder;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Bygning;
use AppBundle\Form\Type\BygningType;
use AppBundle\Form\Type\BygningSearchType;
use AppBundle\Entity\Rapport;
use AppBundle\Form\Type\RapportType;
use Symfony\Component\Translation\TranslatorInterface;
use Yavin\Symfony\Controller\InitControllerInterface;

/**
 * Bygning controller.
 *
 * @Route("/bygning")
 */
class BygningController extends BaseController implements InitControllerInterface {

  protected $breadcrumbs;

  /**
   * @var TranslatorInterface $tranlator
   */
  private $translator;

  /**
   * @var Request
   */
  protected $request;

  public function init(Request $request) {
    $this->request = $request;
    parent::init($request);
    $this->breadcrumbs->addItem('Bygninger', $this->generateUrl('bygning'));
    $this->translator = $this->container->get('translator');
  }

  /**
   * Lists all Bygning entities.
   *
   * @Route(name="bygning")
   * @Method("GET")
   * @Template()
   */
  public function indexAction(Request $request) {
    $bygning = new Bygning();
    $bygning->setStatus(null);
    $form = $this->createSearchForm($bygning);
    $form->handleRequest($request);

    if($form->isSubmitted()) {
      $this->breadcrumbs->addItem('Søg', $this->generateUrl('bygning'));
    }

    $em = $this->getDoctrine()->getManager();

    $search = array();

    $search['bygId'] = $bygning->getBygId();
    $search['navn'] = $bygning->getNavn();
    $search['adresse'] = $bygning->getAdresse();
    $search['postnummer'] = $bygning->getPostnummer();
    $search['postBy'] = $bygning->getPostBy();
    $search['virksomhed'] = $bygning->getVirksomhed();
    $search['segment'] = $bygning->getSegment();

    $user = $this->get('security.context')->getToken()->getUser();
    /** @var Query $query */
    $query = $em->getRepository('AppBundle:Bygning')->searchByUser($user, $search);

    if ($request->query->has('json')) {
      $result = array();
      foreach ($query->getResult() as $bygning) {
        $result[$bygning->getId()] = VirksomhedType::getEanNumberReferenceLabel($bygning);
      }

      $response = new Response();
      $response->setContent(json_encode($result));
      $response->headers->set('Content-Type', 'application/json');
      return $response;
    }

    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
      $query,
      $request->query->get('page', 1),
      20
    );

    return $this->render('AppBundle:Bygning:index.html.twig', array('pagination' => $pagination, 'search' => $search, 'form' => $form->createView()));
  }

  /**
   * Creates a form to search Bygning entities.
   *
   * @param Bygning $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createSearchForm(Bygning $entity) {
    $form = $this->createForm(new BygningSearchType(), $entity, array(
      'action' => $this->generateUrl('bygning'),
      'method' => 'GET',
    ));

    return $form;
  }

  /**
   * Creates a new Bygning entity.
   *
   * @Route("/", name="bygning_create")
   * @Method("POST")
   * @Template("AppBundle:Bygning:new.html.twig")
   *
   * @Security("has_role('ROLE_BYGNING_CREATE')")
   */
  public function createAction(Request $request) {
    $entity = new Bygning();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);
    $em = $this->getDoctrine()->getManager();

    if ($form->isValid()) {
      $em->persist($entity);
      $em->flush();

      // Contact persons are not handled by Doctrine ORM.
      // We inserting it here.
      foreach ($entity->getContactPersons() as $contactPerson) {
        $contactPerson->setReference($entity);
        $em->persist($contactPerson);
      }
      $em->flush();

      // Update Virksomhed by CVR attachments.
      $virksomhed = $entity->getVirksomhed();
      if (!empty($virksomhed)) {
        $bygninger = $virksomhed->getBygningerByCvrNumber();
        $bygninger[] = $entity->getId();
        $virksomhed->setBygningerByCvrNumber($bygninger);
        $em->persist($virksomhed);
        $em->flush();
      }

      $destination = $this->generateUrl('bygning_show', array('id' => $entity->getId()));
      if ($button_destination = $this->getButtonDestination($form->getClickedButton())) {
        $destination = $button_destination;
      }
      return $this->redirect($destination);
    }

    $virksomheder = $em->getRepository(Virksomhed::class)->findBy(array(), array('id' => 'desc'));
    return array(
      'entity' => $entity,
      'virksomheder' => $virksomheder,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a form to create a Bygning entity.
   *
   * @param Bygning $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(Bygning $entity) {
    // Getting desired destination for form redirect.
    $params = array();
    if ($this->request->get('destination')) {
      $destination = $this->request->get('destination');
      $params['destination'] = $destination;
    }
    $form = $this->createForm(new BygningType($this->getDoctrine(), $this->get('security.authorization_checker'), TRUE), $entity, array(
      'action' => $this->generateUrl('bygning_create', $params),
      'method' => 'POST',
    ));

    $this->addCreate($form, $this->generateUrl('bygning'), !empty($destination) ? array(
      'attr' => array(
        'destination' => $destination,
      ),
    ) : array());

    return $form;
  }

  /**
   * Displays a form to create a new Bygning entity.
   *
   * @Route("/new", name="bygning_new")
   * @Method("GET")
   * @Template()
   * @Security("has_role('ROLE_BYGNING_CREATE')")
   */
  public function newAction() {
    $entity = new Bygning();
    $em = $this->getDoctrine()->getManager();
    $virksomhedRepository = $em->getRepository(Virksomhed::class);

    // Settings virksomhed if entity create with reference to virksomhed.
    if (!empty($this->request->get('virksomhed_id'))) {
      /** @var Virksomhed $virksomhed */
      $virksomhed = $virksomhedRepository->find($this->request->get('virksomhed_id'));
      $virksomhed->addBygninger($entity);
    }
    $form = $this->createCreateForm($entity);
    $virksomheder = $virksomhedRepository->findBy(array(), array('id' => 'desc'));

    return array(
      'entity' => $entity,
      'virksomheder' => $virksomheder,
      'form' => $form->createView(),
    );
  }

  /**
   * Gets Unique cvrNumm json list.
   *
   * @Route("/cvrnumm-list", name="bygninger_by_cvrnumm_list")
   * @Method("GET")
   * @Security("has_role('ROLE_BYGNING_VIEW')")
   */
  public function cvrNumListAction() {
    /** @var BygningRepository $repository */
    $repository = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Bygning');
    $response = new Response();
    $result = array();
    foreach ($repository->getCvrNumberReferenceList() as $id => $value) {
      $result[] = array(
        'id' => $id,
        'value' => $value,
      );
    }
    $response->setContent(json_encode($result));
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  /**
   * Gets Unique eanNumm json list.
   *
   * @Route("/eannumm-list", name="bygning_eannumm_list")
   * @Method("GET")
   * @Security("has_role('ROLE_BYGNING_VIEW')")
   */
  public function eanNumListAction() {
    /** @var BygningRepository $repository */
    $repository = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Bygning');
    $response = new Response();
    $result = array();
    foreach ($repository->getEanNumberReferenceList() as $id => $value) {
      $result[] = array(
        'id' => $id,
        'value' => $value,
      );
    }
    $response->setContent(json_encode($result));
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  /**
   * Gets Unique pNumm json list.
   *
   * @Route("/pnumm-list", name="bygning_pnumm_list")
   * @Method("GET")
   * @Security("has_role('ROLE_BYGNING_VIEW')")
   */
  public function pNumListAction() {
    /** @var BygningRepository $repository */
    $repository = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Bygning');
    $response = new Response();
    $result = array();
    foreach ($repository->getPNumberReferenceList() as $id => $value) {
      $result[] = array(
        'id' => $id,
        'value' => $value,
      );
    }
    $response->setContent(json_encode($result));
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  /**
   * Finds and displays a Bygning entity.
   *
   * @Route("/{id}", name="bygning_show")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('BYGNING_VIEW', bygning)")
   */
  public function showAction(Bygning $bygning) {
    $deleteForm = $this->createDeleteForm($bygning);

    $this->breadcrumbs->addItem($bygning, $this->generateUrl('bygning'));

    return array(
      'entity' => $bygning,
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Displays a form to edit an existing Bygning entity.
   *
   * @Route("/{id}/edit", name="bygning_edit")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('BYGNING_EDIT', bygning)")
   */
  public function editAction(Bygning $bygning) {
    $editForm = $this->createEditForm($bygning);
    $deleteForm = $this->createDeleteForm($bygning);

    $this->breadcrumbs->addItem($bygning, $this->generateUrl('bygning_show', array('id' => $bygning->getId())));
    $this->breadcrumbs->addItem('common.edit', $this->generateUrl('bygning'));

    $em = $this->getDoctrine()->getManager();
    $virksomheder = $em->getRepository(Virksomhed::class)->findBy(array(), array('id' => 'desc'));
    return array(
      'entity' => $bygning,
      'virksomheder' => $virksomheder,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Creates a form to edit a Bygning entity.
   *
   * @param Bygning $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Bygning $entity) {
    $form = $this->createForm(new BygningType($this->getDoctrine(), $this->get('security.authorization_checker'), TRUE), $entity, array(
      'action' => $this->generateUrl('bygning_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('bygning_show', array('id' => $entity->getId())));
    $this->addUpdateAndExit($form, $this->generateUrl('bygning_show', array('id' => $entity->getId())));

    return $form;
  }

  /**
   * Edits an existing Bygning entity.
   *
   * @Route("/{id}/edit", name="bygning_update")
   * @Method("PUT")
   * @Template("AppBundle:Bygning:edit.html.twig")
   * @Security("is_granted('BYGNING_EDIT', bygning)")
   */
  public function updateAction(Request $request, Bygning $bygning) {
    $em = $this->getDoctrine()->getManager();

    /** @var Bygning $originalBygning */
    $originalBygning = $em->getRepository(Bygning::class)->find($bygning->getId());
    $originalVirksomhed = $originalBygning->getVirksomhed();

    $originalContactPersons = new ArrayCollection();
    foreach ($originalBygning->getContactPersons() as $contactPerson) {
      $originalContactPersons->add($contactPerson);
    }

    $deleteForm = $this->createDeleteForm($bygning);
    $editForm = $this->createEditForm($bygning);

    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      /** @var ContactPerson $contactPerson */
      foreach ($originalContactPersons as $contactPerson) {
        if (false === $bygning->getContactPersons()->contains($contactPerson)) {
          $em->remove($contactPerson);
        }
      }

      $em->flush();

      // Contact persons are not handled by Doctrine ORM.
      // We updating it here.
      foreach ($bygning->getContactPersons() as $contactPerson) {
        $em->persist($contactPerson);
      }
      $em->flush();

      // Update Virksomhed by CVR attachments.
      $virksomhed = $bygning->getVirksomhed();
      if (!empty($virksomhed)) {
        $bygninger = $virksomhed->getBygningerByCvrNumber();
        $bygninger[] = $bygning->getId();
        $virksomhed->setBygningerByCvrNumber($bygninger);
      }
      $em->persist($virksomhed);
      $em->flush();

      $this->flash->success('bygninger.confirmation.updated');

      $destination = $request->getRequestUri();
      if ($button_destination = $this->getButtonDestination($editForm->getClickedButton())) {
        $destination = $button_destination;
      }
      return $this->redirect($destination);
    }

    $virksomheder = $em->getRepository(Virksomhed::class)->findBy(array(), array('id' => 'desc'));
    return array(
      'entity' => $bygning,
      'virksomheder' => $virksomheder,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Bygning entity.
   *
   * @Route("/{id}", name="bygning_delete")
   * @Method("DELETE")
   * @Security("is_granted('BYGNING_EDIT', bygning)")
   */
  public function deleteAction(Request $request, Bygning $bygning) {
    $form = $this->createDeleteForm($bygning);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $rapport = $bygning->getRapport();
      if (!empty($rapport)) {
        // Arrays to collect orphaned tiltags and details.
        $detailsToDelete = array();
        $tiltagsToDelete = array();

        /** @var Tiltag $tiltag */
        foreach ($rapport->getTiltag() as $tiltag) {
          /** @var Tiltag $detail */
          foreach ($tiltag->getDetails() as $detail) {
            // Detaching details from tiltag.
            $detail->setTiltag(NULL);
            $tiltag->removeDetail($detail);
            $detailsToDelete[] = $detail;
          }
          $em->persist($tiltag);

          // Detaching tiltag from rapport.
          $tiltag->setRapport(NULL);
          $rapport->removeTiltag($tiltag);
          $em->flush();
          $tiltagsToDelete[] = $tiltag;
        }
        $em->persist($rapport);
        $em->flush();

        // Removing orphaned tiltags and details.
        foreach ($tiltagsToDelete as $tiltag) {
          $em->remove($tiltag);
        }
        foreach ($detailsToDelete as $detail) {
          $em->remove($detail);
        }
        $em->flush();
        $this->flash->success('bygning_rapporter.confirmation.deleted_forslags');

        // Removing rapport files.
        $files = $em->getRepository('AppBundle:Fil')->findByEntity($rapport);
        foreach ($files as $file) {
          $em->remove($file);
        }

        // Removing rapport.
        $em->remove($rapport);
        $em->flush();
        $this->flash->success('bygning_rapporter.confirmation.deleted');
      }

      // Contact persons are not handled by Doctrine ORM.
      // We have to update it here.
      foreach ($bygning->getContactPersons() as $contactPerson) {
        $em->remove($contactPerson);
      }

      $virksomhed = $bygning->getVirksomhed();
      $em->remove($bygning);
      $em->flush();
      // @TODO remove revisions.

      // Cleanup bygning reference on Virksomhed.
      if ($virksomhed) {
          $em->getRepository(Virksomhed::class)->cleanupBygningReferences($virksomhed);
          $em->persist($virksomhed);
          $em->flush();
      }

      $this->flash->success('bygninger.confirmation.deleted');
    }

    return $this->redirect($this->generateUrl('bygning'));
  }

  /**
   * Creates a form to delete a Bygning entity by id.
   *
   * @param Bygning $bygning
   *   The entity.
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Bygning $bygning) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('bygning_delete', array('id' => $bygning->getId())))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array(
        'label' => 'Delete',
        'attr' => [
          'class' => 'pinned',
        ],
      ))
      ->getForm();
  }

  /**
   * Lists all Bygning entities.
   *
   * @Route("/{id}/rapport", name="bygning_rapport")
   * @Method("GET")
   * @Template("AppBundle:Bygning:create_rapport.html.twig")
   */
  public function rapportAction(Bygning $bygning) {
    $this->breadcrumbs->addItem($bygning, $this->generateUrl('bygning_show', array('id' => $bygning->getId())));
    $this->breadcrumbs->addItem('bygninger.actions.create_rapport');

    //Set next status to trigger validation group
    $bygning->setStatus(BygningStatusType::TILKNYTTET_RAADGIVER);
    $rapport = $bygning->getRapport();
    if (!$rapport) {
      $bygning->setRapport(new Rapport());
      $editForm = $this->createRapportForm($bygning);
      return array(
        'entity' => $bygning,
        'edit_form' => $editForm->createView(),
      );
    }
    return $this->redirect($this->generateUrl('rapport_show', array('id' => $rapport->getId())));
  }

  /**
   * Edits an existing Bygning entity.
   *
   * @Route("/{id}/rapport", name="bygning_rapport_create")
   * @Method("PUT")
   * @Template("AppBundle:Bygning:create_rapport.html.twig")
   */
  public function rapportCreateAction(Request $request, Bygning $bygning) {
    if (empty($bygning->getRapport())) {
      $rapport = new Rapport();
      $rapport->setBygning($bygning);
    }

    $editForm = $this->createRapportForm($bygning);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      $this->flash->success('bygninger.confirmation.rapport_created');
      return $this->redirect($this->generateUrl('bygning_rapport', array('id' => $bygning->getId())));
    }

    $this->flash->error('common.form_error');
    return array(
      'entity' => $bygning,
      'edit_form' => $editForm->createView(),
    );
  }

    /**
     * Creates a form to edit a Bygning entity.
     *
     * @param Bygning $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createRapportForm(Bygning $entity) {
        $form = $this->createForm(new BygningRapportType($this->getDoctrine(), $this->get('security.context')), $entity, array(
            'action' => $this->generateUrl('bygning_rapport_create', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addCreate($form, $this->generateUrl('bygning_show', array('id' => $entity->getId())));

        return $form;
    }

}
