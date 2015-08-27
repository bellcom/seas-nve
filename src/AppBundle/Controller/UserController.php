<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends BaseController
{
  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('user.labels.plural', $this->generateUrl('user'));
  }

  /**
   * Lists all User entities.
   *
   * @Route("/", name="user")
   * @Method("GET")
   * @Template()
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function indexAction(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $dql   = "SELECT u FROM AppBundle:User u";
    $query = $em->createQuery($dql);

    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
      $query,
      $request->query->get('page', 1),
      20
    );

    return $this->render('AppBundle:User:index.html.twig', array('pagination' => $pagination));
  }

  /**
   * Creates a new User entity.
   *
   * @Route("/", name="user_create")
   * @Method("POST")
   * @Template("AppBundle:User:new.html.twig")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function createAction(Request $request)
  {
    $entity = new User();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'form'   => $form->createView(),
    );
  }

  /**
   * Creates a form to create a User entity.
   *
   * @param User $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(User $entity)
  {
    $form = $this->createForm(new UserType(), $entity, array(
      'action' => $this->generateUrl('user_create'),
      'method' => 'POST',
    ));

    $this->addCreate($form, $this->generateUrl('user'));

    return $form;
  }

  /**
   * Displays a form to create a new User entity.
   *
   * @Route("/new", name="user_new")
   * @Method("GET")
   * @Template()
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function newAction()
  {
    $entity = new User();
    $form   = $this->createCreateForm($entity);
    $this->breadcrumbs->addItem('user.actions.create', $this->generateUrl('user_new'));

    return array(
      'entity' => $entity,
      'form'   => $form->createView(),
    );
  }

  /**
   * Finds and displays a User entity.
   *
   * @Route("/{id}", name="user_show")
   * @Method("GET")
   * @Template()
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:User')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find User entity.');
    }

    $deleteForm = $this->createDeleteForm($id);

    return array(
      'entity'      => $entity,
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Displays a form to edit an existing User entity.
   *
   * @Route("/{id}/edit", name="user_edit")
   * @Method("GET")
   * @Template()
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:User')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find User entity.');
    }

    $editForm = $this->createEditForm($entity);
    $deleteForm = $this->createDeleteForm($id);

    return array(
      'entity'      => $entity,
      'edit_form'   => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Creates a form to edit a User entity.
   *
   * @param User $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(User $entity)
  {
    $form = $this->createForm(new UserType(), $entity, array(
      'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('user'));

    return $form;
  }
  /**
   * Edits an existing User entity.
   *
   * @Route("/{id}", name="user_update")
   * @Method("PUT")
   * @Template("AppBundle:User:edit.html.twig")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function updateAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:User')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find User entity.');
    }

    $deleteForm = $this->createDeleteForm($id);
    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em->flush();

      return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
    }

    return array(
      'entity'      => $entity,
      'edit_form'   => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }
  /**
   * Deletes a User entity.
   *
   * @Route("/{id}", name="user_delete")
   * @Method("DELETE")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function deleteAction(Request $request, $id)
  {
    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('AppBundle:User')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find User entity.');
      }

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('user'));
  }

  /**
   * Creates a form to delete a User entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id)
  {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('user_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm()
      ;
  }
}
