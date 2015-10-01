<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotations\Calculated;

/**
 * KlimaskaermTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class KlimaskaermTiltagDetail extends TiltagDetail {
  /**
   * @var string
   *
   * @ORM\Column(name="orientering", type="string", nullable=true)
   */
  protected $orientering; // "north", "south", "east", "west"

  /**
   * @var Klimaskaerm
   *
   * @ORM\ManyToOne(targetEntity="Klimaskaerm")
   * @ORM\JoinColumn(name="klimaskaerm_id", referencedColumnName="id")
   **/
  protected $klimaskaerm;

  /**
   * @var string
   *
   * @ORM\Column(name="typePlaceringJfPlantegning", type="string")
   */
  protected $typePlaceringJfPlantegning;

  /**
   * @var float
   *
   * @ORM\Column(name="hoejdeElLaengdeM", type="decimal", scale=4)
   */
  protected $hoejdeElLaengdeM;

  /**
   * @var float
   *
   * @ORM\Column(name="breddeM", type="decimal", scale=4)
   */
  protected $breddeM;

  /**
   * @var string
   *
   * @ORM\Column(name="antalStk", type="string")
   */
  protected $antalStk;

  /**
   * @var float
   *
   * @ORM\Column(name="andelAfArealDerEfterisoleres", type="decimal", scale=4)
   */
  protected $andelAfArealDerEfterisoleres;

  /**
   * @var float
   *
   * @ORM\Column(name="uEksWM2K", type="decimal", scale=4)
   */
  protected $uEksWM2K;

  /**
   * @var float
   *
   * @ORM\Column(name="uNyWM2K", type="decimal", scale=4)
   */
  protected $uNyWM2K;

  /**
   * @var float
   *
   * @ORM\Column(name="tIndeC", type="decimal", scale=4)
   */
  protected $tIndeC;

  /**
   * @var float
   *
   * @ORM\Column(name="tUdeC", type="decimal", scale=4)
   */
  protected $tUdeC;

  /**
   * @var float
   *
   * @ORM\Column(name="tOpvarmningTimerAar", type="decimal", scale=4)
   */
  protected $tOpvarmningTimerAar;

  /**
   * @var float
   *
   * @ORM\Column(name="yderligereBesparelserPct", type="decimal", scale=4)
   */
  protected $yderligereBesparelserPct;

  /**
   * @var float
   *
   * @ORM\Column(name="prisfaktor", type="decimal", scale=4)
   */
  protected $prisfaktor;

  /**
   * @var string
   *
   * @ORM\Column(name="noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet", type="text", nullable=true)
   */
  protected $noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet;

  /**
   * @var integer
   *
   * @ORM\Column(name="levetidAar", type="integer")
   */
  protected $levetidAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="arealM2", type="float")
   */
  protected $arealM2;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="besparelseKWhAar", type="float")
   */
  protected $besparelseKWhAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="samletInvesteringKr", type="float")
   */
  protected $samletInvesteringKr;

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
   * @ORM\Column(name="faktorForReinvestering", type="float")
   */
  protected $faktorForReinvestering;

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
   * @ORM\Column(name="kWhBesparElvaerkEksternEnergikilde", type="float")
   */
  protected $kWhBesparElvaerkEksternEnergikilde;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="kWhBesparVarmevaerkEksternEnergikilde", type="float")
   */
  protected $kWhBesparVarmevaerkEksternEnergikilde;

  public function setKlimaskaerm($klimaskaerm) {
    $this->klimaskaerm = $klimaskaerm;

    return $this;
  }

  public function getKlimaskaerm() {
    return $this->klimaskaerm;
  }

  public function setOrientering($orientering) {
    $this->orientering = $orientering;

    return $this;
  }

  public function getOrientering() {
    return $this->orientering;
  }

  /**
   * Set typePlaceringJfPlantegning
   *
   * @param string $typePlaceringJfPlantegning
   * @return KlimaskaermTiltagDetail
   */
  public function setTypePlaceringJfPlantegning($typePlaceringJfPlantegning) {
    $this->typePlaceringJfPlantegning = $typePlaceringJfPlantegning;

    return $this;
  }

  /**
   * Get typePlaceringJfPlantegning
   *
   * @return string
   */
  public function getTypePlaceringJfPlantegning() {
    return $this->typePlaceringJfPlantegning;
  }

  /**
   * Set hoejdeElLaengdeM
   *
   * @param float $hoejdeElLaengdeM
   * @return KlimaskaermTiltagDetail
   */
  public function setHoejdeElLaengdeM($hoejdeElLaengdeM) {
    $this->hoejdeElLaengdeM = $hoejdeElLaengdeM;

    return $this;
  }

  /**
   * Get hoejdeElLaengdeM
   *
   * @return float
   */
  public function getHoejdeElLaengdeM() {
    return $this->hoejdeElLaengdeM;
  }

  /**
   * Set breddeM
   *
   * @param float $breddeM
   * @return KlimaskaermTiltagDetail
   */
  public function setBreddeM($breddeM) {
    $this->breddeM = $breddeM;

    return $this;
  }

  /**
   * Get breddeM
   *
   * @return float
   */
  public function getBreddeM() {
    return $this->breddeM;
  }

  /**
   * Set antalStk
   *
   * @param string $antalStk
   * @return KlimaskaermTiltagDetail
   */
  public function setAntalStk($antalStk) {
    $this->antalStk = $antalStk;

    return $this;
  }

  /**
   * Get antalStk
   *
   * @return string
   */
  public function getAntalStk() {
    return $this->antalStk;
  }

  /**
   * Set andelAfArealDerEfterisoleres
   *
   * @param float $andelAfArealDerEfterisoleres
   * @return KlimaskaermTiltagDetail
   */
  public function setAndelAfArealDerEfterisoleres($andelAfArealDerEfterisoleres) {
    $this->andelAfArealDerEfterisoleres = $andelAfArealDerEfterisoleres;

    return $this;
  }

  /**
   * Get andelAfArealDerEfterisoleres
   *
   * @return float
   */
  public function getAndelAfArealDerEfterisoleres() {
    return $this->andelAfArealDerEfterisoleres;
  }

  /**
   * Set uEksWM2K
   *
   * @param float $uEksWM2K
   * @return KlimaskaermTiltagDetail
   */
  public function setUEksWM2K($uEksWM2K) {
    $this->uEksWM2K = $uEksWM2K;

    return $this;
  }

  /**
   * Get uEksWM2K
   *
   * @return float
   */
  public function getUEksWM2K() {
    return $this->uEksWM2K;
  }

  /**
   * Set uNyWM2K
   *
   * @param float $uNyWM2K
   * @return KlimaskaermTiltagDetail
   */
  public function setUNyWM2K($uNyWM2K) {
    $this->uNyWM2K = $uNyWM2K;

    return $this;
  }

  /**
   * Get uNyWM2K
   *
   * @return float
   */
  public function getUNyWM2K() {
    return $this->uNyWM2K;
  }

  /**
   * Set tIndeC
   *
   * @param float $tIndeC
   * @return KlimaskaermTiltagDetail
   */
  public function setTIndeC($tIndeC) {
    $this->tIndeC = $tIndeC;

    return $this;
  }

  /**
   * Get tIndeC
   *
   * @return float
   */
  public function getTIndeC() {
    return $this->tIndeC;
  }

  /**
   * Set tUdeC
   *
   * @param float $tUdeC
   * @return KlimaskaermTiltagDetail
   */
  public function setTUdeC($tUdeC) {
    $this->tUdeC = $tUdeC;

    return $this;
  }

  /**
   * Get tUdeC
   *
   * @return float
   */
  public function getTUdeC() {
    return $this->tUdeC;
  }

  /**
   * Set tOpvarmningTimerAar
   *
   * @param float $tOpvarmningTimerAar
   * @return KlimaskaermTiltagDetail
   */
  public function setTOpvarmningTimerAar($tOpvarmningTimerAar) {
    $this->tOpvarmningTimerAar = $tOpvarmningTimerAar;

    return $this;
  }

  /**
   * Get tOpvarmningTimerAar
   *
   * @return float
   */
  public function getTOpvarmningTimerAar() {
    return $this->tOpvarmningTimerAar;
  }

  /**
   * Set yderligereBesparelserPct
   *
   * @param float $yderligereBesparelserPct
   * @return KlimaskaermTiltagDetail
   */
  public function setYderligereBesparelserPct($yderligereBesparelserPct) {
    $this->yderligereBesparelserPct = $yderligereBesparelserPct;

    return $this;
  }

  /**
   * Get yderligereBesparelserPct
   *
   * @return float
   */
  public function getYderligereBesparelserPct() {
    return $this->yderligereBesparelserPct;
  }

  /**
   * Set prisfaktor
   *
   * @param float $prisfaktor
   * @return KlimaskaermTiltagDetail
   */
  public function setPrisfaktor($prisfaktor) {
    $this->prisfaktor = $prisfaktor;

    return $this;
  }

  /**
   * Get prisfaktor
   *
   * @return float
   */
  public function getPrisfaktor() {
    return $this->prisfaktor;
  }

  /**
   * Set noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet
   *
   * @param string $noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet
   * @return KlimaskaermTiltagDetail
   */
  public function setNoterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet($noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet) {
    $this->noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet = $noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet;

    return $this;
  }

  /**
   * Get noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet
   *
   * @return string
   */
  public function getNoterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet() {
    return $this->noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet;
  }

  /**
   * Set levetidAar
   *
   * @param integer $levetidAar
   * @return KlimaskaermTiltagDetail
   */
  public function setLevetidAar($levetidAar) {
    $this->levetidAar = $levetidAar;

    return $this;
  }

  /**
   * Get levetidAar
   *
   * @return integer
   */
  public function getLevetidAar() {
    return $this->levetidAar;
  }

  /**
   * Get arealM2
   *
   * @return float
   */
  public function getArealM2() {
    return $this->arealM2;
  }

  /**
   * Get besparelseKWhAar
   *
   * @return float
   */
  public function getBesparelseKWhAar() {
    return $this->besparelseKWhAar;
  }

  /**
   * Get samletInvesteringKr
   *
   * @return float
   */
  public function getSamletInvesteringKr() {
    return $this->samletInvesteringKr;
  }

  /**
   * Get simpelTilbagebetalingstidAar
   *
   * @return float
   */
  public function getSimpelTilbagebetalingstidAar() {
    return $this->simpelTilbagebetalingstidAar;
  }

  /**
   * Get faktorForReinvestering
   *
   * @return float
   */
  public function getFaktorForReinvestering() {
    return $this->faktorForReinvestering;
  }

  /**
   * Get nutidsvaerdiSetOver15AarKr
   *
   * @return float
   */
  public function getNutidsvaerdiSetOver15AarKr() {
    return $this->nutidsvaerdiSetOver15AarKr;
  }

  /**
   * Get kWhBesparElvaerkEksternEnergikilde
   *
   * @return float
   */
  public function getKWhBesparElvaerkEksternEnergikilde() {
    return $this->kWhBesparElvaerkEksternEnergikilde;
  }

  /**
   * Get kWhBesparVarmevaerkEksternEnergikilde
   *
   * @return float
   */
  public function getKWhBesparVarmevaerkEksternEnergikilde() {
    return $this->kWhBesparVarmevaerkEksternEnergikilde;
  }

  public function calculate() {
    $this->arealM2 = $this->calculateArealM2();
    $this->besparelseKWhAar = $this->calculateBesparelseKWhAar();
    $this->samletInvesteringKr = $this->calculateSamletInvesteringKr();
    $this->faktorForReinvestering = $this->calculateFaktorForReinvestering();
    $this->kWhBesparElvaerkEksternEnergikilde = $this->calculateKWhBesparElvaerkEksternEnergikilde();
    $this->kWhBesparVarmevaerkEksternEnergikilde = $this->calculateKWhBesparVarmevaerkEksternEnergikilde();
    $this->nutidsvaerdiSetOver15AarKr = $this->calculateNutidsvaerdiSetOver15AarKr();
    $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
    parent::calculate();
  }

  protected function calculateArealM2() {
    // "Q": "Areal\n(m²)"
    if (!$this->hoejdeElLaengdeM || !$this->breddeM || !$this->antalStk) {
      return 0;
    }
    else {
      return $this->breddeM * $this->hoejdeElLaengdeM * $this->antalStk;
    }
  }

  protected function calculateBesparelseKWhAar() {
    // "Y": "Besparelse\n(kWh/år)"
    if ($this->arealM2 == 0) {
      return 0;
    }
    else {
      return (($this->uEksWM2K - $this->uNyWM2K) * $this->arealM2 * ($this->tIndeC - $this->tUdeC) * $this->tOpvarmningTimerAar / 1000 * $this->andelAfArealDerEfterisoleres) * (1 + $this->yderligereBesparelserPct);
    }
  }

  private function calculateSamletInvesteringKr() {
    // "AE": "Samlet investering (kr)"
    return $this->klimaskaerm->getEnhedsprisEksklMoms() * $this->prisfaktor * $this->arealM2;
  }

  private function calculateSimpelTilbagebetalingstidAar() {
    // "AF": "Simpel tilbagebetalingstid (år)"
    return $this->divide($this->samletInvesteringKr,
                         $this->kWhBesparElvaerkEksternEnergikilde * $this->getRapport()->getElKrKWh() + $this->kWhBesparVarmevaerkEksternEnergikilde * $this->getRapport()->getVarmeKrKWh());
  }

  private function calculateFaktorForReinvestering() {
    // "AM": "Faktor for reinvestering"
    return 1;
  }

  private function calculateNutidsvaerdiSetOver15AarKr() {
    // "AN": "Nutidsværdi set over 15 år (kr)"
    if ($this->kWhBesparElvaerkEksternEnergikilde == 0 && $this->kWhBesparVarmevaerkEksternEnergikilde == 0) {
      return 0;
    }
    else {
      return $this->nvPTO2($this->samletInvesteringKr, $this->kWhBesparVarmevaerkEksternEnergikilde, $this->kWhBesparElvaerkEksternEnergikilde, 0, 0, 0, $this->levetidAar, $this->faktorForReinvestering, 0);
    }
  }

  private function calculateKWhBesparElvaerkEksternEnergikilde() {
    // "AO": "kWh-bespar. Elværk (Ekstern energikilde)"
    if ($this->besparelseKWhAar == 0) {
      return 0;
    }
    elseif ($this->besparelseKWhAar > 0) {
      if ($this->getRapport()->getStandardforsyning()) {
        return 0;
      }
      else {
        return $this->fordelbesparelse($this->besparelseKWhAar, $this->tiltag->getForsyningVarme(), 'EL');
      }
    }
    else {
      return 0;
    }
  }

  private function calculateKWhBesparVarmevaerkEksternEnergikilde() {
    // "AP": "kWh-bespar. Varmeværk (ekstern energikilde)"
    if ($this->besparelseKWhAar == 0) {
      return 0;
    }
    else {
      if ($this->besparelseKWhAar > 0) {
        if ($this->getRapport()->getStandardforsyning()) {
          return $this->besparelseKWhAar;
        }
        else {
          return $this->fordelbesparelse($this->besparelseKWhAar, $this->tiltag->getForsyningVarme(), 'VARME');
        }
      }
      else {
        return 0;
      }
    }
  }

}
