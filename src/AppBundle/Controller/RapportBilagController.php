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
use AppBundle\Form\Type\RapportBilagType;
use AppBundle\Entity\Rapport;

/**
 * RapportBilag controller.
 *
 * @Route("/rapport/{rapport_id}/bilag")
 * @ParamConverter("rapport", class="AppBundle:Rapport", options={"id" = "rapport_id"})
 * @Security("is_granted('RAPPORT_EDIT', rapport)")
 */
class RapportBilagController extends BaseController {
  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('Rapporter', $this->generateUrl('rapport'));
  }

  private function setBreadcrumb(Rapport $rapport) {
    $this->breadcrumbs->addItem($rapport, $this->generateUrl('rapport_show', array('id' => $rapport->getId())));
    $this->breadcrumbs->addItem('Bilag', $this->generateUrl('rapport_bilag_get', array('rapport_id' => $rapport->getId())));
  }

  /**
   * Get Bilag.
   *
   * @Route("", name="rapport_bilag_get")
   * @Method("GET")
   * @Template("AppBundle:RapportBilag:list.html.twig")
   * @Security("is_granted('RAPPORT_VIEW', rapport)")
   *
   * @param Rapport $rapport
   *
   * @return Response
   */
  public function listBilagAction(Rapport $rapport) {
    $this->setBreadcrumb($rapport);

    return array(
      'entity' => $rapport
    );
  }

  /**
   * Displays a form to edit an existing Bilag entity.
   *
   * @Route("/{bilag_id}/edit", name="rapport_bilag_edit")
   * @Method("GET")
   * @Template()
   * @ParamConverter("bilag", class="AppBundle:Bilag", options={"id" = "bilag_id"})
   */
  public function editAction(Rapport $rapport, Bilag $bilag) {
    $this->setBreadcrumb($rapport);
    $this->breadcrumbs->addItem($bilag->getTitel() ? $bilag->getTitel() : $bilag->getId(), $this->generateUrl('rapport_bilag_edit', array('rapport_id' => $rapport->getId(), 'bilag_id' => $bilag->getId())));

    $editForm = $this->createEditForm($rapport, $bilag);
    $deleteForm = $this->createDeleteForm($rapport, $bilag);

    $template = $this->getTemplate('edit');
    return $this->render($template, array(
      'entity' => $bilag,
      'rapport' => $rapport,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Displays a form to create a new Bilag entity.
   *
   * @Route("/new", name="bilag_rapport_new")
   * @Method("GET")
   * @Template()
   */
  public function createForRapportAction(Rapport $rapport) {
    $this->setBreadcrumb($rapport);
    $this->breadcrumbs->addItem("Opret");

    $bilag = new Bilag();
    $bilag->setRapport($rapport);

    $editForm = $this->createNewForm($rapport, $bilag);

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
  private function createEditForm(Rapport $rapport, Bilag $bilag) {
    $form = $this->createForm(new RapportBilagType($bilag), $bilag, array(
      'action' => $this->generateUrl('rapport_bilag_update', array('rapport_id' => $rapport->getId(), 'bilag_id' => $bilag->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('rapport_bilag_edit', array('rapport_id' => $rapport->getId(), 'bilag_id' => $bilag->getId())));

    return $form;
  }

  /**
   * Creates a form to create a Bilag entity.
   *
   * @param Bilag $bilag The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createNewForm(Rapport $rapport, Bilag $bilag) {
    $form = $this->createForm(new RapportBilagType($bilag), $bilag, array(
      'action' => $this->generateUrl('rapport_bilag_create', array('rapport_id' => $rapport->getId())),
      'method' => 'POST',
    ));

    $this->addCreate($form, $this->generateUrl('rapport_bilag_create', array('rapport_id' => $rapport->getId())));

    return $form;
  }

  /**
   * Creates a form to delete a Bilag entity
   *
   * @param Bilag $bilag
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Rapport $rapport, Bilag $bilag) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('rapport_bilag_delete', array('rapport_id' => $rapport->getId(), 'bilag_id' => $bilag->getId())))
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
    return 'AppBundle:RapportBilag' . ':' . $action . '.html.twig';
  }

  /**
   * Edits an existing Bilag entity.
   *
   * @Route("/{bilag_id}", name="rapport_bilag_update")
   * @Method("PUT")
   * @Template("AppBundle:RapportBilag:edit.html.twig")
   * @ParamConverter("bilag", class="AppBundle:Bilag", options={"id" = "bilag_id"})
   */
  public function updateAction(Request $request, Rapport $rapport, Bilag $bilag) {
    $deleteForm = $this->createDeleteForm($rapport, $bilag);
    $editForm = $this->createEditForm($rapport, $bilag);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $bilag->handleUploads($this->get('stof_doctrine_extensions.uploadable.manager'));
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      $this->flash->success('bilag.confirmation.updated');

      return $this->redirect($this->generateUrl('rapport_bilag_get', array('rapport_id' => $rapport->getId())));
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
   * @Route("", name="rapport_bilag_create")
   * @Method("POST")
   * @Template("AppBundle:RapportBilag:new.html.twig")
   */
  public function newBilagAction(Request $request, Rapport $rapport) {
    $bilag = new Bilag();

    $editForm = $this->createNewForm($rapport, $bilag);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $bilag->handleUploads($this->get('stof_doctrine_extensions.uploadable.manager'));
      $em = $this->getDoctrine()->getManager();
      $em->persist($bilag);
      $em->flush();

      $this->flash->success('bilag.confirmation.created');

      return $this->redirect($this->generateUrl('rapport_bilag_get', array('rapport_id' => $rapport->getId())));
    }

    return array(
      'entity' => $bilag,
      'edit_form' => $editForm->createView(),
    );
  }

  /**
   * Deletes a Bilag entity.
   *
   * @Route("/{bilag_id}", name="rapport_bilag_delete")
   * @Method("DELETE")
   * @ParamConverter("bilag", class="AppBundle:Bilag", options={"id" = "bilag_id"})
   */
  public function deleteAction(Request $request, Rapport $rapport, Bilag $bilag) {
    $form = $this->createDeleteForm($rapport, $bilag);
    $form->handleRequest($request);

    $rapport = $bilag->getRapport();

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($bilag);
      $em->flush();

      $this->flash->success('bilag.confirmation.deleted');
    }

    return $this->redirect($this->generateUrl('rapport_bilag_get', array('rapport_id' => $rapport->getId())));
  }

  /**
   * Finds and displays a Bilag entity.
   *
   * @Route("/{bilag_id}", name="rapport_bilag_show")
   * @Method("GET")
   * @param Bilag $bilag
   * @ParamConverter("bilag", class="AppBundle:Bilag", options={"id" = "bilag_id"})
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function showAction(Rapport $rapport, Bilag $bilag) {
    $this->setBreadcrumb($rapport);
    $this->breadcrumbs->addItem($bilag->getTitel() ? $bilag->getTitel() : $bilag->getId(), $this->generateUrl('rapport_bilag_show', array('rapport_id' => $rapport->getId(), 'bilag_id' => $bilag->getId())));

    $deleteForm = $this->createDeleteForm($rapport, $bilag);
    $editForm = $this->createEditForm($rapport, $bilag);

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
   * @Route("/{bilag_id}/download", name="rapport_bilag_download")
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

