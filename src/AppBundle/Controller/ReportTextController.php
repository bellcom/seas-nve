<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RapportSektioner\RapportSektion;
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
   * Redirects to report_image_get
   *
   * @see listAction.
   *
   * @Route("/", name="report_text")
   * @Method("GET")
   * @Template()
   */
  public function indexAction()
  {
    $types = RapportSektion::getRapportSektionTypes(TRUE);
    return $this->redirect($this->generateUrl('report_text_get',array('type' => $types[0])));
  }

  /**
   * Lists all ReportImage of chosen category.
   *
   * @Route("/{type}", name="report_text_get")
   * @Method("GET")
   * @Template("AppBundle:ReportText:list.html.twig")
   */
  public function listAction($type) {
      $sectionTypes = RapportSektion::getRapportSektionTypes();

      $reportSectionTextTypes = array();
      foreach ($sectionTypes as $sectionKey => $sectionClass) {
          $defaultableFields = call_user_func(array('AppBundle\Entity\RapportSektioner\\' . $sectionClass, 'getDefaultableTextFields'));

          foreach ($defaultableFields as $field) {
              $reportSectionTextTypes[$sectionKey][$sectionKey . '_' . $field] = $field;
          }
      }

      $em = $this->getDoctrine()->getManager();
      $reportTexts = $em->getRepository('AppBundle:ReportText')->findBy(array('type' => $type));

      $elements = array();
      foreach ($reportTexts as $reportText) {
          $mark_form = $this->markStandardForm($reportText);
          $delete_form = $this->createDeleteForm($reportText);

          $elements[$reportText->getId()] = array(
              'entity' => $reportText,
              'mark_standard_form' => $mark_form->createView(),
              'delete_form' => $delete_form->createView()
          );
      }

      $type_parts =explode('_', $type);
      $selected_section = $type_parts[0];
      $selected_field = $type_parts[1];

      return array(
          'selected_text_type' => $type,
          'selected_section' => $selected_section,
          'selected_field' => $selected_field,
          'report_section_text_types' => $reportSectionTextTypes,
          'elements' => $elements,
      );
  }


  /**
   * Displays a form to create a new Bilag entity.
   *
   * @Route("/new/{type}", name="report_text_new")
   * @Method("GET")
   * @Template("AppBundle:ReportText:new.html.twig")
   */
  public function createReportTextAction($type) {
    $this->breadcrumbs->addItem('common.create');

    $reportText = new ReportText();
    $reportText->setType($type);
    $editForm = $this->createNewForm($type, $reportText);

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
    $editForm = $this->createNewForm("",$reportText);

    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($reportText);
      $em->flush();

      $this->flash->success('reporttext.confirmation.created');

      return $this->redirect($this->generateUrl('report_text_get', array('type' => $reportText->getType())));
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
   * Edits an existing ReportText as standard.
   *
   * @Route("/{report_text_id}/mark-default", name="report_text_mark_standard")
   * @Method("PUT")
   * @ParamConverter("reportText", class="AppBundle:ReportText",
   *   options={"id" = "report_text_id"})
   */
  public function markStandardAction(Request $request, ReportText $reportText) {
    // Getting all images of that type.
    $em = $this->getDoctrine()->getManager();
    $uploaded_images = $em->getRepository('AppBundle:ReportText')->findBy(array('type' => $reportText->getType()));

    /** @var ReportText $text */
    foreach ($uploaded_images as $text) {
      // Setting standard for the selected text.
      if ($text->getId() == $reportText->getId()) {
        $text->setStandard(TRUE);
      }
      else {
        $text->setStandard(FALSE);
      }

      $em->persist($text);
    }

    $em->flush();
    $this->flash->success('reporttext.confirmation.updated');

    return $this->redirect($this->generateUrl('report_text_get', array('type' => $reportText->getType())));
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

    return $this->redirect($this->generateUrl('report_text_get', array('type' => $reportText->getType())));
  }

  /**
   * Creates a form to create a ReportText entity.
   *
   * @param string $type
   *   The type of report text..
   * @param ReportText $reportText
   *   The entity.
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createNewForm($type, ReportText $reportText) {
    $form = $this->createForm(new ReportTextType($type, $reportText), $reportText, array(
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
    $form = $this->createForm(new ReportTextType($reportText->getType(), $reportText), $reportText, array(
      'action' => $this->generateUrl('report_text_update', array('report_text_id' => $reportText->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('report_text_get', array('type' => $reportText->getType())));
    $this->addUpdateAndExit($form, $this->generateUrl('report_text_get', array('type' => $reportText->getType())));

    return $form;
  }

  /**
   * Creates a form to mark ReportText as standard.
   *
   * If text is already standard, the submit button will be disabled.
   *
   * @param ReportText $reportText
   *   Report text entity.
   *
   * @return \Symfony\Component\Form\Form
   *   Mark standard form.
   */
  private function markStandardForm(ReportText $reportText) {
    if (!$reportText->isStandard()) {
      $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('report_text_mark_standard', array('report_text_id' => $reportText->getId())))
        ->setMethod('PUT')
        ->add('submit', 'submit', array(
          'label' => 'reporttext.actions.mark_standard',
          'button_class' => 'default',
          'attr' => [
            'icon' => 'check',
          ],
        ))
        ->getForm();
    }
    else {
      $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('report_text_mark_standard', array('report_text_id' => $reportText->getId())))
        ->setMethod('PUT')
        ->add('submit', 'submit', array(
          'label' => 'appbundle.reporttext.standard',
          'attr' => [
            'class' => 'disabled',
            'icon' => 'check',
          ],
          'button_class' => 'success'
        ))
        ->getForm();
    }

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
