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
 * @Route("baselinekorrektion")
 */
class BaselineKorrektionController extends BaseController {

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('Bygninger', $this->generateUrl('bygning'));
  }

  /**
   * Displays a form to edit an existing BaselineKorrektion entity.
   *
   * @Route("/{id}/edit", name="baselinekorrektion_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction(BaselineKorrektion $entity) {
    $this->breadcrumbs->addItem($entity->getBaseline()->getBygning(), $this->generateUrl('bygning_show', array('id' => $entity->getBaseline()->getBygning()->getId())));
    $this->breadcrumbs->addItem('appbundle.bygning.baseline', $this->generateUrl('baseline_show', array('id' => $entity->getBaseline()->getId())));
    $this->breadcrumbs->addItem('baselinekorrektioner.actions.edit');

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

    $this->addUpdate($form, $this->generateUrl('baseline_show', array('id' => $entity->getBaseline()->getId())));

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

      return $this->redirect($this->generateUrl('baseline_show', array('id' => $entity->getBaseline()->getId())));
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
    $em = $this->getDoctrine()->getManager();
    $entity = $em->getRepository('AppBundle:BaselineKorrektion')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find BaselineKorrektion entity.');
    }

    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    if ($form->isValid()) {

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('baseline_show', array('id' => $entity->getBaseline()->getId())));
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
