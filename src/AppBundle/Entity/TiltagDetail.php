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
use Doctrine\ORM\Event\LifecycleEventArgs;

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
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TiltagDetailRepository")
 * @JMS\Discriminator(field = "_discr", map = {
 *    "pumpe": "AppBundle\Entity\PumpeTiltagDetail",
 *    "special": "AppBundle\Entity\SpecialTiltagDetail",
 *    "belysning" = "AppBundle\Entity\BelysningTiltagDetail",
 *    "klimaskærm" = "AppBundle\Entity\KlimaskaermTiltagDetail",
 *    "tekniskisolering" = "AppBundle\Entity\TekniskIsoleringTiltagDetail",
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
  private $tiltag;

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
   * @ORM\Column(name="tilvalgt", type="boolean")
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
   * Handle uploads.
   * @param $manager
   */
  public function handleUploads($manager) {}

  /**
   * Post load handler.
   *
   * @ORM\PostLoad
   * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
   */
  public function postLoad(LifecycleEventArgs $event) {
    $this->compute();
  }

  /**
   * Compute stuff.
   */
  protected function compute() {}

  protected function fordelbesparelse($a, $b, $c) {
    return 0;
  }

  protected function nvPTO2($Invest, $BesparKwhVarme, $BesparKwhEl, $Besparm3Vand, $DogV, $Straf, $Levetid, $FaktorReInvest, $SalgAfEnergibesparelse) {
    $Kalkulationsrente = 0.0292; // Worksheets("1.Tiltagslisterådgiver").Range("ai23").Value;
    $Inflationsfaktor = 13.8639998427607; // Worksheets("1.Tiltagslisterådgiver").Range("ai26");
    $Inflation = 0.019; // Worksheets("1.Tiltagslisterådgiver").Range("ak23");
    $Lobetid = 15; // Worksheets("1.Tiltagslisterådgiver").Range("an23");
    $Elfaktor = 23.5852836416293; // Worksheets("1.TiltagslisteRådgiver").Range("ah25"); // 'tilbagediskonterede faktorer for energi-priser over 15 år
    $Varmefaktor = 5.66155209590081; // Worksheets("1.TiltagslisteRådgiver").Range("ah24");
    $Vandfaktor = 566.621673573629; // Worksheets("1.TiltagslisteRådgiver").Range("ai27");

    $Reinvest = 0;
    $AntalReinvest = 0;
    $Scrapvaerdi = 0;

    if ($Levetid > 0) {
      if ($Levetid < $Lobetid) { // 'reinvestering foretages
          $AntalReinvest = floor($Lobetid / $Levetid);

          if ($AntalReinvest == 1) {
            $Reinvest = ($Invest * $FaktorReInvest * (1 + $Inflation) ^ ($Levetid + 1)) / ((1 + $Kalkulationsrente) ^ ($Levetid + 1));
          }
          elseif ($AntalReinvest > 1) { // 'kan evt. forbedres til mere statisk formel aht. beregningshastigheden
            for ($x = 1; $x <= $AntalReinvest; $x++) {
              $Reinvest = $Reinvest + ($Invest * $FaktorReInvest * (1 + $Inflation) ^ (($Levetid * $x) + 1)) / ((1 + $Kalkulationsrente) ^ (($Levetid * $x) + 1));
            }
          }
        }


      if ($Levetid > $Lobetid) { // 'ingen reinvesteringer
        $Scrapvaerdi = (1 - ($Lobetid / $Levetid)) * $Invest * (1 + $Inflation) ^ $Lobetid;
      }
      elseif ($Lobetid - $AntalReinvest * $Levetid == 0) {
        $Scrapvaerdi = 0;
      } else {
        $Scrapvaerdi = (1 - ($Lobetid - $AntalReinvest * $Levetid) / $Levetid) * $Invest * $FaktorReInvest * (1 + $Inflation) ^ $Lobetid;
      }
    }

    return ((-$Invest + $SalgAfEnergibesparelse) / (1 + $Kalkulationsrente) ^ 1) + $BesparKwhVarme * $Varmefaktor + $BesparKwhEl * $Elfaktor + $Besparm3Vand * $Vandfaktor + ($Scrapvaerdi / (1 + $Kalkulationsrente) ^ $Lobetid) + ($DogV + $Straf) * $Inflationsfaktor - $Reinvest;
  }

}
