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
use AppBundle\Entity\TiltagDetail;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * TiltagDetail controller.
 *
 * @Route("/tiltag_detail")
 */
class TiltagDetailController extends BaseController {
  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('Rapporter', $this->generateUrl('rapport'));
  }

  private function setBreadcrumb(TiltagDetail $detail) {
    $tiltag = $detail->getTiltag();
    $rapport = $tiltag->getRapport();
    $bygning = $rapport->getBygning();
    $this->breadcrumbs->addItem($rapport, $this->generateUrl('rapport_show', array('id' => $rapport->getId())));
    $this->breadcrumbs->addItem($tiltag, $this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));
    $this->breadcrumbs->addItem($detail);
  }

  /**
   * Finds and displays a TiltagDetail entity.
   *
   * @Route("/{id}", name="tiltag_detail_show")
   * @Method("GET")
   * @Template()
   * @param TiltagDetail $tiltagdetail
   * @return \Symfony\Component\HttpFoundation\Response
   *
   * @Security("is_granted('TILTAGDETAIL_VIEW', tiltagdetail)")
   */
  public function showAction(TiltagDetail $tiltagdetail) {
    $this->setBreadcrumb($tiltagdetail);
    $deleteForm = $this->createDeleteForm($tiltagdetail);

    $template = $this->getTemplate($tiltagdetail, 'show');
    return $this->render($template, array(
      'entity' => $tiltagdetail,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Displays a form to edit an existing TiltagDetail entity.
   *
   * @Route("/{id}/edit", name="tiltag_detail_edit")
   * @Method("GET")
   * @Template()
   * @param TiltagDetail $tiltagdetail
   * @return \Symfony\Component\HttpFoundation\Response
   * @Security("is_granted('TILTAGDETAIL_EDIT', tiltagdetail)")
   */
  public function editAction(TiltagDetail $tiltagdetail) {
    $this->setBreadcrumb($tiltagdetail);
    $editForm = $this->createEditForm($tiltagdetail);
    $deleteForm = $this->createDeleteForm($tiltagdetail);

    $template = $this->getTemplate($tiltagdetail, 'edit');
    return $this->render($template, array(
      'calculation_changes' => $this->container->get('aaplus.tiltagdetail_calculation')->getChanges($tiltagdetail),
      'entity' => $tiltagdetail,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Copies a TiltagDetails and displays a form to edit the dublicated entity.
   *
   * @Route("/{id}/copy", name="tiltag_detail_copy")
   * @Method("GET")
   * @Template()
   * @param TiltagDetail $tiltagdetail
   * @return \Symfony\Component\HttpFoundation\Response
   * @Security("is_granted('TILTAGDETAIL_EDIT', tiltagdetail)")
   */
  public function copyAction(TiltagDetail $tiltagdetail) {
    $copy = clone $tiltagdetail;
    $em = $this->getDoctrine()->getManager();
    $em->persist($copy);
    $em->flush();

    $this->setBreadcrumb($copy);
    $editForm = $this->createEditForm($copy);
    $deleteForm = $this->createDeleteForm($copy);

    $template = $this->getTemplate($copy, 'copy');
    return $this->render($template, array(
      'calculation_changes' => $this->container->get('aaplus.tiltagdetail_calculation')->getChanges($copy),
      'entity' => $copy,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Creates a form to edit a TiltagDetail entity.
   *
   * @param TiltagDetail $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(TiltagDetail $entity) {
    $className = $this->getFormTypeClassName($entity);
    $form = $this->createForm(new $className($this->container), $entity, array(
      'action' => $this->generateUrl('tiltag_detail_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('tiltag_show', array('id' => $entity->getTiltag()->getId())));

    return $form;
  }

  /**
   * Edits an existing TiltagDetail entity.
   *
   * @Route("/{id}", name="tiltag_detail_update")
   * @Method("PUT")
   * @Template("AppBundle:TiltagDetail:edit.html.twig")
   * @param Request $request
   * @param TiltagDetail $tiltagdetail
   * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
   * @Security("is_granted('TILTAGDETAIL_EDIT', tiltagdetail)")
   */
  public function updateAction(Request $request, TiltagDetail $tiltagdetail) {
    $deleteForm = $this->createDeleteForm($tiltagdetail);
    $editForm = $this->createEditForm($tiltagdetail);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $tiltagdetail->handleUploads($this->get('stof_doctrine_extensions.uploadable.manager'));
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      $flash = $this->get('braincrafted_bootstrap.flash');
      $flash->success('tiltagdetail.confirmation.updated');

      return $this->redirect($this->generateUrl('tiltag_show', array('id' => $tiltagdetail->getTiltag()->getId())));
    }

    $template = $this->getTemplate($tiltagdetail, 'edit');
    return $this->render($template, array(
      'entity' => $tiltagdetail,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Deletes a TiltagDetail entity.
   *
   * @Route("/{id}", name="tiltag_detail_delete"),
   * @Method("DELETE")
   * @param Request $request
   * @param TiltagDetail $tiltagdetail
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   * @Security("is_granted('TILTAGDETAIL_EDIT', tiltagdetail)")
   */
  public function deleteAction(Request $request, TiltagDetail $tiltagdetail) {
    $form = $this->createDeleteForm($tiltagdetail);
    $form->handleRequest($request);
    $tiltag = $tiltagdetail->getTiltag();

    if ($form->isValid()) {
      $tiltag->removeDetail($tiltagdetail)->calculate();
      $em = $this->getDoctrine()->getManager();
      $em->remove($tiltagdetail);
      $em->flush();

      $flash = $this->get('braincrafted_bootstrap.flash');
      $flash->success('tiltagdetail.confirmation.deleted');
    }

    return $this->redirect($this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));
  }

  /**
   * Creates a form to delete a TiltagDetail entity
   *
   * @param TiltagDetail $entity
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(TiltagDetail $entity) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('tiltag_detail_delete', array('id' => $entity->getId())))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

  /**
   * Sends a file to the client.
   *
   * @Route("/{id}/download", name="tiltag_detail_download")
   * @Method("GET")
   * @param TiltagDetail $tiltagdetail
   * @return \Symfony\Component\HttpFoundation\Response
   *
   * @Security("is_granted('TILTAGDETAIL_VIEW', tiltagdetail)")
   */
  public function downloadAction(TiltagDetail $tiltagdetail) {
    $path = $tiltagdetail->getFilepath();
    $file = new File($path);
    $response = new BinaryFileResponse($file->getRealPath());
    $response->setContentDisposition(
      ResponseHeaderBag::DISPOSITION_ATTACHMENT,
      $file->getFilename()
    );
    return $response;
  }

  /**
   * @param \AppBundle\Entity\TiltagDetail $entity
   * @return string
   */
  private function getEntityName(TiltagDetail $entity) {
    $className = get_class($entity);
    if (preg_match('@\\\\([^\\\\]+)$@', $className, $matches)) {
      return $matches[1];
    }
    return $className;
  }

  /**
   * @param \AppBundle\Entity\TiltagDetail $entity
   * @param $action
   * @return string
   */
  private function getTemplate(TiltagDetail $entity, $action) {
    $className = $this->getEntityName($entity);
    $template = 'AppBundle:'.$className.':'.$action.'.html.twig';
    if (!$this->get('templating')->exists($template)) {
      $template = 'AppBundle:TiltagDetail:'.$action.'.html.twig';
    }
    return $template;
  }

  /**
   * @param \AppBundle\Entity\TiltagDetail $entity
   * @return string
   */
  private function getFormTypeClassName(TiltagDetail $entity) {
    $className = '\\AppBundle\\Form\\Type\\'.$this->getEntityName($entity).'Type';
    if (!class_exists($className)) {
      $className = '\\AppBundle\\Form\\TiltagDetailType';
    }
    return $className;
  }
}
