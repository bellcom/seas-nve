<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\BaselineKorrektion;
use AppBundle\Form\BaselineKorrektionType;
use AppBundle\Controller\BaseController;

/**
 * BaselineKorrektion controller.
 *
 * @Route("/baselinekorrektion")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class BaselineKorrektionController extends BaseController {

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('baselinekorrektion.labels.singular', $this->generateUrl('baselinekorrektion'));
  }


  /**
   * Lists all BaselineKorrektion entities.
   *
   * @Route("/", name="baselinekorrektion")
   * @Method("GET")
   * @Template()
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();

    $entities = $em->getRepository('AppBundle:BaselineKorrektion')->findAll();

    return array(
      'entities' => $entities,
    );
  }

  /**
   * Creates a new BaselineKorrektion entity.
   *
   * @Route("/", name="baselinekorrektion_create")
   * @Method("POST")
   * @Template("AppBundle:BaselineKorrektion:new.html.twig")
   */
  public function createAction(Request $request) {
    $entity = new BaselineKorrektion();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('baselinekorrektion'));

    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a form to create a BaselineKorrektion entity.
   *
   * @param BaselineKorrektion $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(BaselineKorrektion $entity) {
    $form = $this->createForm(new BaselineKorrektionType(), $entity, array(
      'action' => $this->generateUrl('baselinekorrektion_create'),
      'method' => 'POST',
    ));

    $this->addUpdate($form, $this->generateUrl('baselinekorrektion'));

    return $form;
  }

  /**
   * Displays a form to create a new BaselineKorrektion entity.
   *
   * @Route("/new", name="baselinekorrektion_new")
   * @Method("GET")
   * @Template()
   */
  public function newAction() {
    $this->breadcrumbs->addItem('common.add', $this->generateUrl('baselinekorrektion'));

    $entity = new BaselineKorrektion();
    $form = $this->createCreateForm($entity);

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Finds and displays a BaselineKorrektion entity.
   *
   * @Route("/{id}", name="baselinekorrektion_show")
   * @Method("GET")
   * @Template()
   */
  public function showAction($id) {

    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:BaselineKorrektion')->find($id);
    $this->breadcrumbs->addItem($entity, $this->generateUrl('baselinekorrektion_show', array('id' => $entity->getId())));

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find BaselineKorrektion entity.');
    }

    $deleteForm = $this->createDeleteForm($id);

    return array(
      'entity' => $entity,
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Displays a form to edit an existing BaselineKorrektion entity.
   *
   * @Route("/{id}/edit", name="baselinekorrektion_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction(BaselineKorrektion $entity) {
    $this->breadcrumbs->addItem($entity, $this->generateUrl('baselinekorrektion_show', array('id' => $entity->getId())));
    $this->breadcrumbs->addItem('common.edit', $this->generateUrl('baselinekorrektion_show', array('id' => $entity->getId())));

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find BaselineKorrektion entity.');
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
   * Creates a form to edit a BaselineKorrektion entity.
   *
   * @param BaselineKorrektion $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(BaselineKorrektion $entity) {
    $form = $this->createForm(new BaselineKorrektionType(), $entity, array(
      'action' => $this->generateUrl('baselinekorrektion_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('baselinekorrektion_show', array('id' => $entity->getId())));

    return $form;
  }

  /**
   * Edits an existing BaselineKorrektion entity.
   *
   * @Route("/{id}", name="baselinekorrektion_update")
   * @Method("PUT")
   * @Template("AppBundle:BaselineKorrektion:edit.html.twig")
   */
  public function updateAction(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:BaselineKorrektion')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find BaselineKorrektion entity.');
    }

    $deleteForm = $this->createDeleteForm($id);
    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em->flush();

      return $this->redirect($this->generateUrl('baselinekorrektion'));
    }

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a BaselineKorrektion entity.
   *
   * @Route("/{id}", name="baselinekorrektion_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $id) {
    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('AppBundle:BaselineKorrektion')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find BaselineKorrektion entity.');
      }

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('baselinekorrektion'));
  }

  /**
   * Creates a form to delete a BaselineKorrektion entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('baselinekorrektion_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }
}
