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
   * @Formula("$this->solcelleproduktion * $this->getRapportElKrKWh() + $this->getSalgTilNettetAar1() * $this->getRapportSolcelletiltagdetailSalgsprisFoerste10AarKrKWh()")
   */
  protected $samletEnergibesparelse;

  /**
   * @Formula("($this->solcelleproduktion + $this->getSalgTilNettetAar1()) / 1000 * $this->calculateelKgCo2MWh() / 1000")
   */
  protected $samletCo2besparelse;

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
    return $this->sum(function($detail) { return $detail->getCashFlow()['Salg til nettet'][1]; }) / $this->getRapportSolcelletiltagdetailSalgsprisFoerste10AarKrKWh();
  }

  public function getRapportSolcelletiltagdetailSalgsprisFoerste10AarKrKWh() {
    return $this->getRapport()->getConfiguration()->getSolcelletiltagdetailSalgsprisFoerste10AarKrKWh();
  }

  public function calculateSalgTilNettetAar1SumExpr() {
    return $this->sum(function($detail) { return $detail->getCashFlow()['Salg til nettet'][1]; }, TRUE);
  }
  
  /**
   * @Formula("$this->calculateSalgTilNettetAar1SumExpr() / $this->getRapportSolcelletiltagdetailSalgsprisFoerste10AarKrKWh()")
   */
  public function calculateSalgTilNettetAar1() {
    return $this->getSalgTilNettetAar1();
  }
  
  public function getSolcelleproduktion() {
    return $this->solcelleproduktion;
  }

  public function calculate() {
    $this->solcelleproduktion = $this->calculateSolcelleproduktion();
    parent::calculate();
  }

  /**
   * @inheritDoc
   * @Formula("$this->calculateSolcelleproduktionExpr()")
   */
  protected function calculateSolcelleproduktion($value = null) {
    return $this->sum('egetForbrugAfProduktionenKWh');
  }

  protected function calculateSolcelleproduktionExpr($value = null) {
    return $this->sum('egetForbrugAfProduktionenKWh', TRUE);
  }

  /**
   * @inheritDoc
   */
  protected function calculateElbesparelse($value = null) {
    return 0;
  }

  protected function calculateelKgCo2MWh() {
    $forsyningsvaerk = $this->getRapport()->getBygning()->getForsyningsvaerkEl(TRUE);
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKgCo2MWh(2015);
  }

  /**
   * Calculates value that is using in Anlaegsinvestering calculation.
   *
   * @return float
   */
  protected function calculateAnlaegsinvesteringValueExpr() {
    return $this->sum('investeringKr') . ' + ' . $this->sum('screeningOgProjekteringKr');
  }
  
  /**
   * @inheritDoc
   * @Formula("$this->calculateAnlaegsinvesteringValueExpr() * $this->calculateAnlaegsinvesteringFaktor()")
   */
  protected function calculateAnlaegsinvestering($value = NULL) {
    $value = ($this->sum('investeringKr') + $this->sum('screeningOgProjekteringKr'));

    return parent::calculateAnlaegsinvestering($value);
  }

  protected function calculateSimpelTilbagebetalingstidAar() {
    return $this->sum('simpelTilbagebetalingstidAar');
  }

  /**
   * Calculates expression for nutidsvaerdiSetOver15AarKr value
   */
  protected function calculateNutidsvaerdiSetOver15AarKrExpr() {
    return $this->sumExpr($this->calculateNutidsvaerdiSetOver15AarKr(TRUE));
  }

  protected function calculateNutidsvaerdiSetOver15AarKr($array = FALSE) {
    if ($this->getTilvalgteDetails()->count() == 1) {
      return Calculation::npv($this->getRapport()->getKalkulationsrente(), $this->getTilvalgteDetails()->first()->getCashFlow()['Cash flow'], $array);
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
