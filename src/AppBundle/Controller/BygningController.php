<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Bygning;
use AppBundle\Form\BygningType;
use AppBundle\Entity\Rapport;
use AppBundle\Form\RapportType;

/**
 * Bygning controller.
 *
 * @Route("/bygning")
 */
class BygningController extends Controller {
  /**
   * Lists all Bygning entities.
   *
   * @Route("/", name="bygning")
   * @Method("GET")
   * @Template()
   */
  public function indexAction(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $user = $this->get('security.context')->getToken()->getUser();
    $query = $em->getRepository('AppBundle:Bygning')->findByUser($user);

    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
      $query,
      $request->query->get('page', 1),
      20
    );

    return $this->render('AppBundle:Bygning:index.html.twig', array('pagination' => $pagination));
  }

  /**
   * Creates a new Bygning entity.
   *
   * @Route("/", name="bygning_create")
   * @Method("POST")
   * @Template("AppBundle:Bygning:new.html.twig")
   *
   * @Security("is_granted('BYGNING_CREATE')")
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
    $form = $this->createForm(new BygningType(), $entity, array(
      'action' => $this->generateUrl('bygning_create'),
      'method' => 'POST',
    ));

    $form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  /**
   * Displays a form to create a new Bygning entity.
   *
   * @Route("/new", name="bygning_new")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('BYGNING_CREATE')")
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
   */
  public function showAction($id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Bygning')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Bygning entity.');
    }

    if (!$this->get('security.context')->isGranted('BYGNING_VIEW', $entity)) {
      throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('View not allowed');
    }

    $deleteForm = $this->createDeleteForm($id);

    return array(
      'entity' => $entity,
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Displays a form to edit an existing Bygning entity.
   *
   * @Route("/{id}/edit", name="bygning_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction($id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Bygning')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Bygning entity.');
    }

    if (!$this->get('security.context')->isGranted('BYGNING_EDIT', $entity)) {
      throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('Edit not allowed');
    }

    $editForm = $this->createEditForm($entity);
    $deleteForm = $this->createDeleteForm($id);

    return array(
      'entity' => $entity,
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
    $form = $this->createForm(new BygningType(), $entity, array(
      'action' => $this->generateUrl('bygning_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $form->add('submit', 'submit', array('label' => 'Update'));

    return $form;
  }

  /**
   * Edits an existing Bygning entity.
   *
   * @Route("/{id}", name="bygning_update")
   * @Method("PUT")
   * @Template("AppBundle:Bygning:edit.html.twig")
   */
  public function updateAction(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Bygning')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Bygning entity.');
    }

    $deleteForm = $this->createDeleteForm($id);
    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em->flush();

      return $this->redirect($this->generateUrl('bygning_edit', array('id' => $id)));
    }

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Bygning entity.
   *
   * @Route("/{id}", name="bygning_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $id) {
    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('AppBundle:Bygning')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find Bygning entity.');
      }

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('bygning'));
  }

  /**
   * Creates a form to delete a Bygning entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('bygning_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

  //--------- Rapport ---------------//

  /**
   * Creates a form to create a Rapport entity.
   *
   * @param Rapport $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createRapportCreateForm(Rapport $entity, $id) {
    $form = $this->createForm(new RapportType(), $entity, array(
      'action' => $this->generateUrl(
        'bygning_rapport_create',
        array('id' => $id)
      ),
      'method' => 'POST',
    ));

    $form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  /**
   * Displays a form to create a new Rapport entity.
   *
   * @Route("/{id}/rapport/new", name="bygning_rapport_new")
   * @Method("GET")
   * @Template()
   */
  public function newRapportAction($id) {
    $entity = new Rapport();
    $form = $this->createRapportCreateForm($entity, $id);

    return $this->render('AppBundle:Rapport:new.html.twig', array(
      'entity' => $entity,
      'form' => $form->createView(),
    ));
  }

  /**
   * Creates a new Rapport entity.
   *
   * @Route("/{id}/rapport", name="bygning_rapport_create")
   * @Method("POST")
   * @Template("AppBundle:Rapport:new.html.twig")
   */
  public function createRapportAction(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $bygning = $em->getRepository('AppBundle:Bygning')->find($id);

    if (!$bygning) {
      throw $this->createNotFoundException('Unable to find Bygning entity.');
    }

    $entity = new Rapport();
    $entity->setBygning($bygning);
    $form = $this->createRapportCreateForm($entity, $id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('rapport_show', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }
}
