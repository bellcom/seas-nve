<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

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
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SolcelleTiltagRepository")
 */
class SolcelleTiltag extends Tiltag {

  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();

    // @Todo: Find af way to use the translations system or move this to some place else....
    $this->setTitle('Solcelletiltag');
  }

  protected function calculateElbesparelse() {
    return $this->sum('egetForbrugAfProduktionenKWh');
  }

  protected function calculateSamletEnergibesparelse() {
    return $this->elbesparelse * $this->getRapport()->getElKrKWh()
      + $this->sum(function($detail) {
        return $detail->getCashFlow()['Salg til nettet'][1];
      });
  }

  protected function calculateSamletCo2besparelse() {
    return (($this->varmebesparelseGAF / 1000) * $this->getRapport()->getVarmeKgCo2MWh()
            + ($this->elbesparelse / 1000) * $this->getRapport()->getElKgCo2MWh()) / 1000;
  }

  protected function calculateAnlaegsinvestering() {
    return $this->sum('investeringKr') + $this->sum('screeningOgProjekteringKr');
  }

}
