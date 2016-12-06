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

    if ($this->isGranted('ROLE_ADMIN')) {

      // Aa+
      return $this->dashboardView($request, $user, 'aaplusAnsvarlig');

    } else if ($this->isGranted('ROLE_EDIT')) {

      // Rådgiver
      if($user->hasGroup('Rådgiver')) {
        return $this->dashboardView($request, $user, 'energiRaadgiver');
      }

      // Projekterende
      if($user->hasGroup('Projekterende')) {
        return $this->dashboardView($request, $user, 'energiRaadgiver');
      }

    } else {
      return $this->dashboardView($request, $user, 'default');
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

    if ($this->isGranted('ROLE_ADMIN') && !$user->getSegmenter()->isEmpty()) {

      return $this->dashboardView($request, $user, 'segmenter');

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

    if ($user->hasGroup('Projektleder')) {

      return $this->dashboardView($request, $user, 'projektleder');

    } else {

      return $this->redirectToRoute('dashboard');

    }

  }

  /**
   * @TODO: Missing description.
   *
   * @Route("/projekterende", name="dashboard_projekterende")
   * @Template()
   */
  public function indexProjekterendeAction(Request $request) {
    $user = $this->get('security.context')->getToken()->getUser();

    if ($user->hasGroup('Projekterende')) {

      return $this->dashboardView($request, $user, 'projekterende');

    } else {

      return $this->redirectToRoute('dashboard');

    }

  }

  /**
   * @TODO: Missing description.
   *
   * @Route("/energiraadgiver", name="dashboard_energiraadgiver")
   * @Template()
   */
  public function indexEnergiRaadgiverAction(Request $request) {
    $user = $this->get('security.context')->getToken()->getUser();

    if ($user->hasGroup('Rådgiver')) {

      return $this->dashboardView($request, $user, 'energiRaadgiver');

    } else {

      return $this->redirectToRoute('dashboard');

    }

  }

  /**
   * @param Request $request
   * @param User $user
   * @param $filterCondition
   * @return \Symfony\Component\HttpFoundation\Response
   */
  private function dashboardView(Request $request, User $user, $filterCondition) {

    $paginator = $this->get('knp_paginator');

    // initialize a query builder
    $filterBuilder = $this->getDashboardFilterBuilder($user, $filterCondition);

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
      'tab' => $filterCondition,
      'aaplusAnsvarlig' => $user->hasGroup('Aa+'),
      'energiRaadgiver' => $user->hasGroup('Rådgiver'),
      'segmenter' => !$user->getSegmenter()->isEmpty(),
      'projektleder' => $user->hasGroup('Projektleder'),
      'projekterende' => $user->hasGroup('Projekterende'),
    ));
  }

  /**
   * @param User $user
   * @param $filterCondition
   * @return mixed
   */
  private function getDashboardFilterBuilder(User $user, $filterCondition) {
    $filterBuilder = $this->get('doctrine.orm.entity_manager')
      ->getRepository('AppBundle:Bygning')
      ->createQueryBuilder('b ');
    $filterBuilder->leftJoin('b.rapport', 'r');

    switch ($filterCondition) {
      case 'aaplusAnsvarlig':
        $filterBuilder->andWhere('b.aaplusAnsvarlig = :aaplusAnsvarlig');
        $filterBuilder->setParameter('aaplusAnsvarlig', $user);
        break;
      case 'energiRaadgiver':
        $filterBuilder->andWhere('b.energiRaadgiver = :energiRaadgiver');
        $filterBuilder->setParameter('energiRaadgiver', $user);
        break;
      case 'projektleder':
        $filterBuilder->andWhere('b.projektleder = :projektleder');
        $filterBuilder->setParameter('projektleder', $user);
        break;
      case 'projekterende':
        $filterBuilder->andWhere('b.projekterende = :projekterende');
        $filterBuilder->setParameter('projekterende', $user);
        break;
      case 'segmenter':
        $filterBuilder->andWhere('b.segment IN (:segmenter)');
        $filterBuilder->setParameter('segmenter', $user->getSegmenter());
        break;
      default:
        $filterBuilder->andWhere(':user MEMBER OF b.users');
        $filterBuilder->setParameter('user', $user);
        break;
    }

    return $filterBuilder;
  }

}