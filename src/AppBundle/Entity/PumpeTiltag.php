<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Formula;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * Tiltag
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PumpeTiltagRepository")
 */
class PumpeTiltag extends Tiltag {

  /**
   * @Formula("$this->varmebesparelseGAF * $this->calculateVarmepris() + $this->elbesparelse * $this->getRapportElKrKWh()")
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
    $this->setTitle('Pumpeudskiftninger');
  }

  protected function calculateVarmebesparelseGAF($value = null) {
    $value = $this->sum('kwhBesparelseVarmeFraVaerket') * $this->getRapport()->getFaktorPaaVarmebesparelse();

    return parent::calculateVarmebesparelseGAF($value);
  }

  protected function calculateElbesparelse($value = null) {
    $value = $this->sum('kwhBesparelseElFraVaerket');

    return parent::calculateElbesparelse($value);
  }

  protected function calculateAnlaegsinvestering($value = NULL) {
    $value = $this->sum('samletInvesteringInklPristillaeg');

    return parent::calculateAnlaegsinvestering($value);
  }

  protected function calculateMaengde() {
    return count($this->getTilvalgteDetails());
  }

  protected function calculateEnhed() {
    return 'stk';
  }

}
