<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\InheritanceType;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;

/**
 * TiltagDetail
 *
 * @ORM\Table()
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *    "pumpe" = "PumpeTiltagDetail",
 *    "special" = "SpecialTiltagDetail",
 *    "belysning" = "BelysningTiltagDetail",
 *    "klimaskærm" = "KlimaskaermTiltagDetail",
 *    "tekniskisolering" = "TekniskIsoleringTiltagDetail",
 *    "solcelle" = "SolcelleTiltagDetail",
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TiltagDetailRepository")
 * @JMS\Discriminator(field = "_discr", map = {
 *    "pumpe": "AppBundle\Entity\PumpeTiltagDetail",
 *    "special": "AppBundle\Entity\SpecialTiltagDetail",
 *    "belysning" = "AppBundle\Entity\BelysningTiltagDetail",
 *    "klimaskærm" = "AppBundle\Entity\KlimaskaermTiltagDetail",
 *    "tekniskisolering" = "AppBundle\Entity\TekniskIsoleringTiltagDetail",
 *    "solcelle" = "AppBundle\Entity\SolcelleTiltagDetail",
 * })
 * @ORM\HasLifecycleCallbacks
 */
abstract class TiltagDetail {
  use TimestampableEntity;

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * Get id
   *
   * @return integer
   */
  final public function getId() {
    return $this->id;
  }

  /**
   * @var object
   *
   * @ORM\Column(name="data", type="object")
   */
  private $data;

  /**
   * Get data.
   *
   * @param string $key
   * @return object
   */
  public function getData($key = null) {
    if ($key === null) {
      return $this->data;
    }
    return isset($this->data->{$key}) ? $this->data->{$key} : null;
  }

  /**
   * Add data
   * @param string $key
   * @param object $value
   * @return $this
   */
  protected function addData($key, $value) {
    $data = $this->data;
    if ($data === null) {
      $data = new \StdClass();
    }
    $data->{$key} = $value;
    // Mark $this->data as dirty (Hack!)
    $this->data = clone $data;

    return $this;
  }

  public function setData($key, $value) {
    return $this->addData($key, $value);
  }

  /**
   * @var string
   *
   * @ORM\Column(name="Title", type="string", length=255, nullable=true)
   */
  private $title;

  public function setTitle($title) {
    $this->title = $title;
    return $this;
  }

  public function getTitle() {
    return $this->title;
  }

  /**
   * @var Tiltag $tiltag
   *
   * @ManyToOne(targetEntity="Tiltag", inversedBy="details")
   * @JoinColumn(name="tiltag_id", referencedColumnName="id")
   * @JMS\Type("AppBundle\Entity\Tiltag")
   **/
  protected $tiltag;

  /**
   * Set tiltag
   *
   * @param \AppBundle\Entity\tiltag $tiltag
   * @return Rapport
   */
  public function setTiltag(Tiltag $tiltag = NULL) {
    if ($this->tiltag && $this->tiltag != $tiltag) {
      $this->tiltag->removeDetail($this);
    }
    if ($tiltag) {
      $tiltag->addDetail($this);
    }
    $this->tiltag = $tiltag;

    return $this;
  }

  /**
   * Get tiltag
   *
   * @return \AppBundle\Entity\tiltag
   */
  public function getTiltag() {
    return $this->tiltag;
  }

  /**
   * @var boolean
   *
   * @ORM\Column(name="tilvalgt", type="boolean", nullable=true)
   */
  private $tilvalgt = false;

  /**
   * Set tilvalgt
   *
   * @param boolean $tilvalgt
   * @return TiltagDetail
   */
  public function setTilvalgt($tilvalgt) {
    $this->tilvalgt = $tilvalgt;

    return $this;
  }

  /**
   * Get tilvalgt
   *
   * @return boolean
   */
  public function getTilvalgt() {
    return $this->tilvalgt;
  }

  /**
   * @var boolean
   *
   * @ORM\Column(name="laastAfEnergiraadgiver", type="boolean", nullable=true)
   */
  private $laastAfEnergiraadgiver;

    /**
   * Set laastAfEnergiraadgiver
   *
   * @param boolean $laastAfEnergiraadgiver
   * @return KlimaskaermTiltagDetail
   */
  public function setLaastAfEnergiraadgiver($laastAfEnergiraadgiver) {
    $this->laastAfEnergiraadgiver = $laastAfEnergiraadgiver;

    return $this;
  }

  /**
   * Get laastAfEnergiraadgiver
   *
   * @return boolean
   */
  public function getLaastAfEnergiraadgiver() {
    return $this->laastAfEnergiraadgiver;
  }

  /**
   * Get the rapport (convenience method)
   *
   * @return Rapport
   */
  public function getRapport() {
    return $this->getTiltag()->getRapport();
  }

  /**
   * Handle uploads.
   * @param $manager
   */
  public function handleUploads($manager) {}

  /**
   * @var Configuration
   */
  protected $configuration;

  /**
   * Calculate stuff.
   */
  public function calculate() {
    $this->tiltag->calculate();
  }

  protected function fordelbesparelse($BesparKwh, $Kilde, $typen) {
    // @FIXME
    return 0;

    /*
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
*/
  }

  protected function nvPTO2($Invest, $BesparKwhVarme, $BesparKwhEl, $Besparm3Vand, $DogV, $Straf, $Levetid, $FaktorReInvest, $SalgAfEnergibesparelse) {
    $rapport = $this->tiltag->getRapport();
    $Kalkulationsrente = $rapport->getKalkulationsrente();
    $Inflationsfaktor = $rapport->getInflationsfaktor();
    $Inflation = $rapport->getInflation();
    $Lobetid  = $rapport->getLobetid();
    $Elfaktor = $rapport->getElfaktor();
    $Varmefaktor = $rapport->getVarmefaktor();
    $Vandfaktor = $rapport->getVandfaktor();

    $Reinvest = 0;
    $AntalReinvest = 0;
    $Scrapvaerdi = 0;

    if ($Levetid > 0) {
      if ($Levetid < $Lobetid) { // 'reinvestering foretages
        $AntalReinvest = floor($Lobetid / $Levetid);

        if ($AntalReinvest == 1) {
          $Reinvest = ($Invest * $FaktorReInvest * pow(1 + $Inflation, $Levetid + 1)) / pow(1 + $Kalkulationsrente, $Levetid + 1);
        }
        elseif ($AntalReinvest > 1) { // 'kan evt. forbedres til mere statisk formel aht. beregningshastigheden
          for ($x = 1; $x <= $AntalReinvest; $x++) {
            $Reinvest = $Reinvest + ($Invest * $FaktorReInvest * pow(1 + $Inflation, $Levetid * $x + 1)) / (pow(1 + $Kalkulationsrente, $Levetid * $x + 1));
          }
        }
      }

      if ($Levetid > $Lobetid) { // 'ingen reinvesteringer
        $Scrapvaerdi = (1 - ($Lobetid / $Levetid)) * $Invest * pow(1 + $Inflation, $Lobetid);
      }
      elseif ($Lobetid - $AntalReinvest * $Levetid == 0) {
        $Scrapvaerdi = 0;
      } else {
        $Scrapvaerdi = (1 - ($Lobetid - $AntalReinvest * $Levetid) / $Levetid) * $Invest * $FaktorReInvest * pow(1 + $Inflation, $Lobetid);
      }
    }

    return ((-$Invest + $SalgAfEnergibesparelse) / (1 + $Kalkulationsrente)) + $BesparKwhVarme * $Varmefaktor + $BesparKwhEl * $Elfaktor + $Besparm3Vand * $Vandfaktor + ($Scrapvaerdi / pow(1 + $Kalkulationsrente, $Lobetid)) + ($DogV + $Straf) * $Inflationsfaktor - $Reinvest;
  }

  /*
Public Function NvPTO2(Invest As Single, BesparKwhVarme As Single, BesparKwhEl As Single, Besparm3Vand As Single, DogV As Single, Straf As Single, Levetid As Single, FaktorReInvest As Single, SalgAfEnergibesparelse)
Dim Kalkulationsrente As Single
Dim Inflationsfaktor As Single
Dim Inflation As Single
Dim Lobetid As Integer
Dim AntalReinvest As Integer
Dim Elfaktor As Single
Dim Varmefaktor As Single
Dim Vandfaktor As Single
Dim Scrapvaerdi As Long
Dim Reinvest As Single
Dim x As Integer

Kalkulationsrente = Worksheets("1.Tiltagslisterådgiver").Range("ai23").Value
Inflationsfaktor = Worksheets("1.Tiltagslisterådgiver").Range("ai26")
Inflation = Worksheets("1.Tiltagslisterådgiver").Range("ak23")
Lobetid = Worksheets("1.Tiltagslisterådgiver").Range("an23")
Elfaktor = Worksheets("1.TiltagslisteRådgiver").Range("ah25") 'tilbagediskonterede faktorer for energi-priser over 15 år
Varmefaktor = Worksheets("1.TiltagslisteRådgiver").Range("ah24")
Vandfaktor = Worksheets("1.TiltagslisteRådgiver").Range("ai27")

Reinvest = 0
AntalReinvest = 0

If Levetid > 0 Then
If Levetid < Lobetid Then 'reinvestering foretages
    AntalReinvest = Application.RoundDown(Lobetid / Levetid, 0)

    If AntalReinvest = 1 Then
        Reinvest = (Invest * FaktorReInvest * (1 + Inflation) ^ (Levetid + 1)) / ((1 + Kalkulationsrente) ^ (Levetid + 1))
    ElseIf AntalReinvest > 1 Then 'kan evt. forbedres til mere statisk formel aht. beregningshastigheden
        For x = 1 To AntalReinvest
            Reinvest = Reinvest + (Invest * FaktorReInvest * (1 + Inflation) ^ ((Levetid * x) + 1)) / ((1 + Kalkulationsrente) ^ ((Levetid * x) + 1))
        Next
    End If

End If


If Levetid > Lobetid Then 'ingen reinvesteringer
    Scrapvaerdi = (1 - (Lobetid / Levetid)) * Invest * (1 + Inflation) ^ Lobetid
ElseIf (Lobetid - AntalReinvest * Levetid) = 0 Then
   Scrapvaerdi = 0
Else
    Scrapvaerdi = (1 - (Lobetid - AntalReinvest * Levetid) / Levetid) * Invest * FaktorReInvest * (1 + Inflation) ^ Lobetid
End If
End If

    NvPTO2 = ((-Invest + SalgAfEnergibesparelse) / (1 + Kalkulationsrente) ^ 1) + BesparKwhVarme * Varmefaktor + BesparKwhEl * Elfaktor + Besparm3Vand * Vandfaktor + (Scrapvaerdi / (1 + Kalkulationsrente) ^ Lobetid) + (DogV + Straf) * Inflationsfaktor - Reinvest
End Function
*/

  /**
   * Calculate Net Present Value
   *
   * @param float $rate
   *   The rate.
   *
   * @param array $values
   *   The values. Indexes should be years (from 1).
   */
  protected function npv($rate, array $values) {
    $nvp = 0;

    // @see http://stackoverflow.com/questions/2027460/how-to-calculate-npv
    foreach ($values as $year => $value) {
      $nvp += $value / pow(1 + $rate, $year);
    }

    return $nvp;
  }

}
