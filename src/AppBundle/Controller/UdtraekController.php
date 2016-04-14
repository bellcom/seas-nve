<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\DataExport\ExcelExport;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Yavin\Symfony\Controller\InitControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Form\Type\BygningUdtraekType;

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
   * @Route(
   *   ".{_format}",
   *   name="udtraek",
   *   defaults={"_format": "html"},
   *   requirements={
   *     "_format": "html|xlsx|csv",
   *   }
   * )
   * @Method("GET")
   * @Template()
   */
  public function indexAction(Request $request, $_format) {
    // initialize a query builder
    $filterBuilder = $this->get('doctrine.orm.entity_manager')
      ->getRepository('AppBundle:Bygning')
      ->createQueryBuilder('e');

    $form = $this->get('form.factory')->create(new BygningUdtraekType(), NULL, array(
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

    $columns = $this->getColumnGroupsInfo($request);
    $types = $this->getTypesInfo($request);
    $type = $this->getType($request);

    if ($_format != 'html') {
      $filename = 'bygninger--' . date('d-m-Y_Hi') . '.' . $_format;

      $response = new Response();
      $response->headers->set('Content-Type', 'application/vnd.ms-excel');
      $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
      $response->headers->set('Cache-Control', 'max-age=0');

      $result = $query->getResult();

      return $this->render('AppBundle:Bygning:index.' . $_format . '.twig',
        array(
          'bygninger' => $result,
          'columns' => $columns,
          'types' => $types,
          'type' => $type,
        ),
        $response);
    } else {
      $paginator = $this->get('knp_paginator');
      $pagination = $paginator->paginate(
        $query,
        $request->query->get('page', 1) /*page number*/,
        10 /*limit per page*/
      );

      return $this->render('AppBundle:Udtraek:index.html.twig', array(
        'pagination' => $pagination,
        'form' => $form->createView(),
        'columns' => $columns,
        'types' => $types,
        'type' => $type,
      ));
    }
  }

  /**
   *
   */
  private function getColumnGroupsInfo(Request $request) {
    $groups = array(
      'name' => '_columns',
      'groups' => array(),
    );
    $values = $request->query->get($groups['name']);
    $names = array(
      UdtraekColumnGroups::ALT,
      UdtraekColumnGroups::BYGNINGSINFORMATION,
      UdtraekColumnGroups::BASELINEINFORMATION,
      UdtraekColumnGroups::AA_SCREENINGSINFORMATION,
      UdtraekColumnGroups::BESPARELSESINFORMATION,
      UdtraekColumnGroups::OEKONOMI,
    );
    foreach ($names as $name) {
      $groups['groups'][$name] = isset($values[$name]) && !empty($values[$name]);
    }

    return $groups;
  }

  private function getColumnGroups(Request $request) {
    $info = $this->getColumnGroupsInfo($request);
    $groups = array();
    foreach ($info['groups'] as $name => $value) {
      if ($value) {
        $groups[$name] = $name;
      }
    }
    return $groups;
  }

  /**
   *
   */
  private function getTypesInfo(Request $request) {
    $types = array(
      'name' => '_entity',
      'types' => array(),
    );
    $value = $request->query->get($types['name'], UdtraekType::BYGNING);
    if (!$value) {
      $value = UdtraekType::BYGNING;
    }
    $names = array(
      UdtraekType::BYGNING,
      UdtraekType::TILTAG,
    );
    foreach ($names as $name) {
      $types['types'][$name] = ($name == $value);
    }

    return $types;
  }

  private function getType(Request $request) {
    $types = $this->getTypesInfo($request);
    foreach ($types['types'] as $type => $value) {
      if ($value) {
        return $type;
      }
    }

    return UdtraekType::BYGNING;
  }

  /**
   * Get predefined udtraek page.
   *
   * @Route("/predefineret", name="udtraek_predefined")
   * @Method("GET")
   * @Template()
   */
  public function predefinedAction() {
    return $this->render('AppBundle:Udtraek:predefined.html.twig', array());
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

      $results[$year]['--- Magistrater ---'] = NULL;

      foreach ($forkortelser as $forkortelse) {
        $search['forkortelse'] = $forkortelse;
        $query = $em->getRepository('AppBundle:Bygning')->getFieldSum($user, $field, $search);

        // Get the results.
        $result = $query->getSingleScalarResult();

        $results[$year][$forkortelse] = $result;
      }

      unset($search['forkortelse']);

      $results[$year]['---- Segmenter ----'] = NULL;

      // Get segments.
      foreach ($segments as $segment) {
        $search['segment'] = $segment;
        $query = $em->getRepository('AppBundle:Bygning')->getFieldSum($user, $field, $search);

        // Get the results.
        $result = $query->getSingleScalarResult();
        $results[$year][$segment->getForkortelse() . " " . $segment->getNavn()] = $result;
      }

      unset($search['segment']);

      $results[$year]['---- Bygningstyper ----'] = NULL;

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

    return ExcelExport::generateTwoDimensionalExcelResponse($results, 'udtraek--' . $field . '-pr-aar--' . date('d-m-Y_Hi') . '.xlsx');
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

      $results[$year]['--- Magistrater ---'] = NULL;

      foreach ($forkortelser as $forkortelse) {
        $search['forkortelse'] = $forkortelse;
        $query = $em->getRepository('AppBundle:Bygning')->getFieldAvgDiff($user, $field, $baseline, $search);

        // Get the results.
        $result = $query->getSingleScalarResult();

        $results[$year][$forkortelse] = $result;
      }

      unset($search['forkortelse']);

      $results[$year]['---- Segmenter ----'] = NULL;

      // Get segments.
      foreach ($segments as $segment) {
        $search['segment'] = $segment;
        $query = $em->getRepository('AppBundle:Bygning')->getFieldAvgDiff($user, $field, $baseline, $search);

        // Get the results.
        $result = $query->getSingleScalarResult();
        $results[$year][$segment->getForkortelse() . " " . $segment->getNavn()] = $result;
      }

      unset($search['segment']);

      $results[$year]['---- Bygningstyper ----'] = NULL;

      // Get segments.
      foreach ($types as $type) {
        $type = $type['type'];
        $search['type'] = $type;
        $query = $em->getRepository('AppBundle:Bygning')->getFieldAvgDiff($user, $field, $baseline, $search);

        // Get the results.
        $result = $query->getSingleScalarResult();
        $results[$year][$type] = $result;
      }
    }

    return ExcelExport::generateTwoDimensionalExcelResponse($results, 'udtraek--' . $field . '-' . $baseline . '-diff-pr-aar--' . date('d-m-Y_Hi') . '.xlsx');
  }
}

abstract class UdtraekColumnGroups {
  const ALT = 'alt';
  const BYGNINGSINFORMATION = 'bygningsinformation';
  const BASELINEINFORMATION = 'baselineinformation';
  const AA_SCREENINGSINFORMATION = 'aa_screeningsinformation';
  const BESPARELSESINFORMATION = 'besparelsesinformation';
  const OEKONOMI = 'oekonomi';
}

abstract class UdtraekType {
  const BYGNING = 'bygning';
  const TILTAG = 'tiltag';
}
