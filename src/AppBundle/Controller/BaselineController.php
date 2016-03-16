<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Baseline;
use AppBundle\Form\BaselineType;
use AppBundle\Controller\BaseController;

/**
 * Baseline controller.
 *
 * @Route("/baseline")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class BaselineController extends BaseController {

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('baseline.labels.singular', $this->generateUrl('baseline'));
  }


  /**
   * Lists all Baseline entities.
   *
   * @Route("/", name="baseline")
   * @Method("GET")
   * @Template()
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();

    $entities = $em->getRepository('AppBundle:Baseline')->findAll();

    return array(
      'entities' => $entities,
    );
  }

  /**
   * Creates a new Baseline entity.
   *
   * @Route("/", name="baseline_create")
   * @Method("POST")
   * @Template("AppBundle:Baseline:new.html.twig")
   */
  public function createAction(Request $request) {
    $entity = new Baseline();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('baseline_edit', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a form to create a Baseline entity.
   *
   * @param Baseline $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(Baseline $entity) {
    $form = $this->createForm(new BaselineType(), $entity, array(
      'action' => $this->generateUrl('baseline_create'),
      'method' => 'POST',
    ));

    $this->addUpdate($form, $this->generateUrl('baseline'));

    return $form;
  }

  /**
   * Displays a form to create a new Baseline entity.
   *
   * @Route("/new", name="baseline_new")
   * @Method("GET")
   * @Template()
   */
  public function newAction() {
    $this->breadcrumbs->addItem('common.add', $this->generateUrl('baseline'));

    $entity = new Baseline();
    $form = $this->createCreateForm($entity);

    return array(
      'entity' => $entity,
      'edit_form' => $form->createView(),
    );
  }

  /**
   * Finds and displays a Baseline entity.
   *
   * @Route("/{id}", name="baseline_show")
   * @Method("GET")
   * @Template()
   */
  public function showAction($id) {

    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Baseline')->find($id);
    $this->breadcrumbs->addItem($entity, $this->generateUrl('baseline_show', array('id' => $entity->getId())));

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Baseline entity.');
    }

    $deleteForm = $this->createDeleteForm($id);

    return array(
      'entity' => $entity,
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Displays a form to edit an existing Baseline entity.
   *
   * @Route("/{id}/edit", name="baseline_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction(Baseline $entity) {
    $this->breadcrumbs->addItem($entity, $this->generateUrl('baseline_show', array('id' => $entity->getId())));
    $this->breadcrumbs->addItem('common.edit', $this->generateUrl('baseline_show', array('id' => $entity->getId())));

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Baseline entity.');
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
   * Creates a form to edit a Baseline entity.
   *
   * @param Baseline $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Baseline $entity) {
    $form = $this->createForm(new BaselineType(), $entity, array(
      'action' => $this->generateUrl('baseline_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('baseline_show', array('id' => $entity->getId())));

    return $form;
  }

  /**
   * Edits an existing Baseline entity.
   *
   * @Route("/{id}", name="baseline_update")
   * @Method("PUT")
   * @Template("AppBundle:Baseline:edit.html.twig")
   */
  public function updateAction(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Baseline')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Baseline entity.');
    }

    $deleteForm = $this->createDeleteForm($id);
    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em->flush();

      return $this->redirect($this->generateUrl('baseline_edit', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Baseline entity.
   *
   * @Route("/{id}", name="baseline_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $id) {
    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('AppBundle:Baseline')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find Baseline entity.');
      }

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('baseline'));
  }

  /**
   * Creates a form to delete a Baseline entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('baseline_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }
}
