<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\DataExport\ExcelExport;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yavin\Symfony\Controller\InitControllerInterface;

/**
 * Udtraek controller.
 *
 * @Route("/udtraek")
 */
class UdtraekController extends BaseController implements InitControllerInterface {

  protected $breadcrumbs;

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('Udtræk', $this->generateUrl('udtraek'));
  }

  /**
   * Get udtraek page.
   *
   * @Route("/", name="udtraek")
   * @Method("GET")
   * @Template()
   */
  public function indexAction(Request $request) {

    return $this->render('AppBundle:Udtraek:index.html.twig', array());
  }
}
