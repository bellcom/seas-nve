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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Bygning;
use AppBundle\Form\Type\BygningType;
use AppBundle\Form\Type\BygningFilterType;

/**
 * Udtraek controller.
 *
 * @Route("/udtraek")
 * @Security("has_role('ROLE_ADMIN')")
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
    // initialize a query builder
    $filterBuilder = $this->get('doctrine.orm.entity_manager')
      ->getRepository('AppBundle:Bygning')
      ->createQueryBuilder('e');

//    $entity = new Bygning();
//    $form = $this->createSearchForm();

    $form = $this->get('form.factory')->create(new BygningFilterType(), null, array(
      'action' => $this->generateUrl('udtraek'),
      'method' => 'GET',
    ));

    if ($request->query->has($form->getName())) {
      // manually bind values from the request
      $form->submit($request->query->get($form->getName()));

      // build the query from the given form object
      $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
    }

    $query = $filterBuilder->getQuery();

    // If this is an excel submit, return an excel response.
    if ($form->get('Excel')->isClicked()) {

      // Get the results.
      $results = $query->getArrayResult();

      // Generate filename.
      $filename = 'bygninger--' . date('d-m-Y_Hi') . '.xlsx';

      return ExcelExport::generateExcelResponse($results, $filename);
    }

    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
      $query,
      $request->query->get('page', 1) /*page number*/,
      10 /*limit per page*/
    );

    $search = array();
    $search['is_search'] = $request->get('is_search');

    return $this->render('AppBundle:Udtraek:index.html.twig', array('pagination' => $pagination, 'search' => $search, 'form' => $form->createView()));
  }

  /**
   * Get sum of field pr year excel export.
   *
   * @Route("/field_sum_pr_year/{field}", name="udtraek_field_sum_pr_year")
   * @Method("GET")
   * @Template()
   */
  public function fieldSumPrAarAction($field) {
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

    // Get all building types
    $types = $em->getRepository('AppBundle:Bygning')->getBuildingTypes();

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

      unset($search['segment']);

      $results[$year]['---- Bygningstyper ----'] = null;

      // Get segments.
      foreach ($types as $type) {
        $type = $type['type'];
        if (is_null($type)) {
          $type = "Ikke valgt";
        }

        $search['type'] = $type;
        $query = $em->getRepository('AppBundle:Bygning')->getFieldSum($user, $field, $search);

        // Get the results.
        $result = $query->getSingleScalarResult();
        $results[$year][$type] = $result;
      }
    }

    return ExcelExport::generateTwoDimensionalExcelResponse($results, 'udtraek--' . $field .'-pr-aar--' . date('d-m-Y_Hi') . '.xlsx');
  }

  /**
   * Get avg of the diff between field and baseline pr year excel export.
   *
   * @Route("/field_avg_diff_pr_year/{field}/{baseline}", name="udtraek_field_avg_diff_pr_year")
   * @Method("GET")
   * @Template()
   */
  public function fieldAvgDiffPrAarAction($field, $baseline) {
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

    // Get all building types
    $types = $em->getRepository('AppBundle:Bygning')->getBuildingTypes();

    for ($year = 2015; $year <= 2018; $year++) {
      $search['year'] = $year;

      // Get hele portefølje
      $query = $em->getRepository('AppBundle:Bygning')->getFieldAvgDiff($user, $field, $baseline, $search);
      $result = $query->getSingleScalarResult();
      $results[$year]['Hele portefølje'] = $result;

      $results[$year]['--- Magistrater ---'] = null;

      foreach ($forkortelser as $forkortelse) {
        $search['forkortelse'] = $forkortelse;
        $query = $em->getRepository('AppBundle:Bygning')->getFieldAvgDiff($user, $field, $baseline, $search);

        // Get the results.
        $result = $query->getSingleScalarResult();

        $results[$year][$forkortelse] = $result;
      }

      unset($search['forkortelse']);

      $results[$year]['---- Segmenter ----'] = null;

      // Get segments.
      foreach ($segments as $segment) {
        $search['segment'] = $segment;
        $query = $em->getRepository('AppBundle:Bygning')->getFieldAvgDiff($user, $field, $baseline, $search);

        // Get the results.
        $result = $query->getSingleScalarResult();
        $results[$year][$segment->getForkortelse() . " " . $segment->getNavn()] = $result;
      }

      unset($search['segment']);

      $results[$year]['---- Bygningstyper ----'] = null;

      // Get segments.
      foreach ($types as $type) {
        $search['type'] = $type;
        $query = $em->getRepository('AppBundle:Bygning')->getFieldAvgDiff($user, $field, $baseline, $search);

        // Get the results.
        $result = $query->getSingleScalarResult();
        $results[$year][$type] = $result;
      }
    }

    return ExcelExport::generateTwoDimensionalExcelResponse($results, 'udtraek--' . $field .'-' . $baseline .'-diff-pr-aar--' . date('d-m-Y_Hi') . '.xlsx');
  }
}
