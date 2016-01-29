<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Calculation\Calculation;
use Doctrine\ORM\Mapping as ORM;

/**
 * BelysningTiltag.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class TekniskIsoleringTiltag extends Tiltag {

  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();

    // @Todo: Find af way to use the translations system or move this to some place else....
    $this->setTitle('Teknisk isolering');
  }

  protected function calculateVarmebesparelseGAF() {
    return $this->sum('kwhBesparelseVarmeFraVaerket') * $this->getRapport()->getFaktorPaaVarmebesparelse();
  }

  protected function calculateElbesparelse() {
    return $this->sum('kwhBesparelseElFraVaerket');
  }

  protected function calculateSamletEnergibesparelse() {
    return $this->varmebesparelseGAF * $this->calculateVarmepris()
      + $this->elbesparelse * $this->getRapport()->getElKrKWh();
  }

  protected function calculateSamletCo2besparelse() {
    return (($this->varmebesparelseGAF / 1000) * $this->getRapport()->getVarmeKgCo2MWh()
            + ($this->elbesparelse / 1000) * $this->getRapport()->getElKgCo2MWh()) / 1000;
  }

  protected function calculateAnlaegsinvestering() {
    return $this->sum('investeringKr');
  }

}
