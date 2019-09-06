<?php

namespace AppBundle\PdfExport;

use AppBundle\Entity\VirksomhedRapport;
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
    $data = array();

    $virksomhed = $rapport->getBygning()->getVirksomhed();

    if ($virksomhed && $virksomhedsNavn = $virksomhed->getName()) {
      $data[] = $virksomhedsNavn;
    }

    if ($bygningsNavn = $rapport->getBygning()->getNavn()) {
      $data[] = $bygningsNavn;
    }

    if ($screeningAt = $rapport->getDatering()) {
      $data[] = $screeningAt->format('d.m.Y');
    }

    if ($updatedAt = $rapport->getUpdatedAt()) {
      $data[] = $updatedAt->format('d.m.Y');
    }

    $html = $this->renderView('AppBundle:Rapport:showPdf2.html.twig', array(
      'rapport' => $rapport,
    ));

    return $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'header-left' => implode(' | ', $data),
            'header-right' => "Side [page] af [toPage]",
            'footer-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdf2Footer.html'),
      $options));
  }

  public function export5(Rapport $rapport, array $options = array()) {
    $data = array();

    $virksomhed = $rapport->getBygning()->getVirksomhed();

    if ($virksomhed && $virksomhedsNavn = $virksomhed->getName()) {
      $data[] = $virksomhedsNavn;
    }

    if ($bygningsNavn = $rapport->getBygning()->getNavn()) {
      $data[] = $bygningsNavn;
    }

    if ($screeningAt = $rapport->getDatering()) {
      $data[] = $screeningAt->format('d.m.Y');
    }

    if ($updatedAt = $rapport->getUpdatedAt()) {
      $data[] = $updatedAt->format('d.m.Y');
    }

    $html = $this->renderView('AppBundle:Rapport:showPdf5.html.twig', array(
      'rapport' => $rapport,
    ));

    return $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('orientation'=>'Landscape',
            'lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'header-left' => implode(' | ', $data),
            'header-right' => "Side [page] af [toPage]",
            'footer-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdf5Footer.html'),
      $options));
  }

  public function exportVirksomhedRapport2(VirksomhedRapport $rapport, array $options = array()) {
    $data = array();

    $virksomhed = $rapport;

    if ($virksomhed && $virksomhedsNavn = $virksomhed->getName()) {
      $data[] = $virksomhedsNavn;
    }

    if ($screeningAt = $rapport->getDatering()) {
      $data[] = $screeningAt->format('d.m.Y');
    }

    if ($updatedAt = $rapport->getUpdatedAt()) {
      $data[] = $updatedAt->format('d.m.Y');
    }

    $html = $this->renderView('AppBundle:VirksomhedRapport:showPdf2.html.twig', array(
      'rapport' => $rapport,
    ));

    return $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'header-left' => implode(' | ', $data),
            'header-right' => "Side [page] af [toPage]",
            'footer-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdf2Footer.html'),
      $options));
  }

  public function exportVirksomhedRapport5(VirksomhedRapport $rapport, array $options = array()) {
    $data = array();

    $virksomhed = $rapport;

    if ($virksomhed && $virksomhedsNavn = $virksomhed->getName()) {
      $data[] = $virksomhedsNavn;
    }

    if ($screeningAt = $rapport->getDatering()) {
      $data[] = $screeningAt->format('d.m.Y');
    }

    if ($updatedAt = $rapport->getUpdatedAt()) {
      $data[] = $updatedAt->format('d.m.Y');
    }

    $html = $this->renderView('AppBundle:VirksomhedRapport:showPdf5.html.twig', array(
      'rapport' => $rapport,
    ));

    return $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('orientation'=>'Landscape',
            'lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'header-left' => implode(' | ', $data),
            'header-right' => "Side [page] af [toPage]",
            'footer-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdf5Footer.html'),
      $options));
  }

  private function renderView($view, array $parameters = array()) {
    return $this->templating->render($view, $parameters);
  }
}
