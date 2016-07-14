<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotations\Calculated;
use AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme;

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
  protected $beskrivelseType;

  /**
   * @var string
   *
   * @ORM\Column(name="type", type="string", length=255)
   */
  protected $type;

  /**
   * @var float
   *
   * @ORM\Column(name="driftstidTAar", type="decimal", scale=4)
   */
  protected $driftstidTAar;

  /**
   * @var float
   *
   * @ORM\Column(name="udvDiameterMm", type="decimal", scale=4)
   */
  protected $udvDiameterMm;

  /**
   * @var float
   *
   * @ORM\Column(name="eksistIsolMm", type="decimal", scale=4)
   */
  protected $eksistIsolMm;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="roerstoerrelseMmAekvivalent", type="float")
   */
  protected $roerstoerrelseMmAekvivalent;

  /**
   * @var float
   *
   * @ORM\Column(name="tankVolL", type="decimal", scale=4, nullable=true)
   */
  protected $tankVolL;

  /**
   * @var float
   *
   * @ORM\Column(name="tempOmgivelC", type="decimal", scale=4)
   */
  protected $tempOmgivelC;

  /**
   * @var float
   *
   * @ORM\Column(name="tempMedieC", type="decimal", scale=4)
   */
  protected $tempMedieC;

  /**
   * @var float
   *
   * @ORM\Column(name="roerlaengdeEllerHoejdeAfVvbM", type="decimal", scale=4)
   */
  protected $roerlaengdeEllerHoejdeAfVvbM;

//  /**
//   * @var float
//   *
//   * @ORM\Column(name="nyttiggjortVarme", type="decimal", scale=4)
//   */
//  protected $nyttiggjortVarme;


  /**
   * @var NyttiggjortVarme
   *
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme", fetch="EAGER")
   * @ORM\JoinColumn(name="nyttiggjortvarme_id", referencedColumnName="id")
   */
  protected $nyttiggjortVarme;

  /**
   * @var float
   *
   * @ORM\Column(name="nyIsolMm", type="decimal", scale=4, nullable=true)
   */
  protected $nyIsolMm;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeledningsevnePaaEksistIsoleringWMK", type="float")
   */
  protected $varmeledningsevnePaaEksistIsoleringWMK;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeledningsevnePaaNyIsoleringWMK", type="float")
   */
  protected $varmeledningsevnePaaNyIsoleringWMK;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="arealAfBeholderM2", type="float")
   */
  protected $arealAfBeholderM2;

  /**
   * @var float
   *
   * @ORM\Column(name="standardinvestKrM2EllerKrM", type="decimal", scale=4, nullable=true)
   */
  protected $standardinvestKrM2EllerKrM;

  /**
   * @var float
   *
   * @ORM\Column(name="prisfaktor", type="decimal", scale=4, nullable=true)
   */
  protected $prisfaktor;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="investeringKr", type="float")
   */
  protected $investeringKr;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="eksistVarmetabKwh", type="float")
   */
  protected $eksistVarmetabKwh;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="nytVarmetabKwh", type="float")
   */
  protected $nytVarmetabKwh;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmebespKwhAar", type="float")
   */
  protected $varmebespKwhAar;

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

  /**
   * Set nyttiggjortVarme
   *
   * @param \AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme $nyttiggjortVarme
   *
   * @return TekniskIsoleringTiltagDetail
   */
  public function setNyttiggjortVarme(\AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme $nyttiggjortVarme = null)
  {
    $this->nyttiggjortVarme = $nyttiggjortVarme;

    return $this;
  }

  /**
   * Get nyttiggjortVarme
   *
   * @return \AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme
   */
  public function getNyttiggjortVarme()
  {
    return $this->nyttiggjortVarme;
  }

  protected $propertiesRequiredForCalculation = [
    'type',
    'driftstidTAar',
    'eksistIsolMm',
    'udvDiameterMm',
    'tempOmgivelC',
    'roerlaengdeEllerHoejdeAfVvbM',
    'nyttiggjortVarme',
    'nyIsolMm',
    'tempMedieC',
    'standardinvestKrM2EllerKrM',
    'prisfaktor',
  ];

  public function calculate() {
    $this->roerstoerrelseMmAekvivalent = $this->calculateRoerstoerrelseMmAekvivalent();
    $this->varmeledningsevnePaaEksistIsoleringWMK = $this->calculateVarmeledningsevnePaaEksistIsoleringWMK();
    $this->varmeledningsevnePaaNyIsoleringWMK = $this->calculateVarmeledningsevnePaaNyIsoleringWMK();
    $this->arealAfBeholderM2 = $this->calculateArealAfBeholderM2();
    $this->investeringKr = $this->calculateInvesteringKr();
    $this->eksistVarmetabKwh = $this->calculateEksistVarmetabKwh();
    $this->nytVarmetabKwh = $this->calculateNytVarmetabKwh();
    $this->varmebespKwhAar = $this->calculateVarmebespKwhAar();
    $this->kwhBesparelseElFraVaerket = $this->calculateKwhBesparelseElFraVaerket();
    $this->kwhBesparelseVarmeFraVaerket = $this->calculateKwhBesparelseVarmeFraVaerket();

    // Must come after both kwhBesparelseElFraVaerket and kwhBesparelseVarmeFraVaerket
    $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
    $this->nutidsvaerdiSetOver15AarKr = $this->calculateNutidsvaerdiSetOver15AarKr();
    parent::calculate();
  }

  private function calculateRoerstoerrelseMmAekvivalent() {
    // 'P'
    if ($this->tankVolL == 0) {
      return $this->udvDiameterMm;
    } else {
      return sqrt(($this->tankVolL / 1000) / ($this->roerlaengdeEllerHoejdeAfVvbM * M_PI)) * 1000;
    }
  }

  private function calculateVarmeledningsevnePaaEksistIsoleringWMK() {
    return $this->getRapport()->getConfiguration()->getTekniskIsoleringVarmeledningsevneEksistLamelmaatter();
  }

  private function calculateVarmeledningsevnePaaNyIsoleringWMK() {
    return $this->getRapport()->getConfiguration()->getTekniskIsoleringVarmeledningsevneNyIsolering();
  }

  private function calculateArealAfBeholderM2() {
    // 'Y'
    if ($this->tankVolL == 0) {
      return 0;
    } else {
      return sqrt(($this->tankVolL / 1000) / (M_PI * $this->roerlaengdeEllerHoejdeAfVvbM))
        * (1 + $this->roerlaengdeEllerHoejdeAfVvbM * 2 * M_PI);
    }
  }

  private function calculateInvesteringKr() {
    // 'AB'
    if ($this->tankVolL == 0) {
      return $this->standardinvestKrM2EllerKrM * $this->prisfaktor * $this->roerlaengdeEllerHoejdeAfVvbM;
    } else {
      return $this->standardinvestKrM2EllerKrM * $this->prisfaktor * $this->arealAfBeholderM2;
    }
  }

  private function calculateEksistVarmetabKwh() {
    // 'AC'
    if (strcasecmp($this->type, 'rør') == 0) {
     return $this->calculateEksisterendeUVaerdi()*$this->roerlaengdeEllerHoejdeAfVvbM*(abs($this->tempMedieC-$this->tempOmgivelC))*$this->driftstidTAar/1000*$this->nyttiggjortVarme->getFaktor();
    } else if (strcasecmp($this->type, 'beholder') == 0) {
      return ($this->roerstoerrelseMmAekvivalent/1000*PI()*$this->roerlaengdeEllerHoejdeAfVvbM+($this->roerstoerrelseMmAekvivalent/1000)^2*PI())*abs($this->tempMedieC-$this->tempOmgivelC)*$this->calculateEksisterendeUVaerdi()*$this->driftstidTAar/1000;
    } else {
      return 0;
    }
  }

  private function calculateNytVarmetabKwh() {
    // 'AD'
    if (strcasecmp($this->type, 'rør') == 0) {
      return $this->calculateUkorrigeret()*$this->roerlaengdeEllerHoejdeAfVvbM*(abs($this->tempMedieC-$this->tempOmgivelC))*$this->driftstidTAar/1000*$this->nyttiggjortVarme->getFaktor();
    } else if (strcasecmp($this->type, 'beholder') == 0) {
      return ($this->roerstoerrelseMmAekvivalent/1000*PI()*$this->roerlaengdeEllerHoejdeAfVvbM+($this->roerstoerrelseMmAekvivalent/1000)^2*PI())*abs($this->tempMedieC-$this->tempOmgivelC)*$this->calculateUkorrigeret()*$this->driftstidTAar/1000;
    } else {
      return 0;
    }
  }

  private function calculateVarmebespKwhAar() {
    // 'AE'
    try {
      return $this->eksistVarmetabKwh - $this->nytVarmetabKwh;
    } catch (\Exception $ex) {
      return 0;
    }
  }

  private function calculateKwhBesparelseElFraVaerket() {
    // 'AH'
    if ($this->varmebespKwhAar == 0) {
      return 0;
    } else if ($this->getRapport()->getStandardforsyning()) {
      return 0;
    } else {
      return $this->fordelbesparelse($this->varmebespKwhAar, $this->tiltag->getForsyningVarme(), 'EL');
    }
  }

  private function calculateKwhBesparelseVarmeFraVaerket() {
    // 'AI'
    if ($this->varmebespKwhAar == 0) {
      return 0;
    } else if ($this->getRapport()->getStandardforsyning()) {
      return $this->varmebespKwhAar;
    } else {
      return $this->fordelbesparelse($this->varmebespKwhAar, $this->tiltag->getForsyningVarme(), 'VARME');
    }
  }

  private function calculateSimpelTilbagebetalingstidAar() {
    // 'AF'
    if ($this->standardinvestKrM2EllerKrM > 0) {
      return $this->divide($this->investeringKr, $this->getRapport()->getElKrKWh() * $this->kwhBesparelseElFraVaerket + $this->getRapport()->getVarmeKrKWh() * $this->kwhBesparelseVarmeFraVaerket);
    } else {
      return 0;
    }
  }

  private function calculateNutidsvaerdiSetOver15AarKr() {
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

  private function calculateEksisterendeUVaerdi() {
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
  private function calculateUkorrigeret() {
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
