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
   * @Formula("$this->elbesparelse * $this->getRapportElKrKWh()")
   */
  protected $samletEnergibesparelse;

  /**
   * @Formula("(($this->varmebesparelseGAF / 1000) * $this->getRapportVarmeKgCo2MWh() + ($this->elbesparelse / 1000) * $this->getRapportElKgCo2MWh()) / 1000")
   */
  protected $samletCo2besparelse;

  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();

    // @Todo: Find af way to use the translations system or move this to some place else....
    $this->setTitle('Køleanlæg');
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
