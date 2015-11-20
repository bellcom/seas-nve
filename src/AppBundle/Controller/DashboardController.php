<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yavin\Symfony\Controller\InitControllerInterface;
use Symfony\Component\HttpFoundation\Request;
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
      $finished_buildings_q = $em->getRepository('AppBundle:Rapport')->getByUserAndStatus($user, BygningStatusType::AFLEVERET_RAADGIVER);

      $byg_pagination = $paginator->paginate(
        $finished_buildings_q,
        $request->query->get('page', 1),
        10
      );

      $segmenter_byg_pagination = array();
      foreach($user->getSegmenter() as $segment) {
        $seg_query = $em->getRepository('AppBundle:Rapport')->getBySegment($segment);

        $segmenter_byg_pagination[$segment->getId()] = $paginator->paginate(
          $seg_query,
          $request->query->get('page', 1),
          10
        );
      }

      return $this->render('AppBundle:Dashboard:admin.html.twig', array('byg_pagination' => $byg_pagination, 'segmenter' => $user->getSegmenter(), 'segmenter_byg_pagination' => $segmenter_byg_pagination));

    } else if ($this->isGranted('ROLE_EDIT')) {

      $current_buildings_q = $em->getRepository('AppBundle:Rapport')->getByUserAndStatus($user, BygningStatusType::TILKNYTTET_RAADGIVER);
      $finished_buildings_q = $em->getRepository('AppBundle:Rapport')->getByUserAndStatus($user, BygningStatusType::AFLEVERET_RAADGIVER);

      $current_buildings = $paginator->paginate(
        $current_buildings_q,
        $request->query->get('page', 1),
        10
      );

      $finished_buildings = $paginator->paginate(
        $finished_buildings_q,
        $request->query->get('page', 1),
        10
      );

      $summary_current = $em->getRepository('AppBundle:Rapport')->getSummaryByUserAndStatus($user, BygningStatusType::TILKNYTTET_RAADGIVER);
      $summary_finished = $em->getRepository('AppBundle:Rapport')->getSummaryByUserAndStatus($user, BygningStatusType::AFLEVERET_RAADGIVER);

      return $this->render('AppBundle:Dashboard:editor.html.twig', array('current_buildings' => $current_buildings, 'finished_buildings' => $finished_buildings, 'summary_current' => $summary_current, 'summary_finished' => $summary_finished));

    } else {

      return $this->render('AppBundle:Dashboard:default.html.twig');

    }

  }

}