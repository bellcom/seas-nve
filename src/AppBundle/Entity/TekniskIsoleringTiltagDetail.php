<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TekniskIsoleringTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TekniskIsoleringTiltagDetail extends TiltagDetail {
  /**
   * @var string
   *
   * @ORM\Column(name="beskrivelseType", type="text")
   */
  private $beskrivelseType;

  /**
   * @var string
   *
   * @ORM\Column(name="type", type="string", length=255)
   */
  private $type;

  /**
   * @var double
   *
   * @ORM\Column(name="driftstidTAar", type="float")
   */
  private $driftstidTAar;

  /**
   * @var double
   *
   * @ORM\Column(name="udvDiameterMm", type="float")
   */
  private $udvDiameterMm;

  /**
   * @var double
   *
   * @ORM\Column(name="eksistIsolMm", type="float")
   */
  private $eksistIsolMm;

  /**
   * @var double
   */
  private $roerstoerrelseMmAekvivalent;

  /**
   * @var double
   *
   * @ORM\Column(name="tankVolL", type="float")
   */
  private $tankVolL;

  /**
   * @var double
   *
   * @ORM\Column(name="tempOmgivelC", type="float")
   */
  private $tempOmgivelC;

  /**
   * @var double
   *
   * @ORM\Column(name="tempMedieC", type="float")
   */
  private $tempMedieC;

  /**
   * @var double
   *
   * @ORM\Column(name="roerlaengdeEllerHoejdeAfVvbM", type="float")
   */
  private $roerlaengdeEllerHoejdeAfVvbM;

  /**
   * @var double
   *
   * @ORM\Column(name="nyttiggjortVarme", type="float")
   */
  private $nyttiggjortVarme;

  /**
   * @var double
   *
   * @ORM\Column(name="nyIsolMm", type="float")
   */
  private $nyIsolMm;

  private $varmeledningsevnePaaEksistIsoleringWMK;

  private $varmeledningsevnePaaNyIsoleringWMK;

  private $arealAfBeholderM2;

  /**
   * @var double
   *
   * @ORM\Column(name="standardinvestKrM2EllerKrM", type="float")
   */
  private $standardinvestKrM2EllerKrM;

  /**
   * @var double
   *
   * @ORM\Column(name="prisfaktor", type="float")
   */
  private $prisfaktor;

  private $investeringKr;

  private $eksistVarmetabKwh;

  private $nytVarmetabKwh;

  private $varmebespKwhAar;

  private $simpelTilbagebetalingstidAar;

  private $nutidsvaerdiSetOver15AarKr;

  private $kwhBesparelseElFraVaerket;

  private $kwhBesparelseVarmeFraVaerket;

  public function setBeskrivelseType($beskrivelseType) {
    $this->beskrivelseType = $beskrivelseType;

    return $this;
  }

  public function getBeskrivelseType() {
    return $this->beskrivelseType;
  }

  public function setType($type) {
    $this->type = $type;

    return $this;
  }

  public function getType() {
    return $this->type;
  }

  public function setDriftstidTAar($driftstidTAar) {
    $this->driftstidTAar = $driftstidTAar;

    return $this;
  }

  public function getDriftstidTAar() {
    return $this->driftstidTAar;
  }

  public function setUdvDiameterMm($udvDiameterMm) {
    $this->udvDiameterMm = $udvDiameterMm;

    return $this;
  }

  public function getUdvDiameterMm() {
    return $this->udvDiameterMm;
  }

  public function setEksistIsolMm($eksistIsolMm) {
    $this->eksistIsolMm = $eksistIsolMm;

    return $this;
  }

  public function getEksistIsolMm() {
    return $this->eksistIsolMm;
  }

  public function getRoerstoerrelseMmAekvivalent() {
    return $this->roerstoerrelseMmAekvivalent;
  }

  public function setTankVolL($tankVolL) {
    $this->tankVolL = $tankVolL;

    return $this;
  }

  public function getTankVolL() {
    return $this->tankVolL;
  }

  public function setTempOmgivelC($tempOmgivelC) {
    $this->tempOmgivelC = $tempOmgivelC;

    return $this;
  }

  public function getTempOmgivelC() {
    return $this->tempOmgivelC;
  }

  public function setTempMedieC($tempMedieC) {
    $this->tempMedieC = $tempMedieC;

    return $this;
  }

  public function getTempMedieC() {
    return $this->tempMedieC;
  }

  public function setRoerlaengdeEllerHoejdeAfVvbM($roerlaengdeEllerHoejdeAfVvbM) {
    $this->roerlaengdeEllerHoejdeAfVvbM = $roerlaengdeEllerHoejdeAfVvbM;

    return $this;
  }

  public function getRoerlaengdeEllerHoejdeAfVvbM() {
    return $this->roerlaengdeEllerHoejdeAfVvbM;
  }

  public function setNyttiggjortVarme($nyttiggjortVarme) {
    $this->nyttiggjortVarme = $nyttiggjortVarme;

    return $this;
  }

  public function getNyttiggjortVarme() {
    return $this->nyttiggjortVarme;
  }

  public function setNyIsolMm($nyIsolMm) {
    $this->nyIsolMm = $nyIsolMm;

    return $this;
  }

  public function getNyisolMm() {
    return $this->nyIsolMm;
  }

  public function getVarmeledningsevnePaaEksistIsoleringWMK() {
    return $this->varmeledningsevnePaaEksistIsoleringWMK;
  }

  public function getVarmeledningsevnePaaNyIsoleringWMK() {
    return $this->varmeledningsevnePaaNyIsoleringWMK;
  }

  public function getArealAfBeholderM2() {
    return $this->arealAfBeholderM2;
  }

  public function setStandardinvestKrM2EllerKrM($standardinvestKrM2EllerKrM) {
    $this->standardinvestKrM2EllerKrM = $standardinvestKrM2EllerKrM;

    return $this;
  }

  public function getStandardinvestKrM2EllerKrM() {
    return $this->standardinvestKrM2EllerKrM;
  }

  public function setPrisfaktor($prisfaktor) {
    $this->prisfaktor = $prisfaktor;

    return $this;
  }

  public function getPrisfaktor() {
    return $this->prisfaktor;
  }

  public function getInvesteringKr() {
    return $this->investeringKr;
  }

  public function getEksistVarmetabKwh() {
    return $this->eksistVarmetabKwh;
  }

  public function getNytVarmetabKwh() {
    return $this->nytVarmetabKwh;
  }

  public function getVarmebespKwhAar() {
    return $this->varmebespKwhAar;
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

  public function compute() {
    $this->roerstoerrelseMmAekvivalent = $this->computeRoerstoerrelseMmAekvivalent();
    $this->varmeledningsevnePaaEksistIsoleringWMK = $this->computeVarmeledningsevnePaaEksistIsoleringWMK();
    $this->varmeledningsevnePaaNyIsoleringWMK = $this->computeVarmeledningsevnePaaNyIsoleringWMK();
    $this->arealAfBeholderM2 = $this->computeArealAfBeholderM2();
    $this->investeringKr = $this->computeInvesteringKr();
    $this->eksistVarmetabKwh = $this->computeEksistVarmetabKwh();
    $this->nytVarmetabKwh = $this->computeNytVarmetabKwh();
    $this->varmebespKwhAar = $this->computeVarmebespKwhAar();
    $this->kwhBesparelseElFraVaerket = $this->computeKwhBesparelseElFraVaerket();
    $this->kwhBesparelseVarmeFraVaerket = $this->computeKwhBesparelseVarmeFraVaerket();

    // Must come after both kwhBesparelseElFraVaerket and kwhBesparelseVarmeFraVaerket
    $this->simpelTilbagebetalingstidAar = $this->computeSimpelTilbagebetalingstidAar();
    $this->nutidsvaerdiSetOver15AarKr = $this->computeNutidsvaerdiSetOver15AarKr();
    parent::compute();
  }

  private function computeRoerstoerrelseMmAekvivalent() {
    // 'P'
    if ($this->tankVolL == 0) {
      return $this->udvDiameterMm;
    } else {
      return sqrt(($this->tankVolL / 1000) / ($this->roerlaengdeEllerHoejdeAfVvbM * M_PI)) * 1000;
    }
  }

  private function computeVarmeledningsevnePaaEksistIsoleringWMK() {
    // 'W', '$N$38'
    // @FIXME: Where should we get/store this value?
    return 0.05;
  }

  private function computeVarmeledningsevnePaaNyIsoleringWMK() {
    // 'X', '$N$39'
    // @FIXME: Where should we get/store this value?
    return 0.044;
  }

  private function computeArealAfBeholderM2() {
    // 'Y'
    if ($this->tankVolL == 0) {
      return 0;
    } else {
      return sqrt(($this->tankVolL / 1000) / (M_PI * $this->roerlaengdeEllerHoejdeAfVvbM))
        * (1 + $this->roerlaengdeEllerHoejdeAfVvbM * 2 * M_PI);
    }
  }

  private function computeInvesteringKr() {
    // 'AB'
    if ($this->tankVolL == 0) {
      return $this->standardinvestKrM2EllerKrM * $this->prisfaktor * $this->roerlaengdeEllerHoejdeAfVvbM;
    } else {
      return $this->standardinvestKrM2EllerKrM * $this->prisfaktor * $this->arealAfBeholderM2;
    }
  }

  private function computeEksistVarmetabKwh() {
    // 'AC'
    if (strcasecmp($this->type, 'rør') == 0) {
     return $this->computeEksisterendeUVaerdi()*$this->roerlaengdeEllerHoejdeAfVvbM*(abs($this->tempMedieC-$this->tempOmgivelC))*$this->driftstidTAar/1000*$this->nyttiggjortVarme;
    } else if (strcasecmp($this->type, 'beholder') == 0) {
      return ($this->roerstoerrelseMmAekvivalent/1000*PI()*$this->roerlaengdeEllerHoejdeAfVvbM+($this->roerstoerrelseMmAekvivalent/1000)^2*PI())*abs($this->tempMedieC-$this->tempOmgivelC)*$this->computeEksisterendeUVaerdi()*$this->driftstidTAar/1000;
    } else {
      return 0;
    }
  }

  private function computeNytVarmetabKwh() {
    // 'AD'
    if (strcasecmp($this->type, 'rør') == 0) {
      return $this->computeUkorrigeret()*$this->roerlaengdeEllerHoejdeAfVvbM*(abs($this->tempMedieC-$this->tempOmgivelC))*$this->driftstidTAar/1000*$this->nyttiggjortVarme;
    } else if (strcasecmp($this->type, 'beholder') == 0) {
      return ($this->roerstoerrelseMmAekvivalent/1000*PI()*$this->roerlaengdeEllerHoejdeAfVvbM+($this->roerstoerrelseMmAekvivalent/1000)^2*PI())*abs($this->tempMedieC-$this->tempOmgivelC)*$this->computeUkorrigeret()*$this->driftstidTAar/1000;
    } else {
      return 0;
    }
  }

  private function computeVarmebespKwhAar() {
    // 'AE'
    try {
      return $this->eksistVarmetabKwh - $this->nytVarmetabKwh;
    } catch (\Exception $ex) {
      return 0;
    }
  }

  private function computeKwhBesparelseElFraVaerket() {
    // 'AH'
    if ($this->varmebespKwhAar == 0) {
      return 0;
    } else if ($this->getRapport()->isStandardforsyning()) {
      return 0;
    } else {
      return $this->fordelbesparelse($this->varmebespKwhAar, $this->tiltag->getForsyningVarme(), 'EL');
    }
  }

  private function computeKwhBesparelseVarmeFraVaerket() {
    // 'AI'
    if ($this->varmebespKwhAar == 0) {
      return 0;
    } else if ($this->getRapport()->isStandardforsyning()) {
      return $this->varmebespKwhAar;
    } else {
      return $this->fordelbesparelse($this->varmebespKwhAar, $this->tiltag->getForsyningVarme(), 'VARME');
    }
  }

  private function computeSimpelTilbagebetalingstidAar() {
    // 'AF'
    if ($this->standardinvestKrM2EllerKrM > 0) {
      return ($this->standardinvestKrM2EllerKrM * $this->roerlaengdeEllerHoejdeAfVvbM)
        / ($this->getRapport()->getElKrKWh() * $this->kwhBesparelseElFraVaerket + $this->getRapport()->getVarmeKrKWh() * $this->kwhBesparelseVarmeFraVaerket);
    } else {
      return 0;
    }
  }

  private function computeNutidsvaerdiSetOver15AarKr() {
    if ($this->varmebespKwhAar == 0) {
      return 0;
    } else {
      return $this->nvPTO2($this->investeringKr, $this->kwhBesparelseVarmeFraVaerket, $this->kwhBesparelseElFraVaerket, 0, 0, 0, $this->tiltag->getLevetid(), 1, 0);
    }
  }

  /*
"AJ": {
            "calculated": "=IF(OR(TekniskIsol20[[#This Row],[Driftstid (t/år)]]=\"\",TekniskIsol20[[#This Row],[Temp. omgivel. \n'[°C']]]=\"\",TekniskIsol20[[#This Row],[Temp. \nMedie \n'[°C']]]=\"\"),\"\",1*ABS(TekniskIsol20[[#This Row],[Temp. \nMedie \n'[°C']]]-TekniskIsol20[[#This Row],[Temp. omgivel. \n'[°C']]])*TekniskIsol20[[#This Row],[Driftstid (t/år)]]*3600)",
            "name": "Driftparameter  [°Cs/år]",
        },
  */

  /*
        "AK": {
            "calculated": "=IF(OR(TekniskIsol20[[#This Row],[Eksist. \nisol. \n'[mm']]]=\"\",TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]=0),\"\",\n2*((2*TekniskIsol20[[#This Row],[Eksist. \nisol. \n'[mm']]]/1000)+TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000)*TekniskIsol20[[#This Row],[Varmeledningsevne på eksist isolering '[W/m·K']]]*$AC$25*PI()/(((2*TekniskIsol20[[#This Row],[Eksist. \nisol. \n'[mm']]]/1000)+TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000)*LN(((2*TekniskIsol20[[#This Row],[Eksist. \nisol. \n'[mm']]]/1000)+TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000)/(TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000))*$AC$25+2*TekniskIsol20[[#This Row],[Varmeledningsevne på eksist isolering '[W/m·K']]]))",
            "name": "Eksisterende U-værdi "
        },
  */

  private function computeEksisterendeUVaerdi() {
    // 'AK'
    if ($this->eksistIsolMm === null || $this->roerstoerrelseMmAekvivalent == 0) {
      return 0;
    } else {
      return 2*((2*$this->eksistIsolMm/1000)+$this->roerstoerrelseMmAekvivalent/1000)*$this->varmeledningsevnePaaEksistIsoleringWMK*$this->getKonvektivVarmeovergangskoefficient()*PI()/(((2*$this->eksistIsolMm/1000)+$this->roerstoerrelseMmAekvivalent/1000)*log(((2*$this->eksistIsolMm/1000)+$this->roerstoerrelseMmAekvivalent/1000)/($this->roerstoerrelseMmAekvivalent/1000))*$this->getKonvektivVarmeovergangskoefficient()+2*$this->varmeledningsevnePaaEksistIsoleringWMK);
    }
  }

  /*
        "AL": {
            "calculated": "=IF(OR(TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]=\"\",TekniskIsol20[[#This Row],[Ny \nisol. \n'[mm']]]=\"\",TekniskIsol20[[#This Row],[Varmeledningsevne på ny isolering '[W/m·K']]]=\"\"),\"\",2*((2*TekniskIsol20[[#This Row],[Ny \nisol. \n'[mm']]]/1000)+TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000)*TekniskIsol20[[#This Row],[Varmeledningsevne på ny isolering '[W/m·K']]]*$AC$25*PI()/(((2*TekniskIsol20[[#This Row],[Ny \nisol. \n'[mm']]]/1000)+TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000)*LN(((2*TekniskIsol20[[#This Row],[Ny \nisol. \n'[mm']]]/1000)+TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000)/(TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000))*$AC$25+2*TekniskIsol20[[#This Row],[Varmeledningsevne på ny isolering '[W/m·K']]]))",
            "name": "Ukorrigeret "
  */
  private function computeUkorrigeret() {
    // 'AL'
    if ($this->roerstoerrelseMmAekvivalent == 0 || $this->nyIsolMm == 0 || $this->varmeledningsevnePaaNyIsoleringWMK == 0) {
      return 0;
    } else {
      return 2*((2*$this->nyIsolMm/1000)+$this->roerstoerrelseMmAekvivalent/1000)*$this->varmeledningsevnePaaNyIsoleringWMK*$this->getKonvektivVarmeovergangskoefficient()*PI()/(((2*$this->nyIsolMm/1000)+$this->roerstoerrelseMmAekvivalent/1000)*log(((2*$this->nyIsolMm/1000)+$this->roerstoerrelseMmAekvivalent/1000)/($this->roerstoerrelseMmAekvivalent/1000))*$this->getKonvektivVarmeovergangskoefficient()+2*$this->varmeledningsevnePaaNyIsoleringWMK);
    }
  }

  private function getKonvektivVarmeovergangskoefficient() {
    // '$AC$25':
    return 9;
  }

}
