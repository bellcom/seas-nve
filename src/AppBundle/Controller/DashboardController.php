<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yavin\Symfony\Controller\InitControllerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DashboardController
 * @package AppBundle\Controller
 */
class DashboardController extends Controller implements InitControllerInterface {

  protected $breadcrumbs;

  public function init(Request $request)
  {
    $this->breadcrumbs = $this->get('white_october_breadcrumbs');
    $this->breadcrumbs->addItem('Dashboard');
  }

  /**
   * @TODO: Missing description.
   *
   * @Route("/", name="dashboard")
   * @Template()
   */
  public function indexAction() {
    return array();
  }

}
