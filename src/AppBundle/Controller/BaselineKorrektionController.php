<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Virksomhed;
use AppBundle\Entity\VirksomhedRapport;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\BaselineKorrektion;
use AppBundle\Entity\Baseline;
use AppBundle\Form\BaselineKorrektionType;
use AppBundle\Controller\BaseController;

/**
 * BaselineKorrektion controller.
 *
 * @Route("baselinekorrektion")
 */
class BaselineKorrektionController extends BaseController {

  public function init(Request $request) {
    $this->request = $request;
    parent::init($request);
    $this->breadcrumbs->addItem('virksomhed.labels.plural', $this->generateUrl('virksomhed'));
  }

  /**
   * Use a Rapport as breadcrumbs rather than a Virksomhed.
   *
   * @param VirksomhedRapport
   *   The virksomhed rapport.
   */
  private function setRapportBreadcrumbs(VirksomhedRapport $rapport, BaselineKorrektion $korrektion) {
    // Reset the breadcrumbs.
    $this->breadcrumbs->clear();
    parent::init($this->request);
    // Add Virksomhed Rapport path.
    $this->breadcrumbs->addItem('virksomhed_rapporter.labels.plural', $this->generateUrl('virksomhed_rapport'));
    $this->breadcrumbs->addItem($rapport, $this->generateUrl('virksomhed_rapport_show', array('id' => $rapport->getId())));
    $this->breadcrumbs->addItem('appbundle.virksomhed.baseline', $this->generateUrl('baseline_edit', array('id' => $korrektion->getBaseline()->getId())));
  }

  /**
   * Displays a form to edit an existing BaselineKorrektion entity.
   *
   * @Route("/{id}/edit", name="baselinekorrektion_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction(BaselineKorrektion $entity) {
    /** @var Virksomhed $virksomhed */
    $virksomhed = $entity->getBaseline()->getVirksomhed();
    $rapport = $virksomhed ? $virksomhed->getRapport() : NULL;
    if ($rapport) {
      $this->setRapportBreadcrumbs($rapport, $entity);
    } else {
      $this->breadcrumbs->addItem($entity->getBaseline()->getVirksomhed(), $this->generateUrl('virksomhed_show', array('id' => $entity->getBaseline()->getVirksomhed()->getId())));
    }
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
    $this->addUpdateAndExit($form, $this->generateUrl('baseline_show', array('id' => $entity->getBaseline()->getId())));

    return $form;
  }

  /**
   * Edits an existing BaselineKorrektion entity.
   *
   * @Route("/{id}/edit", name="baselinekorrektion_update")
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

      $this->flash->success('baselinekorrektioner.confirmation.updated');

      $destination = $request->getRequestUri();
      if ($button_destination = $this->getButtonDestination($editForm)) {
        $destination = $button_destination;
      }
      return $this->redirect($destination);
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
      $this->flash->success('baselinekorrektioner.confirmation.deleted');
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
      ->add('submit', 'submit', array(
        'label' => 'Delete',
        'attr' => array(
          'class' => 'pinned',
        ),
      ))
      ->getForm();
  }
}
