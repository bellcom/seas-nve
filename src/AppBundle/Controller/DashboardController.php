<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

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
    $em = $this->getDoctrine()->getManager();

    $user = $this->get('security.context')->getToken()->getUser();
    $query = $em->getRepository('AppBundle:Bygning')->findByUser($user, true, true);

    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
      $query,
      $request->query->get('page', 1),
      20
    );

    return $this->render('AppBundle:Dashboard:index.html.twig', array('pagination' => $pagination));
  }

}
