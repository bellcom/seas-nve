<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Virksomhed;
use AppBundle\Form\Type\VirksomhedRapportSearchType;
use AppBundle\Form\Type\VirksomhedRapportStatusType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\VirksomhedRapport;
use AppBundle\Form\Type\VirksomhedRapportType;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Yavin\Symfony\Controller\InitControllerInterface;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Fil;
use Doctrine\ORM\Mapping\Entity;

/**
 * Rapport controller.
 *
 * @Route("/virksomhed/rapport")
 */
class VirksomhedRapportController extends BaseController {
  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('Virksomhed Rapporter', $this->generateUrl('virksomed_rapport'));
  }

  /**
   * Lists all VirksomhedRapport entities.
   *
   * @Route("/", name="virksomed_rapport")
   * @Method("GET")
   * @Template()
   */
  public function indexAction(Request $request) {
    $rapport = new VirksomhedRapport();
    $rapport->setDatering(null);
    $rapport->setElena(null);
    $rapport->setAva(null);
    $rapport->setVersion(null);
    $virksomhed = new Virksomhed();
    $rapport->setVirksomhed($virksomhed);

    $form = $this->createSearchForm($rapport);
    $form->handleRequest($request);

    if($form->isSubmitted()) {
      $this->breadcrumbs->addItem('Søg', $this->generateUrl('rapport'));
    }

    $em = $this->getDoctrine()->getManager();

    $search = array();

    $search['navn'] = $rapport->getVirksomhed()->getNavn();
    $search['adresse'] = $rapport->getVirksomhed()->getAdresse();
    $search['postnummer'] = $rapport->getVirksomhed()->getPostnummer();
    $search['segment'] = $rapport->getVirksomhed()->getSegment();
    $search['status'] = $rapport->getVirksomhed()->getStatus();
    $search['datering'] = $rapport->getDatering();
    $search['version'] = $rapport->getVersion();

    $search['elena'] = $rapport->getElena();
    $search['ava'] = $rapport->getAva();

    $user = $this->get('security.context')->getToken()->getUser();

    $query = $em->getRepository('AppBundle:VirksomhedRapport')->searchByUser($user, $search);

    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
      $query,
      $request->query->get('page', 1),
      20
    );

    return $this->render('AppBundle:VirksomhedRapport:index.html.twig', array('pagination' => $pagination, 'search' => $search, 'form' => $form->createView()));
  }

  /**
   * Creates a form to search VirksomhedRapport entities.
   *
   * @param VirksomhedRapport $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createSearchForm(VirksomhedRapport $entity) {
    $form = $this->createForm(new VirksomhedRapportSearchType($this->get('security.context')), $entity, array(
      'action' => $this->generateUrl('rapport'),
      'method' => 'GET',
    ));

    return $form;
  }

  /**
   * Finds and displays a VirksomhedRapport entity.
   *
   * @Route("/{id}", name="virksomhed_rapport_show")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('VIRKSOMHED_RAPPORT_VIEW', rapport)")
   * @param VirksomhedRapport $rapport
   * @return array
   */
  public function showAction(VirksomhedRapport $rapport) {
    $this->breadcrumbs->addItem($rapport, $this->generateUrl('virksomhed_rapport_show', array('id' => $rapport->getId())));

    $deleteForm = $this->createDeleteForm($rapport->getId())->createView();
    $editForm = $this->createEditFormFinansiering($rapport);

    $calculationChanges = $this->container->get('aaplus.rapport_calculation')->getChanges($rapport);
    $calculateForm = $this->createCalculateForm($rapport, $calculationChanges)->createView();

    $twigVars = array(
      'entity' => $rapport,
      'delete_form' => $deleteForm,
      'edit_form' => $editForm ? $editForm->createView() : NULL,
      'calculate_form' => $calculateForm,
      'calculation_changes' => $calculationChanges,
      'calculation_warnings' => $rapport->getCalculationWarnings(),
    );

    return $twigVars;
  }

  /**
   * Finds and displays a VirksomhedRapport entity in PDF form. (Resultatoversigt)
   *
   * @Route("/{id}/pdf2", name="virksomhed_rapport_show_pdf2")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('VIRKSOMHED_RAPPORT_VIEW', rapport)")
   * @param VirksomhedRapport $rapport
   * @return array
   */
  public function showPdf2Action(VirksomhedRapport $rapport) {
    $exporter = $this->get('aaplus.pdf_export');
    $pdf = $exporter->export2($rapport);

    $pdfName = $rapport->getVirksomhed()->getAddress() . '-Dokument 2-' . date('Y-m-d') . '-Status ' . $rapport->getVirksomhed() . '-Itt ' . $rapport->getVersion();

    return new Response($pdf, 200, array(
      'Content-Type'          => 'application/pdf',
      'Content-Disposition'   => 'attachment; filename="' . $pdfName . '.pdf"',
    ));
  }

  /**
   * Finds and displays a VirksomhedRapport entity in PDF form. (Detailark)
   *
   * @Route("/{id}/pdf5", name="virksomhed_rapport_show_pdf5")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('VIRKSOMHED_RAPPORT_VIEW', rapport)")
   * @param VirksomhedRapport $rapport
   * @return array
   */
  public function showPdf5Action(VirksomhedRapport $rapport) {
    $exporter = $this->get('aaplus.pdf_export');
    $pdf = $exporter->export5($rapport);

    $pdfName = $rapport->getVirksomhed()->getAddress() . '-Dokument 5-' . date('Y-m-d') . '-Status ' . $rapport->getVirksomhed() . '-Itt ' . $rapport->getVersion();

    return new Response($pdf, 200, array(
      'Content-Type'          => 'application/pdf',
      'Content-Disposition'   => 'attachment; filename="' . $pdfName .'.pdf"',
    ));
  }

  /**
   * Finds and displays a VirksomhedRapport entity.
   *
   * @Route("/{id}/pdf2test", name="virksomhed_rapport_show_pdf2test")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('VIRKSOMHED_RAPPORT_VIEW', rapport)")
   * @param VirksomhedRapport $rapport
   * @return array
   */
  public function showPdf2TestAction(VirksomhedRapport $rapport) {

    return array(
      'rapport' => $rapport,
      'entity' => $rapport,
    );

  }

  /**
   * Finds and displays a VirksomhedRapport entity.
   *
   * @Route("/{id}/pdf5test", name="virksomhed_rapport_show_pdf5test")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('VIRKSOMHED_RAPPORT_VIEW', rapport)")
   * @param VirksomhedRapport $rapport
   * @return array
   */
  public function showPdf5TestAction(VirksomhedRapport $rapport) {

    return array(
      'rapport' => $rapport,
      'entity' => $rapport,
    );

  }

  /**
   * Displays a form to edit an existing VirksomhedRapport entity.
   *
   * @Route("/{id}/edit", name="virksomhed_rapport_edit")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('VIRKSOMHED_RAPPORT_EDIT', rapport)")
   */
  public function editAction(VirksomhedRapport $rapport) {
    $this->breadcrumbs->addItem($rapport, $this->generateUrl('virksomhed_rapport_show', array('id' => $rapport->getId())));
    $this->breadcrumbs->addItem('common.edit', $this->generateUrl('virksomhed_rapport_edit', array('id' => $rapport->getId())));

    $editForm = $this->createEditForm($rapport);
    $deleteForm = $this->createDeleteForm($rapport->getId());

    return array(
      'entity' => $rapport,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Edits an existing VirksomhedRapport entity.
   *
   * @Route("/{id}", name="virksomhed_rapport_update")
   * @Method("PUT")
   * @Template("AppBundle:VirksomhedRapport:edit.html.twig")
   * @Security("is_granted('VIRKSOMHED_RAPPORT_EDIT', rapport)")
   */
  public function updateAction(Request $request, VirksomhedRapport $rapport) {
    $this->breadcrumbs->addItem($rapport, $this->generateUrl('virksomhed_rapport_show', array('id' => $rapport->getId())));
    $this->breadcrumbs->addItem('common.edit', $this->generateUrl('virksomhed_rapport_edit', array('id' => $rapport->getId())));

    $deleteForm = $this->createDeleteForm($rapport->getId());
    $editForm = $this->createEditForm($rapport);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      return $this->redirect($this->generateUrl('virksomhed_rapport_show', array('id' => $rapport->getId())));
    }

    return array(
      'entity' => $rapport,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Creates a form to delete a VirksomhedRapport entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('virksomhed_rapport_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

  /**
   * Deletes a VirksomhedRapport entity.
   *
   * @Route("/{id}", name="virksomhed_rapport_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $id) {
    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('AppBundle:VirksomhedRapport')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find Rapport entity.');
      }

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('virksomhed_rapport'));
  }

  /**
   * Creates a form to edit a VirksomhedRapport entity.
   *
   * @param VirksomhedRapport $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(VirksomhedRapport $entity) {
    $form = $this->createForm(new VirksomhedRapportType($this->get('security.context'), $entity), $entity, array(
      'action' => $this->generateUrl('virksomhed_rapport_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('virksomhed_rapport_show', array('id' => $entity->getId())));

    return $form;
  }

  //---------------- Rådgiver aflever -------------------//

  /**
   * Aaplus verifies a VirksomhedRapport entity.
   *
   * @Route("/{id}/submit", name="virksomhed_rapport_submit")
   * @Method("PUT")
   * @Security("is_granted('VIRKSOMHED_RAPPORT_EDIT', rapport)")
   */
  public function submitAction(Request $request, VirksomhedRapport $rapport) {
    $this->statusAction($request, $rapport, 'virksomhed_rapport_submit', 'rapporter.actions.submit');

    $this->flash->success('rapporter.confirmation.submitted');

    return $this->redirect($this->generateUrl('dashboard_default'));
  }

  //---------------- Retur til Rådgiver -------------------//

  /**
   * Aaplus verifies a Rapport entity.
   *
   * @Route("/{id}/retur", name="virksomhed_rapport_retur")
   * @Method("PUT")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function returAction(Request $request, VirksomhedRapport $rapport) {
    $this->statusAction($request, $rapport, 'virksomhed_rapport_retur', 'rapporter.actions.retur');

    $this->flash->success('rapporter.confirmation.retur');

    return $this->redirect($this->generateUrl('dashboard_default'));
  }


  //---------------- Aa+ Verificeret -------------------//

  /**
   * Aaplus verifies a VirksomhedRapport entity.
   *
   * @Route("/{id}/verify", name="virksomhed_rapport_verify")
   * @Method("PUT")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function verifyAction(Request $request, VirksomhedRapport $rapport) {
    $this->statusAction($request, $rapport, 'virksomhed_rapport_verify', 'rapporter.actions.verify');

    $this->flash->success('rapporter.confirmation.verified');

    return $this->redirect($this->generateUrl('dashboard_default'));
  }

  //---------------- Godkendt Magistrat -------------------//

  /**
   * Magistrat VirksomhedRapport Godkendt
   *
   * @Route("/{id}/approve", name="virksomhed_rapport_approve")
   * @Method("PUT")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function approvedAction(Request $request, VirksomhedRapport $rapport) {
    $this->statusAction($request, $rapport, 'virksomhed_rapport_approve', 'rapporter.actions.approve');

    $this->flash->success('rapporter.confirmation.approved');

    return $this->redirect($this->generateUrl('dashboard_default'));
  }

  //---------------- Under udførsel -------------------//

  /**
   * Under udførsel
   *
   * @Route("/{id}/implementation", name="virksomhed_rapport_implementation")
   * @Method("PUT")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function implementationAction(Request $request, VirksomhedRapport $rapport) {
    $this->statusAction($request, $rapport, 'virksomhed_rapport_implementation', 'rapporter.actions.implementation');

    $this->flash->success('rapporter.confirmation.implementation');

    return $this->redirect($this->generateUrl('dashboard_default'));
  }

  //---------------- Drift -------------------//

  /**
   * Drift
   *
   * @Route("/{id}/operation", name="virksomhed_rapport_operation")
   * @Method("PUT")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function operationAction(Request $request, VirksomhedRapport $rapport) {
    $this->statusAction($request, $rapport, 'virksomhed_rapport_operation', 'rapporter.actions.operation');

    $this->flash->success('rapporter.confirmation.operation');

    return $this->redirect($this->generateUrl('dashboard_default'));
  }

  //---------------- Generic Status -------------------//


  private function statusAction(Request $request, VirksomhedRapport $rapport, $route, $label) {
    $form = $this->createStatusForm($rapport, $route, $label);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $rapport = $em->getRepository('AppBundle:VirksomhedRapport')->find($rapport->getId());

      if (!$rapport) {
        throw $this->createNotFoundException('Unable to find Rapport entity.');
      }

      $exporter = $this->get('aaplus.pdf_export');
      $filRepository = $em->getRepository('AppBundle:Fil');

      $pdf = $exporter->export2($rapport);
      $pdfName = $rapport->getVirksomhed()->getAdresse() . '-Dokument 2-' . date('Y-m-d') . '-Status '.$rapport->getVirksomhed().'-Itt '.$rapport->getVersion() . '.pdf';

      $fil = new Fil();
      $fil
        ->setNavn($pdfName)
        ->setEntity($rapport);
      $filRepository->saveContent($pdf, $fil, $this->container);
      $em->persist($fil);

      $pdf = $exporter->export5($rapport);
      $pdfName = $rapport->getVirksomhed()->getAdresse() . '-Dokument 5-' . date('Y-m-d') . '-Status '.$rapport->getVirksomhed().'-Itt '.$rapport->getVersion() . '.pdf';

      $fil = new Fil();
      $fil
        ->setNavn($pdfName)
        ->setEntity($rapport);
      $filRepository->saveContent($pdf, $fil, $this->container);
      $em->persist($fil);

      $rapport->setVersion($rapport->getVersion() + 1);
      $em->flush();
    }

  }

  /**
   * Creates a form to verify a VirksomhedRapport entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createStatusForm(VirksomhedRapport $entity, $route, $label) {
    $form = $this->createForm(new VirksomhedRapportStatusType($this->get('security.context')), $entity, array(
      'action' => $this->generateUrl($route, array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, null, $label);

    return $form;

  }

  //---------------- Regninger -------------------//

  /**
   * Finds and displays a VirksomhedRapport entity.
   *
   * @Route("/{id}/regninger", name="virksomhed_rapport_regninger_show")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('VIRKSOMHED_RAPPORT_VIEW', rapport)")
   * @param VirksomhedRapport $rapport
   * @return array
   */
  public function showRegningerAction(VirksomhedRapport $rapport) {
    $this->breadcrumbs->addItem($rapport->getVirksomhed(), $this->get('router')
      ->generate('virksomhed_show', array(
        'id' => $rapport->getVirksomhed()
          ->getId()
      )));
    $this->breadcrumbs->addItem($rapport->getVersion(), $this->get('router')
      ->generate('virksomhed_rapport_show', array('id' => $rapport->getId())));

    $deleteForm = $this->createDeleteForm($rapport->getId());

    return array(
      'tiltag' => $rapport->getTiltag(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Finds and displays a VirksomhedRapport entity.
   *
   * @Route("/{id}/finansiering", name="virksomhed_rapport_finansiering_show")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('VIRKSOMHED_RAPPORT_VIEW', rapport)")
   * @param VirksomhedRapport $rapport
   * @return array
   */
  public function showFinansieringAction(VirksomhedRapport $rapport) {
    $this->breadcrumbs->addItem($rapport->getVirksomhed(), $this->get('router')
      ->generate('virksomhed_show', array(
        'id' => $rapport->getVirksomhed()
          ->getId()
      )));
    $this->breadcrumbs->addItem($rapport->getVersion(), $this->get('router')
      ->generate('virksomhed_rapport_show', array('id' => $rapport->getId())));

    $editForm = $this->createEditFormFinansiering($rapport);

    return array(
      'entity' => $rapport,
      'edit_form' => $editForm ? $editForm->createView() : NULL,
    );
  }

  /**
   * Creates a form to edit a VirksomhedRapport entity.
   *
   * @param VirksomhedRapport $rapport The rapport
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditFormFinansiering(VirksomhedRapport $rapport) {
    if (!$this->container->get('security.context')->isGranted('VIRKSOMHED_RAPPORT_EDIT', $rapport)) {
      return NULL;
    }

    $form = $this->createFormBuilder($rapport)
      ->setAction($this->generateUrl('virksomhed_rapport_finansiering_update', array('id' => $rapport->getId())))
      ->setMethod('PUT')
      ->add('laanLoebetid', NULL, array(
        'label' => 'løbetid',
        'attr' => array(
          'input_group' => array(
            'append' => 'år'
          )
        ),
      ))
      ->getForm();

    $this->addUpdate($form);

    return $form;
  }

  /**
   * Edits an existing VirksomhedRapport entity.
   *
   * @Route("/{id}/finansiering", name="virksomhed_rapport_finansiering_update")
   * @Method("PUT")
   * @Security("is_granted('VIRKSOMHED_RAPPORT_EDIT', rapport)")
   */
  public function updateActionFinansiering(Request $request, VirksomhedRapport $rapport) {
    $em = $this->getDoctrine()->getManager();

    $editForm = $this->createEditFormFinansiering($rapport);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $rapport->calculate();
      $em->persist($rapport);
      $em->flush();

      return $this->redirect($request->headers->get('referer'));
    }

    return array(
      'entity' => $rapport,
      'edit_form' => $editForm->createView(),
    );
  }

  /**
   * Calculates and persists a VirksomhedRapport entity.
   *
   * @Route("/{id}/calculate", name="virksomhed_rapport_calculate")
   * @Method("POST")
   * @Security("is_granted('VIRKSOMHED_RAPPORT_EDIT', rapport)")
   */
  public function calculateAction(Request $request, VirksomhedRapport $rapport) {
    $em = $this->getDoctrine()->getManager();
    $flash = $this->get('braincrafted_bootstrap.flash');

    try {
      $rapport->calculate();

      $em->persist($rapport);
      $em->flush();

      $flash->success('Virksomhed Rapport calculated');
    } catch (\Exception $ex) {
      $flash->error('Cannot calculate rapport');
    }

    return $this->redirect($this->generateUrl('virksomhed_rapport_show', array('id' => $rapport->getId())));
  }

  /**
   * Creates a form to calculate a VirksomhedRapport entity.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCalculateForm(VirksomhedRapport $rapport, array $changes) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('virksomhed_rapport_calculate', array('id' => $rapport->getId())))
      ->setMethod('POST')
      ->add('submit', 'submit', array(
        'label' => 'rapporter.actions.re-calculate',
        'disabled' => empty($changes),
        'button_class' => 'default',
      ))
      ->getForm();
  }

  /**
   * Lists all files for the VirksomhedRapport.
   *
   * @Route("/{id}/filer", name="virksomhed_rapport_filer")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('VIRKSOMHED_RAPPORT_VIEW', rapport)")
   */
  public function showFilerAction(Request $request, VirksomhedRapport $rapport) {
    $this->breadcrumbs->addItem($rapport, $this->generateUrl('virksomhed_rapport_show', array('id' => $rapport->getId())));
    $this->breadcrumbs->addItem('filer', $this->generateUrl('virksomhed_rapport_filer', array('id' => $rapport->getId())));

    $em = $this->getDoctrine()->getManager();
    $filRepository = $em->getRepository('AppBundle:Fil');

    $filer = $filRepository->findByEntity($rapport);

    return array(
      'entity' => $rapport,
      'filer' => $filer,
    );
  }

  /**
   * Lists all files for the VirksomhedRapport.
   *
   * @Route("/{id}/fil/{fil}", name="virksomhed_rapport_fil")
   * @Method("GET")
   * @Security("is_granted('VIRKSOMHED_RAPPORT_VIEW', rapport)")
   */
  public function filAction(Request $request, VirksomhedRapport $rapport, Fil $fil) {
    $path = $fil->getFilepath();
    $file = new File($path);
    $response = new BinaryFileResponse($file->getRealPath());
    if ($request->query->getBoolean('download', false)) {
      $response->setContentDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        $fil->getNavn()
      );
    }
    return $response;
  }

  /**
   * Download all files for VirksomhedRapport.
   *
   * @Route("/{id}/download_files", name="virksomhed_rapport_download_files")
   * @Method("GET")
   * @Security("is_granted('VIRKSOMHED_RAPPORT_VIEW', rapport)")
   */
  public function downloadFilesAction(Request $request, VirksomhedRapport $rapport) {
    $allFiles = $rapport->getAllFiles();

    if (!$allFiles) {
      $this->flash->error('rapporter.messages.no_files');
      return $this->redirect($this->generateUrl('virksomhed_rapport_show', array('id' => $rapport->getId())));
    }

    $zipName = 'Bilag-' . $rapport->getVirksomhed()->getAdresse() . '-' . date('Y-m-d') . '.zip';
    // Sanitize filename.
    $zipName = preg_replace('/[^a-z0-9.-]/i', '_', $zipName);

    $archive = new \ZipArchive();
    $zipPath = tempnam(sys_get_temp_dir(), $zipName);
    $archive->open($zipPath, \ZipArchive::CREATE);

    $this->addFilesToArchive($archive, $allFiles);
    $archive->close();

    $response = new BinaryFileResponse($zipPath);
    $response->setContentDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        $zipName
    );

    return $response;
  }

  /**
   * Add files to archive.
   *
   * If a value in $files is an array the files in the value will be added to a sub-directory.
   *
   * @param array $files
   *   The files to add.
   * @param string $dir
   *   The dir to add files to. Must be empty or end with a slash (/).
   */
  private function addFilesToArchive(\ZipArchive $archive, array $files, $dir = '') {
    if ($files) {
      foreach ($files as $key => $data) {
        if (is_array($data)) {
          $subDir = $dir . $key . '/';
          $archive->addEmptyDir($subDir);
          $this->addFilesToArchive($archive, $data, $subDir);
        } else {
          $file = new File($data);
          $archive->addFromString($dir . $file->getBasename(), file_get_contents($file->getRealPath()));
        }
      }
    }
  }

}
