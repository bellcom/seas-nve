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

  protected function calculateVarmebesparelseGAF($value = null) {
    $value = $this->sum('kwhBesparelseVarmeFraVaerket') * $this->getRapport()->getFaktorPaaVarmebesparelse();

    return parent::calculateVarmebesparelseGAF($value);
  }

  protected function calculateElbesparelse($value = null) {
    $value = $this->sum('kwhBesparelseElFraVaerket');

    return parent::calculateElbesparelse($value);
  }

  protected function calculateSamletEnergibesparelse() {
    return $this->varmebesparelseGAF * $this->calculateVarmepris() + $this->elbesparelse * $this->getRapport()->getElKrKWh();
  }

  protected function calculateSamletCo2besparelse() {
    return (($this->varmebesparelseGAF / 1000) * $this->getRapport()->getVarmeKgCo2MWh()
            + ($this->elbesparelse / 1000) * $this->getRapport()->getElKgCo2MWh()) / 1000;
  }

  protected function calculateAnlaegsinvestering($value = NULL) {
    $value = $this->sum('investeringKr');

    return parent::calculateAnlaegsinvestering($value);
  }

  protected function calculateMaengde() {
    return $this->sum('roerlaengdeEllerHoejdeAfVvbM');
  }

  protected function calculateEnhed() {
    return 'm';
  }

}
