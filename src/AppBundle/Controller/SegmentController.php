<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Segment;
use AppBundle\Form\Type\SegmentType;
use AppBundle\Controller\BaseController;

/**
 * Segment controller.
 *
 * @Route("/segment")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class SegmentController extends BaseController {

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('segment.labels.singular', $this->generateUrl('segment'));
  }

  /**
   * Lists all Segment entities.
   *
   * @Route("/", name="segment")
   * @Method("GET")
   * @Template()
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();

    $entities = $em->getRepository('AppBundle:Segment')->findAll();

    return array(
      'entities' => $entities,
    );
  }

  /**
   * Creates a new Segment entity.
   *
   * @Route("/", name="segment_create")
   * @Method("POST")
   * @Template("AppBundle:Segment:new.html.twig")
   */
  public function createAction(Request $request) {
    $entity = new Segment();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('segment'));

    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a form to create a Segment entity.
   *
   * @param Segment $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(Segment $entity) {
    $form = $this->createForm(new SegmentType($this->getDoctrine()), $entity, array(
      'action' => $this->generateUrl('segment_create'),
      'method' => 'POST',
    ));

    $this->addUpdate($form, $this->generateUrl('segment'));

    return $form;
  }

  /**
   * Displays a form to create a new Segment entity.
   *
   * @Route("/new", name="segment_new")
   * @Method("GET")
   * @Template()
   */
  public function newAction() {
    $this->breadcrumbs->addItem('common.add', $this->generateUrl('segment'));

    $entity = new Segment();
    $form = $this->createCreateForm($entity);

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Finds and displays a Segment entity.
   *
   * @Route("/{id}", name="segment_show")
   * @Method("GET")
   * @Template()
   */
  public function showAction($id) {

    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Segment')->find($id);
    $this->breadcrumbs->addItem($entity, $this->generateUrl('segment_show', array('id' => $entity->getId())));

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Segment entity.');
    }

    $deleteForm = $this->createDeleteForm($id);

    return array(
      'entity' => $entity,
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Displays a form to edit an existing Segment entity.
   *
   * @Route("/{id}/edit", name="segment_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction(Segment $entity) {
    $this->breadcrumbs->addItem($entity, $this->generateUrl('segment_show', array('id' => $entity->getId())));
    $this->breadcrumbs->addItem('common.edit', $this->generateUrl('segment_show', array('id' => $entity->getId())));

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Segment entity.');
    }

    $editForm = $this->createEditForm($entity);
    $deleteForm = $this->createDeleteForm($entity->getId());

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Creates a form to edit a Segment entity.
   *
   * @param Segment $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Segment $entity) {
    $form = $this->createForm(new SegmentType($this->getDoctrine()), $entity, array(
      'action' => $this->generateUrl('segment_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('segment_show', array('id' => $entity->getId())));

    return $form;
  }

  /**
   * Edits an existing Segment entity.
   *
   * @Route("/{id}", name="segment_update")
   * @Method("PUT")
   * @Template("AppBundle:Segment:edit.html.twig")
   */
  public function updateAction(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Segment')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Segment entity.');
    }

    $deleteForm = $this->createDeleteForm($id);
    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em->flush();

      return $this->redirect($this->generateUrl('segment'));
    }

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Segment entity.
   *
   * @Route("/{id}", name="segment_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $id) {
    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('AppBundle:Segment')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find Segment entity.');
      }

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('segment'));
  }

  /**
   * Creates a form to delete a Segment entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id) {
    $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Segment');
    $segment = $repository->find($id);
    $message = $repository->getRemoveErrorMessage($segment);

    return $this->createFormBuilder()
      ->setAction($this->generateUrl('segment_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array(
        'label' => 'Delete',
        'disabled' => $message,
        'attr' => array(
          'disabled_message' => $message,
        ),
      ))
      ->getForm();
  }
}
