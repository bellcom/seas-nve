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
    * @Formula("($this->varmebesparelseGAF + $this->varmebesparelseGUF) * $this->calculateVarmepris() + $this->elbesparelse * $this->getRapportElKrKWh() + $this->yderligereBesparelse")
    */
  protected $samletEnergibesparelse;

  /**
   * @Formula("((($this->varmebesparelseGAF + $this->varmebesparelseGUF) / 1000) * $this->getRapportVarmeKgCo2MWh() + ($this->elbesparelse / 1000) * $this->getRapportElKrKWh()) / 1000")
   */
  protected $samletCo2besparelse;

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
   * @ORM\Column(name="energiBesparelse", type="decimal", scale=4, precision=14)
   */
  protected $energiBesparelse;

  /**
   * @var float
   *
   * @ORM\Column(name="dieselPris", type="decimal", scale=4, precision=14)
   */
  protected $dieselPris;

  /**
   * @var float
   *
   * @ORM\Column(name="benzinPris", type="decimal", scale=4, precision=14)
   */
  protected $benzinPris;

  /**
   * @var float
   *
   * @ORM\Column(name="antalGulpladeBiler", type="decimal", scale=4, precision=14)
   */
  protected $antalGulpladeBiler;

  /**
   * @var float
   *
   * @ORM\Column(name="antalHvidpladeBiler", type="decimal", scale=4, precision=14)
   */
  protected $antalHvidpladeBiler;

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

  /**
   * @return float
   */
  public function getDieselPris() {
    return $this->dieselPris;
  }

  /**
   * @param float $dieselPris
   */
  public function setDieselPris($dieselPris) {
    $this->dieselPris = $dieselPris;
  }

  /**
   * @return float
   */
  public function getBenzinPris() {
    return $this->benzinPris;
  }

  /**
   * @param float $benzinPris
   */
  public function setBenzinPris($benzinPris) {
    $this->benzinPris = $benzinPris;
  }

  /**
   * @return float
   */
  public function getAntalGulpladeBiler() {
    return $this->antalGulpladeBiler;
  }

  /**
   * @param float $antalGulpladeBiler
   */
  public function setAntalGulpladeBiler($antalGulpladeBiler) {
    $this->antalGulpladeBiler = $antalGulpladeBiler;
  }

  /**
   * @return float
   */
  public function getAntalHvidpladeBiler() {
    return $this->antalHvidpladeBiler;
  }

  /**
   * @param float $antalHvidpladeBiler
   */
  public function setAntalHvidpladeBiler($antalHvidpladeBiler) {
    $this->antalHvidpladeBiler = $antalHvidpladeBiler;
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

  protected function calculateVarmebesparelseGUF($value = null) {
    $value = ($this->rapport->getStandardForsyning() ? $this->besparelseGUF : $this->fordelbesparelse($this->besparelseGUF, $this->getForsyningVarme(), 'VARME')) * $this->rapport->getFaktorPaaVarmebesparelse();
    return parent::calculateVarmebesparelseGUF($value);
  }

  protected function calculateVarmebesparelseGAF($value = null) {
    $value = ($this->rapport->getStandardForsyning() ? $this->besparelseGAF : $this->fordelbesparelse($this->besparelseGAF, $this->getForsyningVarme(), 'VARME')) * $this->rapport->getFaktorPaaVarmebesparelse();
    return parent::calculateVarmebesparelseGAF($value);
  }

  protected function calculateElbesparelse($value = null) {
    if ($this->rapport->getStandardForsyning()) {
      $value = $this->besparelseEl;
    }
    else {
      $value = ($this->fordelbesparelse($this->besparelseGUF, $this->getForsyningVarme(), 'EL')
        + $this->fordelbesparelse($this->besparelseGAF, $this->getForsyningVarme(), 'EL')
        + $this->besparelseEl);
    }

    return parent::calculateElbesparelse($value);
  }

  protected function calculateCashFlow($numberOfYears, $yderligereBesparelseKrAar = 0) {
    return parent::calculateCashFlow($numberOfYears, $this->getYderligereBesparelse());
  }

  public function calculateSavingsForYear($year) {
    return parent::calculateSavingsForYear($year) + $this->getYderligereBesparelse();
  }

  protected function calculateAnlaegsinvestering($value = NULL) {
    return parent::calculateAnlaegsinvestering($this->getAnlaegsinvesteringExRisiko());
  }

}


// solcelle=(C4+C5)*INDIREKTE("'1.TiltagslisteRådgiver'!AI6")+INDIREKTE("'1.TiltagslisteRådgiver'!AI7")*C6*INDIREKTE("'1.TiltagslisteRådgiver'!$F$22")+C7*INDIREKTE("'1.TiltagslisteRådgiver'!AI8")+L48

// special=(C4+C5)*INDIREKTE("'1.TiltagslisteRådgiver'!AI6")+INDIREKTE("'1.TiltagslisteRådgiver'!AI7")*C6*INDIREKTE("'1.TiltagslisteRådgiver'!$F$22")+C7*INDIREKTE("'1.TiltagslisteRådgiver'!AI8")

// teknisk=(C4+C5)*INDIREKTE("'1.TiltagslisteRådgiver'!AI6")+INDIREKTE("'1.TiltagslisteRådgiver'!AI7")*C6+C7*INDIREKTE("'1.TiltagslisteRådgiver'!AI8")
