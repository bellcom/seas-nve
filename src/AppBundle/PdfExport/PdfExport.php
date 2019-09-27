<?php

namespace AppBundle\PdfExport;

use AppBundle\Entity\Bygning;
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
      $data[] = 'Screeningsdato: ' . $screeningAt->format('d.m.Y');
    }

    if ($updatedAt = $rapport->getUpdatedAt()) {
      $data[] = 'Opdateret: ' . $updatedAt->format('d.m.Y');
    }

    $cover = $this->renderView('AppBundle:Rapport:showPdf2Cover.html.twig', array(
      'rapport' => $rapport,
    ));

    $html = $this->renderView('AppBundle:Rapport:showPdf2.html.twig', array(
      'rapport' => $rapport,
    ));

    return $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'cover' => $cover,
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
      $data[] = 'Screeningsdato: ' . $screeningAt->format('d.m.Y');
    }

    if ($updatedAt = $rapport->getUpdatedAt()) {
      $data[] = 'Opdateret: ' . $updatedAt->format('d.m.Y');
    }

    $cover = $this->renderView('AppBundle:Rapport:showPdf5Cover.html.twig', array(
      'rapport' => $rapport,
    ));

    $html = $this->renderView('AppBundle:Rapport:showPdf5.html.twig', array(
      'rapport' => $rapport,
    ));

    return $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('orientation'=>'Landscape',
            'lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'cover' => $cover,
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
      $data[] = 'Screeningsdato: ' . $screeningAt->format('d.m.Y');
    }

    if ($updatedAt = $rapport->getUpdatedAt()) {
      $data[] = 'Opdateret: ' . $updatedAt->format('d.m.Y');
    }

    $cover = $this->renderView('AppBundle:VirksomhedRapport:showPdf2Cover.html.twig', array(
      'rapport' => $rapport,
    ));

    $html = $this->renderView('AppBundle:VirksomhedRapport:showPdf2.html.twig', array(
      'rapport' => $rapport,
    ));

    return $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'cover' => $cover,
            'header-left' => implode(' | ', $data),
            'header-right' => "Side [page] af [toPage]",
            'footer-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdf2VirksomhedFooter.html'),
      $options));
  }

  public function exportVirksomhedRapportKortlaegning(VirksomhedRapport $rapport, array $options = array()) {
    $data = array();
    $virksomhed = $rapport;

    if ($virksomhed && $virksomhedsNavn = $virksomhed->getName()) {
      $data[] = $virksomhedsNavn;
    }

    if ($screeningAt = $rapport->getDatering()) {
      $data[] = 'Screeningsdato: ' . $screeningAt->format('d.m.Y');
    }

    if ($updatedAt = $rapport->getUpdatedAt()) {
      $data[] = 'Opdateret: ' . $updatedAt->format('d.m.Y');
    }

    $cover = $this->renderView('AppBundle:VirksomhedRapport:showPdfKortlaegningCover.html.twig', array(
      'rapport' => $rapport,
    ));

    $html = $this->renderView('AppBundle:VirksomhedRapport:showPdfKortlaegning.html.twig', array(
      'rapport' => $rapport,
    ));

    return $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'cover' => $cover,
            'header-left' => implode(' | ', $data),
            'header-right' => "Side [page] af [toPage]",
            'footer-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdfKortlaegningFooter.html'),
      $options));
  }

  public function exportVirksomhedRapportDetailark(VirksomhedRapport $rapport, array $options = array()) {
    $data = array();
    $virksomhed = $rapport->getVirksomhed();

    if ($virksomhed && $virksomhedsNavn = $virksomhed->getName()) {
      $data[] = $virksomhedsNavn;
    }

    if ($screeningAt = $rapport->getDatering()) {
      $data[] = 'Screeningsdato: ' . $screeningAt->format('d.m.Y');
    }

    if ($updatedAt = $rapport->getUpdatedAt()) {
      $data[] = 'Opdateret: ' . $updatedAt->format('d.m.Y');
    }

    $html = '';
    /** @var Bygning $bygning */
    foreach ($virksomhed->getBygninger() as $bygning) {
      $bygningRaport = $bygning->getRapport();
      if (empty($bygningRaport)) {
        continue;
      }
      $html .= $this->renderView('AppBundle:Rapport:showPdf5CoverBody.html.twig', array(
        'rapport' => $bygningRaport,
      ));

      $html .= $this->renderView('AppBundle:Rapport:showPdf5Body.html.twig', array(
        'rapport' => $bygningRaport,
      ));
    }

    $cover = $this->renderView('AppBundle:VirksomhedRapport:showPdfDetailarkCover.html.twig', array(
      'rapport' => $rapport,
    ));

    return $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('orientation'=>'Landscape',
            'lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'cover' => $cover,
            'header-left' => implode(' | ', $data),
            'header-right' => "Side [page] af [toPage]",
            'footer-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdfVirksomhedDetailarkFooter.html'),
      $options));
  }

  private function renderView($view, array $parameters = array()) {
    return $this->templating->render($view, $parameters);
  }
}
