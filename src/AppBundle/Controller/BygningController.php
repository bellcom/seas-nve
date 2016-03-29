<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\DataExport\ExcelExport;
use Symfony\Component\Config\Definition\Exception\Exception;
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
use Yavin\Symfony\Controller\InitControllerInterface;

/**
 * Bygning controller.
 *
 * @Route("/bygning")
 */
class BygningController extends BaseController implements InitControllerInterface {

  protected $breadcrumbs;

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('Bygninger', $this->generateUrl('bygning'));
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
    $search['segment'] = $bygning->getSegment();
    $search['status'] = $bygning->getStatus();

    $user = $this->get('security.context')->getToken()->getUser();

    $query = $em->getRepository('AppBundle:Bygning')->searchByUser($user, $search);

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

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('bygning_show', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
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
    $form = $this->createForm(new BygningType($this->getDoctrine(), $this->get('security.authorization_checker')), $entity, array(
      'action' => $this->generateUrl('bygning_create'),
      'method' => 'POST',
    ));

    $this->addCreate($form, $this->generateUrl('bygning'));

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
    $form = $this->createCreateForm($entity);

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
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

    $this->breadcrumbs->addItem($bygning, $this->generateUrl('bygning'));
    $this->breadcrumbs->addItem('common.edit', $this->generateUrl('bygning'));

    return array(
      'entity' => $bygning,
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
    $form = $this->createForm(new BygningType($this->getDoctrine(), $this->get('security.authorization_checker')), $entity, array(
      'action' => $this->generateUrl('bygning_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('bygning_show', array('id' => $entity->getId())));

    return $form;
  }

  /**
   * Edits an existing Bygning entity.
   *
   * @Route("/{id}", name="bygning_update")
   * @Method("PUT")
   * @Template("AppBundle:Bygning:edit.html.twig")
   * @Security("is_granted('BYGNING_EDIT', bygning)")
   */
  public function updateAction(Request $request, Bygning $bygning) {
    $deleteForm = $this->createDeleteForm($bygning);
    $editForm = $this->createEditForm($bygning);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      return $this->redirect($this->generateUrl('bygning_show', array('id' => $bygning->getId())));
    }

    return array(
      'entity' => $bygning,
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
      $em->remove($bygning);
      $em->flush();
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
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

}
