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
use AppBundle\Entity\Klimaskaerm;
use AppBundle\Form\Type\KlimaskaermType;
use Yavin\Symfony\Controller\InitControllerInterface;

/**
 * Klimaskaerm controller.
 *
 * @Route("/klimaskaerm")
 */
class KlimaskaermController extends BaseController {
  /**
   * Lists all Klimaskaerm entities.
   *
   * @Route("/", name="klimaskaerm")
   * @Method("GET")
   * @Template()
   */
  public function indexAction(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $entities = $em->getRepository('AppBundle:Klimaskaerm')->findAll();

    return array(
      'entities' => $entities,
    );
  }

  /**
   * Creates a new Klimaskaerm entity.
   *
   * @Route("/", name="klimaskaerm_create")
   * @Method("POST")
   * @Template("AppBundle:Klimaskaerm:new.html.twig")
   *
   * @Security("has_role('ROLE_KLIMASKAERM_CREATE')")
   */
  public function createAction(Request $request) {
    $entity = new Klimaskaerm();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('klimaskaerm_show', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a form to create a Klimaskaerm entity.
   *
   * @param Klimaskaerm $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(Klimaskaerm $entity) {
    $form = $this->createForm(new KlimaskaermType(), $entity, array(
      'action' => $this->generateUrl('klimaskaerm_create'),
      'method' => 'POST',
    ));

    $this->addCreate($form, $this->generateUrl('klimaskaerm'));

    return $form;
  }

  /**
   * Displays a form to create a new Klimaskaerm entity.
   *
   * @Route("/new", name="klimaskaerm_new")
   * @Method("GET")
   * @Template()
   * @Security("has_role('ROLE_KLIMASKAERM_CREATE')")
   */
  public function newAction() {
    $entity = new Klimaskaerm();
    $form = $this->createCreateForm($entity);

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Finds and displays a Klimaskaerm entity.
   *
   * @Route("/{id}", name="klimaskaerm_show")
   * @Method("GET")
   * @Template()
   * @ Security("is_granted('KLIMASKAERM_VIEW', klimaskaerm)")
   */
  public function showAction(Klimaskaerm $klimaskaerm) {
    $deleteForm = $this->createDeleteForm($klimaskaerm->getId());

    return array(
      'entity' => $klimaskaerm,
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Displays a form to edit an existing Klimaskaerm entity.
   *
   * @Route("/{id}/edit", name="klimaskaerm_edit")
   * @Method("GET")
   * @Template()
   * @ Security("is_granted('KLIMASKAERM_EDIT', klimaskaerm)")
   */
  public function editAction(Klimaskaerm $klimaskaerm) {
    $editForm = $this->createEditForm($klimaskaerm);
    $deleteForm = $this->createDeleteForm($klimaskaerm->getId());

    return array(
      'entity' => $klimaskaerm,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Creates a form to edit a Klimaskaerm entity.
   *
   * @param Klimaskaerm $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Klimaskaerm $entity) {
    $form = $this->createForm(new KlimaskaermType(), $entity, array(
      'action' => $this->generateUrl('klimaskaerm_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('klimaskaerm_show', array('id' => $entity->getId())));

    return $form;
  }

  /**
   * Edits an existing Klimaskaerm entity.
   *
   * @Route("/{id}", name="klimaskaerm_update")
   * @Method("PUT")
   * @Template("AppBundle:Klimaskaerm:edit.html.twig")
   * @ Security("is_granted('KLIMASKAERM_EDIT', klimaskaerm)")
   */
  public function updateAction(Request $request, Klimaskaerm $klimaskaerm) {
    $deleteForm = $this->createDeleteForm($klimaskaerm->getId());
    $editForm = $this->createEditForm($klimaskaerm);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      return $this->redirect($this->generateUrl('klimaskaerm_edit', array('id' => $klimaskaerm->getId())));
    }

    return array(
      'entity' => $klimaskaerm,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Klimaskaerm entity.
   *
   * @Route("/{id}", name="klimaskaerm_delete")
   * @Method("DELETE")
   * @Security("has_role('ROLE_KLIMASKAERM_EDIT', klimaskaerm)")
   */
  public function deleteAction(Request $request, Klimaskaerm $klimaskaerm) {
    $form = $this->createDeleteForm($klimaskaerm->getId());
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($klimaskaerm);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('klimaskaerm'));
  }

  /**
   * Creates a form to delete a Klimaskaerm entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('klimaskaerm_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

}
