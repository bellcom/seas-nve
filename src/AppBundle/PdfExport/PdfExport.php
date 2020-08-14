<?php

namespace AppBundle\PdfExport;

use AppBundle\Entity\Bygning;
use AppBundle\Entity\VirksomhedRapport;
use AppBundle\Service\BygningRapportExporter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Rapport;

class PdfExport extends BygningRapportExporter {
  public function __construct(ContainerInterface $container) {
    parent::__construct($container);
  }

  public function export2(Rapport $rapport, array $options = array(), $review = FALSE) {
    $data = $this->data($rapport);
    $cover = $this->cover2($rapport, $review);
    $html = $this->rapport2($rapport, $review);

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

}
