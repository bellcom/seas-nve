<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Calculation\Calculation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\InheritanceType;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\PropertyAccess\PropertyAccess;

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
 *    "køleanlæg" = "KoeleanlaegTiltagDetail",
 *    "nyklimaskærm" = "NyKlimaskaermTiltagDetail",
 *    "varmeanlaeg" = "VarmeanlaegTiltagDetail",
 *    "vindue" = "VindueTiltagDetail",
 *    "ventilation" = "VentilationTiltagDetail",
 *    "tekniskisolering" = "TekniskIsoleringTiltagDetail",
 *    "trykluft" = "TrykluftTiltagDetail",
 *    "solcelle" = "SolcelleTiltagDetail",
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TiltagDetailRepository")
 * @JMS\Discriminator(field = "_discr", map = {
 *    "pumpe": "AppBundle\Entity\PumpeTiltagDetail",
 *    "special": "AppBundle\Entity\SpecialTiltagDetail",
 *    "belysning" = "AppBundle\Entity\BelysningTiltagDetail",
 *    "køleanlæg" = "AppBundle\Entity\KoeleanlaegTiltagDetail",
 *    "nyklimaskærm" = "AppBundle\Entity\NyKlimaskaermTiltagDetail",
 *    "tekniskisolering" = "AppBundle\Entity\TekniskIsoleringTiltagDetail",
 *    "trykluft" = "AppBundle\Entity\TrykluftTiltagDetail",
 *    "ventilation" = "AppBundle\Entity\VentilationTiltagDetail",
 *    "varmeanlaeg" = "AppBundle\Entity\VarmeanlaegTiltagDetail",
 *    "solcelle" = "AppBundle\Entity\SolcelleTiltagDetail",
 * })
 * @ORM\HasLifecycleCallbacks
 */
abstract class TiltagDetail {
  use TimestampableEntity;

  /**
   * Constructor
   */
  public function __construct() {

  }

  /**
   * Initialize a new TiltagDetail.
   *
   * Can be used for setting default values, say.
   */
  public function init(Tiltag $tiltag) {
    $this->setTiltag($tiltag);
  }

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var Tiltag $tiltag
   *
   * @ManyToOne(targetEntity="Tiltag", inversedBy="details")
   * @JoinColumn(name="tiltag_id", referencedColumnName="id")
   * @JMS\Type("AppBundle\Entity\Tiltag")
   **/
  protected $tiltag;


  /**
   * Get id
   *
   * @return integer
   */
  final public function getId() {
    return $this->id;
  }

  /**
   * @var boolean
   *
   * @ORM\Column(name="ikkeElenaBerettiget", type="boolean", nullable=true)
   */
  protected $ikkeElenaBerettiget = false;

  /**
   * Set ikkeElenaBerettiget
   *
   * @param string ikkeElenaBerettiget
   * @return Bygning
   */
  public function setIkkeElenaBerettiget($ikkeElenaBerettiget) {
    $this->ikkeElenaBerettiget = $ikkeElenaBerettiget;

    return $this;
  }

  /**
   * Get ikkeelenaberettiget
   *
   * @return boolean
   */
  public function getIkkeElenaBerettiget() {
    return $this->ikkeElenaBerettiget;
  }

  /**
   * @var string
   *
   * @ORM\Column(name="Title", type="string", length=255, nullable=true)
   */
  protected $title;

  public function setTitle($title) {
    $this->title = $title;
    return $this;
  }

  public function getTitle() {
    return $this->title;
  }


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
  protected $tilvalgt = TRUE;

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
  protected $laastAfEnergiraadgiver;

    /**
   * Set laastAfEnergiraadgiver
   *
   * @param boolean $laastAfEnergiraadgiver
   * @return TiltagDetail
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
    return empty($this->getTiltag()) ? NULL : $this->getTiltag()->getRapport();
  }

  /**
   * Get all files on this TiltagDetail.
   *
   * @return array
   */
  public function getAllFiles() {
    return null;
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

  protected $propertiesRequiredForCalculation = [];

  public function getPropertiesRequiredForCalculation() {
    return $this->propertiesRequiredForCalculation;
  }

  /**
   * Check if calculating this Tiltag makes sense.
   * Some values may be required to make a meaningful calculation.
   */
  public function getCalculationWarnings($messages = []) {
    $properties = $this->getPropertiesRequiredForCalculation();
    $prefix = strtolower((string)$this);
    $d = Calculation::getCalculationWarnings($this, $properties, $prefix);
    return Calculation::getCalculationWarnings($this, $properties, $prefix);
  }

  /**
   * Get index
   *
   * @return integer
   */
  public function getIndexNumber() {
    $details = $this->getTiltag()->getDetails();
    $index = 1;
    foreach ($details as $d) {
      if($this->getId() === $d->getId()) {
        return $index;
      }
      $index++;
    }

    return 0;
  }

  /**
   * Calculate stuff.
   */
  public function calculate() {
  }

  protected function fordelbesparelse($BesparKwh, $kilde, $type) {
    return Calculation::fordelbesparelse($BesparKwh, $kilde, $type);
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
      // $Scrapvaerdi is defined as long in Excel.
      $Scrapvaerdi = round($Scrapvaerdi);
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
   * Safe division.
   *
   * @param float $numerator
   *   The numerator.
   *
   * @param float $denominator
   *   The denominator.
   *
   * @return float
   *   .
   */
  protected function divide($numerator, $denominator) {
    return Calculation::divide($numerator, $denominator);
  }

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    $className = get_class($this);
    if (preg_match('@\\\\(?<name>[^\\\\]+)$@', $className, $matches)) {
      return $matches['name'];
    }
    return $className;
  }

  // Temp field for batch edit form - not persisted
  protected $batchEdit = false;

  /**
   * @return boolean
   */
  public function isBatchEdit()
  {
    return $this->batchEdit;
  }

  /**
   * @param boolean $batchEdit
   */
  public function setBatchEdit($batchEdit)
  {
    $this->batchEdit = $batchEdit;
  }

  public function updateProperties($detail) {
    $accessor = PropertyAccess::createPropertyAccessor();

    if(get_class($this) === get_class($detail)) {
      foreach ($detail as $property => $value) {
        // Only update set values
        if($value !== null && $accessor->isWritable($this, $property)) {
          $accessor->setValue($this, $property, $value);
        }
      }
    }
  }

}
