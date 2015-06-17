<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
   * @ORM\Column(name="type", type="string")
   */
  private $type; // "klimaskaerm" / "vindue"

  /**
   * @var string
   *
   * @ORM\Column(name="vindue_orientering", type="string", nullable=true)
   */
  private $vindue_orientering; // "nord", "syd", "øst", "vest"

  /**
   * @var Klimaskaerm
   *
   * @ORM\ManyToOne(targetEntity="Klimaskaerm")
   * @ORM\JoinColumn(name="klimaskaerm_id", referencedColumnName="id")
   **/
  private $klimaskaerm;

  /**
   * @var string
   *
   * @ORM\Column(name="typePlaceringJfPlantegning", type="string")
   */
  private $typePlaceringJfPlantegning;

  /**
   * @var float
   *
   * @ORM\Column(name="hoejdeElLaengdeM", type="float")
   */
  private $hoejdeElLaengdeM;

  /**
   * @var float
   *
   * @ORM\Column(name="breddeM", type="float")
   */
  private $breddeM;

  /**
   * @var string
   *
   * @ORM\Column(name="antalStk", type="string")
   */
  private $antalStk;

  /**
   * @var float
   *
   * @ORM\Column(name="andelAfArealDerEfterisoleres", type="float")
   */
  private $andelAfArealDerEfterisoleres;

  /**
   * @var float
   *
   * @ORM\Column(name="uEksWM2K", type="float")
   */
  private $uEksWM2K;

  /**
   * @var float
   *
   * @ORM\Column(name="uNyWM2K", type="float")
   */
  private $uNyWM2K;

  /**
   * @var float
   *
   * @ORM\Column(name="tIndeC", type="float")
   */
  private $tIndeC;

  /**
   * @var float
   *
   * @ORM\Column(name="tUdeC", type="float")
   */
  private $tUdeC;

  /**
   * @var float
   *
   * @ORM\Column(name="tOpvarmningTimerAar", type="float")
   */
  private $tOpvarmningTimerAar;

  /**
   * @var float
   *
   * @ORM\Column(name="yderligereBesparelserPct", type="float")
   */
  private $yderligereBesparelserPct;

  /**
   * @var float
   *
   * @ORM\Column(name="prisfaktor", type="float")
   */
  private $prisfaktor;

  /**
   * @var string
   *
   * @ORM\Column(name="noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet", type="text")
   */
  private $noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet;

  /**
   * @var integer
   *
   * @ORM\Column(name="levetidAar", type="integer")
   */
  private $levetidAar;

  /**
   * @var float
   */
  private $arealM2;

  /**
   * @var float
   */
  private $besparelseKWhAar;

  /**
   * @var string
   * @ORM\Column(name="priskategori", type="string")
   */
  private $priskategori;

  /**
   * @var float
   */
  private $samletInvesteringKr;

  /**
   * @var float
   */
  private $simpelTilbagebetalingstidAar;

  /**
   * @var float
   */
  private $faktorForReinvestering;

  /**
   * @var float
   */
  private $nutidsvaerdiSetOver15AarKr;

  /**
   * @var float
   */
  private $kWhBesparElvaerkEksternEnergikilde;

  /**
   * @var float
   */
  private $kWhBesparVarmevaerkEksternEnergikilde;



    return $this;
  }

  }


    return $this;
  }

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
   * Set priskategori
   *
   * @return KlimaskaermTiltagDetail
   */
  public function setPriskategori($priskategori) {
    $this->priskategori = $priskategori;

    return $this;
  }

  /**
   * Get priskategori
   *
   * @return string
   */
  public function getPriskategori() {
    return $this->priskategori;
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

  public function compute() {
    $this->arealM2 = $this->computeArealM2();
    $this->besparelseKWhAar = $this->computeBesparelseKWhAar();
    $this->samletInvesteringKr = $this->computeSamletInvesteringKr();
    $this->faktorForReinvestering = $this->computeFaktorForReinvestering();
    $this->kWhBesparElvaerkEksternEnergikilde = $this->computeKWhBesparElvaerkEksternEnergikilde();
    $this->kWhBesparVarmevaerkEksternEnergikilde = $this->computeKWhBesparVarmevaerkEksternEnergikilde();
    $this->nutidsvaerdiSetOver15AarKr = $this->computeNutidsvaerdiSetOver15AarKr();
    $this->simpelTilbagebetalingstidAar = $this->computeSimpelTilbagebetalingstidAar();
    parent::compute();
  }

  private function computeArealM2() {
    // "Q": "Areal\n(m²)"
    if (!$this->hoejdeElLaengdeM || !$this->breddeM || !$this->antalStk) {
      return 0;
    }
    else {
      return $this->breddeM * $this->hoejdeElLaengdeM * $this->antalStk;
    }
  }

  private function computeBesparelseKWhAar() {
    // "Y": "Besparelse\n(kWh/år)"
    if ($this->arealM2 == 0) {
      return 0;
    }
    else {
      return (($this->uEksWM2K - $this->uNyWM2K) * $this->arealM2 * ($this->tIndeC - $this->tUdeC) * $this->tOpvarmningTimerAar / 1000 * $this->andelAfArealDerEfterisoleres) * (1 + $this->yderligereBesparelserPct);
    }
  }

  private function computeSamletInvesteringKr() {
    // "AE": "Samlet investering (kr)"
    return $this->klimaskaerm->getEnhedsprisExclMoms() * $this->arealM2;
  }

  private function computeSimpelTilbagebetalingstidAar() {
    // "AF": "Simpel tilbagebetalingstid (år)"
    $denominator = ($this->kWhBesparElvaerkEksternEnergikilde * $this->getRapport()->getElKrKWh() + $this->kWhBesparVarmevaerkEksternEnergikilde * $this->getRapport()->getVarmeKrKWh());
    return $denominator == 0 ? 0 : $this->samletInvesteringKr / $denominator;
  }

  private function computeFaktorForReinvestering() {
    // "AM": "Faktor for reinvestering"
    return 1;
  }

  private function computeNutidsvaerdiSetOver15AarKr() {
    // "AN": "Nutidsværdi set over 15 år (kr)"
    if ($this->kWhBesparElvaerkEksternEnergikilde == 0 && $this->kWhBesparVarmevaerkEksternEnergikilde == 0) {
      return 0;
    }
    else {
      return $this->nvPTO2($this->samletInvesteringKr, $this->kWhBesparVarmevaerkEksternEnergikilde, $this->kWhBesparElvaerkEksternEnergikilde, 0, 0, 0, $this->levetidAar, $this->faktorForReinvestering, 0);
    }
  }

  private function computeKWhBesparElvaerkEksternEnergikilde() {
    // "AO": "kWh-bespar. Elværk (Ekstern energikilde)"
    if ($this->besparelseKWhAar == 0) {
      return 0;
    }
    elseif ($this->besparelseKWhAar > 0) {
      if ($this->getRapport()->isStandardforsyning()) {
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

  private function computeKWhBesparVarmevaerkEksternEnergikilde() {
    // "AP": "kWh-bespar. Varmeværk (ekstern energikilde)"
    if ($this->besparelseKWhAar == 0) {
      return 0;
    }
    else {
      if ($this->besparelseKWhAar > 0) {
        if ($this->getRapport()->isStandardforsyning()) {
          return 0;
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
