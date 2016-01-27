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
use Symfony\Component\HttpKernel\Exception\HttpException;
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
   * Get sum of field pr year excel export.
   *
   * @Route("/field_sum_pr_year/{field}", name="udtraek_field_pr_aar")
   * @Method("GET")
   * @Template()
   */
  public function fieldSumPrAarAction(Request $request, $field) {
    $user = $this->get('security.context')->getToken()->getUser();
    $em = $this->getDoctrine()->getManager();

    $search = array();

    if (empty($field)) {
      throw new HttpException("field not set");
    }

    $results = array();

    // Get all segmenter
    $segments = $em->getRepository('AppBundle:Segment')->findAll();

    // Get all forkortelser
    $forkortelser = array();
    foreach ($segments as $segment) {
      if (!in_array($segment->getForkortelse(), $forkortelser)) {
        $forkortelser[] = $segment->getForkortelse();
      }
    }

    for ($year = 2015; $year <= 2018; $year++) {
      $search['year'] = $year;

      // Get hele portefølje
      $query = $em->getRepository('AppBundle:Bygning')->getFieldSum($user, $field, $search);
      $result = $query->getSingleScalarResult();
      $results[$year]['Hele portefølje'] = $result;

      $results[$year]['--- Magistrater ---'] = null;

      foreach ($forkortelser as $forkortelse) {
        $search['forkortelse'] = $forkortelse;
        $query = $em->getRepository('AppBundle:Bygning')->getFieldSum($user, $field, $search);

        // Get the results.
        $result = $query->getSingleScalarResult();

        $results[$year][$forkortelse] = $result;
      }

      unset($search['forkortelse']);

      $results[$year]['---- Segmenter ----'] = null;

      // Get segments.
      foreach ($segments as $segment) {
        $search['segment'] = $segment;
        $query = $em->getRepository('AppBundle:Bygning')->getFieldSum($user, $field, $search);

        // Get the results.
        $result = $query->getSingleScalarResult();
        $results[$year][$segment->getForkortelse() . " " . $segment->getNavn()] = $result;
      }
    }

    return ExcelExport::generateTwoDimensionalExcelResponse($results, 'udtraek--' . $field .'-pr-aar--' . date('d-m-Y_Hi') . '.xlsx');
  }
}
