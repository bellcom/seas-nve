<?php
/**
 * @file
 * Contains BilagController.
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Yavin\Symfony\Controller\InitControllerInterface;

use AppBundle\Entity\Bilag;
use AppBundle\Form\Type\TiltagBilagType;
use AppBundle\Entity\Tiltag;
use AppBundle\Entity\SpecialTiltag;

/**
 * TiltagBilag controller.
 *
 * @Route("/tiltag/{tiltag_id}/bilag")
 * @ParamConverter("tiltag", class="AppBundle:Tiltag", options={"id" = "tiltag_id"})
 * @Security("is_granted('TILTAG_EDIT', tiltag)")
 */
class TiltagBilagController extends BaseController {
  public function init(Request $request) {
    parent::init($request);
  }

  private function setBreadcrumb(Tiltag $tiltag) {
    $this->breadcrumbs->addItem('Rapporter', $this->generateUrl('rapport'));
    $this->breadcrumbs->addItem($tiltag->getRapport(), $this->generateUrl('rapport_show', array('id' => $tiltag->getRapport()->getId())));
    $this->breadcrumbs->addItem('Tiltag');
    $this->breadcrumbs->addItem($tiltag, $this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));
    $this->breadcrumbs->addItem('Bilag', $this->generateUrl('tiltag_bilag_get', array('tiltag_id' => $tiltag->getId())));
  }

  /**
   * Get Bilag.
   *
   * @Route("", name="tiltag_bilag_get")
   * @Method("GET")
   * @Template("AppBundle:TiltagBilag:list.html.twig")
   * @Security("is_granted('TILTAG_VIEW', tiltag)")
   *
   * @param Tiltag $tiltag
   *
   * @return Response
   */
  public function listBilagAction(Tiltag $tiltag) {
    if ($tiltag instanceof SpecialTiltag) {
      $editURL = $this->generateUrl('tiltag_show', array('id' => $tiltag->getId()));
      return $this->redirect($editURL);
    }

    $this->setBreadcrumb($tiltag);

    return array(
      'entity' => $tiltag
    );
  }

  /**
   * Displays a form to edit an existing Bilag entity.
   *
   * @Route("/{bilag_id}/edit", name="tiltag_bilag_edit")
   * @Method("GET")
   * @Template()
   * @ParamConverter("bilag", class="AppBundle:Bilag", options={"id" = "bilag_id"})
   */
  public function editAction(Tiltag $tiltag, Bilag $bilag) {
    $this->setBreadcrumb($tiltag);
    $this->breadcrumbs->addItem($bilag->getTitel() ? $bilag->getTitel() : $bilag->getId(), $this->generateUrl('tiltag_bilag_edit', array(
      'tiltag_id' => $tiltag->getId(),
      'bilag_id' => $bilag->getId()
    )));

    $editForm = $this->createEditForm($tiltag, $bilag);
    $deleteForm = $this->createDeleteForm($tiltag, $bilag);

    $template = $this->getTemplate('edit');
    return $this->render($template, array(
      'entity' => $bilag,
      'tiltag' => $tiltag,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Displays a form to create a new Bilag entity.
   *
   * @Route("/new", name="bilag_tiltag_new")
   * @Method("GET")
   * @Template()
   */
  public function createForTiltagAction(Tiltag $tiltag) {
    if ($tiltag instanceof SpecialTiltag) {
      $editURL = $this->generateUrl('tiltag_detail_new', array('id' => $tiltag->getId()));
      return $this->redirect($editURL);
    }

    $this->setBreadcrumb($tiltag);
    $this->breadcrumbs->addItem("Opret");

    $bilag = new Bilag();
    $bilag->setTiltag($tiltag);

    $editForm = $this->createNewForm($tiltag, $bilag);

    $template = $this->getTemplate('new');
    return $this->render($template, array(
      'entity' => $bilag,
      'edit_form' => $editForm->createView()
    ));
  }

  /**
   * Creates a form to edit a Bilag entity.
   *
   * @param Bilag $bilag The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Tiltag $tiltag, Bilag $bilag) {
    $form = $this->createForm(new TiltagBilagType($bilag), $bilag, array(
      'action' => $this->generateUrl('tiltag_bilag_update', array('tiltag_id' => $tiltag->getId(), 'bilag_id' => $bilag->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('tiltag_bilag_edit', array('tiltag_id' => $tiltag->getId(), 'bilag_id' => $bilag->getId())));

    return $form;
  }

  /**
   * Creates a form to create a Bilag entity.
   *
   * @param Bilag $bilag The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createNewForm(Tiltag $tiltag, Bilag $bilag) {
    $form = $this->createForm(new TiltagBilagType($bilag), $bilag, array(
      'action' => $this->generateUrl('tiltag_bilag_create', array('tiltag_id' => $tiltag->getId())),
      'method' => 'POST',
    ));

    $this->addCreate($form, $this->generateUrl('tiltag_bilag_create', array('tiltag_id' => $tiltag->getId())));

    return $form;
  }

  /**
   * Creates a form to delete a Bilag entity
   *
   * @param Bilag $bilag
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Tiltag $tiltag, Bilag $bilag) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('tiltag_bilag_delete', array('tiltag_id' => $tiltag->getId(), 'bilag_id' => $bilag->getId())))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

  /**
   * Get template for a bilag and an action.
   *
   * @param string $action
   * @return string
   */
  private function getTemplate($action) {
    return 'AppBundle:TiltagBilag:' . $action . '.html.twig';
  }

  /**
   * Edits an existing Bilag entity.
   *
   * @Route("/{bilag_id}", name="tiltag_bilag_update")
   * @Method("PUT")
   * @Template("AppBundle:TiltagBilag:edit.html.twig")
   * @ParamConverter("bilag", class="AppBundle:Bilag", options={"id" = "bilag_id"})
   */
  public function updateAction(Request $request, Tiltag $tiltag, Bilag $bilag) {
    $deleteForm = $this->createDeleteForm($tiltag, $bilag);
    $editForm = $this->createEditForm($tiltag, $bilag);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $bilag->handleUploads($this->get('stof_doctrine_extensions.uploadable.manager'));
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      $flash = $this->get('braincrafted_bootstrap.flash');
      $flash->success('bilag.confirmation.updated');

      return $this->redirect($this->generateUrl('tiltag_bilag_get', array('tiltag_id' => $tiltag->getId())));
    }

    return array(
      'entity' => $bilag,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Creates a new Bilag entity.
   *
   * @Route("", name="tiltag_bilag_create")
   * @Method("POST")
   * @Template("AppBundle:TiltagBilag:new.html.twig")
   */
  public function newBilagAction(Request $request, Tiltag $tiltag) {
    $bilag = new Bilag();

    $editForm = $this->createNewForm($tiltag, $bilag);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $bilag->handleUploads($this->get('stof_doctrine_extensions.uploadable.manager'));
      $em = $this->getDoctrine()->getManager();
      $em->persist($bilag);
      $em->flush();

      $flash = $this->get('braincrafted_bootstrap.flash');
      $flash->success('bilag.confirmation.created');

      return $this->redirect($this->generateUrl('tiltag_bilag_get', array('tiltag_id' => $tiltag->getId())));
    }

    return array(
      'entity' => $bilag,
      'edit_form' => $editForm->createView(),
    );
  }

  /**
   * Deletes a Bilag entity.
   *
   * @Route("/{bilag_id}", name="tiltag_bilag_delete")
   * @Method("DELETE")
   * @ParamConverter("bilag", class="AppBundle:Bilag", options={"id" = "bilag_id"})
   */
  public function deleteAction(Request $request, Tiltag $tiltag, Bilag $bilag) {
    $form = $this->createDeleteForm($tiltag, $bilag);
    $form->handleRequest($request);

    $tiltag = $bilag->getTiltag();

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($bilag);
      $em->flush();

      $flash = $this->get('braincrafted_bootstrap.flash');
      $flash->success('bilag.confirmation.deleted');
    }

    return $this->redirect($this->generateUrl('tiltag_bilag_get', array('tiltag_id' => $tiltag->getId())));
  }

  /**
   * Finds and displays a Bilag entity.
   *
   * @Route("/{bilag_id}", name="tiltag_bilag_show")
   * @Method("GET")
   * @param Bilag $bilag
   * @ParamConverter("bilag", class="AppBundle:Bilag", options={"id" = "bilag_id"})
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function showAction(Tiltag $tiltag, Bilag $bilag) {
    $this->setBreadcrumb($tiltag);
    $this->breadcrumbs->addItem($bilag->getTitel() ? $bilag->getTitel() : $bilag->getId(), $this->generateUrl('tiltag_bilag_show', array(
      'tiltag_id' => $tiltag->getId(),
      'bilag_id' => $bilag->getId()
    )));

    $deleteForm = $this->createDeleteForm($tiltag, $bilag);
    $editForm = $this->createEditForm($tiltag, $bilag);

    $template = $this->getTemplate('show');
    return $this->render($template, array(
      'entity' => $bilag,
      'delete_form' => $deleteForm->createView(),
      'edit_form' => $editForm->createView(),
    ));
  }

  /**
   * Sends a file to the client.
   *
   * @Route("/{bilag_id}/download", name="tiltag_bilag_download")
   * @Method("GET")
   * @ParamConverter("bilag", class="AppBundle:Bilag", options={"id" = "bilag_id"})
   * @param Bilag $bilag
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function downloadAction(Bilag $bilag) {
    $path = $bilag->getFilepath();
    $file = new File($path);
    $response = new BinaryFileResponse($file->getRealPath());
    $response->setContentDisposition(
      ResponseHeaderBag::DISPOSITION_ATTACHMENT,
      $file->getFilename()
    );
    return $response;
  }

}

