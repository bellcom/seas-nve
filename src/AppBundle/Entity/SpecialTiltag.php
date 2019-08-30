<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Formula;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Tiltag
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SpecialTiltagRepository")
 */
class SpecialTiltag extends Tiltag {
  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();

    // @Todo: Find af way to use the translations system or move this to some place else....
    $this->setTitle('Specialforslag');
  }

  /**
    * @Formula("($this->varmebesparelseGAF + $this->varmebesparelseGUF) * $this->calculateVarmepris() + $this->elbesparelse * $this->getRapportElKrKWh() + $this->yderligereBesparelse + $this->besparelseInvestering + $this->besparelseVedligehold + ($this->energiBesparelse * $this->tilskudsstoerrelse)")
    */
  protected $samletEnergibesparelse;

  /**
   * @Formula("((($this->varmebesparelseGAF + $this->varmebesparelseGUF) / 1000) * $this->getRapportVarmeKgCo2MWh() + ($this->elbesparelse / 1000) * $this->getRapportElKrKWh()) / 1000")
   */
  protected $samletCo2besparelse;

  /**
   * @Formula("$this->energiBesparelse * $this->tilskudsstoerrelse")
   */
  protected $samletTilskud;

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseGUF", type="decimal", scale=4, precision=14)
   */
  protected $besparelseGUF;

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseGAF", type="decimal", scale=4, precision=14)
   */
  protected $besparelseGAF;

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseEl", type="decimal", scale=4, precision=14)
   */
  protected $besparelseEl;

  /**
   * @var float
   *
   * @ORM\Column(name="energiBesparelse", type="decimal", scale=4, precision=14, nullable=true)
   * @Formula("($this->varmebesparelseGAF + $this->varmebesparelseGUF) * $this->calculateVarmepris() + $this->elbesparelse * $this->getRapportElKrKWh() + $this->yderligereBesparelse + $this->besparelseInvestering + $this->besparelseVedligehold + ($this->energiBesparelse * $this->tilskudsstoerrelse)")
   */
  protected $energiBesparelse;

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseInvestering", type="decimal", scale=4, precision=14, nullable=true)
   */
  protected $besparelseInvestering;

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseVedligehold", type="decimal", scale=4, precision=14, nullable=true)
   */
  protected $besparelseVedligehold;

  /**
   * @var float
   *
   * @ORM\Column(name="yderligereBesparelse", type="decimal", scale=4, precision=14)
   */
  protected $yderligereBesparelse;

  /**
   * @return float
   */
  public function getYderligereBesparelse() {
    return $this->yderligereBesparelse;
  }

  /**
   * @param float $yderligereBesparelse
   */
  public function setYderligereBesparelse($yderligereBesparelse) {
    $this->yderligereBesparelse = $yderligereBesparelse;
  }

  /**
   * @return float
   */
  public function getEnergiBesparelse() {
    return $this->energiBesparelse;
  }

  /**
   * @param float $energiBesparelse
   */
  public function setEnergiBesparelse($energiBesparelse) {
    $this->energiBesparelse = $energiBesparelse;
  }

  public function setBesparelseGUF($besparelseGUF) {
    $this->besparelseGUF = $besparelseGUF;

    return $this;
  }

  public function getBesparelseGUF() {
    return $this->besparelseGUF;
  }

  public function setBesparelseGAF($besparelseGAF) {
    $this->besparelseGAF = $besparelseGAF;

    return $this;
  }

  public function getBesparelseGAF() {
    return $this->besparelseGAF;
  }

  public function setBesparelseEl($besparelseEl) {
    $this->besparelseEl = $besparelseEl;

    return $this;
  }

  public function getBesparelseEl() {
    return $this->besparelseEl;
  }

  public function setBesparelseInvestering($besparelseInvestering) {
    $this->besparelseInvestering = $besparelseInvestering;

    return $this;
  }

  public function getBesparelseInvestering() {
    return $this->besparelseInvestering;
  }

  public function setBesparelseVedligehold($besparelseVedligehold) {
    $this->besparelseVedligehold = $besparelseVedligehold;

    return $this;
  }

  public function getBesparelseVedligehold() {
    return $this->besparelseVedligehold;
  }

  /**
   * Set anlaegsinvestering
   *
   * @param float
   *
   * @return SpecialTiltag
   */
  public function setAnlaegsinvestering($anlaegsinvestering) {
    $this->anlaegsinvestering = $anlaegsinvestering;

    return $this;
  }

  /**
   * @param float $anlaegsinvesteringExRisiko
   *
   * @return SpecialTiltag
   */
  public function setAnlaegsinvesteringExRisiko($anlaegsinvesteringExRisiko) {
    $this->anlaegsinvesteringExRisiko = $anlaegsinvesteringExRisiko;

    return $this;
  }

  protected $propertiesRequiredForCalculation = [
    'besparelseEl',
    'besparelseGAF',
    'besparelseGUF',
    'faktorForReinvesteringer',
    'forsyningEl',
    'forsyningVarme',
    'levetid',
    'primaerEnterprise',
    'tiltagskategori',
    'yderligereBesparelse',
  ];

  /**
   * Calculates value that is using in varmebesparelseGUF calculation.
   *
   * @return float
   */
  protected function calculateVarmebesparelseGUFValue() {
    return ($this->rapport->getStandardForsyning() ? $this->besparelseGUF : $this->fordelbesparelse($this->besparelseGUF, $this->getForsyningVarme(), 'VARME')) * $this->rapport->getFaktorPaaVarmebesparelse();
  }

  /**
   * @inheritDoc
   * @Formula("$this->calculateVarmebesparelseGUFValue() * $this->calculateRisikoFaktor() * $this->calculateEnergiledelseFaktor()")
   */
  protected function calculateVarmebesparelseGUF($value = null) {
    $value = $this->calculateVarmebesparelseGUFValue();
    return parent::calculateVarmebesparelseGUF($value);
  }

  /**
   * Calculates value that is using in varmebesparelseGAF calculation.
   *
   * @return float
   */
  protected function calculateVarmebesparelseGAFValue() {
    return ($this->rapport->getStandardForsyning() ? $this->besparelseGAF : $this->fordelbesparelse($this->besparelseGAF, $this->getForsyningVarme(), 'VARME')) * $this->rapport->getFaktorPaaVarmebesparelse();
  }

  /**
   * @inheritDoc
   * @Formula("$this->calculateVarmebesparelseGAFValue() * $this->calculateRisikoFaktor() * $this->calculateEnergiledelseFaktor()")
   */
  protected function calculateVarmebesparelseGAF($value = null) {
    $value = $this->calculateVarmebesparelseGAFValue();
    return parent::calculateVarmebesparelseGAF($value);
  }

  /**
   * Calculates value that is using in elbesparelse calculation.
   *
   * @return float
   */
  protected function calculateElbesparelseValue() {
    if ($this->rapport->getStandardForsyning()) {
      return $this->besparelseEl;
    }

    return ($this->fordelbesparelse($this->besparelseGUF, $this->getForsyningVarme(), 'EL')
      + $this->fordelbesparelse($this->besparelseGAF, $this->getForsyningVarme(), 'EL')
      + $this->besparelseEl);
  }

  /**
   * @inheritDoc
   * @Formula("$this->calculateElbesparelseValue() * $this->calculateRisikoFaktor() * $this->calculateEnergiledelseFaktor()")
   */
  protected function calculateElbesparelse($value = null) {
    $value = $this->calculateElbesparelseValue();
    return parent::calculateElbesparelse($value);
  }

  protected function calculateCashFlow($numberOfYears, $yderligereBesparelseKrAar = 0) {
    return parent::calculateCashFlow($numberOfYears, $this->getYderligereBesparelse());
  }

  public function calculateSavingsForYear($year) {
    return parent::calculateSavingsForYear($year) + $this->getYderligereBesparelse();
  }

  /**
   * @inheritDoc
   * @Formula("$this->getAnlaegsinvesteringExRisiko() * $this->calculateAnlaegsinvesteringFaktor()")
   */
  protected function calculateAnlaegsinvestering($value = NULL) {
    return parent::calculateAnlaegsinvestering($this->getAnlaegsinvesteringExRisiko());
  }

  public function calculate() {
    $this->samletTilskud = $this->calculateByFormula('samletTilskud');
    parent::calculate();
  }

}


// solcelle=(C4+C5)*INDIREKTE("'1.TiltagslisteRådgiver'!AI6")+INDIREKTE("'1.TiltagslisteRådgiver'!AI7")*C6*INDIREKTE("'1.TiltagslisteRådgiver'!$F$22")+C7*INDIREKTE("'1.TiltagslisteRådgiver'!AI8")+L48

// special=(C4+C5)*INDIREKTE("'1.TiltagslisteRådgiver'!AI6")+INDIREKTE("'1.TiltagslisteRådgiver'!AI7")*C6*INDIREKTE("'1.TiltagslisteRådgiver'!$F$22")+C7*INDIREKTE("'1.TiltagslisteRådgiver'!AI8")

// teknisk=(C4+C5)*INDIREKTE("'1.TiltagslisteRådgiver'!AI6")+INDIREKTE("'1.TiltagslisteRådgiver'!AI7")*C6+C7*INDIREKTE("'1.TiltagslisteRådgiver'!AI8")
