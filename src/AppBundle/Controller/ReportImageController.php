<?php

namespace AppBundle\Controller;

use AppBundle\DBAL\Types\SlutanvendelseType;
use AppBundle\Entity\BelysningTiltagDetail\Lyskilde;
use AppBundle\Entity\Bilag;
use AppBundle\Entity\Bygning;
use AppBundle\Entity\Rapport;
use AppBundle\Entity\ReportImage;
use AppBundle\Form\BelysningTiltagDetail\LyskildeType;
use AppBundle\Form\Type\RapportBilagType;
use AppBundle\Form\Type\RapportSearchType;
use AppBundle\Form\Type\ReportImageMarkStandardType;
use AppBundle\Form\Type\ReportImageType;
use Gedmo\Exception\UploadableInvalidMimeTypeException;
use mysql_xdevapi\Exception;
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
   * Lists all BelysningTiltagDetail\Lyskilde entities.
   *
   * @Route("/", name="report_image")
   * @Method("GET")
   * @Template()
   */
  public function indexAction()
  {
    return $this->redirect($this->generateUrl('report_image_get',array('image_type' => 'main')));

    var_dump('test');
    //\Doctrine\Common\Util\Debug::dump($entities);
  }

  /**
   * Lists all BelysningTiltagDetail\Lyskilde entities.
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
      $mark_form = $this->createForm(new ReportImageMarkStandardType($image), $image, array(
        'action' => $this->generateUrl('report_image_mark_standard', array('report_image_id' => $image->getId())),
        'method' => 'PUT',
      ));

      $image_elements[$image->getId()] = array(
        'image' => $image,
        'mark_standard_form' => $mark_form->createView()
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

    return $this->redirect($this->generateUrl('report_image', array('image_type' => $image_type)));
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

    return $this->redirect($this->generateUrl('report_image', array('image_type' => $reportImage->getType())));
  }

  /**
   * Creates a form to create a Bilag entity.
   *
   * @param Bilag $bilag The entity
   *
   * @return \Symfony\Component\Form\Form The form
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
   * Handles the upload of the image.
   *
   * @param $manager
   */
  protected function handleUploads(ReportImage $reportImage) {
    $fileInfo = $reportImage->getFilepath();

    if (is_object($fileInfo) && $fileInfo instanceof UploadedFile) {
      $manager = $this->get('stof_doctrine_extensions.uploadable.manager');
      $manager->markEntityToUpload($this, $fileInfo);
    }
  }
}