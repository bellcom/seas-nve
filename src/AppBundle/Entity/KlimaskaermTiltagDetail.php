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
   * @var integer
   *
   * @ORM\Column(name="tiltagsnr", type="integer")
   */
  private $tiltagsnr;

  /**
   * @var integer
   *
   * @ORM\Column(name="tiltagsnrDelpriser", type="integer")
   */
  private $tiltagsnrDelpriser;

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
   * @var float
   */
  private $samletBesparelseKWhAarInklDelbesparelser;

  /**
   * @var float
   */
  private $priskategori;

  /**
   * @var float
   */
  private $delprisKrM2;

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
  private $tilSortering;

  /**
   * @var float
   */
  private $tilSummeringAfDelpriser;

  /**
   * @var float
   */
  private $vaegtetGnm;

  /**
   * @var float
   */
  private $vaegtetLevetidForTiltagetAfrundet;

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

  /**
   * @var float
   */
  private $tilvalgteDeltiltag;

  /**
   * Set tiltagsnr
   *
   * @param integer $tiltagsnr
   * @return KlimaskaermTiltagDetail
   */
  public function setTiltagsnr($tiltagsnr) {
    $this->tiltagsnr = $tiltagsnr;

    return $this;
  }

  /**
   * Get tiltagsnr
   *
   * @return integer
   */
  public function getTiltagsnr() {
    return $this->tiltagsnr;
  }

  /**
   * Set tiltagsnrDelpriser
   *
   * @param integer $tiltagsnrDelpriser
   * @return KlimaskaermTiltagDetail
   */
  public function setTiltagsnrDelpriser($tiltagsnrDelpriser) {
    $this->tiltagsnrDelpriser = $tiltagsnrDelpriser;

    return $this;
  }

  /**
   * Get tiltagsnrDelpriser
   *
   * @return integer
   */
  public function getTiltagsnrDelpriser() {
    return $this->tiltagsnrDelpriser;
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
   * Get samletBesparelseKWhAarInklDelbesparelser
   *
   * @return float
   */
  public function getSamletBesparelseKWhAarInklDelbesparelser() {
    return $this->samletBesparelseKWhAarInklDelbesparelser;
  }

  /**
   * Get priskategori
   *
   * @return float
   */
  public function getPriskategori() {
    return $this->priskategori;
  }

  /**
   * Get delprisKrM2
   *
   * @return float
   */
  public function getDelprisKrM2() {
    return $this->delprisKrM2;
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
   * Get tilSortering
   *
   * @return float
   */
  public function getTilSortering() {
    return $this->tilSortering;
  }

  /**
   * Get tilSummeringAfDelpriser
   *
   * @return float
   */
  public function getTilSummeringAfDelpriser() {
    return $this->tilSummeringAfDelpriser;
  }

  /**
   * Get vaegtetGnm
   *
   * @return float
   */
  public function getVaegtetGnm() {
    return $this->vaegtetGnm;
  }

  /**
   * Get vaegtetLevetidForTiltagetAfrundet
   *
   * @return float
   */
  public function getVaegtetLevetidForTiltagetAfrundet() {
    return $this->vaegtetLevetidForTiltagetAfrundet;
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

  /**
   * Get tilvalgteDeltiltag
   *
   * @return float
   */
  public function getTilvalgteDeltiltag() {
    return $this->tilvalgteDeltiltag;
  }

  protected function compute() {
    $this->arealM2 = $this->__get('Q');
    $this->besparelseKWhAar = $this->__get('Y');
    $this->samletBesparelseKWhAarInklDelbesparelser = $this->__get('Z');
    $this->priskategori = $this->__get('AB');
    $this->delprisKrM2 = $this->__get('AD');
    $this->samletInvesteringKr = $this->__get('AE');
    // @FIXME (Division by zero)
    // $this->simpelTilbagebetalingstidAar = $this->__get('AF');
    $this->tilSortering = $this->__get('AH');
    $this->tilSummeringAfDelpriser = $this->__get('AI');
    $this->vaegtetGnm = $this->__get('AK');
    $this->vaegtetLevetidForTiltagetAfrundet = $this->__get('AL');
    $this->faktorForReinvestering = $this->__get('AM');
    $this->nutidsvaerdiSetOver15AarKr = $this->__get('AN');
    $this->kWhBesparElvaerkEksternEnergikilde = $this->__get('AO');
    $this->kWhBesparVarmevaerkEksternEnergikilde = $this->__get('AP');
    $this->tilvalgteDeltiltag = $this->__get('AQ');
  }

  public function __get($key) {
    switch ($key) {
      case '$C$13':
        return $this->getTiltag()->getForsyningVarme();

      case 'INDIRECT("\'1.TiltagslisteRådgiver\'!AI7")':
        return 1.609478;

      case 'INDIRECT("\'1.TiltagslisteRådgiver\'!AI6")':
        return 0.491;

      case 'INDIRECT("\'2.Forsyning\'!$H$3")':
        return null;

      case 'Q':
        // "Q": "Areal\n(m²)"
        return ($this->hoejdeElLaengdeM === null || $this->breddeM === null || $this->antalStk === null)
                                        ? 0
                                        : $this->breddeM*$this->hoejdeElLaengdeM*$this->antalStk;

      case 'Y':
        // "Y": "Besparelse\n(kWh/år)"
        return $this->arealM2 === 0
                              ? 0
                              : (($this->uEksWM2K-$this->uNyWM2K)*$this->arealM2*($this->tIndeC-$this->tUdeC)*$this->tOpvarmningTimerAar/1000*$this->andelAfArealDerEfterisoleres)*(1+$this->yderligereBesparelserPct);

      case 'Z':
        // "Z": "Samlet Besparelse (kWh/år) \ninkl. delbesparelser"
        // @FIXME
        // return IFERROR(IF($this->tiltagsnrDelpriser === null,$this->besparelseKWhAar+SUMIFS([Besparelse\n(kWh/år)],[Tiltagsnr. Delpriser],$this->tiltagsnr), null), null);
        return 0;

      case 'AB':
        // "AB": "Priskategori"
        // @FIXME
        // return IF($this->priskategori === null,\"Neutral pris\",\nINDEX(INDIRECT(\"Table21\"),MATCH($this->priskategori,INDIRECT(\"Table21[[Post]]\"),0),3));
        return 0;

      case 'AD':
        // "AD": "Delpris (kr/m2)"
        // return \nIF($this->prisfaktor === null, null,\nIFERROR(IF($this->priskategori === null,$this->prisfaktor,\nINDEX(INDIRECT(\"Table21\"),MATCH($this->priskategori,INDIRECT(\"Table21[[Post]]\"),0),4)*$this->prisfaktor), null));
        return 0;

      case 'AE':
        // "AE": "Samlet investering (kr)"
        // @FIXME
        // return IFERROR(IF($this->tiltagsnrDelpriser === null,$this->delprisKrM2*$this->arealM2+SUMIFS([Til summering af delpriser],[Tiltagsnr. Delpriser],$this->tiltagsnr), null), null);
        return 0;

      case 'AF':
        // "AF": "Simpel tilbagebetalingstid (år)"
        return $this->tiltagsnr === null
                                ? null
                                : $this->samletInvesteringKr/($this->kWhBesparElvaerkEksternEnergikilde*$this->{'INDIRECT("\'1.TiltagslisteRådgiver\'!AI7")'}+$this->kWhBesparVarmevaerkEksternEnergikilde*$this->{'INDIRECT("\'1.TiltagslisteRådgiver\'!AI6")'});
        return 0;

      case 'AH':
        // "AH": "Til sortering"
        return $this->tiltagsnr > 0
          ? $this->tiltagsnr
          : ($this->tiltagsnrDelpriser > 0
             ? $this->tiltagsnrDelpriser+0.1
             : 'z');
        return 0;

      case 'AI':
        // "AI": "Til summering af delpriser"
        return $this->arealM2 * $this->delprisKrM2;

      case 'AK':
        // "AK": "VaegtetGnm"
        return $this->levetidAar > 0
          ? $this->levetidAar*$this->tilSummeringAfDelpriser
          : 0;

      case 'AL':
        // "AL": "Vægtet levetid for tiltaget (afrundet)"
        // @FIXME
        // return IF($this->tiltagsnr>0,(SUMIFS([VaegtetGnm],[Tiltagsnr. Delpriser],$this->tiltagsnr)+$this->vaegtetGnm)/$this->samletInvesteringKr, null);
        return 0;

      case 'AM':
        // "AM": "Faktor for reinvestering"
        return 1;

      case 'AN':
        // "AN": "Nutidsværdi set over 15 år (kr)"
        return $this->tiltagsnr === null
                                ? null
                                : (($this->kWhBesparElvaerkEksternEnergikilde === 0 && $this->kWhBesparVarmevaerkEksternEnergikilde === 0)
                                   ? 0
                                   : $this->nvPTO2($this->samletInvesteringKr, $this->kWhBesparVarmevaerkEksternEnergikilde, $this->kWhBesparElvaerkEksternEnergikilde, 0, 0, 0, $this->vaegtetLevetidForTiltagetAfrundet, $this->faktorForReinvestering, 0)
                                );

      case 'AO':
        // "AO": "kWh-bespar. Elværk (Ekstern energikilde)"
        return ($this->besparelseKWhAar === 0 && $this->samletBesparelseKWhAarInklDelbesparelser === null)
                                        ? 0
                                        : ($this->besparelseKWhAar > 0
                                           ? ($this->{'INDIRECT("\'2.Forsyning\'!$H$3")'} == 1
                                              ? 0
                                              : $this->fordelbesparelse($this->besparelseKWhAar, $this->{'$C$13'}, 'EL'))
                                           : ($this->samletBesparelseKWhAarInklDelbesparelser > 0
                                              ? ($this->{'INDIRECT("\'2.Forsyning\'!$H$3")'} == 1
                                                 ? 0
                                                 : $this->fordelbesparelse($this->samletBesparelseKWhAarInklDelbesparelser, $this->{'$C$13'}, 'EL'))
                                              : 0)
                                        );

      case 'AP':
        // "AP": "kWh-bespar. Varmeværk (ekstern energikilde)"
        return ($this->besparelseKWhAar === 0 ||$this->samletBesparelseKWhAarInklDelbesparelser === null)
                                        ? 0
                                        : ($this->besparelseKWhAar > 0
                                           ? ($this->{'INDIRECT("\'2.Forsyning\'!$H$3")'} == 1
                                              ? $this->samletBesparelseKWhAarInklDelbesparelser
                                              : $this->fordelbesparelse($this->samletBesparelseKWhAarInklDelbesparelser,$this->{'$C$13'}, 'VARME'))
                                           : 0);

      case 'AQ':
        // "AQ": "Tilvalgte (deltiltag)"
        // return IF($this->tilvalgt="x","x",\nIF($this->tiltagsnrDelpriser<>"",INDEX(Table821[[Tilvalgt]:[Tiltagsnr.]],MATCH($this->tiltagsnrDelpriser,[Tiltagsnr.],0),1),0));
        return 0;

    }

    throw new \Exception('Invalid key: '.$key);
  }

}
