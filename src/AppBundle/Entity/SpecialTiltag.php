<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

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
    $this->setTitle('Specialtiltag');
  }

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseGUF", type="decimal", scale=4)
   */
  protected $besparelseGUF;

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseGAF", type="decimal", scale=4)
   */
  protected $besparelseGAF;

  /**
   * @var float
   *
   * @ORM\Column(name="besparelseEl", type="decimal", scale=4)
   */
  protected $besparelseEl;

  /**
   * @var float
   *
   * @ORM\Column(name="yderligereBesparelse", type="decimal", scale=4)
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

  protected function calculateVarmebesparelseGUF() {
    if ($this->rapport->getStandardForsyning()) {
      return $this->besparelseGUF;
    }
    else {
      return $this->fordelbesparelse($this->besparelseGUF, $this->getForsyningVarme(), 'VARME') * $this->rapport->getFaktorPaaVarmebesparelse();
    }
  }

  protected function calculateVarmebesparelseGAF() {
    if ($this->rapport->getStandardForsyning()) {
      return $this->besparelseGAF;
    }
    else {
      return $this->fordelbesparelse($this->besparelseGAF, $this->getForsyningVarme(), 'VARME') * $this->rapport->getFaktorPaaVarmebesparelse();
    }
  }

  protected function calculateElbesparelse() {
    if ($this->rapport->getStandardForsyning()) {
      return $this->besparelseEl;
    }
    else {
      return $this->fordelbesparelse($this->besparelseGUF, $this->getForsyningVarme(), 'EL')
        + $this->fordelbesparelse($this->besparelseGAF, $this->getForsyningVarme(), 'EL')
        + $this->besparelseEl;
    }
  }

  protected function calculateSamletEnergibesparelse() {
    return ($this->varmebesparelseGAF + $this->varmebesparelseGUF) * $this->calculateVarmepris()
      + $this->elbesparelse * $this->getRapport()->getElKrKWh() + $this->yderligereBesparelse;
  }

  protected function calculateSamletCo2besparelse() {
    return (($this->varmebesparelseGAF / 1000) * $this->getRapport()->getVarmeKgCo2MWh()
            + ($this->elbesparelse / 1000) * $this->getRapport()->getElKgCo2MWh()) / 1000;
  }

}


// solcelle=(C4+C5)*INDIREKTE("'1.TiltagslisteRådgiver'!AI6")+INDIREKTE("'1.TiltagslisteRådgiver'!AI7")*C6*INDIREKTE("'1.TiltagslisteRådgiver'!$F$22")+C7*INDIREKTE("'1.TiltagslisteRådgiver'!AI8")+L48

// special=(C4+C5)*INDIREKTE("'1.TiltagslisteRådgiver'!AI6")+INDIREKTE("'1.TiltagslisteRådgiver'!AI7")*C6*INDIREKTE("'1.TiltagslisteRådgiver'!$F$22")+C7*INDIREKTE("'1.TiltagslisteRådgiver'!AI8")

// teknisk=(C4+C5)*INDIREKTE("'1.TiltagslisteRådgiver'!AI6")+INDIREKTE("'1.TiltagslisteRådgiver'!AI7")*C6+C7*INDIREKTE("'1.TiltagslisteRådgiver'!AI8")