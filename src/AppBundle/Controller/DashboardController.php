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

    if ($this->isGranted('ROLE_ADMIN')) {
      $query = $em->getRepository('AppBundle:Bygning')->findByUser($user, true, true);

      $paginator = $this->get('knp_paginator');
      $pagination = $paginator->paginate(
        $query,
        $request->query->get('page', 1),
        20
      );

      return $this->render('AppBundle:Dashboard:admin.html.twig', array('pagination' => $pagination));

    } else if ($this->isGranted('ROLE_EDIT')) {

      $status_current = $em->getRepository('AppBundle:BygningStatus')->findOneBy(array('navn' => 'Tilknyttet Rådgiver'));
      $status_finished = $em->getRepository('AppBundle:BygningStatus')->findOneBy(array('navn' => 'Afleveret af Rådgiver'));

      $current_buildings_q = $em->getRepository('AppBundle:Bygning')->getByUserAndStatus($user, $status_current);
      $finished_buildings_q = $em->getRepository('AppBundle:Bygning')->getByUserAndStatus($user, $status_finished);

      $paginator = $this->get('knp_paginator');

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

      $totalareal = $em->getRepository('AppBundle:Bygning')->getSummaryByUserAndStatus($user, $status_current);

      return $this->render('AppBundle:Dashboard:editor.html.twig', array('current_buildings' => $current_buildings, 'finished_buildings' => $finished_buildings, 'totalareal' => $totalareal['totalareal']));

    } else {

      return $this->render('AppBundle:Dashboard:default.html.twig');

    }

  }

}