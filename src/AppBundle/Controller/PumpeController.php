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
use AppBundle\Entity\Pumpe;
use AppBundle\Form\Type\PumpeType;

/**
 * Pumpe controller.
 *
 * @Route("/pumpe")
 */
class PumpeController extends BaseController {
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
   * @param Pumpe $pumpe
   * @return array
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
   * @param Pumpe $pumpe
   * @return array
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
   * @Template("AppBundle:Pumpe:edit.html.twig")
   * @param Pumpe $pumpe
   * @param Request $request
   * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
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

    return $this->editAction($pumpe);
  }

  /**
   * Creates a form to edit a Pumpe entity.
   *
   * @param Pumpe $pumpe The Pumpe
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Pumpe $pumpe) {
    $form = $this->createForm(new PumpeType(), $pumpe, array(
      'action' => $this->generateUrl('pumpe_update', array('id' => $pumpe->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('pumpe_show', array('id' => $pumpe->getId())));

    return $form;
  }

  /**
   * Deletes a Pumpe entity.
   *
   * @Route("/{id}", name="pumpe_delete")
   * @Method("DELETE")
   * @Template()
   * @param Pumpe $pumpe
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   */
  public function deleteAction(Pumpe $pumpe, Request $request) {
    $form = $this->createDeleteForm($pumpe);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($pumpe);
      $em->flush();
    }

    return $this->redirectToRoute('pumpe');
  }

  /**
   * Creates a form to delete a Pumpe entity by id.
   *
   * @param Pumpe $pumpe The Pumpe
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

}
