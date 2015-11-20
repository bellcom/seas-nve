<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Forsyningsvaerk;
use AppBundle\Form\Type\ForsyningsvaerkType;
use Yavin\Symfony\Controller\InitControllerInterface;

/**
 * Forsyningsvaerk controller.
 *
 * @Route("/forsyningsvaerk")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ForsyningsvaerkController extends BaseController {
  /**
   * Lists all Forsyningsvaerk entities.
   *
   * @Route("/", name="forsyningsvaerk")
   * @Method("GET")
   * @Template()
   */
  public function indexAction(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $entities = $em->getRepository('AppBundle:Forsyningsvaerk')->findAll();

    return array(
      'entities' => $entities,
    );
  }

  /**
   * Creates a new Forsyningsvaerk entity.
   *
   * @Route("/", name="forsyningsvaerk_create")
   * @Method("POST")
   * @Template("AppBundle:Forsyningsvaerk:new.html.twig")
   *
   * @Security("is_granted('FORSYNINGSVAERK_CREATE')")
   */
  public function createAction(Request $request) {
    $entity = new Forsyningsvaerk();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('forsyningsvaerk_show', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a form to create a Forsyningsvaerk entity.
   *
   * @param Forsyningsvaerk $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(Forsyningsvaerk $entity) {
    $form = $this->createForm(new ForsyningsvaerkType(), $entity, array(
      'action' => $this->generateUrl('forsyningsvaerk_create'),
      'method' => 'POST',
    ));

    $this->addCreate($form, $this->generateUrl('forsyningsvaerk'));

    return $form;
  }

  /**
   * Displays a form to create a new Forsyningsvaerk entity.
   *
   * @Route("/new", name="forsyningsvaerk_new")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('FORSYNINGSVAERK_CREATE')")
   */
  public function newAction() {
    $entity = new Forsyningsvaerk();
    $form = $this->createCreateForm($entity);

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Finds and displays a Forsyningsvaerk entity.
   *
   * @Route("/{id}", name="forsyningsvaerk_show")
   * @Method("GET")
   * @Template()
   * @ Security("is_granted('FORSYNINGSVAERK_VIEW', forsyningsvaerk)")
   */
  public function showAction(Forsyningsvaerk $forsyningsvaerk) {
    $deleteForm = $this->createDeleteForm($forsyningsvaerk->getId());

    return array(
      'entity' => $forsyningsvaerk,
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Displays a form to edit an existing Forsyningsvaerk entity.
   *
   * @Route("/{id}/edit", name="forsyningsvaerk_edit")
   * @Method("GET")
   * @Template()
   * @ Security("is_granted('FORSYNINGSVAERK_EDIT', forsyningsvaerk)")
   */
  public function editAction(Forsyningsvaerk $forsyningsvaerk) {
    $editForm = $this->createEditForm($forsyningsvaerk);
    $deleteForm = $this->createDeleteForm($forsyningsvaerk->getId());

    return array(
      'entity' => $forsyningsvaerk,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Creates a form to edit a Forsyningsvaerk entity.
   *
   * @param Forsyningsvaerk $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Forsyningsvaerk $entity) {
    $form = $this->createForm(new ForsyningsvaerkType(), $entity, array(
      'action' => $this->generateUrl('forsyningsvaerk_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('forsyningsvaerk_show', array('id' => $entity->getId())));

    return $form;
  }

  /**
   * Edits an existing Forsyningsvaerk entity.
   *
   * @Route("/{id}", name="forsyningsvaerk_update")
   * @Method("PUT")
   * @Template("AppBundle:Forsyningsvaerk:edit.html.twig")
   * @ Security("is_granted('FORSYNINGSVAERK_EDIT', forsyningsvaerk)")
   */
  public function updateAction(Request $request, Forsyningsvaerk $forsyningsvaerk) {
    $deleteForm = $this->createDeleteForm($forsyningsvaerk->getId());
    $editForm = $this->createEditForm($forsyningsvaerk);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      return $this->redirect($this->generateUrl('forsyningsvaerk_edit', array('id' => $forsyningsvaerk->getId())));
    }

    return array(
      'entity' => $forsyningsvaerk,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Forsyningsvaerk entity.
   *
   * @Route("/{id}", name="forsyningsvaerk_delete")
   * @Method("DELETE")
   * @Security("is_granted('FORSYNINGSVAERK_EDIT', forsyningsvaerk)")
   */
  public function deleteAction(Request $request, Forsyningsvaerk $forsyningsvaerk) {
    $form = $this->createDeleteForm($forsyningsvaerk->getId());
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($forsyningsvaerk);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('forsyningsvaerk'));
  }

  /**
   * Creates a form to delete a Forsyningsvaerk entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('forsyningsvaerk_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

}
