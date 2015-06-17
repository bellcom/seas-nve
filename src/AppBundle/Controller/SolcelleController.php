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
use AppBundle\Entity\Solcelle;
use AppBundle\Form\Type\SolcelleType;
use Yavin\Symfony\Controller\InitControllerInterface;

/**
 * Solcelle controller.
 *
 * @Route("/solcelle")
 */
class SolcelleController extends Controller {
  /**
   * Lists all Solcelle entities.
   *
   * @Route("/", name="solcelle")
   * @Method("GET")
   * @Template()
   */
  public function indexAction(Request $request) {
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
   *
   * @Security("has_role('ROLE_SOLCELLE_CREATE')")
   */
  public function createAction(Request $request) {
    $entity = new Solcelle();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('solcelle_show', array('id' => $entity->getId())));
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

    $form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  /**
   * Displays a form to create a new Solcelle entity.
   *
   * @Route("/new", name="solcelle_new")
   * @Method("GET")
   * @Template()
   * @Security("has_role('ROLE_SOLCELLE_CREATE')")
   */
  public function newAction() {
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
   * @ Security("is_granted('SOLCELLE_VIEW', solcelle)")
   */
  public function showAction(Solcelle $solcelle) {
    $deleteForm = $this->createDeleteForm($solcelle->getId());

    return array(
      'entity' => $solcelle,
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Displays a form to edit an existing Solcelle entity.
   *
   * @Route("/{id}/edit", name="solcelle_edit")
   * @Method("GET")
   * @Template()
   * @ Security("is_granted('SOLCELLE_EDIT', solcelle)")
   */
  public function editAction(Solcelle $solcelle) {
    $editForm = $this->createEditForm($solcelle);
    $deleteForm = $this->createDeleteForm($solcelle->getId());

    return array(
      'entity' => $solcelle,
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

    $form->add('submit', 'submit', array('label' => 'Update'));

    return $form;
  }

  /**
   * Edits an existing Solcelle entity.
   *
   * @Route("/{id}", name="solcelle_update")
   * @Method("PUT")
   * @Template("AppBundle:Solcelle:edit.html.twig")
   * @ Security("is_granted('SOLCELLE_EDIT', solcelle)")
   */
  public function updateAction(Request $request, Solcelle $solcelle) {
    $deleteForm = $this->createDeleteForm($solcelle->getId());
    $editForm = $this->createEditForm($solcelle);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      return $this->redirect($this->generateUrl('solcelle_edit', array('id' => $solcelle->getId())));
    }

    return array(
      'entity' => $solcelle,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Solcelle entity.
   *
   * @Route("/{id}", name="solcelle_delete")
   * @Method("DELETE")
   * @Security("is_granted('SOLCELLE_EDIT', solcelle)")
   */
  public function deleteAction(Request $request, Solcelle $solcelle) {
    $form = $this->createDeleteForm($solcelle->getId());
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($solcelle);
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
