<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Formula;
use AppBundle\Calculation\Calculation;
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
    $this->setTitle('Solceller');
  }

  /**
   * @var float
   *
   * @ORM\Column(name="solcelleproduktion", type="decimal", scale=4, precision=14)
   */
  protected $solcelleproduktion;

  public function getSalgTilNettetAar1() {
    return $this->sum(function($detail) { return $detail->getCashFlow()['Salg til nettet'][1]; }) / $this->getRapport()->getConfiguration()->getSolcelletiltagdetailSalgsprisFoerste10AarKrKWh();
  }

  public function getSolcelleproduktion() {
    return $this->solcelleproduktion;
  }

  public function calculate() {
    $this->solcelleproduktion = $this->calculateSolcelleproduktion();
    parent::calculate();
  }

  protected function calculateSolcelleproduktion($value = null) {
    return $this->sum('egetForbrugAfProduktionenKWh');
  }

  protected function calculateElbesparelse($value = null) {
    return 0;
  }

  /**
   * @Formula("$this->solcelleproduktion * $this->getRapportElKrKWh() + $this->getSalgTilNettetAar1() * $this->getRapportSolcelletiltagdetailSalgsprisFoerste10AarKrKWh()")
   */
  protected function calculateSamletEnergibesparelse() {
    return $this->solcelleproduktion * $this->getRapport()->getElKrKWh()
      + $this->getSalgTilNettetAar1() * $this->getRapportSolcelletiltagdetailSalgsprisFoerste10AarKrKWh();
  }

  /**
   * @Formula("($this->solcelleproduktion + $this->getSalgTilNettetAar1()) / 1000 * $this->calculateelKgCo2MWh() / 1000")
   */
  protected function calculateSamletCo2besparelse() {
    return ($this->solcelleproduktion + $this->getSalgTilNettetAar1()) / 1000 * $this->calculateelKgCo2MWh() / 1000;
  }

  protected function calculateelKgCo2MWh() {
    $forsyningsvaerk = $this->getRapport()->getBygning()->getForsyningsvaerkEl();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKgCo2MWh(2009);
  }

  protected function calculateAnlaegsinvestering($value = NULL) {
    $value = ($this->sum('investeringKr') + $this->sum('screeningOgProjekteringKr'));

    return parent::calculateAnlaegsinvestering($value);
  }

  protected function calculateSimpelTilbagebetalingstidAar() {
    return $this->sum('simpelTilbagebetalingstidAar');
  }

  protected function calculateNutidsvaerdiSetOver15AarKr() {
    if ($this->getTilvalgteDetails()->count() == 1) {
      return Calculation::npv($this->getRapport()->getKalkulationsrente(), $this->getTilvalgteDetails()->first()->getCashFlow()['Cash flow']);
    }
    return 0;
  }

  protected function calculateMaengde() {
    return $this->sum('anlaegsstoerrelseKWp');
  }

  protected function calculateEnhed() {
    return 'KWp';
  }

  public function calculateSavingsForYear($year) {
    if ($year > $this->levetid) {
      return 0;
    }

    return parent::calculateSavingsForYear($year)
      + $this->getSolcelleproduktion() * $this->getRapport()->getElKrKWh($year)
      + $this->getSalgTilNettetAar1() * $this->getRapport()->getConfiguration()->getSolcelletiltagdetailSalgsprisFoerste10AarKrKWh();
  }

}
