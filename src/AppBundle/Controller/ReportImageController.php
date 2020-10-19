<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ReportImage;
use AppBundle\Form\Type\ReportImageType;
use Gedmo\Exception\UploadableInvalidMimeTypeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Report images controller.
 *
 * @Route("/report_image")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ReportImageController extends BaseController {

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('reportimage.labels.plural', $this->generateUrl('report_image'));
  }

  /**
   * Redirects to report_image_get
   *
   * @see listAction.
   *
   * @Route("/", name="report_image")
   * @Method("GET")
   * @Template()
   */
  public function indexAction()
  {
    return $this->redirect($this->generateUrl('report_image_get',array('image_type' => 'main')));
  }

  /**
   * Lists all ReportImage of chosen category.
   *
   * @Route("/{image_type}", name="report_image_get")
   * @Method("GET")
   * @Template("AppBundle:ReportImage:list.html.twig")
   */
  public function listAction($image_type) {
    // New form.
    $reportImage = new ReportImage();
    $upload_form = $this->createNewForm($image_type, $reportImage);

    $image_types = array(
      'main',
      'recommendation',
    );
    $suggestion_image_types = array(
      'pumpe',
      'belysning',
      'nyklimaskaerm',
      'vindue',
      'solcelle',
      'tekniskisolering',
      'ventilation',
      'trykluft',
      'varmeanlaeg',
      'koeleanlaeg',
      'special',
    );

    $em = $this->getDoctrine()->getManager();
    $uploaded_images = $em->getRepository('AppBundle:ReportImage')->findBy(array('type' => $image_type));

    $image_elements = array();
    foreach ($uploaded_images as $image) {
      $mark_form = $this->markStandardForm($image);
      $delete_form = $this->createDeleteForm($image->getId());

      $image_elements[$image->getId()] = array(
        'image' => $image,
        'mark_standard_form' => $mark_form->createView(),
        'delete_form' => $delete_form->createView()
      );
    }

    return array(
      'selected_image_type' => $image_type,
      'report_image_types' => $image_types,
      'suggestion_image_types' => $suggestion_image_types,
      'image_elements' => $image_elements,
      'upload_form' => $upload_form->createView(),
    );
  }

  /**
   * Creates a new Report Image entity.
   *
   * @Route("/{image_type}", name="report_image_create")
   * @Method("POST")
   */
  public function newReportImageAction(Request $request, $image_type) {
    $reportImage = new ReportImage();
    $reportImage->setType($image_type);
    $editForm = $this->createNewForm($image_type, $reportImage);

    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      try {
        $this->handleUploads($reportImage);

        $em = $this->getDoctrine()->getManager();
        $em->persist($reportImage);
        $em->flush();

        $this->flash->success('reportimage.confirmation.created');
      }
      catch (UploadableInvalidMimeTypeException $e) {
        $this->flash->error('reportimage.error.filetype');
      }
      catch (\Exception $e) {
        $this->flash->error('reportimage.error.general');
      }
    }

    return $this->redirect($this->generateUrl('report_image_get', array('image_type' => $image_type)));
  }

  /**
   * Edits an existing Bilag entity.
   *
   * @Route("/{report_image_id}/mark-default", name="report_image_mark_standard")
   * @Method("PUT")
   * @ParamConverter("reportImage", class="AppBundle:ReportImage",
   *   options={"id" = "report_image_id"})
   */
  public function markStandardAction(Request $request, ReportImage $reportImage) {
    // Getting all images of that type.
    $em = $this->getDoctrine()->getManager();
    $uploaded_images = $em->getRepository('AppBundle:ReportImage')->findBy(array('type' => $reportImage->getType()));

    /** @var ReportImage $image */
    foreach ($uploaded_images as $image) {
      // Setting standard for the selected image.
      if ($image->getId() == $reportImage->getId()) {
        $image->setStandard(TRUE);
      }
      else {
        $image->setStandard(FALSE);
      }

      $em->persist($image);
    }

    $em->flush();
    $this->flash->success('reportimage.confirmation.created');

    return $this->redirect($this->generateUrl('report_image_get', array('image_type' => $reportImage->getType())));
  }

  /**
   * Deletes a Report Image entity.
   *
   * @Route("/{id}", name="report_image_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $id) {
    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    $reportImage = NULL;

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $reportImage = $em->getRepository('AppBundle:ReportImage')->find($id);

      if (!$reportImage) {
        throw $this->createNotFoundException('Unable to find Report entity.');
      }

      $em->remove($reportImage);
      $em->flush();
    }

    if ($reportImage) {
      $redirectUrl = $this->generateUrl('report_image_get', array('image_type' => $reportImage->getType()));
    }
    else {
      $redirectUrl = $this->generateUrl('report_image_get',array('image_type' => 'main'));
    }

    return $this->redirect($redirectUrl);
  }

  /**
   * Creates a form to create a Report Image entity.
   *
   * @param string $reportImageType
   *   Report image type.
   * @param \AppBundle\Entity\ReportImage $reportImage
   *   Empty report Image entity.
   *
   * @return \Symfony\Component\Form\Form
   *   Create new form.
   */
  private function createNewForm($reportImageType, ReportImage $reportImage) {
    $form = $this->createForm(new ReportImageType($reportImage), $reportImage, array(
      'action' => $this->generateUrl('report_image_create', array('image_type' => $reportImageType)),
      'method' => 'POST',
    ));

    $this->addCreate($form, $this->generateUrl('report_image_create', array('image_type' => $reportImageType)));

    return $form;
  }

  /**
   * Creates a form to mark Image as standard.
   *
   * If image is already standard, the submit button will be disabled.
   *
   * @param ReportImage $reportImage
   *   Report image entity.
   *
   * @return \Symfony\Component\Form\Form
   *   Mark standard form.
   */
  private function markStandardForm(ReportImage $reportImage) {
    if (!$reportImage->isStandard()) {
      $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('report_image_mark_standard', array('report_image_id' => $reportImage->getId())))
        ->setMethod('PUT')
        ->add('submit', 'submit', array(
          'label' => 'reportimage.actions.mark_standard',
          'button_class' => 'default',
          'attr' => [
            'icon' => 'check',
          ],
        ))
        ->getForm();
    }
    else {
      $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('report_image_mark_standard', array('report_image_id' => $reportImage->getId())))
        ->setMethod('PUT')
        ->add('submit', 'submit', array(
          'label' => 'appbundle.reportimage.standard',
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
   * Creates a form to delete a Report Image by id.
   *
   * @param mixed $id
   *   The entity id.
   *
   * @return \Symfony\Component\Form\Form
   *   The delete form.
   */
  private function createDeleteForm($id) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('report_image_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array(
        'label' => 'Delete',
      ))
      ->getForm();
  }

  /**
   * Handles the upload of the image.
   *
   * @param \AppBundle\Entity\ReportImage $reportImage
   *   Report image entity.
   */
  protected function handleUploads(ReportImage $reportImage) {
    $fileInfo = $reportImage->getFilepath();

    if (is_object($fileInfo) && $fileInfo instanceof UploadedFile) {
      $manager = $this->get('stof_doctrine_extensions.uploadable.manager');
      $manager->markEntityToUpload($reportImage, $fileInfo);
    }
  }
}