<?php

namespace AppBundle\PdfExport;

use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Rapport;

class PdfExport {
  private $container;
  private $templating;

  public function __construct(ContainerInterface $container) {
    $this->container = $container;
    $this->templating = $this->container->get('templating');
  }

  public function export2(Rapport $rapport, array $options = array()) {
    $html = $this->renderView('AppBundle:Rapport:showPdf2.html.twig', array(
      'rapport' => $rapport,
    ));

    $cover = $this->renderView('AppBundle:Rapport:showPdf2Cover.html.twig', array(
      'rapport' => $rapport,
    ));

    return $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'cover' => $cover,
            'header-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdf2Header.html',
            'footer-left' => $rapport->getBygning(),
            'footer-right' => "Side [page] af [toPage]"),
      $options));
  }

  public function export5(Rapport $rapport, array $options = array()) {
    $html = $this->renderView('AppBundle:Rapport:showPdf5.html.twig', array(
      'rapport' => $rapport,
    ));

    $cover = $this->renderView('AppBundle:Rapport:showPdf5Cover.html.twig', array(
      'rapport' => $rapport,
    ));

    return $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('orientation'=>'Landscape',
            'lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'cover' => $cover,
            'header-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdf5Header.html',
            'footer-left' => $rapport->getBygning(),
            'footer-right' => "Side [page] af [toPage]"),
      $options));
  }

  private function renderView($view, array $parameters = array()) {
    return $this->templating->render($view, $parameters);
  }
}
