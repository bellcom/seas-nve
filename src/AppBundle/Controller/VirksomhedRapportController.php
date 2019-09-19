<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Virksomhed;
use AppBundle\Form\Type\VirksomhedRapportSearchType;
use AppBundle\Form\Type\VirksomhedRapportShowType;
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
    $this->breadcrumbs->addItem('Virksomhed Rapporter', $this->generateUrl('virksomhed_rapport'));
  }

  /**
   * Lists all VirksomhedRapport entities.
   *
   * @Route("/", name="virksomhed_rapport")
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

    $search['name'] = $rapport->getVirksomhed()->getName();
    $search['address'] = $rapport->getVirksomhed()->getAddress();
    $search['datering'] = $rapport->getDatering();
    $search['version'] = $rapport->getVersion();

    $search['elena'] = $rapport->getElena();
    $search['ava'] = $rapport->getAva();

    $query = $em->getRepository('AppBundle:VirksomhedRapport')->search($search);

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
   *
   * @return array
   */
  public function showAction(VirksomhedRapport $rapport) {
    $this->breadcrumbs->addItem($rapport, $this->generateUrl('virksomhed_rapport_show', array('id' => $rapport->getId())));

    $editForm = $this->createEditFormFinansiering($rapport);

    $calculationChanges = $this->container->get('aaplus.virksomhed_rapport_calculation')->getChanges($rapport);
    $calculateForm = $this->createCalculateForm($rapport, $calculationChanges)->createView();

    $twigVars = array(
      'entity' => $rapport,
      'edit_form' => $editForm ? $editForm->createView() : NULL,
      'calculate_form' => $calculateForm,
      'calculation_changes' => $calculationChanges,
      'calculation_warnings' => $rapport->getCalculationWarnings(),
    );

    return $twigVars;
  }

  /**
   * Finds and displays Baseline for a VirksomhedRapport entity.
   *
   * @Route("/{id}/baseline", name="virksomhed_rapport_show_baseline")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('VIRKSOMHED_RAPPORT_VIEW', rapport)")
   * @param VirksomhedRapport $rapport
   * @return array
   */
  public function baselineAction(VirksomhedRapport $rapport) {
    $this->breadcrumbs->addItem($rapport, $this->generateUrl('virksomhed_rapport_show', array('id' => $rapport->getId())));
    $this->breadcrumbs->addItem('appbundle.virksomhed.baseline', $this->generateUrl('baseline_show', array('id' => $rapport->getVirksomhed()->getBaseline()->getId())));

    $showForm = $this->createForm(new VirksomhedRapportShowType($this->get('security.context'), $rapport), $rapport, array(
      'action' => '#',
      'method' => 'PUT',
    ));

    return array(
      'entity' => $rapport,
      'show_form' => $showForm->createView(),
    );
  }

  /**
   * Finds and displays a VirksomhedRapport entity in PDF form. (Resultatoversigt)
   *
   * @Route("/{id}/pdf2", name="virksomhed_rapport_show_pdf2")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('VIRKSOMHED_RAPPORT_VIEW', rapport)")
   * @param VirksomhedRapport $rapport
   *
   * @return Response
   */
  public function showPdf2Action(VirksomhedRapport $rapport) {
    $exporter = $this->get('aaplus.pdf_export');
    $pdf = $exporter->exportVirksomhedRapport2($rapport);

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
   *
   * @return Response
   */
  public function showPdf5Action(VirksomhedRapport $rapport) {
    $exporter = $this->get('aaplus.pdf_export');
    $pdf = $exporter->exportVirksomhedRapport5($rapport);

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

      $flash->success('virksomhed_rapporter.confirmation.calculated');
    } catch (\Exception $ex) {
      $flash->error('virksomhed_rapporter.error.beregn_fejl');
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
        'label' => 'bygning_rapporter.actions.re-calculate',
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

}
