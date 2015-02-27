<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DashboardController
 * @package AppBundle\Controller
 */
class DashboardController extends Controller {
  /**
   * @TODO: Missing description.
   *
   * @Route("/")
   * @Template()
   */
  public function indexAction() {
    return array();
  }

}
