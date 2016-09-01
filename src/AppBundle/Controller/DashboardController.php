<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\Query;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yavin\Symfony\Controller\InitControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\BygningDashboardType;
use AppBundle\DBAL\Types\BygningStatusType;

/**
 * Class DashboardController
 * @package AppBundle\Controller
 */
class DashboardController extends BaseController {

  /**
   * @TODO: Missing description.
   *
   * @Route("/", name="dashboard")
   * @Template()
   */
  public function indexAction(Request $request) {
    $user = $this->get('security.context')->getToken()->getUser();
    $em = $this->getDoctrine()->getManager();
    $paginator = $this->get('knp_paginator');

    if ($this->isGranted('ROLE_ADMIN')) {

      // Bygning

      // initialize a query builder
      $filterBuilder = $this->get('doctrine.orm.entity_manager')
        ->getRepository('AppBundle:Bygning')
        ->createQueryBuilder('b');
      $filterBuilder->andWhere('b.aaplusAnsvarlig = :aaplusAnsvarlig');
      $filterBuilder->setParameter('aaplusAnsvarlig', $user);

      $form = $this->get('form.factory')->create(new BygningDashboardType($this->getDoctrine()), NULL, array(
        'action' => $this->generateUrl('dashboard'),
        'method' => 'GET',
      ));

      if ($request->query->has($form->getName())) {
        // manually bind values from the request
        $form->submit($request->query->get($form->getName()));

        // build the query from the given form object
        $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
      }

      $query = $filterBuilder->getQuery();

      $pagination = $paginator->paginate(
        $query,
        $request->query->get('page', 1) /*page number*/,
        20, /*limit per page*/
        array('defaultSortFieldName' => 'b.updatedAt', 'defaultSortDirection' => 'desc')
      );

      return $this->render('AppBundle:Dashboard:default.html.twig', array(
        'pagination' => $pagination,
        'form' => $form->createView(),
        'tab' => 'bygninger',
        'bygninger' => $user->hasGroup('Aa+'),
        'segmenter' => !$user->getSegmenter()->isEmpty(),
        'projektleder' => $user->hasGroup('Projektleder'),
      ));

    } else if ($this->isGranted('ROLE_EDIT')) {

      $current_buildings_q = $em->getRepository('AppBundle:Rapport')->getByUserAndStatus($user, BygningStatusType::TILKNYTTET_RAADGIVER);
      $finished_buildings_q = $em->getRepository('AppBundle:Rapport')->getByUserAndStatusAfter($user, BygningStatusType::AFLEVERET_RAADGIVER);

      $current_buildings = $paginator->paginate(
        $current_buildings_q,
        $request->query->get('page', 1),
        10,
        array('defaultSortFieldName' => 'b.updatedAt', 'defaultSortDirection' => 'desc')
      );

      $finished_buildings = $paginator->paginate(
        $finished_buildings_q,
        $request->query->get('page', 1),
        10,
        array('defaultSortFieldName' => 'b.updatedAt', 'defaultSortDirection' => 'desc')
      );

      $summary_current = $em->getRepository('AppBundle:Rapport')->getSummaryByUserAndStatus($user, BygningStatusType::TILKNYTTET_RAADGIVER);
      $summary_finished = $em->getRepository('AppBundle:Rapport')->getSummaryByUserAndStatus($user, BygningStatusType::AFLEVERET_RAADGIVER);

      return $this->render('AppBundle:Dashboard:editor.html.twig', array('current_buildings' => $current_buildings, 'finished_buildings' => $finished_buildings, 'summary_current' => $summary_current, 'summary_finished' => $summary_finished));

    } else {

      // initialize a query builder
      $filterBuilder = $this->get('doctrine.orm.entity_manager')
        ->getRepository('AppBundle:Bygning')
        ->createQueryBuilder('b');
      $filterBuilder->andWhere(':user MEMBER OF b.users');
      $filterBuilder->setParameter('user', $user);

      $form = $this->get('form.factory')->create(new BygningDashboardType($this->getDoctrine()), NULL, array(
        'action' => $this->generateUrl('dashboard'),
        'method' => 'GET',
      ));

      if ($request->query->has($form->getName())) {
        // manually bind values from the request
        $form->submit($request->query->get($form->getName()));

        // build the query from the given form object
        $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
      }

      $query = $filterBuilder->getQuery();

      $pagination = $paginator->paginate(
        $query,
        $request->query->get('page', 1) /*page number*/,
        20, /*limit per page*/
        array('defaultSortFieldName' => 'b.updatedAt', 'defaultSortDirection' => 'desc')
      );

      return $this->render('AppBundle:Dashboard:default.html.twig', array(
        'pagination' => $pagination,
        'form' => $form->createView(),
        'tab' => 'bygninger',
        'bygninger' => $user->hasGroup('Aa+'),
        'segmenter' => !$user->getSegmenter()->isEmpty(),
        'projektleder' => $user->hasGroup('Projektleder'),
      ));

    }

  }

  /**
   * @TODO: Missing description.
   *
   * @Route("/segmenter", name="dashboard_segmenter")
   * @Template()
   */
  public function indexSegmenterAction(Request $request) {
    $user = $this->get('security.context')->getToken()->getUser();
    $em = $this->getDoctrine()->getManager();
    $paginator = $this->get('knp_paginator');

    if ($this->isGranted('ROLE_ADMIN') && !$user->getSegmenter()->isEmpty()) {

      // SEGMENTER

      // initialize a query builder
      $filterBuilder = $this->get('doctrine.orm.entity_manager')
        ->getRepository('AppBundle:Bygning')
        ->createQueryBuilder('b ');
//      $filterBuilder->leftJoin('b.rapport', 'r');
      $filterBuilder->leftJoin('b.rapport', 'r');
//      $sFilterBuilder->andWhere('b.aaplusAnsvarlig = :aaplusAnsvarlig');
      $filterBuilder->andWhere('b.segment IN (:segmenter)');
      $filterBuilder->setParameter('segmenter', $user->getSegmenter());

      $form = $this->get('form.factory')->create(new BygningDashboardType($this->getDoctrine()), NULL, array(
        'action' => $this->generateUrl('dashboard_segmenter'),
        'method' => 'GET',
      ));

      if ($request->query->has($form->getName())) {
        // manually bind values from the request
        $form->submit($request->query->get($form->getName()));

        // build the query from the given form object
        $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
      }

      $query = $filterBuilder->getQuery();

      $pagination = $paginator->paginate(
        $query,
        $request->query->get('page', 1) /*page number*/,
        20, /*limit per page*/
        array('defaultSortFieldName' => 'b.updatedAt', 'defaultSortDirection' => 'desc')
      );

      return $this->render('AppBundle:Dashboard:default.html.twig', array(
        'pagination' => $pagination,
        'form' => $form->createView(),
        'tab' => 'segmenter',
        'bygninger' => $user->hasGroup('Aa+'),
        'segmenter' => !$user->getSegmenter()->isEmpty(),
        'projektleder' => $user->hasGroup('Projektleder'),
      ));

    } else {

      return $this->redirectToRoute('dashboard');

    }

  }

  /**
   * @TODO: Missing description.
   *
   * @Route("/projektleder", name="dashboard_projektleder")
   * @Template()
   */
  public function indexProjektlederAction(Request $request) {
    $user = $this->get('security.context')->getToken()->getUser();
    $em = $this->getDoctrine()->getManager();
    $paginator = $this->get('knp_paginator');

    if ($this->isGranted('ROLE_ADMIN') && !$user->getSegmenter()->isEmpty()) {

      // SEGMENTER

      // initialize a query builder
      $filterBuilder = $this->get('doctrine.orm.entity_manager')
        ->getRepository('AppBundle:Bygning')
        ->createQueryBuilder('b ');
//      $filterBuilder->leftJoin('b.rapport', 'r');
      $filterBuilder->leftJoin('b.rapport', 'r');
      $filterBuilder->andWhere('b.projektleder = :projektleder');
      $filterBuilder->setParameter('projektleder', $user);

      $form = $this->get('form.factory')->create(new BygningDashboardType($this->getDoctrine()), NULL, array(
        'action' => $this->generateUrl('dashboard_segmenter'),
        'method' => 'GET',
      ));

      if ($request->query->has($form->getName())) {
        // manually bind values from the request
        $form->submit($request->query->get($form->getName()));

        // build the query from the given form object
        $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
      }

      $query = $filterBuilder->getQuery();

      $pagination = $paginator->paginate(
        $query,
        $request->query->get('page', 1) /*page number*/,
        20, /*limit per page*/
        array('defaultSortFieldName' => 'b.updatedAt', 'defaultSortDirection' => 'desc')
      );

      return $this->render('AppBundle:Dashboard:default.html.twig', array(
        'pagination' => $pagination,
        'form' => $form->createView(),
        'tab' => 'projektleder',
        'bygninger' => $user->hasGroup('Aa+'),
        'segmenter' => !$user->getSegmenter()->isEmpty(),
        'projektleder' => $user->hasGroup('Projektleder'),
      ));

    } else {

      return $this->redirectToRoute('dashboard');

    }

  }

}