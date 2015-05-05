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
    // 'W'
    // @FIXME
    return 0.05;
  }

  private function computeVarmeledningsevnePaaNyIsoleringWMK() {
    // 'X'
    // @FIXME
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
    } else if ($this->__get('INDIRECT(\"\'2.Forsyning\'!$H$3\")') == 1) {
      return 0;
    } else {
      return $this->fordelbesparelse($this->varmebespKwhAar, $this->tiltag->getForsyningVarme(), 'EL');
    }
  }

  private function computeKwhBesparelseVarmeFraVaerket() {
    // 'AI'
    if ($this->varmebespKwhAar == 0) {
      return 0;
    } else if ($this->__get('INDIRECT(\"\'2.Forsyning\'!$H$3\")') == 1) {
      return $this->varmebespKwhAar;
    } else {
      return $this->fordelbesparelse($this->varmebespKwhAar, $this->tiltag->getForsyningVarme(), 'VARME');
    }
  }

  private function computeSimpelTilbagebetalingstidAar() {
    // 'AF'
    if ($this->standardinvestKrM2EllerKrM > 0) {
      // @FIXME: Division by zero
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
      return 2*((2*$this->eksistIsolMm/1000)+$this->roerstoerrelseMmAekvivalent/1000)*$this->varmeledningsevnePaaEksistIsoleringWMK*$this->__get('$AC$25')*PI()/(((2*$this->eksistIsolMm/1000)+$this->roerstoerrelseMmAekvivalent/1000)*log(((2*$this->eksistIsolMm/1000)+$this->roerstoerrelseMmAekvivalent/1000)/($this->roerstoerrelseMmAekvivalent/1000))*$this->__get('$AC$25')+2*$this->varmeledningsevnePaaEksistIsoleringWMK);
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
      return 2*((2*$this->nyIsolMm/1000)+$this->roerstoerrelseMmAekvivalent/1000)*$this->varmeledningsevnePaaNyIsoleringWMK*$this->__get('$AC$25')*PI()/(((2*$this->nyIsolMm/1000)+$this->roerstoerrelseMmAekvivalent/1000)*log(((2*$this->nyIsolMm/1000)+$this->roerstoerrelseMmAekvivalent/1000)/($this->roerstoerrelseMmAekvivalent/1000))*$this->__get('$AC$25')+2*$this->varmeledningsevnePaaNyIsoleringWMK);
    }
  }

  public function __get($key) {
    switch ($key) {
      case 'INDIRECT(\"\'2.Forsyning\'!$H$3\")':
        // @FIXME
        // =IF(AND(A15="Hovedforsyning El",J15="El",I15=1,H15=1,A16="Fjernvarme",J16="Varme",I16=1,H16=1),1,"ikke standardforsyning")
        return 1;

      case '$AC$25':
        return 9;
    }

    throw new \Exception('Invalid key: '.$key);
  }

}

/**
Public Function FordelBesparelse(BesparKwh As Single, Kilde As String, typen As String)

Dim lastRow As Integer
Dim y As Integer
Dim t As Integer

With Worksheets("2.Forsyning")
lastRow = Worksheets("2.Forsyning").Range("a3").Value 'sidste række i øverste tabel
End With

For y = 14 To lastRow

If Worksheets("2.Forsyning").Range("a" & y) = Kilde Then
    If typen = "EL" Or typen = "VARME" Or typen = "PRIORITEREL" Or typen = "PRIORITERVARME" Then 'tjekker at der er tale om alm. el og varme og ikke "konverteringvarme" hvor det gamle forsyningsværks værdier skal bruges
        If Worksheets("2.Forsyning").Range("ai" & y) <> "" Then 'der er beregnet konvertering
            t = Worksheets("2.Forsyning").Range("ai" & y).Value 'række for konvertering indtastes

            If Worksheets("2.Forsyning").Range("a" & t) <> "" Then 'konverteringen er tilvalgt
                If typen = "EL" Or typen = "VARME" Then
                    If Worksheets("2.Forsyning").Range("aj" & t) = 1 Then 'konvertering prioriteres forud for øvrige tiltag
                        y = t 'denne funktion bypasses hvis de er er tale om KONVERTERINGVARME eller KONVERTERINGEL, hvor det eksisterende værks værdier skal anvendes.
                        'MsgBox ("y er " & y)
                    End If

                ElseIf typen = "PRIORITEREL" Then
                y = t 'prioriterel og varme er altid efter nye forsyningskildes effektivitet, uanset om prioritering er 1 eller 2
                typen = "EL"
                ElseIf typen = "PRIORITERVARME" Then
                y = t
                typen = "VARME"
                'MsgBox ("prioritering virker")
                End If
            End If
        End If

    ElseIf typen = "KONVERTERINGVARME" Then 'dvs. regner altid med gamle værks effektivitet
    typen = "VARME"
    ElseIf typen = "KONVERTERINGEL" Then 'dvs. regner altid med gamle værks effektivitet
    typen = "EL"
    End If

            If typen = "EL" Then
                BesparKwh = BesparKwh * Worksheets("2.Forsyning").Range("ah" & y)
            End If

            If typen = "VARME" Then
                BesparKwh = BesparKwh * Worksheets("2.Forsyning").Range("ag" & y)
            End If

y = lastRow 'såfremt der forsyningskilden er fundet, skal efterfølgende rækker ikke kontrolleres
End If

Next y

If typen = "VARME" Then
FordelBesparelse = BesparKwh
End If

If typen = "EL" Then
FordelBesparelse = BesparKwh
End If

End Function



Sub NVTilFra()
Dim omraade As String
Dim formel As String

ActiveSheet.unprotect Password:="ptodem"

With ActiveSheet
        If .Range("h8") = "TekniskIsol" Then
            omraade = "af49"
            formel = "=IF(TekniskIsol20[[#This Row],[Varme-" & Chr(10) & "besp. " & Chr(10) & "'[kWh/år']]]="""",""""," & Chr(10) & "nvPTO2(TekniskIsol20[[#This Row],[Investering  " & Chr(10) & "'[kr']]],TekniskIsol20[[#This Row],[kWh-besparelse Varme fra værket]],TekniskIsol20[[#This Row],[kWh-besparelse El fra værket]],0,0,0,$G$7,1,0))"

        ElseIf .Range("h8") = "VandbesparWC" Then
            omraade = "aa43"
            formel = "=IF(Table14[[#This Row],[Simpel tilbagebetalingstid (år)]]="""","""",nvPTO2(Table14[[#This Row],[Samlet investering (kr)]],0,0,Table14[[#This Row],[Vandbespar. (m³/år)]],0,0,$G$7,R11C3,0))"

        ElseIf .Range("h8") = "Belysning" Then
            omraade = "bq42"
            formel = "=IF(Table10[[#This Row],[Vægtet Levetid (år)]]="""",""""," & Chr(10) & "IF(Table10[[#This Row],[Faktor for reinvestering (ALTID 1 INDTIL VIDERE)]]="""",""""," & Chr(10) & "IF(Table10[[#This Row],[Ny lyskilde, input]]=""""," & Chr(10) & "nvPTO2(Table10[[#This Row],[Investering, alle lokaler (kr)]],Table10[[#This Row],[kWh-besparelse Varme fra varmeværket]],Table10[[#This Row],[kWh-besparelse El]],0,0,0,ROUND(Table10[[#This Row],[Vægtet Levetid (år)]],0),Table10[[#This Row],[Faktor for reinvestering (ALTID 1 INDTIL VIDERE)]],0), " & Chr(10) & "nvPTO2(Table10[[#This Row],[Investering, alle lokaler (kr)]],Table10[[#This Row],[kWh-besparelse Varme fra varmeværket]],Table10[[#This Row],[kWh-besparelse El]],0,Table10[[#This Row],[Driftsbesparelse til lyskilder" & Chr(10) & "Alle lokaler (kr/år)]],0,ROUND(Table10[[#This Row],[Vægtet Levetid (år)]],0),Table10[[#This Row],[Faktor for reinvestering (ALTID 1 INDTIL VIDERE)]],0))))"

        ElseIf .Range("h8") = "Pumper" Then
            omraade = "as37"
            formel = "=IF(AND(Table12[[#This Row],[kWh-besparelse El fra værket]]=0,Table12[[#This Row],[kWh-besparelse Varme fra værket]]=0),0," & Chr(10) & "nvPTO2(Table12[[#This Row],[Samlet investering inkl. pristillæg]],Table12[[#This Row],[kWh-besparelse Varme fra værket]],Table12[[#This Row],[kWh-besparelse El fra værket]],0,0,0,$G$7,1,0))"

        ElseIf .Range("h8") = "Klimaskaerm" Then
            omraade = "am39"
            formel = "=IF(Table821[[#This Row],[Tiltagsnr.]]="""",""""," & Chr(10) & "IF(AND(Table821[[#This Row],[kWh-bespar. Elværk (Ekstern energikilde)]]=0,Table821[[#This Row],[kWh-bespar. Varmeværk (ekstern energikilde)]]=0),0," & Chr(10) & "nvPTO2(Table821[[#This Row],[Samlet investering (kr)]],Table821[[#This Row],[kWh-bespar. Varmeværk (ekstern energikilde)]],Table821[[#This Row],[kWh-bespar. Elværk (Ekstern energikilde)]],0,0,0,Table821[[#This Row],[Vægtet levetid for tiltaget (afrundet)]],Table821[[#This Row],[Faktor for reinvestering]],0)))"

        ElseIf .Range("h8") = "Vandbespar" Then
            omraade = "ai53"
            formel = "=IF(AND(Table1419[[#This Row],[kWh-besparelse El fra værket]]=0,Table1419[[#This Row],[kWh-besparelse Varme fra værket]]=0,Table1419[[#This Row],[Vandbesparelse (m³/år)]]=""""),""""," & Chr(10) & "nvPTO2(Table1419[[#This Row],[Samlet investering (kr)]],Table1419[[#This Row],[kWh-besparelse Varme fra værket]],Table1419[[#This Row],[kWh-besparelse El fra værket]],Table1419[[#This Row],[Vandbesparelse (m³/år)]],0,0,$G$7,1,0))"

        Else
            Exit Sub 'ingen standardark fundet
        End If


        If MsgBox("Slå nutidsværdi på deltiltagsniveau til?", vbYesNo, "") = vbNo Then
            formel = "=0"
        End If

.Range(omraade).FormulaR1C1 = _
formel

ActiveSheet.Protect Password:="ptodem", AllowFiltering:=True, AllowFormattingColumns:=True

End With

End Sub



*/