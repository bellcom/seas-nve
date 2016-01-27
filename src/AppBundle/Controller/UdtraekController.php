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

  /**
   * Get varme_pr_aar excel export.
   *
   * @Route("/varme_pr_aar", name="udtraek_varme_pr_aar")
   * @Method("GET")
   * @Template()
   */
  public function varmePrAarAction(Request $request) {
    $user = $this->get('security.context')->getToken()->getUser();
    $em = $this->getDoctrine()->getManager();

    $search = array();

    $results = array();

    $segments = $em->getRepository('AppBundle:Segment')->findAll();
    $segments[] = null;

    for ($year = 2015; $year <= 2018; $year++) {
      $search['year'] = $year;

      foreach ($segments as $segment) {
        $search['segment'] = $segment;
        $query = $em->getRepository('AppBundle:Bygning')->getVarmeBesparelseForSegment($user, $search);

        // Get the results.
        $result = $query->getSingleScalarResult();

        if (is_null($segment)) {
          $results[$year]['Hele portefølje'] = $result;
        }
        else {
          $results[$year][$segment->getForkortelse() . " " . $segment->getNavn()] = $result;
        }
      }
    }

    return ExcelExport::generateTwoDimensionalExcelResponse($results, 'udtraek--varme-pr-aar--' . date('d-m-Y_Hi') . '.xlsx');
  }
}
