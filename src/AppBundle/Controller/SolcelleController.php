<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Solcelle;
use AppBundle\Form\Type\SolcelleType;
use AppBundle\Controller\BaseController;

/**
 * Solcelle controller.
 *
 * @Route("/solcelle")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class SolcelleController extends BaseController {

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('solcelle.labels.singular', $this->generateUrl('solcelle'));
  }


  /**
   * Lists all Solcelle entities.
   *
   * @Route("/", name="solcelle")
   * @Method("GET")
   * @Template()
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();

    $entities = $em->getRepository('AppBundle:Solcelle')->findAll();

    return array(
      'entities' => $entities,
    );
  }

  /**
   * Creates a new Solcelle entity.
   *
   * @Route("/", name="solcelle_create")
   * @Method("POST")
   * @Template("AppBundle:Solcelle:new.html.twig")
   */
  public function createAction(Request $request) {
    $entity = new Solcelle();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('solcelle'));

    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a form to create a Solcelle entity.
   *
   * @param Solcelle $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(Solcelle $entity) {
    $form = $this->createForm(new SolcelleType(), $entity, array(
      'action' => $this->generateUrl('solcelle_create'),
      'method' => 'POST',
    ));

    $this->addUpdate($form, $this->generateUrl('solcelle'));

    return $form;
  }

  /**
   * Displays a form to create a new Solcelle entity.
   *
   * @Route("/new", name="solcelle_new")
   * @Method("GET")
   * @Template()
   */
  public function newAction() {
    $this->breadcrumbs->addItem('common.add', $this->generateUrl('solcelle'));

    $entity = new Solcelle();
    $form = $this->createCreateForm($entity);

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Finds and displays a Solcelle entity.
   *
   * @Route("/{id}", name="solcelle_show")
   * @Method("GET")
   * @Template()
   */
  public function showAction($id) {

    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Solcelle')->find($id);
    $this->breadcrumbs->addItem($entity, $this->generateUrl('solcelle_show', array('id' => $entity->getId())));

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Solcelle entity.');
    }

    $deleteForm = $this->createDeleteForm($id);

    return array(
      'entity' => $entity,
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Displays a form to edit an existing Solcelle entity.
   *
   * @Route("/{id}/edit", name="solcelle_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction(Solcelle $entity) {
    $this->breadcrumbs->addItem($entity, $this->generateUrl('solcelle_show', array('id' => $entity->getId())));
    $this->breadcrumbs->addItem('common.edit', $this->generateUrl('solcelle_show', array('id' => $entity->getId())));

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Solcelle entity.');
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
   * Creates a form to edit a Solcelle entity.
   *
   * @param Solcelle $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Solcelle $entity) {
    $form = $this->createForm(new SolcelleType(), $entity, array(
      'action' => $this->generateUrl('solcelle_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('solcelle_show', array('id' => $entity->getId())));

    return $form;
  }

  /**
   * Edits an existing Solcelle entity.
   *
   * @Route("/{id}", name="solcelle_update")
   * @Method("PUT")
   * @Template("AppBundle:Solcelle:edit.html.twig")
   */
  public function updateAction(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Solcelle')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Solcelle entity.');
    }

    $deleteForm = $this->createDeleteForm($id);
    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em->flush();

      return $this->redirect($this->generateUrl('solcelle'));
    }

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Solcelle entity.
   *
   * @Route("/{id}", name="solcelle_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $id) {
    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('AppBundle:Solcelle')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find Solcelle entity.');
      }

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('solcelle'));
  }

  /**
   * Creates a form to delete a Solcelle entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('solcelle_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }
}
