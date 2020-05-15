<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use AppBundle\Annotations\Calculated;

/**
 * PumpeTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PumpeDetailRepository")
 */
class PumpeTiltagDetail extends TiltagDetail {
  /**
   * @var string
   *
   * @ORM\Column(name="PumpeID", type="string", length=50)
   */
  protected $pumpeID;

  /**
   * @var string
   *
   * @ORM\Column(name="Forsyningsomraade", type="string", length=255)
   */
  protected $forsyningsomraade;

  /**
   * @var string
   *
   * @ORM\Column(name="Placering", type="string", length=255)
   */
  protected $placering;

  /**
   * @ManyToOne(targetEntity="PumpeTiltagDetailApplikation")
   * @JoinColumn(name="applikation_id", referencedColumnName="id")
   **/
  protected $applikation;

  /**
   * @var boolean
   *
   * @ORM\Column(name="Isoleringskappe", type="boolean")
   */
  protected $isoleringskappe = false;

  /**
   * @var float
   *
   * @deprecated
   *
   * @ORM\Column(name="bFaktor", type="decimal", scale=4)
   */
  protected $bFaktor;

  /**
   * @var NyttiggjortVarme
   *
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme", fetch="EAGER")
   * @ORM\JoinColumn(name="nyttiggjortvarme_id", referencedColumnName="id")
   */
  protected $nyttiggjortVarme;

  /**
   * @var string
   *
   * @ORM\Column(name="Noter", type="text", nullable=true)
   */
  protected $noter;

  /**
   * @var integer
   *
   * @ORM\Column(name="EksisterendeDrifttid", type="integer")
   */
  protected $eksisterendeDrifttid;

  /**
   * @var integer
   *
   * @ORM\Column(name="NyDrifttid", type="integer")
   */
  protected $nyDrifttid;

  /**
   * @var float
   *
   * @ORM\Column(name="Prisfaktor", type="decimal", scale=4)
   */
  protected $prisfaktor = 1;

  /**
   * @ManyToOne(targetEntity="Pumpe")
   * @JoinColumn(name="pumpe_id", referencedColumnName="id")
   **/
  protected $pumpe;

  /**
   * @var float
   *
   * @ORM\Column(name="overskrevetPris", type="decimal", scale=4)
   */
  protected $overskrevetPris;

  /**
   * @var string
   *
   * @ORM\Column(name="varmetabIftAekvivalentRoerstoerrelse", type="string", length=10)
   */
  protected $varmetabIftAekvivalentRoerstoerrelse;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="pristillaeg", type="float")
   */
  protected $pristillaeg;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="samletInvesteringInklPristillaeg", type="float")
   */
  protected $samletInvesteringInklPristillaeg;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="elforbrugVedNyeDriftstidKWhAar", type="float")
   */
  protected $elforbrugVedNyeDriftstidKWhAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="elbespKWhAar", type="float")
   */
  protected $elbespKWhAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmebespIsokappeKWh", type="float")
   */
  protected $varmebespIsokappeKWh;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="simpelTilbagebetalingstidAar", type="float")
   */
  protected $simpelTilbagebetalingstidAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="nutidsvaerdiSetOver15AarKr", type="float")
   */
  protected $nutidsvaerdiSetOver15AarKr;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="kwhBesparelseElFraVaerket", type="float")
   */
  protected $kwhBesparelseElFraVaerket;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="kwhBesparelseVarmeFraVaerket", type="float")
   */
  protected $kwhBesparelseVarmeFraVaerket;

  /**
   * Set pumpeID
   *
   * @param string $pumpeID
   * @return PumpeDetail
   */
  public function setPumpeID($pumpeID) {
    $this->pumpeID = $pumpeID;

    return $this;
  }

  /**
   * Get pumpeID
   *
   * @return string
   */
  public function getPumpeID() {
    return $this->pumpeID;
  }

  /**
   * Set forsyningsomraade
   *
   * @param string $forsyningsomraade
   * @return PumpeDetail
   */
  public function setForsyningsomraade($forsyningsomraade) {
    $this->forsyningsomraade = $forsyningsomraade;

    return $this;
  }

  /**
   * Get forsyningsomraade
   *
   * @return string
   */
  public function getForsyningsomraade() {
    return $this->forsyningsomraade;
  }

  /**
   * Set placering
   *
   * @param string $placering
   * @return PumpeDetail
   */
  public function setPlacering($placering) {
    $this->placering = $placering;

    return $this;
  }

  /**
   * Get placering
   *
   * @return string
   */
  public function getPlacering() {
    return $this->placering;
  }

  /**
   * Set applikation
   *
   * @param string $applikation
   * @return PumpeDetail
   */
  public function setApplikation($applikation) {
    $this->applikation = $applikation;

    return $this;
  }

  /**
   * Get applikation
   *
   * @return string
   */
  public function getApplikation() {
    return $this->applikation;
  }

  /**
   * Set isoleringskappe
   *
   * @param boolean $isoleringskappe
   * @return PumpeDetail
   */
  public function setIsoleringskappe($isoleringskappe) {
    $this->isoleringskappe = $isoleringskappe;

    return $this;
  }

  /**
   * Get isoleringskappe
   *
   * @return boolean
   */
  public function getIsoleringskappe() {
    return $this->isoleringskappe;
  }

  /**
   * Get bFaktor
   *
   * @deprecated
   *
   * @return string
   */
  public function getBFaktor() {
    return $this->bFaktor;
  }

  /**
   * Set nyttiggjortVarme
   *
   * @param \AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme $nyttiggjortVarme
    *
   * @return TekniskIsoleringTiltagDetail
    */
  public function setNyttiggjortVarme(\AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme $nyttiggjortVarme = null) {
    $this->nyttiggjortVarme = $nyttiggjortVarme;

    return $this;
  }

  /**
   * Get nyttiggjortVarme
   *
   * @return \AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme
   */
  public function getNyttiggjortVarme() {
    return $this->nyttiggjortVarme;
  }

  /**
   * Set noter
   *
   * @param string $noter
   * @return PumpeDetail
   */
  public function setNoter($noter) {
    $this->noter = $noter;

    return $this;
  }

  /**
   * Get noter
   *
   * @return string
   */
  public function getNoter() {
    return $this->noter;
  }

  /**
   * Set eksisterendeDrifttid
   *
   * @param integer $eksisterendeDrifttid
   * @return PumpeDetail
   */
  public function setEksisterendeDrifttid($eksisterendeDrifttid) {
    $this->eksisterendeDrifttid = $eksisterendeDrifttid;

    return $this;
  }

  /**
   * Get eksisterendeDrifttid
   *
   * @return integer
   */
  public function getEksisterendeDrifttid() {
    return $this->eksisterendeDrifttid;
  }

  /**
   * Set nyDrifttid
   *
   * @param integer $nyDrifttid
   * @return PumpeDetail
   */
  public function setNyDrifttid($nyDrifttid) {
    $this->nyDrifttid = $nyDrifttid;

    return $this;
  }

  /**
   * Get nyDrifttid
   *
   * @return integer
   */
  public function getNyDrifttid() {
    return $this->nyDrifttid;
  }

  /**
   * Set prisfaktor
   *
   * @param string $prisfaktor
   * @return PumpeDetail
   */
  public function setPrisfaktor($prisfaktor) {
    $this->prisfaktor = $prisfaktor;

    return $this;
  }

  /**
   * Get prisfaktor
   *
   * @return string
   */
  public function getPrisfaktor() {
    return empty($this->prisfaktor) ? 1 : $this->prisfaktor;
  }

  /**
   * Set pumpe
   *
   * @param \AppBundle\Entity\Pumpe $pumpe
   * @return PumpeDetail
   */
  public function setPumpe(Pumpe $pumpe = NULL) {
    $this->pumpe = $pumpe;

    return $this;
  }

  /**
   * Get pumpe
   *
   * @return \AppBundle\Entity\Pumpe
   */
  public function getPumpe() {
    return $this->pumpe;
  }

  /**
   * Set overskrevetPris
   *
   * @param float $overskrevetPris
   * @return PumpeDetail
   */
  public function setOverskrevetPris($overskrevetPris) {
    $this->overskrevetPris = $overskrevetPris;

    return $this;
  }

  /**
   * Get overskrevetPris
   *
   * @return float
   */
  public function getOverskrevetPris() {
    return $this->overskrevetPris;
  }

  public function setVarmetabIftAekvivalentRoerstoerrelse($varmetabIftAekvivalentRoerstoerrelse) {
    $this->varmetabIftAekvivalentRoerstoerrelse = $varmetabIftAekvivalentRoerstoerrelse;

    return $this;
  }

  public function getVarmetabIftAekvivalentRoerstoerrelse() {
    return $this->varmetabIftAekvivalentRoerstoerrelse;
  }

  public function getPristillaeg() {
    return $this->pristillaeg;
  }

  public function getSamletInvesteringInklPristillaeg() {
    return $this->samletInvesteringInklPristillaeg;
  }

  public function getElforbrugVedNyeDriftstidKWhAar() {
    return $this->elforbrugVedNyeDriftstidKWhAar;
  }

  public function getElbespKWhAar() {
    return $this->elbespKWhAar;
  }

  public function getVarmebespIsokappeKWh() {
    return $this->varmebespIsokappeKWh;
  }

  public function getSimpelTilbagebetalingstidAar() {
    return $this->simpelTilbagebetalingstidAar;
  }

  public function getNutidsvaerdiSetOver15AarKr() {
    return $this->nutidsvaerdiSetOver15AarKr;
  }

  public function getKwhBesparelseElFraVaerket() {
    return $this->kwhBesparelseElFraVaerket;
  }

  public function getKwhBesparelseVarmeFraVaerket() {
    return $this->kwhBesparelseVarmeFraVaerket;
  }

  protected $propertiesRequiredForCalculation = [
    'applikation',
    'eksisterendeDrifttid',
    'forsyningsomraade',
    'nyDrifttid',
    'nyttiggjortVarme',
    'placering',
    'prisfaktor',
    'pumpe',
    'pumpeID',
  ];

  public function calculate() {
    if (empty($this->getPumpe())) {
      return;
    }

    $this->pristillaeg = $this->calculatePristillaeg();
    $this->samletInvesteringInklPristillaeg = $this->calculateSamletInvesteringInklPristillaeg();
    $this->elforbrugVedNyeDriftstidKWhAar = $this->calculateElforbrugVedNyeDriftstidKWhAar();
    $this->elbespKWhAar = $this->calculateElbespKWhAar();
    $this->varmebespIsokappeKWh = $this->calculateVarmebespIsokappeKWh();
    $this->kwhBesparelseElFraVaerket = $this->calculateKwhBesparelseElFraVaerket();
    $this->kwhBesparelseVarmeFraVaerket = $this->calculateKwhBesparelseVarmeFraVaerket();
    $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
    $this->nutidsvaerdiSetOver15AarKr = $this->calculateNutidsvaerdiSetOver15AarKr();
    parent::calculate();
  }

  private function getPris() {
    if ($this->overskrevetPris !== null) {
      return $this->overskrevetPris;
    } else if ($this->pumpe !== null) {
      return $this->pumpe->getStandInvestering();
    }

    return 0;
  }

  public function calculatePristillaeg() {
    // 'AN'
    if ($this->prisfaktor == 0) {
      return 0;
    }
    else {
      return ($this->prisfaktor - 1) * $this->getPris();
    }
  }

  public function calculateSamletInvesteringInklPristillaeg() {
    // 'AO'
    return $this->pristillaeg + $this->getPris();
  }

  public function calculateElforbrugVedNyeDriftstidKWhAar() {
    // 'AP'
    return ($this->nyDrifttid * $this->pumpe->getNytAarsforbrug()) / $this->eksisterendeDrifttid;
  }

  public function calculateElbespKWhAar() {
    // 'AQ'
    return ($this->pumpe->getAarsforbrug() * $this->eksisterendeDrifttid - $this->pumpe->getNytAarsforbrug() * $this->nyDrifttid) / 8760;
  }

  private function getBesparelseVedIsoleringskappe() {
    return $this->pumpe->getBesparelseVedIsoleringskappe($this->varmetabIftAekvivalentRoerstoerrelse);
  }

  public function calculateVarmebespIsokappeKWh() {
    // 'AR'
    if ($this->isoleringskappe) {
      return 0;
    }
    else {
      if (!$this->nyttiggjortVarme) {
        return $this->bFaktor * $this->getBesparelseVedIsoleringskappe();
      }
      return $this->nyttiggjortVarme->getFaktor() * $this->getBesparelseVedIsoleringskappe();
    }
  }

  public function calculateSimpelTilbagebetalingstidAar() {
    // 'AS'
    if ($this->kwhBesparelseElFraVaerket == 0 && $this->kwhBesparelseVarmeFraVaerket == 0) {
      return 0;
    }
    else {
      return $this->divide($this->samletInvesteringInklPristillaeg,
                           $this->kwhBesparelseElFraVaerket * $this->getRapport()->getElKrKWh() + $this->kwhBesparelseVarmeFraVaerket * $this->getRapport()->getVarmeKrKWh());
    }
  }

  public function calculateNutidsvaerdiSetOver15AarKr() {
    // 'AT'
    if ($this->kwhBesparelseElFraVaerket == 0 && $this->kwhBesparelseVarmeFraVaerket == 0) {
      return 0;
    }
    else {
      return $this->nvPTO2($this->samletInvesteringInklPristillaeg, $this->kwhBesparelseVarmeFraVaerket, $this->kwhBesparelseElFraVaerket, 0, 0, 0, $this->tiltag->getLevetid(), 1, 0);
    }
  }

  public function calculateKwhBesparelseElFraVaerket() {
    // 'AU'
    if ($this->elbespKWhAar == 0 && $this->varmebespIsokappeKWh == 0) {
      return 0;
    }
    else {
      if ($this->getRapport()->getStandardforsyning()) {
        return $this->elbespKWhAar;
      }
      else {
        return $this->fordelbesparelse($this->varmebespIsokappeKWh, $this->tiltag->getForsyningVarme(), 'EL') + $this->elbespKWhAar;
      }
    }
  }

  public function calculateKwhBesparelseVarmeFraVaerket() {
    // 'AV'
    if ($this->varmebespIsokappeKWh == 0) {
      return 0;
    }
    else {
      if ($this->getRapport()->getStandardforsyning()) {
        return $this->varmebespIsokappeKWh;
      }
      else {
        return $this->fordelbesparelse($this->varmebespIsokappeKWh, $this->tiltag->getForsyningVarme(), 'VARME');
      }
    }
  }

}
