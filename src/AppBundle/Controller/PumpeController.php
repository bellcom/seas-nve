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
use AppBundle\Entity\Pumpe;
use AppBundle\Form\Type\PumpeType;

/**
 * Pumpe controller.
 *
 * @Route("/pumpe")
 */
class PumpeController extends Controller {
  /**
   * Lists all Pumpe entities.
   *
   * @Route("/", name="pumpe")
   * @Method("GET")
   * @Template()
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();

    $entities = $em->getRepository('AppBundle:Pumpe')->findAll();

    return array(
      'entities' => $entities,
    );
  }

  /**
   * Finds and displays a Pumpe entity.
   *
   * @Route("/{id}", name="pumpe_show")
   * @Method("GET")
   * @Template()
   */
  public function showAction(Pumpe $pumpe) {
    return array(
      'entity' => $pumpe,
      'delete_form' => $this->createDeleteForm($pumpe)->createView(),
    );
  }

  /**
   * Finds and edits a Pumpe entity.
   *
   * @Route("/{id}/edit", name="pumpe_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction(Pumpe $pumpe) {
    $editForm = $this->createEditForm($pumpe);

    return array(
      'entity' => $pumpe,
      'edit_form' => $editForm->createView(),
    );
  }

  /**
   * Finds and edits a Pumpe entity.
   *
   * @Route("/{id}", name="pumpe_update")
   * @Method("PUT")
   * @Template()
   */
  public function updateAction(Pumpe $pumpe, Request $request) {
    $editForm = $this->createEditForm($pumpe);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($pumpe);
      $em->flush();

      return $this->redirect($this->generateUrl('pumpe_edit', array('id' => $pumpe->getId())));
    }
  }

  /**
   * Creates a form to edit a Bygning entity.
   *
   * @param Bygning $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Pumpe $pumpe) {
    $form = $this->createForm(new PumpeType(), $pumpe, array(
      'action' => $this->generateUrl('pumpe_update', array('id' => $pumpe->getId())),
      'method' => 'PUT',
    ));

    $form->add('submit', 'submit', array('label' => 'Update'));

    return $form;
  }

  /**
   * Deletes a Pumpe entity.
   *
   * @Route("/{id}", name="pumpe_delete")
   * @Method("DELETE")
   * @Template()
   */
  public function deleteAction(Request $request, $id) {
    $entity = $this->getRepository()->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Pumpe entity.');
    }

    $form = $this->createDeleteForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($entity);
      $em->flush();
    }

    return $this->redirectToRoute('pumpe');
  }

  /**
   * Creates a form to delete a Pumpe entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Pumpe $pumpe) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('pumpe_delete', array_merge($this->get('request')->query->all(), array('id' => $pumpe->getId()))))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

  private function getRepository() {
    $repo = $this->getDoctrine()->getManager()
          ->getRepository('AppBundle:Pumpe');
    // if ($this->get('request')->query->get('show') == 'all') {
    //   $repo->disableFilter();
    // }

    return $repo;
  }

}
