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
    * @Formula("($this->varmebesparelseGAF + $this->varmebesparelseGUF) * $this->getVarmePris() + $this->elbesparelse * $this->getElPris() + $this->yderligereBesparelse")
    */
  protected $samletEnergibesparelse;

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseGUF", type="decimal", scale=4, precision=14)
   */
  protected $besparelseGUF = 0;

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseCo2Braendstof", type="decimal", scale=4, precision=14, nullable=true)
   */
  protected $besparelseCo2Braendstof = 0;

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseCo2BraendstofITon", type="decimal", scale=4, precision=14, nullable=true)
   */
  protected $besparelseCo2BraendstofITon = 0;

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseGAF", type="decimal", scale=4, precision=14)
   */
  protected $besparelseGAF = 0;

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseEl", type="decimal", scale=4, precision=14)
   */
  protected $besparelseEl = 0;

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseBraendstof", type="decimal", scale=4, precision=14, nullable=true)
   */
  protected $besparelseBraendstof = 0;

  /**
   * @var float
   *
   * @ORM\Column(name="forbrugFoerVarme", type="decimal", nullable=true)
   */
  protected $forbrugFoerVarme = 0;

  /**
   * @var float
   *
   * @ORM\Column(name="forbrugFoerEl", type="decimal", nullable=true)
   */
  protected $forbrugFoerEl = 0;

  /**
   * @var float
   *
   * @ORM\Column(name="forbrugFoerBraendstof", type="decimal", nullable=true)
   */
  protected $forbrugFoerBraendstof = 0;

  /**
   * @Formula("$this->forbrugFoer - ($this->varmebesparelseGAF + $this->varmebesparelseGUF)")
   */
  protected $forbrugEfter = 0;

  /**
   * @var float
   *
   * @ORM\Column(name="yderligereBesparelse", type="decimal", scale=4, precision=14)
   */
  protected $yderligereBesparelse = 0;

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
  public function getBesparelseBraendstof() {
    return $this->besparelseBraendstof;
  }

  /**
   * @param float $besparelseBraendstof
   */
  public function setBesparelseBraendstof($besparelseBraendstof) {
    $this->besparelseBraendstof = $besparelseBraendstof;
  }

  public function setBesparelseGUF($besparelseGUF) {
    $this->besparelseGUF = $besparelseGUF;

    return $this;
  }

  public function getBesparelseGUF() {
    return $this->besparelseGUF;
  }

  public function setBesparelseCo2Braendstof($besparelseCo2Braendstof) {
    $this->besparelseCo2Braendstof = $besparelseCo2Braendstof;

    return $this;
  }

  public function getBesparelseCo2Braendstof() {
    return $this->besparelseCo2Braendstof;
  }

  public function setBesparelseCo2BraendstofITon($besparelseCo2BraendstofITon) {
    $this->besparelseCo2BraendstofITon = $besparelseCo2BraendstofITon;

    return $this;
  }

  public function getBesparelseCo2BraendstofITon() {
    return $this->besparelseCo2BraendstofITon;
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

  /**
   * Set forbrugFoerVarme
   *
   * @param float $forbrugFoerVarme
   * @return Tiltag
   */
  public function setForbrugFoerVarme($forbrugFoerVarme) {
    $this->forbrugFoerVarme = $forbrugFoerVarme;

    return $this;
  }

  /**
   * Get forbrugFoerVarme
   *
   * @return float
   */
  public function getForbrugFoerVarme() {
    return $this->forbrugFoerVarme;
  }

  /**
   * Set forbrugFoerEl
   *
   * @param float $forbrugFoerEl
   * @return Tiltag
   */
  public function setForbrugFoerEl($forbrugFoerEl) {
    $this->forbrugFoerEl = $forbrugFoerEl;

    return $this;
  }

  /**
   * Get forbrugFoerEl
   *
   * @return float
   */
  public function getForbrugFoerEl() {
    return $this->forbrugFoerEl;
  }

  /**
   * Set forbrugFoerBraendstof
   *
   * @param float $forbrugFoerBraendstof
   * @return Tiltag
   */
  public function setForbrugFoerBraendstof($forbrugFoerBraendstof) {
    $this->forbrugFoerBraendstof = $forbrugFoerBraendstof;

    return $this;
  }

  /**
   * Get forbrugFoerBraendstof
   *
   * @return float
   */
  public function getForbrugFoerBraendstof() {
    return $this->forbrugFoerBraendstof;
  }

  protected $propertiesRequiredForCalculation = [
    'besparelseEl',
    'besparelseGAF',
    'besparelseGUF',
    'faktorForReinvesteringer',
    'forsyningEl',
    'forsyningVarme',
    'levetid',
    'yderligereBesparelse',
    'slutanvendelse',
  ];

  /**
   * Calculates value that is using in varmebesparelseGUF calculation.
   *
   * @return float
   */
  protected function calculateVarmebesparelseGUFValue() {
    return ($this->rapport->getStandardForsyning() ? $this->besparelseGUF : $this->fordelbesparelse($this->besparelseGUF, $this->getForsyningVarme(), 'VARME'));
  }

  /**
   * @inheritDoc
   * @Formula("$this->calculateVarmebesparelseGUFValue() * $this->calculateEnergiledelseFaktor()")
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
    return ($this->rapport->getStandardForsyning() ? $this->besparelseGAF : $this->fordelbesparelse($this->besparelseGAF, $this->getForsyningVarme(), 'VARME'));
  }

  /**
   * @inheritDoc
   * @Formula("$this->calculateVarmebesparelseGAFValue() * $this->calculateEnergiledelseFaktor()")
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
   * @Formula("$this->calculateElbesparelseValue() * $this->calculateEnergiledelseFaktor()")
   */
  protected function calculateElbesparelse($value = null) {
    $value = $this->calculateElbesparelseValue();
    return parent::calculateElbesparelse($value);
  }

  protected function calculateCashFlow($numberOfYears, $yderligereBesparelseKrAar = 0) {
    return parent::calculateCashFlow($numberOfYears, $this->getYderligereBesparelse());
  }

  /**
   * @inheritDoc
   * @Formula("$this->getAnlaegsinvesteringExRisiko() * $this->calculateAnlaegsinvesteringFaktor()")
   */
  protected function calculateAnlaegsinvestering($value = NULL) {
    return parent::calculateAnlaegsinvestering($this->getAnlaegsinvesteringExRisiko());
  }


  /**
   * {@inheritDoc}
   * @Formula("$this->calculateForbrugFoerVarme() + $this->calculateForbrugFoerEl() + $this->getForbrugFoerBraendstof()")
   */
  protected function calculateForbrugFoer() {
    return parent::calculateForbrugFoer() + $this->getForbrugFoerBraendstof();
  }

  /**
   * {@inheritDoc}
   */
  protected function calculateForbrugFoerVarme() {
    // Bypass default calculation for this tiltag. Value defines in tiltag form.
    return $this->getForbrugFoerVarme();
  }

  /**
   * {@inheritDoc}
   */
  protected function calculateForbrugFoerEl() {
    // Bypass default calculation for this tiltag. Value defines in tiltag form.
    return $this->getForbrugFoerEl();
  }

  /**
   * {@inheritDoc}
   */
  protected function calculateForbrugEfter() {
    return $this->calculateForbrugFoer() - $this->getVarmebesparelseGAF() - $this->getVarmebesparelseGUF() - $this->getElbesparelse() - $this->getBesparelseBraendstof();
  }

}


// solcelle=(C4+C5)*INDIREKTE("'1.TiltagslisteRådgiver'!AI6")+INDIREKTE("'1.TiltagslisteRådgiver'!AI7")*C6*INDIREKTE("'1.TiltagslisteRådgiver'!$F$22")+C7*INDIREKTE("'1.TiltagslisteRådgiver'!AI8")+L48

// special=(C4+C5)*INDIREKTE("'1.TiltagslisteRådgiver'!AI6")+INDIREKTE("'1.TiltagslisteRådgiver'!AI7")*C6*INDIREKTE("'1.TiltagslisteRådgiver'!$F$22")+C7*INDIREKTE("'1.TiltagslisteRådgiver'!AI8")

// teknisk=(C4+C5)*INDIREKTE("'1.TiltagslisteRådgiver'!AI6")+INDIREKTE("'1.TiltagslisteRådgiver'!AI7")*C6+C7*INDIREKTE("'1.TiltagslisteRådgiver'!AI8")
