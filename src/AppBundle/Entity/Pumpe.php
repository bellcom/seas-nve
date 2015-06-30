<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Pumpe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PumpeRepository")
 */
class Pumpe {
  use TimestampableEntity;

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   *
   * @ORM\Column(name="NuvaerendeType", type="string", length=255)
   */
  protected $nuvaerendeType;

  /**
   * @var integer
   *
   * @ORM\Column(name="Byggemaal", type="integer")
   */
  protected $byggemaal;

  /**
   * @var string
   *
   * @ORM\Column(name="Tilslutning", type="string", length=25)
   */
  protected $tilslutning;

  /**
   * @var integer
   *
   * @ORM\Column(name="Indst", type="integer")
   */
  protected $indst;

  /**
   * @var string
   *
   * @ORM\Column(name="Forbrug", type="string", length=25)
   */
  protected $forbrug;

  /**
   * @var string
   *
   * @ORM\Column(name="Q", type="decimal")
   */
  protected $q;

  /**
   * @var string
   *
   * @ORM\Column(name="H", type="decimal")
   */
  protected $h;

  /**
   * @var integer
   *
   * @ORM\Column(name="Aarsforbrug", type="integer")
   */
  protected $aarsforbrug;

  /**
   * @var string
   *
   * @ORM\Column(name="NyPumpe", type="string", length=255)
   */
  protected $nyPumpe;

  /**
   * @var integer
   *
   * @ORM\Column(name="NyByggemaal", type="integer")
   */
  protected $nyByggemaal;

  /**
   * @var string
   *
   * @ORM\Column(name="NyTilslutning", type="string", length=25)
   */
  protected $nyTilslutning;

  /**
   * @var string
   *
   * @ORM\Column(name="vvsnr", type="string", length=20)
   */
  protected $vvsnr;

  /**
   * @var integer
   *
   * @ORM\Column(name="NytAarsforbrug", type="integer")
   */
  protected $nytAarsforbrug;

  /**
   * @var integer
   *
   * @ORM\Column(name="Elbesparelse", type="integer")
   */
  protected $elbesparelse;

  /**
   * @var string
   *
   * @ORM\Column(name="Udligningssaet", type="string", length=20)
   */
  protected $udligningssaet;

  /**
   * @var string
   *
   * @ORM\Column(name="Kommentarer", type="string", length=255)
   */
  protected $kommentarer;

  /**
   * @var integer
   *
   * @ORM\Column(name="StandInvestering", type="integer", nullable=true)
   */
  protected $standInvestering;

  /**
   * @var string
   *
   * @ORM\Column(name="Fabrikant", type="string", length=50)
   */
  protected $fabrikant;

  /**
   * @var integer
   *
   * @ORM\Column(name="Roerlaengde", type="integer")
   */
  protected $roerlaengde;

  /**
   * @var string
   *
   * @ORM\Column(name="Roerstoerrelse", type="string", length=10)
   */
  protected $roerstoerrelse;

  /**
   * @var float
   */
  protected $besparelseVedIsoleringskappe = null;

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    return $this->id.'. '.$this->nuvaerendeType . ' / ' . $this->nyPumpe;
  }


  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set nuvaerendeType
   *
   * @param string $nuvaerendeType
   * @return Pumpe
   */
  public function setNuvaerendeType($nuvaerendeType) {
    $this->nuvaerendeType = $nuvaerendeType;

    return $this;
  }

  /**
   * Get nuvaerendeType
   *
   * @return string
   */
  public function getNuvaerendeType() {
    return $this->nuvaerendeType;
  }

  /**
   * Set byggemaal
   *
   * @param integer $byggemaal
   * @return Pumpe
   */
  public function setByggemaal($byggemaal) {
    $this->byggemaal = $byggemaal;

    return $this;
  }

  /**
   * Get byggemaal
   *
   * @return integer
   */
  public function getByggemaal() {
    return $this->byggemaal;
  }

  /**
   * Set tilslutning
   *
   * @param string $tilslutning
   * @return Pumpe
   */
  public function setTilslutning($tilslutning) {
    $this->tilslutning = $tilslutning;

    return $this;
  }

  /**
   * Get tilslutning
   *
   * @return string
   */
  public function getTilslutning() {
    return $this->tilslutning;
  }

  /**
   * Set indst
   *
   * @param integer $indst
   * @return Pumpe
   */
  public function setIndst($indst) {
    $this->indst = $indst;

    return $this;
  }

  /**
   * Get indst
   *
   * @return integer
   */
  public function getIndst() {
    return $this->indst;
  }

  /**
   * Set forbrug
   *
   * @param string $forbrug
   * @return Pumpe
   */
  public function setForbrug($forbrug) {
    $this->forbrug = $forbrug;

    return $this;
  }

  /**
   * Get forbrug
   *
   * @return string
   */
  public function getForbrug() {
    return $this->forbrug;
  }

  /**
   * Set q
   *
   * @param string $q
   * @return Pumpe
   */
  public function setQ($q) {
    $this->q = $q;

    return $this;
  }

  /**
   * Get q
   *
   * @return string
   */
  public function getQ() {
    return $this->q;
  }

  /**
   * Set h
   *
   * @param string $h
   * @return Pumpe
   */
  public function setH($h) {
    $this->h = $h;

    return $this;
  }

  /**
   * Get h
   *
   * @return string
   */
  public function getH() {
    return $this->h;
  }

  /**
   * Set aarsforbrug
   *
   * @param integer $aarsforbrug
   * @return Pumpe
   */
  public function setAarsforbrug($aarsforbrug) {
    $this->aarsforbrug = $aarsforbrug;

    return $this;
  }

  /**
   * Get aarsforbrug
   *
   * @return integer
   */
  public function getAarsforbrug() {
    return $this->aarsforbrug;
  }

  /**
   * Set nyPumpe
   *
   * @param string $nyPumpe
   * @return Pumpe
   */
  public function setNyPumpe($nyPumpe) {
    $this->nyPumpe = $nyPumpe;

    return $this;
  }

  /**
   * Get nyPumpe
   *
   * @return string
   */
  public function getNyPumpe() {
    return $this->nyPumpe;
  }

  /**
   * Set nyByggemaal
   *
   * @param integer $nyByggemaal
   * @return Pumpe
   */
  public function setNyByggemaal($nyByggemaal) {
    $this->nyByggemaal = $nyByggemaal;

    return $this;
  }

  /**
   * Get nyByggemaal
   *
   * @return integer
   */
  public function getNyByggemaal() {
    return $this->nyByggemaal;
  }

  /**
   * Set nyTilslutning
   *
   * @param string $nyTilslutning
   * @return Pumpe
   */
  public function setNyTilslutning($nyTilslutning) {
    $this->nyTilslutning = $nyTilslutning;

    return $this;
  }

  /**
   * Get nyTilslutning
   *
   * @return string
   */
  public function getNyTilslutning() {
    return $this->nyTilslutning;
  }

  /**
   * Set vvsnr
   *
   * @param string $vvsNr
   * @return Pumpe
   */
  public function setVvsNr($vvsNr) {
    $this->vvsnr = $vvsNr;

    return $this;
  }

  /**
   * Get vvsnr
   *
   * @return string
   */
  public function getVvsNr() {
    return $this->vvsnr;
  }

  /**
   * Set nytAarsforbrug
   *
   * @param integer $nytAarsforbrug
   * @return Pumpe
   */
  public function setNytAarsforbrug($nytAarsforbrug) {
    $this->nytAarsforbrug = $nytAarsforbrug;

    return $this;
  }

  /**
   * Get nytAarsforbrug
   *
   * @return integer
   */
  public function getNytAarsforbrug() {
    return $this->nytAarsforbrug;
  }

  /**
   * Set elbesparelse
   *
   * @param integer $elbesparelse
   * @return Pumpe
   */
  public function setElbesparelse($elbesparelse) {
    $this->elbesparelse = $elbesparelse;

    return $this;
  }

  /**
   * Get elbesparelse
   *
   * @return integer
   */
  public function getElbesparelse() {
    return $this->elbesparelse;
  }

  /**
   * Set udligningssaet
   *
   * @param string $udligningssaet
   * @return Pumpe
   */
  public function setUdligningssaet($udligningssaet) {
    $this->udligningssaet = $udligningssaet;

    return $this;
  }

  /**
   * Get udligningssaet
   *
   * @return string
   */
  public function getUdligningssaet() {
    return $this->udligningssaet;
  }

  /**
   * Set kommentarer
   *
   * @param string $kommentarer
   * @return Pumpe
   */
  public function setKommentarer($kommentarer) {
    $this->kommentarer = $kommentarer;

    return $this;
  }

  /**
   * Get kommentarer
   *
   * @return string
   */
  public function getKommentarer() {
    return $this->kommentarer;
  }

  /**
   * Set standInvestering
   *
   * @param integer $standInvestering
   * @return Pumpe
   */
  public function setStandInvestering($standInvestering) {
    $this->standInvestering = $standInvestering;

    return $this;
  }

  /**
   * Get standInvestering
   *
   * @return integer
   */
  public function getStandInvestering() {
    return $this->standInvestering;
  }

  /**
   * Set fabrikant
   *
   * @param string $fabrikant
   * @return Pumpe
   */
  public function setFabrikant($fabrikant) {
    $this->fabrikant = $fabrikant;

    return $this;
  }

  /**
   * Get fabrikant
   *
   * @return string
   */
  public function getFabrikant() {
    return $this->fabrikant;
  }

  /**
   * Set roerlaengde
   *
   * @param integer $roerlaengde
   * @return Pumpe
   */
  public function setRoerlaengde($roerlaengde) {
    $this->roerlaengde = $roerlaengde;

    return $this;
  }

  /**
   * Get roerlaengde
   *
   * @return integer
   */
  public function getRoerlaengde() {
    return $this->roerlaengde;
  }

  /**
   * Set roerstoerrelse
   *
   * @param string $roerstoerrelse
   * @return Pumpe
   */
  public function setRoerstoerrelse($roerstoerrelse) {
    $this->roerstoerrelse = $roerstoerrelse;

    return $this;
  }

  /**
   * Get roerstoerrelse
   *
   * @return string
   */
  public function getRoerstoerrelse() {
    return $this->roerstoerrelse;
  }

  /**
   *
   */
  public function getBesparelseVedIsoleringskappe() {
    if ($this->besparelseVedIsoleringskappe === null) {
      $this->besparelseVedIsoleringskappe = $this->calculateBesparelseVedIsoleringskappe();
    }
    return $this->besparelseVedIsoleringskappe;
  }

  private function calculateBesparelseVedIsoleringskappe() {
    $standardtemperatur = (45 - 12);
    $varmetab = self::$varmetabstabel[$this->roerstoerrelse];
    return ($varmetab[1] - $varmetab[2]) * 2 * $standardtemperatur * 5448 / 1000;
  }

  private static $varmetabstabel = array(
    // 'Isol. (mm' => [ 'Isolering/Diameter mm', '0 mm', '30 mm' ]
    '3/8"' => array( 17.2, 0.83, 0.16 ),
    '1/2"' => array( 21.3, 1.01, 0.17 ),
    '3/4"' => array( 26.9, 1.23, 0.2 ),
    '1"' => array( 33.7, 1.49, 0.23 ),
    '1-1/4"' => array( 42.4, 1.82, 0.26 ),
    '1-1/2"' => array( 48.3, 2.04, 0.28 ),
    '2"' => array( 60.3, 2.47, 0.33 ),
    '2-1/2"' => array( 76.1, 3.03, 0.39 ),
    '3"' => array( 88.9, 3.46, 0.44 ),
    '4"' => array( 114.3, 4.31, 0.54 ),
    '5"' => array( 139.7, 5.15, 0.63 ),
    '6"' => array( 168.2, 6.03, 0.74 ),
  );

}
