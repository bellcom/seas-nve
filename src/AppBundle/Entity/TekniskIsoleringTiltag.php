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
    $besparelse = $this->getRisikovurderingAendringIBesparelseFaktor() ? $this->getRisikovurderingAendringIBesparelseFaktor() : 0;

    return ($this->varmebesparelseGAF * $this->calculateVarmepris()
      + $this->elbesparelse * $this->getRapport()->getElKrKWh()) * (1 - $besparelse);
  }

  protected function calculateSamletCo2besparelse() {
    return (($this->varmebesparelseGAF / 1000) * $this->getRapport()->getVarmeKgCo2MWh()
            + ($this->elbesparelse / 1000) * $this->getRapport()->getElKgCo2MWh()) / 1000;
  }

  protected function calculateAnlaegsinvestering() {
    $kompensering = $this->getRisikovurderingOekonomiskKompenseringIftInvesteringFaktor() ? $this->getRisikovurderingOekonomiskKompenseringIftInvesteringFaktor() : 0;

    return $this->sum('investeringKr') * (1 + $kompensering);
  }

}
