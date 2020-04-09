<?php

/**
 * @file
 * KoelingTiltag.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Formula;
use Doctrine\ORM\Mapping as ORM;

/**
 * KoelingTiltag.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class KoelingTiltag extends Tiltag {


  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();

    // @Todo: Find af way to use the translations system or move this to some place else....
    $this->setTitle('Køling');
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
   * @Formula("$this->calculateElbesparelseValue() * $this->calculateRisikoFaktor() * $this->calculateEnergiledelseFaktor()")
   */
  protected function calculateElbesparelse($value = null) {
    $value = $this->calculateElbesparelseValue();

    return parent::calculateElbesparelse($value);
  }


}