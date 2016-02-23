<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\DBAL\Types\BygningStatusType;
use AppBundle\Entity\Bygning;
use AppBundle\Form\Type\RapportSearchType;
use AppBundle\Form\Type\TiltagTilvalgtType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Rapport;
use AppBundle\Form\Type\RapportType;
use Yavin\Symfony\Controller\InitControllerInterface;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Bilag;
use Doctrine\ORM\Mapping\Entity;

/**
 * Rapport controller.
 *
 * @Route("/rapport")
 */
class RapportController extends BaseController {
  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('Rapporter', $this->generateUrl('rapport'));
  }

  /**
   * Lists all Rapport entities.
   *
   * @Route("/", name="rapport")
   * @Method("GET")
   * @Template()
   */
  public function indexAction(Request $request) {
    $rapport = new Rapport();
    $rapport->setDatering(null);
    $bygning = new Bygning();
    $bygning->setStatus(null);
    $rapport->setBygning($bygning);

    $form = $this->createSearchForm($rapport);
    $form->handleRequest($request);

    if($form->isSubmitted()) {
      $this->breadcrumbs->addItem('Søg', $this->generateUrl('rapport'));
    }

    $em = $this->getDoctrine()->getManager();

    $search = array();

    $search['navn'] = $rapport->getBygning()->getNavn();
    $search['adresse'] = $rapport->getBygning()->getAdresse();
    $search['postnummer'] = $rapport->getBygning()->getPostnummer();
    $search['segment'] = $rapport->getBygning()->getSegment();
    $search['status'] = $rapport->getBygning()->getStatus();
    $search['datering'] = $rapport->getDatering();

    $search['elena'] = $rapport->getElena();

    $user = $this->get('security.context')->getToken()->getUser();

    $query = $em->getRepository('AppBundle:Rapport')->searchByUser($user, $search);

    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
      $query,
      $request->query->get('page', 1),
      20
    );

    return $this->render('AppBundle:Rapport:index.html.twig', array('pagination' => $pagination, 'search' => $search, 'form' => $form->createView()));
  }

  /**
   * Creates a form to search Rapport entities.
   *
   * @param Bygning $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createSearchForm(Rapport $entity) {
    $form = $this->createForm(new RapportSearchType($this->get('security.context')), $entity, array(
      'action' => $this->generateUrl('rapport'),
      'method' => 'GET',
    ));

    return $form;
  }

  /**
   * Finds and displays a Rapport entity.
   *
   * @Route("/{id}", name="rapport_show")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('RAPPORT_VIEW', rapport)")
   * @param Rapport $rapport
   * @return array
   */
  public function showAction(Rapport $rapport) {
    $this->breadcrumbs->addItem($rapport, $this->generateUrl('bygning_show', array('id' => $rapport->getBygning()->getId())));

    $deleteForm = $this->createDeleteForm($rapport->getId())->createView();
    $editForm = $this->createEditFormFinansiering($rapport);

    $status = $rapport->getBygning()->getStatus();

    $formArray = array();
    if($status == BygningStatusType::TILKNYTTET_RAADGIVER) {
      $formArray['next_status_form'] = $this->createStatusForm($rapport, 'rapport_submit', 'rapporter.actions.submit')->createView();
    } else if ($status == BygningStatusType::AFLEVERET_RAADGIVER) {
      $formArray['prev_status_form'] = $this->createStatusForm($rapport, 'rapport_retur', 'rapporter.actions.retur')->createView();
      $formArray['next_status_form'] = $this->createStatusForm($rapport, 'rapport_verify', 'rapporter.actions.verify')->createView();
    } else if ($status == BygningStatusType::AAPLUS_VERIFICERET) {
      $formArray['next_status_form'] = $this->createStatusForm($rapport, 'rapport_approve', 'rapporter.actions.approve')->createView();
    } else if ($status == BygningStatusType::GODKENDT_AF_MAGISTRAT) {
      $formArray['next_status_form'] = $this->createStatusForm($rapport, 'rapport_implementation', 'rapporter.actions.implementation')->createView();
    } else if ($status == BygningStatusType::UNDER_UDFOERSEL) {
      $formArray['next_status_form'] = $this->createStatusForm($rapport, 'rapport_operation', 'rapporter.actions.operation')->createView();
    }

    $tilvalgtFormArray = array();
    $fravalgtFormArray = array();

    if ($this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
      foreach ($rapport->getTiltag() as $tiltag) {
        if ($tiltag->getTilvalgt()) {
          $tilvalgtFormArray[$tiltag->getId()] = $this->createEditTilvalgTilvalgtForm($tiltag, $rapport)
            ->createView();
        }
        else {
          $fravalgtFormArray[$tiltag->getId()] = $this->createEditTilvalgTilvalgtForm($tiltag, $rapport)
            ->createView();
        }
      }
    }


    $twigVars = array(
      'entity' => $rapport,
      'tilvalgt_form_array' => $tilvalgtFormArray,
      'fravalgt_form_array' => $fravalgtFormArray,
      'delete_form' => $deleteForm,
      'edit_form' => $editForm ? $editForm->createView() : NULL,
    );

    return array_merge($twigVars, $formArray);
  }

  /**
   * Finds and displays a Rapport entity in PDF form. (Resultatoversigt)
   *
   * @Route("/{id}/pdf2", name="rapport_show_pdf2")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('RAPPORT_VIEW', rapport)")
   * @param Rapport $rapport
   * @return array
   */
  public function showPdf2Action(Rapport $rapport) {
    $tilvalgtFormArray = array();
    $fravalgtFormArray = array();

    if ($this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
      foreach ($rapport->getTiltag() as $tiltag) {
        if ($tiltag->getTilvalgt()) {
          $tilvalgtFormArray[$tiltag->getId()] = $this->createEditTilvalgTilvalgtForm($tiltag, $rapport)
            ->createView();
        }
        else {
          $fravalgtFormArray[$tiltag->getId()] = $this->createEditTilvalgTilvalgtForm($tiltag, $rapport)
            ->createView();
        }
      }
    }

    $html = $this->renderView('AppBundle:Rapport:showPdf2.html.twig', array(
      'rapport' => $rapport,
      'tilvalgt_form_array' => $tilvalgtFormArray,
      'fravalgt_form_array' => $fravalgtFormArray,
    ));

    $cover = $this->renderView('AppBundle:Rapport:showPdf2Cover.html.twig', array(
      'rapport' => $rapport,
    ));

    $pdfName = $rapport->getBygning()->getAdresse() . '-Dokument 2-' . date('Y-m-d');

    return new Response(
      $this->get('knp_snappy.pdf')->getOutputFromHtml($html,
        array('lowquality' => false,
          'encoding' => 'utf-8',
          'images' => true,
          'cover' => $cover,
          'header-html' => $this->get('request')->getSchemeAndHttpHost().'/html/pdf2Header.html',
          'footer-left' => $rapport->getBygning(),
          'footer-right' => "Side [page] af [toPage]")
      ),
      200,
      array(
        'Content-Type'          => 'application/pdf',
        'Content-Disposition'   => 'attachment; filename="' . $pdfName . '.pdf"'
      )
    );
  }

  /**
   * Finds and displays a Rapport entity in PDF form. (Detailark)
   *
   * @Route("/{id}/pdf5", name="rapport_show_pdf5")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('RAPPORT_VIEW', rapport)")
   * @param Rapport $rapport
   * @return array
   */
  public function showPdf5Action(Rapport $rapport) {

    $html = $this->renderView('AppBundle:Rapport:showPdf5.html.twig', array(
      'rapport' => $rapport,
    ));

    $cover = $this->renderView('AppBundle:Rapport:showPdf5Cover.html.twig', array(
      'rapport' => $rapport,
    ));

    $pdfName = $rapport->getBygning()->getAdresse() . '-Dokument 5-' . date('Y-m-d');

    return new Response(
      $this->get('knp_snappy.pdf')->getOutputFromHtml($html,
        array('lowquality' => false,
          'encoding' => 'utf-8',
          'images' => true,
          'cover' => $cover,
          'header-html' => $this->get('request')->getSchemeAndHttpHost().'/html/pdf5Header.html',
          'footer-left' => $rapport->getBygning(),
          'footer-right' => "Side [page] af [toPage]")
      ),
      200,
      array(
        'Content-Type'          => 'application/pdf',
        'Content-Disposition'   => 'attachment; filename="' . $pdfName .'.pdf"'
      )
    );
  }


  /**
   * Finds and displays a Rapport entity.
   *
   * @Route("/{id}/pdftest", name="rapport_show_pdftest")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('RAPPORT_VIEW', rapport)")
   * @param Rapport $rapport
   * @return array
   */
  public function showPdfTestAction(Rapport $rapport) {

    return array(
      'rapport' => $rapport,
      'entity' => $rapport,
    );

  }

  /**
   * Displays a form to edit an existing Rapport entity.
   *
   * @Route("/{id}/edit", name="rapport_edit")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('RAPPORT_EDIT', rapport)")
   */
  public function editAction(Rapport $rapport) {
    $this->breadcrumbs->addItem($rapport->getBygning(), $this->generateUrl('bygning_show', array('id' => $rapport->getBygning()->getId())));
    $this->breadcrumbs->addItem('common.edit', $this->generateUrl('rapport_edit', array('id' => $rapport->getId())));

    $editForm = $this->createEditForm($rapport);
    $deleteForm = $this->createDeleteForm($rapport->getId());

    return array(
      'entity' => $rapport,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Creates a form to edit a Rapport entity.
   *
   * @param Rapport $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Rapport $entity) {
    $form = $this->createForm(new RapportType($this->get('security.context')), $entity, array(
      'action' => $this->generateUrl('rapport_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('rapport_show', array('id' => $entity->getId())));

    return $form;
  }

  /**
   * Creates a form to edit a Tiltag entity.
   *
   * @param Tiltag $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditTilvalgTilvalgtForm($entity, Rapport $rapport) {

    $form = $this->createForm(new TiltagTilvalgtType($entity), $entity, array(
      'action' => $this->generateUrl('tiltag_tilvalgt_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form);
    //$form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  /**
   * Edits an existing Rapport entity.
   *
   * @Route("/{id}", name="rapport_update")
   * @Method("PUT")
   * @Template("AppBundle:Rapport:edit.html.twig")
   * @Security("is_granted('RAPPORT_EDIT', rapport)")
   */
  public function updateAction(Request $request, Rapport $rapport) {
    $deleteForm = $this->createDeleteForm($rapport->getId());
    $editForm = $this->createEditForm($rapport);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      return $this->redirect($this->generateUrl('rapport_show', array('id' => $rapport->getId())));
    }

    return array(
      'entity' => $rapport,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Creates a form to delete a Rapport entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('rapport_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

  /**
   * Deletes a Rapport entity.
   *
   * @Route("/{id}", name="rapport_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $id) {
    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('AppBundle:Rapport')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find Rapport entity.');
      }

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('rapport'));
  }

  //---------------- Rådgiver aflever -------------------//

  /**
   * Aaplus verifies a Rapport entity.
   *
   * @Route("/{id}/submit", name="rapport_submit")
   * @Method("PUT")
   * @Security("is_granted('RAPPORT_EDIT', rapport)")
   */
  public function submitAction(Request $request, Rapport $rapport) {
    $this->statusAction($request, $rapport, BygningStatusType::AFLEVERET_RAADGIVER, 'rapport_submit', 'rapporter.actions.submit');

    $flash = $this->get('braincrafted_bootstrap.flash');
    $flash->success('rapporter.confirmation.submitted');

    return $this->redirect($this->generateUrl('dashboard'));
  }

  //---------------- Retur til Rådgiver -------------------//

  /**
   * Aaplus verifies a Rapport entity.
   *
   * @Route("/{id}/retur", name="rapport_retur")
   * @Method("PUT")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function returAction(Request $request, Rapport $rapport) {
    $this->statusAction($request, $rapport, BygningStatusType::TILKNYTTET_RAADGIVER, 'rapport_retur', 'rapporter.actions.retur');

    $flash = $this->get('braincrafted_bootstrap.flash');
    $flash->success('rapporter.confirmation.retur');

    return $this->redirect($this->generateUrl('dashboard'));
  }


  //---------------- Aa+ Verificeret -------------------//

  /**
   * Aaplus verifies a Rapport entity.
   *
   * @Route("/{id}/verify", name="rapport_verify")
   * @Method("PUT")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function verifyAction(Request $request, Rapport $rapport) {
    $this->statusAction($request, $rapport, BygningStatusType::AAPLUS_VERIFICERET, 'rapport_verify', 'rapporter.actions.verify');

    $flash = $this->get('braincrafted_bootstrap.flash');
    $flash->success('rapporter.confirmation.verified');

    return $this->redirect($this->generateUrl('dashboard'));
  }

  //---------------- Godkendt Magistrat -------------------//

  /**
   * Magistrat Godkendt
   *
   * @Route("/{id}/approve", name="rapport_approve")
   * @Method("PUT")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function approvedAction(Request $request, Rapport $rapport) {
    $this->statusAction($request, $rapport, BygningStatusType::GODKENDT_AF_MAGISTRAT, 'rapport_approve', 'rapporter.actions.approve');

    $flash = $this->get('braincrafted_bootstrap.flash');
    $flash->success('rapporter.confirmation.approved');

    return $this->redirect($this->generateUrl('dashboard'));
  }

  //---------------- Under udførsel -------------------//

  /**
   * Under udførsel
   *
   * @Route("/{id}/implementation", name="rapport_implementation")
   * @Method("PUT")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function implementationAction(Request $request, Rapport $rapport) {
    $this->statusAction($request, $rapport, BygningStatusType::UNDER_UDFOERSEL, 'rapport_implementation', 'rapporter.actions.implementation');

    $flash = $this->get('braincrafted_bootstrap.flash');
    $flash->success('rapporter.confirmation.implementation');

    return $this->redirect($this->generateUrl('dashboard'));
  }

  //---------------- Drift -------------------//

  /**
   * Drift
   *
   * @Route("/{id}/operation", name="rapport_operation")
   * @Method("PUT")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function operationAction(Request $request, Rapport $rapport) {
    $this->statusAction($request, $rapport, BygningStatusType::DRIFT, 'rapport_operation', 'rapporter.actions.operation');

    $flash = $this->get('braincrafted_bootstrap.flash');
    $flash->success('rapporter.confirmation.operation');

    return $this->redirect($this->generateUrl('dashboard'));
  }

  //---------------- Generic Status -------------------//


  private function statusAction(Request $request, Rapport $rapport, $status, $route, $label) {
    $form = $this->createStatusForm($rapport, $route, $label);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $rapport = $em->getRepository('AppBundle:Rapport')->find($rapport->getId());

      if (!$rapport) {
        throw $this->createNotFoundException('Unable to find Rapport entity.');
      }

      $rapport->getBygning()->setStatus($status);
      $rapport->setVersion($rapport->getVersion() + 1);
      $em->flush();
    }

  }

  /**
   * Creates a form to verify a Rapport entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createStatusForm($rapport, $route, $label) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl($route, array('id' => $rapport->getId())))
      ->setMethod('PUT')
      ->add('submit', 'submit', array('label' => $label))
      ->getForm();
  }

  //---------------- Tiltag -------------------//

  /**
   * Creates a new Tiltag entity.
   *
   * @Route("/{id}/tiltag/new/{type}", name="tiltag_create")
   * @Method("POST")
   * @Template("AppBundle:Tiltag:new.html.twig")
   * @Security("is_granted('RAPPORT_EDIT', rapport)")
   */
  public function newTiltagAction(Request $request, Rapport $rapport, $type) {
    $em = $this->getDoctrine()->getManager();
    $tiltag = $em->getRepository('AppBundle:Tiltag')->create($type);

    $tiltag->setRapport($rapport);

    $em->persist($tiltag);
    $em->flush();

    $flash = $this->get('braincrafted_bootstrap.flash');
    $flash->success( $type.'tiltag.confirmation.created');

    return $this->redirect($this->generateUrl('tiltag_edit', array('id' => $tiltag->getId())));
  }

  //---------------- Regninger -------------------//

  /**
   * Finds and displays a Rapport entity.
   *
   * @Route("/{id}/regninger", name="rapport_regninger_show")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('RAPPORT_VIEW', rapport)")
   * @param Rapport $rapport
   * @return array
   */
  public function showRegningerAction(Rapport $rapport) {
    $this->breadcrumbs->addItem($rapport->getBygning(), $this->get('router')
      ->generate('bygning_show', array(
        'id' => $rapport->getBygning()
          ->getId()
      )));
    $this->breadcrumbs->addItem($rapport->getVersion(), $this->get('router')
      ->generate('rapport_show', array('id' => $rapport->getId())));

    $deleteForm = $this->createDeleteForm($rapport->getId());

    return array(
      'tiltag' => $rapport->getTiltag(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Finds and displays a Rapport entity.
   *
   * @Route("/{id}/finansiering", name="rapport_finansiering_show")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('RAPPORT_VIEW', rapport)")
   * @param Rapport $rapport
   * @return array
   */
  public function showFinansieringAction(Rapport $rapport) {
    $this->breadcrumbs->addItem($rapport->getBygning(), $this->get('router')
      ->generate('bygning_show', array(
        'id' => $rapport->getBygning()
          ->getId()
      )));
    $this->breadcrumbs->addItem($rapport->getVersion(), $this->get('router')
      ->generate('rapport_show', array('id' => $rapport->getId())));

    $editForm = $this->createEditFormFinansiering($rapport);

    return array(
      'entity' => $rapport,
      'edit_form' => $editForm ? $editForm->createView() : NULL,
    );
  }

  /**
   * Creates a form to edit a Rapport entity.
   *
   * @param Rapport $rapport The rapport
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditFormFinansiering(Rapport $rapport) {
    if (!$this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
      return NULL;
    }

    $form = $this->createFormBuilder($rapport)
      ->setAction($this->generateUrl('rapport_finansiering_update', array('id' => $rapport->getId())))
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
   * Edits an existing Rapport entity.
   *
   * @Route("/{id}/finansiering", name="rapport_finansiering_update")
   * @Method("PUT")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function updateActionFinansiering(Request $request, Rapport $rapport) {
    $em = $this->getDoctrine()->getManager();

    $editForm = $this->createEditFormFinansiering($rapport);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em->flush();

      return $this->redirect($request->headers->get('referer'));
    }

    return array(
      'entity' => $rapport,
      'edit_form' => $editForm->createView(),
    );
  }
}
