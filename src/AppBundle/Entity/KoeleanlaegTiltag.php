<?php

/**
 * @file
 * KoeleanlaegTiltag.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Formula;
use Doctrine\ORM\Mapping as ORM;

/**
 * KoeleanlaegTiltag.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class KoeleanlaegTiltag extends Tiltag {

  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();

    // @Todo: Find af way to use the translations system or move this to some place else....
    $this->setTitle('Køleanlæg');
  }

  /**
   * {@inheritDoc}
   */
  protected function calculateForbrugFoerEl() {
    return $this->sum(function($detail) { return $detail->getTilstandDataFoerEtot(); });
  }

  /**
   * Calculates value that is using in elbesparelse calculation.
   *
   * @return float
   */
  protected function calculateElbesparelseValue() {
    return  $this->sum('samletBesparelse');
  }

  /**
   * @inheritDoc
   * @Formula("$this->calculateElbesparelseValue() * $this->calculateEnergiledelseFaktor()")
   */
  protected function calculateElbesparelse($value = null) {
    $value = $this->calculateElbesparelseValue();

    return parent::calculateElbesparelse($value);
  }

}
