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

  public function export2(Rapport $rapport, array $options = array(), $review = FALSE) {
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

    $coverParams = array(
      'rapport' => $rapport,
      'review' => $review,
    );
    if ($virksomhed && $virksomhedsType = $virksomhed->getTypeNameLabel()) {
      $coverParams['typenavn'] = $virksomhedsType;
    }
    $cover = $this->renderView('AppBundle:Rapport:showPdf2Cover.html.twig', $coverParams);

    $html = $this->renderView('AppBundle:Rapport:showPdf2.html.twig', array(
      'rapport' => $rapport,
      'review' => $review,
    ));

    return $review ? ($cover . $html) :  $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'cover' => $cover,
            'header-left' => implode(' | ', $data),
            'header-right' => "Side [page] af [toPage]",
            'footer-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdf2Footer.html'),
      $options));
  }

  public function export5(Rapport $rapport, array $options = array(), $review = FALSE) {
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

    $coverParams = array(
      'rapport' => $rapport,
      'review' => $review,
    );
    if ($virksomhed && $virksomhedsType = $virksomhed->getTypeNameLabel()) {
      $coverParams['typenavn'] = $virksomhedsType;
    }
    $cover = $this->renderView('AppBundle:Rapport:showPdf5Cover.html.twig', $coverParams);

    $html = $this->renderView('AppBundle:Rapport:showPdf5.html.twig', array(
      'rapport' => $rapport,
      'review' => $review,
    ));

    return $review ? ($cover . $html) :  $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
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

  public function exportVirksomhedRapport2(VirksomhedRapport $rapport, array $options = array(), $review = FALSE) {
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

    $coverParams = array(
      'rapport' => $rapport,
      'review' => $review,
      );
    if ($virksomhed && $virksomhedsType = $virksomhed->getTypeNameLabel()) {
      $coverParams['typenavn'] = $virksomhedsType;
    }
    $cover = $this->renderView('AppBundle:VirksomhedRapport:showPdf2Cover.html.twig', $coverParams);

    $html = $this->renderView('AppBundle:VirksomhedRapport:showPdf2.html.twig', array(
      'rapport' => $rapport,
      'review' => $review,
    ));

    return $review ? ($cover . $html) : $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'cover' => $cover,
            'header-left' => implode(' | ', $data),
            'header-right' => "Side [page] af [toPage]",
            'footer-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdf2VirksomhedFooter.html'),
      $options));
  }

  public function exportVirksomhedRapportKortlaegning(VirksomhedRapport $rapport, array $options = array(), $review = FALSE) {
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

    $coverParams = array(
      'rapport' => $rapport,
      'review' => $review,
    );

    if ($virksomhed && $virksomhedsType = $virksomhed->getTypeNameLabel()) {
      $coverParams['typenavn'] = $virksomhedsType;
    }
    $cover = $this->renderView('AppBundle:VirksomhedRapport:showPdfKortlaegningCover.html.twig', $coverParams);

    // Data for energiFordeling pie chart.
    $energiFordeling = array(
      array(
        'label' => 'El',
        'value' => $rapport->getBaselineEl(),
      ),
      array(
        'label' => 'Varme',
        'value' => $rapport->getBaselineVarme(),
      ),
      array(
        'label' => 'Brændstof',
        'value' => $rapport->getBaselineBraendstof(),
      ),
    );
    $pieChartData['energiFordeling'] = $energiFordeling;

    // Data for overordnetForrug pie chart.
    $overordnetForrug = array(
      array(
        'label' => $rapport->getVirksomhed()->__toString(),
        'value' => $rapport->calculateSamletEnergiForbrug(),
      ),
    );
    foreach ($rapport->getVirksomhed()->getDatterSelskaber() as $datterSelskab) {
      if (empty($datterSelskab->getRapport())) {
        continue;
      }
      $overordnetForrug[] = array(
        'label' => $datterSelskab->getRapport()->getVirksomhed()->__toString(),
        'value' => $datterSelskab->getRapport()->calculateSamletEnergiForbrug(),
      );
    }
    $pieChartData['overordnetForrug'] = $overordnetForrug;

    // Data for elForrug pie chart.
    $elForrug = array(
      array(
        'label' => $rapport->getVirksomhed()->__toString(),
        'value' => $rapport->getBaselineEl(),
        'erhvervsareal' => $rapport->getErhvervsareal(),
      ),
    );
    foreach ($rapport->getVirksomhed()->getDatterSelskaber() as $datterSelskab) {
      if (empty($datterSelskab->getRapport())) {
        continue;
      }
      $elForrug[] = array(
        'label' => $datterSelskab->getRapport()->getVirksomhed()->__toString(),
        'value' => $datterSelskab->getRapport()->getBaselineEl(),
        'erhvervsareal' => $datterSelskab->getRapport()->getErhvervsareal(),
      );
    }
    $pieChartData['elForrug'] = $elForrug;

    // Data for varmeForrug pie chart.
    $varmeForrug = array(
      array(
        'label' => $rapport->getVirksomhed()->__toString(),
        'value' => $rapport->getBaselineVarme(),
        'opvarmetareal' => $rapport->getOpvarmetareal(),
      ),
    );
    foreach ($rapport->getVirksomhed()->getDatterSelskaber() as $datterSelskab) {
      if (empty($datterSelskab->getRapport())) {
        continue;
      }
      $varmeForrug[] = array(
        'label' => $datterSelskab->getRapport()->getVirksomhed()->__toString(),
        'value' => $datterSelskab->getRapport()->getBaselineVarme(),
        'erhvervsareal' => $datterSelskab->getRapport()->getErhvervsareal(),
      );
    }
    $pieChartData['varmeForrug'] = $varmeForrug;

    // Data for varmeForrug pie chart.
    $braendstofForrug = array(
      array(
        'label' => $rapport->getVirksomhed()->__toString(),
        'value' => $rapport->getBaselineVarme(),
        'erhvervsareal' => $rapport->getOpvarmetareal(),
      ),
    );
    foreach ($rapport->getVirksomhed()->getDatterSelskaber() as $datterSelskab) {
      if (empty($datterSelskab->getRapport())) {
        continue;
      }
      $braendstofForrug[] = array(
        'label' => $datterSelskab->getRapport()->getVirksomhed()->__toString(),
        'value' => $datterSelskab->getRapport()->getBaselineVarme(),
        'erhvervsareal' => $datterSelskab->getRapport()->getOpvarmetareal(),
      );
    }
    $pieChartData['braendstofForbrug'] = $braendstofForrug;

    // Data for beplarelseSluanvendelse pie chart.
    $labels = $rapport->getBesparelseSlutanvendelserLabels();
    $chartData = array();
    foreach ($rapport->getBesparelseSlutanvendelser(1) as $key => $value) {
      $chartData[] = array(
        'label' => $labels[$key],
        'value' => $value,
      );
    }
    $beplarelseSluanvendelse = array(
      array(
        'name' => $rapport->getVirksomhed()->getName(),
        'data' => $chartData,
      ),
    );

    foreach ($rapport->getVirksomhed()->getDatterSelskaber() as $datterSelskab) {
      if (empty($datterSelskab->getRapport())) {
        continue;
      }
      $chartData = array();
      foreach ($datterSelskab->getRapport()->getBesparelseSlutanvendelser(1) as $key => $value) {
        $chartData[] = array(
          'label' => $labels[$key],
          'value' => $value,
        );
      }
      $beplarelseSluanvendelse[] = array(
        'name' => $datterSelskab->getName(),
        'data' => $chartData,
      );
    }
    $pieChartData['beplarelseSluanvendelse'] = $beplarelseSluanvendelse;

    // Data for elForbrugSluanvendelse pie chart.
    $labels = $rapport->getBesparelseSlutanvendelserLabels();
    $elForbrugSluanvendelse = array();
    $chartData = array();
    if (!empty($rapport->getVirksomhed()->getKortlaegning())) {
      foreach ($rapport->getVirksomhed()->getKortlaegning()->getSlutanvendelser() as $key => $value) {
        $chartData[] = array(
          'label' => $labels[$key],
          'value' => $value['forbrug'],
        );
      }
      $elForbrugSluanvendelse[] = array(
        'name' => $rapport->getVirksomhed()->getName(),
        'data' => $chartData,
      );
    }

    foreach ($rapport->getVirksomhed()->getDatterSelskaber() as $datterSelskab) {
      if (empty($datterSelskab->getKortlaegning())) {
        continue;
      }
      $chartData = array();
      foreach ($datterSelskab->getKortlaegning()->getSlutanvendelser() as $key => $value) {
        $chartData[] = array(
          'label' => $labels[$key],
          'value' => $value['forbrug'],
        );
      }
      $elForbrugSluanvendelse[] = array(
        'name' => $datterSelskab->getName(),
        'data' => $chartData,
      );
    }
    $pieChartData['elForbrugSluanvendelse'] = $elForbrugSluanvendelse;
    $base_url = $this->container->get('request')->getSchemeAndHttpHost();
    $fm_elfinder_config = $this->container->getParameter('fm_elfinder');
    $uploadsPath =  '/' . $fm_elfinder_config['instances']['default']['connector']['roots']['uploads']['path'];
    if (!empty($uploadsPath)) {
      $uploadsUrl = $base_url . $uploadsPath;
      $rapport->setKortlaegningKonklusionTekst(str_replace('"' . $uploadsPath, '"' . $uploadsUrl, $rapport->getKortlaegningKonklusionTekst()));
      $rapport->setKortlaegningVirksomhedBeskrivelse(str_replace('"' . $uploadsPath, '"' . $uploadsUrl, $rapport->getKortlaegningVirksomhedBeskrivelse()));
    }

    $html = $this->renderView('AppBundle:VirksomhedRapport:showPdfKortlaegning.html.twig', array(
      'rapport' => $rapport,
      'pie_chart_data' => $pieChartData,
      'review' => $review,
    ));

    return $review ? ($cover . $html) : $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
      array('lowquality' => false,
            'encoding' => 'utf-8',
            'images' => true,
            'cover' => $cover,
            'header-left' => implode(' | ', $data),
            'header-right' => "Side [page] af [toPage]",
            'footer-html' => $base_url .'/html/pdfKortlaegningFooter.html'),
      $options));
  }

  public function exportVirksomhedRapportDetailark(VirksomhedRapport $rapport, array $options = array(), $review = FALSE) {
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
        'review' => $review,
      ));
    }

    $coverParams = array(
      'rapport' => $rapport,
      'review' => $review,
    );
    if ($virksomhed && $virksomhedsType = $virksomhed->getTypeNameLabel()) {
      $coverParams['typenavn'] = ucfirst($virksomhedsType);
    }
    $cover = $this->renderView('AppBundle:VirksomhedRapport:showPdfDetailarkCover.html.twig', $coverParams);

    return $review ? ($cover . $html) :  $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
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
