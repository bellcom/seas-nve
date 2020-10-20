<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ReportText;
use AppBundle\Form\Type\ReportTextType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Report text controller.
 *
 * @Route("/report_text")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ReportTextController extends BaseController {

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('reporttext.labels.plural', $this->generateUrl('report_text'));
  }

  /**
   * Lists os report texts.
   *
   * @Route("/", name="report_text")
   * @Method("GET")
   * @Template("AppBundle:ReportText:index.html.twig")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $entities = $em->getRepository('AppBundle:ReportText')->findAll();

    return array(
      'entities' => $entities,
    );
  }

  /**
   * Displays a form to create a new Bilag entity.
   *1
   * @Route("/new", name="report_text_new")
   * @Method("GET")
   * @Template("AppBundle:ReportText:new.html.twig")
   */
  public function createReportTextAction() {
    $this->breadcrumbs->addItem('common.create');

    $reportText = new ReportText();
    $editForm = $this->createNewForm($reportText);

    return array(
      'entity' => $reportText,
      'edit_form' => $editForm->createView()
    );
  }

  /**
   * Creates a new ReportText entity.
   *
   * @Route("", name="report_text_create")
   * @Method("POST")
   * @Template("AppBundle:ReportText:new.html.twig")
   */
  public function newReportTextAction(Request $request) {
    $reportText = new ReportText();
    $editForm = $this->createNewForm($reportText);

    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($reportText);
      $em->flush();

      $this->flash->success('reporttext.confirmation.created');

      return $this->redirect($this->generateUrl('report_text'));
    }

    return array(
      'entity' => $reportText,
      'edit_form' => $editForm->createView(),
    );
  }

  /**
   * Displays a form to edit an existing ReportText entity.
   *
   * @Route("/{report_text_id}/edit", name="report_text_edit")
   * @Method("GET")
   * @Template("AppBundle:ReportText:edit.html.twig")
   * @ParamConverter("reportText", class="AppBundle:ReportText", options={"id" = "report_text_id"})
   */
  public function editAction(ReportText $reportText) {
    $this->breadcrumbs->addItem($reportText->getTitle());

    $editForm = $this->createEditForm($reportText);
    $deleteForm = $this->createDeleteForm($reportText);

    return array(
      'entity' => $reportText,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Edits an existing Bilag entity.
   *
   * @Route("/{report_text_id}/edit", name="report_text_update")
   * @Method("PUT")
   * @Template("AppBundle:ReportText:edit.html.twig")
   * @ParamConverter("reportText", class="AppBundle:ReportText", options={"id" = "report_text_id"})
   */
  public function updateAction(Request $request, ReportText $reportText) {
    $editForm = $this->createEditForm($reportText);
    $deleteForm = $this->createDeleteForm($reportText);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      $this->flash->success('reporttext.confirmation.updated');

      $destination = $request->getRequestUri();
      if ($button_destination = $this->getButtonDestination($editForm)) {
        $destination = $button_destination;
      }
      return $this->redirect($destination);
    }

    return array(
      'entity' => $reportText,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a ReportText entity.
   *
   * @Route("/{report_text_id}", name="report_text_delete")
   * @Method("DELETE")
   * @ParamConverter("reportText", class="AppBundle:ReportText", options={"id" = "report_text_id"})
   */
  public function deleteAction(Request $request, ReportText $reportText) {
    $form = $this->createDeleteForm($reportText);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($reportText);
      $em->flush();

      $this->flash->success('reporttext.confirmation.deleted');
    }

    return $this->redirect($this->generateUrl('report_text'));
  }

  /**
   * Creates a form to create a ReportText entity.
   *
   * @param ReportText $reportText
   *   The entity.
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createNewForm(ReportText $reportText) {
    $form = $this->createForm(new ReportTextType($reportText), $reportText, array(
      'action' => $this->generateUrl('report_text_create'),
      'method' => 'POST',
    ));

    $this->addCreate($form, $this->generateUrl('report_text_create'));

    return $form;
  }

  /**
   * Creates a form to edit a ReportText entity.
   *
   * @param ReportText $reportText The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(ReportText $reportText) {
    $form = $this->createForm(new ReportTextType($reportText), $reportText, array(
      'action' => $this->generateUrl('report_text_update', array('report_text_id' => $reportText->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('report_text'));
    $this->addUpdateAndExit($form, $this->generateUrl('report_text'));

    return $form;
  }

  /**
   * Creates a form to delete a ReportText entity
   *
   * @param ReportText $reportText
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(ReportText $reportText) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('report_text_delete', array('report_text_id' => $reportText->getId())))
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