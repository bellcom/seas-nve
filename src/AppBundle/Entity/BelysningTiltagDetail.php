<?php

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\BelysningTiltagDetail\Lyskilde as BelysningTiltagDetailLyskilde;
use AppBundle\Entity\BelysningTiltagDetail\Placering as BelysningTiltagDetailPlacering;
use AppBundle\Entity\BelysningTiltagDetail\Styring as BelysningTiltagDetailStyring;
use AppBundle\Entity\BelysningTiltagDetail\Tiltag as BelysningTiltagDetailTiltag;

/**
 * BelysningTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class BelysningTiltagDetail extends TiltagDetail {
  /**
   * @var string
   *
   * @ORM\Column(name="lokale_navn", type="string", length=255)
   */
  private $lokale_navn;

  /**
   * @var string
   *
   * @ORM\Column(name="lokale_type", type="string", length=255)
   */
  private $lokale_type;

  /**
   * @var float
   *
   * @ORM\Column(name="armaturhoejdeM", type="decimal", scale=4)
   */
  private $armaturhoejdeM;

  /**
   * @var float
   *
   * @ORM\Column(name="rumstoerrelseM2", type="decimal", scale=4)
   */
  private $rumstoerrelseM2;

  /**
   * @var integer
   *
   * @ORM\Column(name="lokale_antal", type="integer")
   */
  private $lokale_antal;

  /**
   * @var string
   *
   * @ORM\Column(name="drifttidTAar", type="integer")
   */
  private $drifttidTAar;

  /**
   * @var BelysningTiltagDetailLyskilde
   *
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BelysningTiltagDetail\Lyskilde")
   * ORM\JoinColumn(name="lyskilde_id", referencedColumnName="id")
   **/
  private $lyskilde;

  /**
   * @var integer
   *
   * @ORM\Column(name="lyskildeStkArmatur", type="integer")
   */
  private $lyskildeStkArmatur;

  /**
   * @var integer
   *
   * @ORM\Column(name="lyskildeWLyskilde", type="integer")
   */
  private $lyskildeWLyskilde;

  /**
   * @var integer
   *
   * @ORM\Column(name="forkoblingStkArmatur", type="integer")
   */
  private $forkoblingStkArmatur;

  /**
   * @var integer
   *
   * @ORM\Column(name="armaturerStkLokale", type="integer")
   */
  private $armaturerStkLokale;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="elforbrugWM2", type="float")
   */
  private $elforbrugWM2;

  /**
   * @var string
   *
   * @ORM\Column(name="placering_id", type="string", length=255)
   */
  private $placeringId;

  /**
   * @var integer
   *
   * @ORM\Column(name="styring_id", type="string", length=255)
   */
  private $styringId;

  /**
   * @var string
   *
   * @ORM\Column(name="noter", type="text")
   */
  private $noter;

  /**
   * @var integer
   *
   * @ORM\Column(name="belysningstiltag_id", type="string", length=255)
   **/
  private $belysningstiltagId;

  /**
   * @var integer
   *
   * @ORM\Column(name="nyeSensorerStkLokale", type="integer")
   */
  private $nyeSensorerStkLokale;

  /**
   * @var float
   *
   * @ORM\Column(name="standardinvestSensorKrStk", type="decimal", scale=4)
   */
  private $standardinvestSensorKrStk;

  /**
   * @var float
   *
   * @ORM\Column(name="reduktionAfDrifttid", type="decimal", scale=4)
   */
  private $reduktionAfDrifttid;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="nyDriftstid", type="float")
   */
  private $nyDriftstid;

  /**
   * @var float
   *
   * @ORM\Column(name="standardinvestArmaturElLyskildeKrStk", type="decimal", scale=4)
   */
  private $standardinvestArmaturElLyskildeKrStk;

  /**
   * @var float
   *
   * @ORM\Column(name="standardinvestLyskildeKrStk", type="decimal", scale=4)
   */
  private $standardinvestLyskildeKrStk;

  /**
   * @var BelysningTiltagDetailLyskilde
   *
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BelysningTiltagDetail\Lyskilde")
   * ORM\JoinColumn(name="ny_lyskilde_id", referencedColumnName="id")
   */
  private $nyLyskilde;

  /**
   * @var integer
   *
   * @ORM\Column(name="nyLyskildeStkArmatur", type="integer")
   */
  private $nyLyskildeStkArmatur;

  /**
   * @var integer
   *
   * @ORM\Column(name="nyLyskildeWLyskilde", type="integer")
   */
  private $nyLyskildeWLyskilde;

  /**
   * @var integer
   *
   * @ORM\Column(name="nyForkoblingStkArmatur", type="integer")
   */
  private $nyForkoblingStkArmatur;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="nyArmatureffektWStk", type="float")
   */
  private $nyArmatureffektWStk;

  /**
   * @var integer
   *
   * @ORM\Column(name="nyeArmaturerStkLokale", type="integer")
   */
  private $nyeArmaturerStkLokale;

  /**
   * @var float
   *
   * @ORM\Column(name="nyttiggjortVarmeAfElBesparelse", type="decimal", scale=4)
   */
  private $nyttiggjortVarmeAfElBesparelse;

  /**
   * @var float
   *
   * @ORM\Column(name="prisfaktor", type="decimal", scale=4)
   */
  private $prisfaktor;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="prisfaktorTillaegKrLokale", type="float")
   */
  private $prisfaktorTillaegKrLokale;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="investeringAlleLokalerKr", type="float")
   */
  private $investeringAlleLokalerKr;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="nytElforbrugWM2", type="float")
   */
  private $nytElforbrugWM2;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="driftsbesparelseTilLyskilderKrAar", type="float")
   */
  private $driftsbesparelseTilLyskilderKrAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="simpelTilbagebetalingstidAar", type="float")
   */
  private $simpelTilbagebetalingstidAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="vaegtetLevetidAar", type="float")
   */
  private $vaegtetLevetidAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="nutidsvaerdiSetOver15AarKr", type="float")
   */
  private $nutidsvaerdiSetOver15AarKr;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="kWhBesparelseEl", type="float")
   */
  private $kWhBesparelseEl;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="kWhBesparelseVarmeFraVarmevaerket", type="float")
   */
  private $kWhBesparelseVarmeFraVarmevaerket;

  /**
   * Set lokale_navn
   *
   * @param string $lokaleNavn
   * @return BelysningTiltagDetail
   */
  public function setLokaleNavn($lokaleNavn) {
    $this->lokale_navn = $lokaleNavn;

    return $this;
  }

  /**
   * Get lokale_navn
   *
   * @return string
   */
  public function getLokaleNavn() {
    return $this->lokale_navn;
  }

  /**
   * Set lokale_type
   *
   * @param string $lokaleType
   * @return BelysningTiltagDetail
   */
  public function setLokaleType($lokaleType) {
    $this->lokale_type = $lokaleType;

    return $this;
  }

  /**
   * Get lokale_type
   *
   * @return string
   */
  public function getLokaleType() {
    return $this->lokale_type;
  }

  /**
   * Set armaturhoejdeM.
   *
   * @param float $armaturhoejdeM
   * @return BelysningTiltagDetail
   */
  public function setArmaturhoejdeM($armaturhoejdeM) {
    $this->armaturhoejdeM = $armaturhoejdeM;

    return $this;
  }

  /**
   * Get armaturhoejdeM
   *
   * @return float
   */
  public function getArmaturhoejdeM() {
    return $this->armaturhoejdeM;
  }

  /**
   * Set rumstoerrelseM2
   *
   * @param float $rumstoerrelseM2
   * @return BelysningTiltagDetail
   */
  public function setRumstoerrelseM2($rumstoerrelseM2) {
    $this->rumstoerrelseM2 = $rumstoerrelseM2;

    return $this;
  }

  /**
   * Get rumstoerrelseM2
   *
   * @return float
   */
  public function getRumstoerrelseM2() {
    return $this->rumstoerrelseM2;
  }

  /**
   * Set lokale_antal
   *
   * @param integer $lokaleAntal
   * @return BelysningTiltagDetail
   */
  public function setLokaleAntal($lokaleAntal) {
    $this->lokale_antal = $lokaleAntal;

    return $this;
  }

  /**
   * Get lokale_antal
   *
   * @return integer
   */
  public function getLokaleAntal() {
    return $this->lokale_antal;
  }

  /**
   * Set drifttidTAar
   *
   * @param string $drifttidTAar
   * @return BelysningTiltagDetail
   */
  public function setDrifttidTAar($drifttidTAar) {
    $this->drifttidTAar = $drifttidTAar;

    return $this;
  }

  /**
   * Get drifttidTAar
   *
   * @return float
   */
  public function getDrifttidTAar() {
    return $this->drifttidTAar;
  }

  /**
   * Set lyskilde
   *
   * @param BelysningTiltagDetailLyskilde $lyskilde
   * @return BelysningTiltagDetail
   */
  public function setLyskilde(BelysningTiltagDetailLyskilde $lyskilde) {
    $this->lyskilde = $lyskilde;
    $this->addData('lyskilde', $lyskilde);

    return $this;
  }

  /**
   * Get lyskilde.
   *
   * @param bool $useCached
   *   If set, then that cached value is returned. Otherwise the current value is returned.
   *
   * @return BelysningTiltagDetailLyskilde
   */
  public function getLyskilde($useCached = false) {
    return $useCached ? $this->getData('lyskilde') : $this->lyskilde;
  }

  /**
   * Set lyskildeStkArmatur
   *
   * @param integer $lyskildeStkArmatur
   * @return BelysningTiltagDetail
   */
  public function setLyskildeStkArmatur($lyskildeStkArmatur) {
    $this->lyskildeStkArmatur = $lyskildeStkArmatur;

    return $this;
  }

  /**
   * Get lyskildeStkArmatur
   *
   * @return integer
   */
  public function getLyskildeStkArmatur() {
    return $this->lyskildeStkArmatur;
  }

  /**
   * Set lyskildeWLyskilde
   *
   * @param integer $lyskildeWLyskilde
   * @return BelysningTiltagDetail
   */
  public function setLyskildeWLyskilde($lyskildeWLyskilde) {
    $this->lyskildeWLyskilde = $lyskildeWLyskilde;

    return $this;
  }

  /**
   * Get lyskildeWLyskilde
   *
   * @return integer
   */
  public function getLyskildeWLyskilde() {
    return $this->lyskildeWLyskilde;
  }

  /**
   * Set forkoblingStkArmatur
   *
   * @param integer $forkoblingStkArmatur
   * @return BelysningTiltagDetail
   */
  public function setForkoblingStkArmatur($forkoblingStkArmatur) {
    $this->forkoblingStkArmatur = $forkoblingStkArmatur;

    return $this;
  }

  /**
   * Get forkoblingStkArmatur
   *
   * @return integer
   */
  public function getForkoblingStkArmatur() {
    return $this->forkoblingStkArmatur;
  }

  /**
   * Set armaturerStkLokale
   *
   * @param integer $armaturerStkLokale
   * @return BelysningTiltagDetail
   */
  public function setArmaturerStkLokale($armaturerStkLokale) {
    $this->armaturerStkLokale = $armaturerStkLokale;

    return $this;
  }

  /**
   * Get armaturerStkLokale
   *
   * @return integer
   */
  public function getArmaturerStkLokale() {
    return $this->armaturerStkLokale;
  }

  /**
   * Get elforbrugWM2
   *
   * @return float
   */
  public function getElforbrugWM2() {
    return $this->elforbrugWM2;
  }

  /**
   * Set placeringId
   *
   * @param string $placeringId
   * @return BelysningTiltagDetail
   */
  public function setPlaceringId($placeringId) {
    $this->placeringId = $placeringId;

    return $this;
  }

  /**
   * Get placeringId
   *
   * @return string
   */
  public function getPlaceringId() {
    return $this->placeringId;
  }

  // /**
  //  * Get placering
  //  *
  //  * @return BelysningTiltagDetailPlacering
  //  */
  // public function getPlacering() {
  // }

  /**
   * Set styring
   *
   * @param string $styringId
   * @return BelysningTiltagDetail
   */
  public function setStyringId($styringId) {
    $this->styringId = $styringId;

    return $this;
  }

  /**
   * Get styringId
   *
   * @return string
   */
  public function getStyringId() {
    return $this->styringId;
  }

  /**
   * Get styring
   *
   * @return BelysningTiltagDetailStyring
   */
  public function getStyring() {
  }

  /**
   * Set noter
   *
   * @param string $noter
   * @return BelysningTiltagDetail
   */
  public function setNoter($noter) {
    $this->noter = $noter;

    return $this;
  }

  /**
   * Get noter
   *
   * @return string
   */
  public function getNoter() {
    return $this->noter;
  }

  /**
   * Set tiltag
   *
   * @param string $belysningstiltagId
   * @return BelysningTiltagDetail
   */
  public function setBelysningstiltagId($belysningstiltagId) {
    $this->belysningstiltagId = $belysningstiltagId;

    return $this;
  }

  /**
   * Get belysningtiltagId
   *
   * @return string
   */
  public function getBelysningstiltagId() {
    return $this->belysningstiltagId;
  }

  /**
   * Get belysningtiltag
   *
   * @return BelysningTiltagDetailTiltag
   */
  public function getBelysningstiltag() {
  }

  /**
   * Set nyeSensorerStkLokale
   *
   * @param integer $nyeSensorerStkLokale
   * @return BelysningTiltagDetail
   */
  public function setNyeSensorerStkLokale($nyeSensorerStkLokale) {
    $this->nyeSensorerStkLokale = $nyeSensorerStkLokale;

    return $this;
  }

  /**
   * Get nyeSensorerStkLokale
   *
   * @return integer
   */
  public function getNyeSensorerStkLokale() {
    return $this->nyeSensorerStkLokale;
  }

  /**
   * Set standardinvestSensorKrStk
   *
   * @param string $standardinvestSensorKrStk
   * @return BelysningTiltagDetail
   */
  public function setStandardinvestSensorKrStk($standardinvestSensorKrStk) {
    $this->standardinvestSensorKrStk = $standardinvestSensorKrStk;

    return $this;
  }

  /**
   * Get standardinvestSensorKrStk
   *
   * @return float
   */
  public function getStandardinvestSensorKrStk() {
    return $this->standardinvestSensorKrStk;
  }

  /**
   * Set reduktionAfDrifttid
   *
   * @param string $reduktionAfDrifttid
   * @return BelysningTiltagDetail
   */
  public function setReduktionAfDrifttid($reduktionAfDrifttid) {
    $this->reduktionAfDrifttid = $reduktionAfDrifttid;

    return $this;
  }

  /**
   * Get reduktionAfDrifttid
   *
   * @return float
   */
  public function getReduktionAfDrifttid() {
    return $this->reduktionAfDrifttid;
  }

  /**
   * Get nyDriftstid
   *
   * @return float
   */
  public function getNyDriftstid() {
    return $this->nyDriftstid;
  }

  /**
   * Set standardinvestArmaturElLyskildeKrStk
   *
   * @param string $standardinvestArmaturElLyskildeKrStk
   * @return BelysningTiltagDetail
   */
  public function setStandardinvestArmaturElLyskildeKrStk($standardinvestArmaturElLyskildeKrStk) {
    $this->standardinvestArmaturElLyskildeKrStk = $standardinvestArmaturElLyskildeKrStk;

    return $this;
  }

  /**
   * Get standardinvestArmaturElLyskildeKrStk
   *
   * @return float
   */
  public function getStandardinvestArmaturElLyskildeKrStk() {
    return $this->standardinvestArmaturElLyskildeKrStk;
  }

  /**
   * Set standardinvestLyskildeKrStk
   *
   * @param string $standardinvestLyskildeKrStk
   * @return BelysningTiltagDetail
   */
  public function setStandardinvestLyskildeKrStk($standardinvestLyskildeKrStk) {
    $this->standardinvestLyskildeKrStk = $standardinvestLyskildeKrStk;

    return $this;
  }

  /**
   * Get standardinvestLyskildeKrStk
   *
   * @return float
   */
  public function getStandardinvestLyskildeKrStk() {
    return $this->standardinvestLyskildeKrStk;
  }

  /**
   * Set nyLyskilde
   *
   * @param BelysningTiltagDetailLyskilde $nyLyskilde
   * @return BelysningTiltagDetail
   */
  public function setNyLyskilde($nyLyskilde) {
    $this->nyLyskilde = $nyLyskilde;
    $this->addData('nyLyskilde', $nyLyskilde);

    return $this;
  }

  /**
   * Get nyLyskilde.
   *
   * @see getLyskilde()
   *
   * @param bool $useCached
   * @return BelysningTiltagDetailLyskilde
   */
  public function getNyLyskilde($useCached = false) {
    return $useCached ? $this->getData('nyLyskilde') : $this->nyLyskilde;
  }

  /**
   * Set nyLyskildeStkArmatur
   *
   * @param integer $nyLyskildeStkArmatur
   * @return BelysningTiltagDetail
   */
  public function setNyLyskildeStkArmatur($nyLyskildeStkArmatur) {
    $this->nyLyskildeStkArmatur = $nyLyskildeStkArmatur;

    return $this;
  }

  /**
   * Get nyLyskildeStkArmatur
   *
   * @return integer
   */
  public function getNyLyskildeStkArmatur() {
    return $this->nyLyskildeStkArmatur;
  }

  /**
   * Set nyLyskildeWLyskilde
   *
   * @param integer $nyLyskildeWLyskilde
   * @return BelysningTiltagDetail
   */
  public function setNyLyskildeWLyskilde($nyLyskildeWLyskilde) {
    $this->nyLyskildeWLyskilde = $nyLyskildeWLyskilde;

    return $this;
  }

  /**
   * Get nyLyskildeWLyskilde
   *
   * @return integer
   */
  public function getNyLyskildeWLyskilde() {
    return $this->nyLyskildeWLyskilde;
  }

  /**
   * Set nyForkoblingStkArmatur
   *
   * @param integer $nyForkoblingStkArmatur
   * @return BelysningTiltagDetail
   */
  public function setNyForkoblingStkArmatur($nyForkoblingStkArmatur) {
    $this->nyForkoblingStkArmatur = $nyForkoblingStkArmatur;

    return $this;
  }

  /**
   * Get nyForkoblingStkArmatur
   *
   * @return integer
   */
  public function getNyForkoblingStkArmatur() {
    return $this->nyForkoblingStkArmatur;
  }

  /**
   * Get nyArmatureffektWStk
   *
   * @return float
   */
  public function getNyArmatureffektWStk() {
    return $this->nyArmatureffektWStk;
  }

  /**
   * Set nyeArmaturerStkLokale
   *
   * @param integer $nyeArmaturerStkLokale
   * @return BelysningTiltagDetail
   */
  public function setNyeArmaturerStkLokale($nyeArmaturerStkLokale) {
    $this->nyeArmaturerStkLokale = $nyeArmaturerStkLokale;

    return $this;
  }

  /**
   * Get nyeArmaturerStkLokale
   *
   * @return integer
   */
  public function getNyeArmaturerStkLokale() {
    return $this->nyeArmaturerStkLokale;
  }

  /**
   * Set nyttiggjortVarmeAfElBesparelse
   *
   * @param string $nyttiggjortVarmeAfElBesparelse
   * @return BelysningTiltagDetail
   */
  public function setNyttiggjortVarmeAfElBesparelse($nyttiggjortVarmeAfElBesparelse) {
    $this->nyttiggjortVarmeAfElBesparelse = $nyttiggjortVarmeAfElBesparelse;

    return $this;
  }

  /**
   * Get nyttiggjortVarmeAfElBesparelse
   *
   * @return float
   */
  public function getNyttiggjortVarmeAfElBesparelse() {
    return $this->nyttiggjortVarmeAfElBesparelse;
  }

  /**
   * Set prisfaktor
   *
   * @param string $prisfaktor
   * @return BelysningTiltagDetail
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
   * Get prisfaktorTillaegKrLokale
   *
   * @return float
   */
  public function getPrisfaktorTillaegKrLokale() {
    return $this->prisfaktorTillaegKrLokale;
  }

  /**
   * Get investeringAlleLokalerKr
   *
   * @return float
   */
  public function getInvesteringAlleLokalerKr() {
    return $this->investeringAlleLokalerKr;
  }

  /**
   * Get nytElforbrugWM2
   *
   * @return float
   */
  public function getNytElforbrugWM2() {
    return $this->nytElforbrugWM2;
  }

  /**
   * Get driftsbesparelseTilLyskilderKrAar
   *
   * @return float
   */
  public function getDriftsbesparelseTilLyskilderKrAar() {
    return $this->driftsbesparelseTilLyskilderKrAar;
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
   * Get vaegtetLevetidAar
   *
   * @return float
   */
  public function getVaegtetLevetidAar() {
    return $this->vaegtetLevetidAar;
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
   * Get kWhBesparelseEl
   *
   * @return float
   */
  public function getKwhBesparelseEl() {
    return $this->kWhBesparelseEl;
  }

  /**
   * Get kWhBesparelseVarmeFraVarmevaerket
   *
   * @return float
   */
  public function getKwhBesparelseVarmeFraVarmevaerket() {
    return $this->kWhBesparelseVarmeFraVarmevaerket;
  }

  public function calculate() {
    $this->elforbrugWM2 = $this->calculateElforbrugWM2();
    $this->nyDriftstid = $this->calculateNyDriftstid();
    $this->nyArmatureffektWStk = $this->calculateNyArmatureffektWStk();
    $this->prisfaktorTillaegKrLokale = $this->calculatePrisfaktorTillaegKrLokale();
    $this->investeringAlleLokalerKr = $this->calculateInvesteringAlleLokalerKr();
    $this->nytElforbrugWM2 = $this->calculateNytElforbrugWM2();
    $this->driftsbesparelseTilLyskilderKrAar = $this->calculateDriftsbesparelseTilLyskilderKrAar();
    $this->kWhBesparelseEl = $this->calculateKwhBesparelseEl();
    $this->kWhBesparelseVarmeFraVarmevaerket = $this->calculateKwhBesparelseVarmeFraVarmevaerket();
    $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
    $this->vaegtetLevetidAar = $this->calculateVaegtetLevetidAar();
    $this->nutidsvaerdiSetOver15AarKr = $this->calculateNutidsvaerdiSetOver15AarKr();
    parent::calculate();
  }

  private function calculateElforbrugWM2() {
    // AC
    $armaturEffekt = $this->_computeArmaturEffekt($this->getLyskilde(true));

    if ($this->rumstoerrelseM2 == 0 || $armaturEffekt == 0 || $this->armaturerStkLokale == 0) {
      return 0;
    }
    else {
      return $armaturEffekt * $this->armaturerStkLokale / $this->rumstoerrelseM2;
    }
  }

  private function calculateNyDriftstid() {
    // AN
    if ($this->drifttidTAar == 0 || $this->belysningstiltagId == null) {
      return 0;
    }
    else {
      return $this->drifttidTAar - $this->reduktionAfDrifttid * $this->drifttidTAar;
    }
  }

  private function calculateNyArmatureffektWStk() {
    // AW
    return $this->__computeArmaturEffekt($this->getNyLyskilde(true), $this->nyLyskildeStkArmatur, $this->nyLyskildeWLyskilde, $this->nyForkoblingStkArmatur);
  }

  private function calculatePrisfaktorTillaegKrLokale() {
    // BA
    if ($this->prisfaktor == 0) {
      return 0;
    }
    else {
      return ($this->nyeSensorerStkLokale * $this->standardinvestSensorKrStk
              + $this->standardinvestArmaturElLyskildeKrStk * $this->nyeArmaturerStkLokale
              + $this->standardinvestLyskildeKrStk * $this->nyLyskildeStkArmatur)
        * ($this->prisfaktor - 1);
    }
  }

  private function calculateInvesteringAlleLokalerKr() {
    // BB
    $nyLyskilde = $this->getNyLyskilde(true);
    if (!$nyLyskilde) {
      return 0;
    }
    elseif ($nyLyskilde->getId() == 12) { // !!!
      return ($this->nyeSensorerStkLokale * $this->standardinvestSensorKrStk
              + $this->standardinvestArmaturElLyskildeKrStk * $this->nyeArmaturerStkLokale * $this->nyLyskildeStkArmatur
              + $this->prisfaktorTillaegKrLokale) * $this->lokale_antal;
    }
    else {
      return ($this->nyeSensorerStkLokale * $this->standardinvestSensorKrStk
              + $this->standardinvestArmaturElLyskildeKrStk * $this->nyeArmaturerStkLokale
              + $this->standardinvestLyskildeKrStk * $this->nyLyskildeStkArmatur * $this->nyeArmaturerStkLokale
              + $this->prisfaktorTillaegKrLokale) * $this->lokale_antal;
    }
  }

  private function calculateNytElforbrugWM2() {
    // BD
    if ($this->rumstoerrelseM2 == 0) {
      return 0;
    }
    else {
      if ($this->nyArmatureffektWStk == 0) {
        return $this->elforbrugWM2;
      }
      else {
        return $this->nyArmatureffektWStk * $this->nyeArmaturerStkLokale / $this->rumstoerrelseM2;
      }
    }
  }

  private function calculateDriftsbesparelseTilLyskilderKrAar() {
    // BK
    $lyskilde = $this->getLyskilde(true);
    $nyLyskilde = $this->getNyLyskilde(true);

    if (!$lyskilde || $lyskilde->getLevetid() == 0 || !$nyLyskilde || $nyLyskilde->getLevetid() == 0) {
      return 0;
    }
    else {
      return ($this->lyskildeStkArmatur * $this->armaturerStkLokale * $lyskilde->getUdgift() * $this->drifttidTAar / $lyskilde->getLevetid()
              - $this->nyLyskildeStkArmatur * $this->nyeArmaturerStkLokale * $nyLyskilde->getUdgift() * $this->nyDriftstid / $nyLyskilde->getLevetid())
        * $this->lokale_antal;
    }
  }

  private function calculateKwhBesparelseEl() {
    // BT
    $elbesparelse = $this->_computeElbesparelseAlleLokaler();
    $varmebesparelse = $this->_computeVarmebesparelseAlleLokaler();

    if ($elbesparelse == 0 && $varmebesparelse == 0) {
      return 0;
    }
    elseif ($this->getRapport()->isStandardforsyning()) {
      return $elbesparelse;
    }
    else {
      return $this->fordelbesparelse($varmebesparelse, $this->tiltag->getForsyningVarme(), 'EL') + $elbesparelse;
    }
  }

  private function _computeElbesparelseAlleLokaler() {
    // BE
    $computeElforbrugPrLokale = function() {
      // AB
      $armaturEffekt = $this->_computeArmaturEffekt($this->getLyskilde(true));
      if ($armaturEffekt == 0 || $this->armaturerStkLokale == 0) {
        return 0;
      }
      else {
        return $armaturEffekt * $this->drifttidTAar * $this->armaturerStkLokale / 1000;
      }
    };

    $computeNytElforbrugPrLokale = function() {
      // BC
      if ($this->nyDriftstid == 0) {
        return 0;
      }
      elseif ($this->nyArmatureffektWStk == 0) {
        $armaturEffekt = $this->_computeArmaturEffekt($this->getLyskilde(true));
        return $armaturEffekt * $this->nyDriftstid * $this->armaturerStkLokale / 1000;
      }
      else {
        return $this->nyArmatureffektWStk * $this->nyDriftstid * $this->nyeArmaturerStkLokale / 1000;
      }
    };

    $elforbrug = $computeElforbrugPrLokale();
    $nytElforbrug = $computeNytElforbrugPrLokale();

    if ($elforbrug == 0 || $nytElforbrug == 0 || $this->lokale_antal == 0) {
      return 0;
    }
    else {
      return ($elforbrug - $nytElforbrug) * $this->lokale_antal;
    }
  }

  private function _computeVarmebesparelseAlleLokaler() {
    // BF
    $elbesparelse = $this->_computeElbesparelseAlleLokaler();
    if ($elbesparelse == 0) {
      return 0;
    }
    else {
      return $elbesparelse * -$this->nyttiggjortVarmeAfElBesparelse;
    }
  }

  private function calculateKwhBesparelseVarmeFraVarmevaerket() {
    // BU
    $varmebesparelse = $this->_computeVarmebesparelseAlleLokaler();
    if ($varmebesparelse == 0) {
      return 0;
    }
    elseif ($this->getRapport()->isStandardforsyning()) {
      return $varmebesparelse;
    }
    else {
      return $this->fordelbesparelse($varmebesparelse, $this->tiltag->getForsyningVarme(), 'VARME');
    }
  }

  private function calculateSimpelTilbagebetalingstidAar() {
    // BL
    if ($this->investeringAlleLokalerKr == 0) {
      return 0;
    }
    else {
      return $this->investeringAlleLokalerKr / ($this->kWhBesparelseEl * $this->getRapport()->getElKrKWh() + $this->kWhBesparelseVarmeFraVarmevaerket * $this->getRapport()->getVarmeKrKWh() + $this->driftsbesparelseTilLyskilderKrAar);
    }
  }

  private function calculateVaegtetLevetidAar() {
    // BM
    if ($this->investeringAlleLokalerKr == 0) {
      return 0;
    }
    elseif ($this->nyLyskilde == null) {
      return 10;
    }
    else {
      $udgiftSensorer = $this->_computeUdgiftSensorer();
      $levetidSensor = $this->_computeLevetidSensor();
      $udgiftArmatur = $this->_computeUdgiftArmatur();
      $levetidArmatur = $this->_computeLevetidArmatur();
      $udgiftLyskilde = $this->_computeUdgiftLyskilde();
      $levetidLyskilde = $this->_computeLevetidLyskilde();

      $denominator = $udgiftSensorer + $udgiftArmatur + $udgiftLyskilde;
      return $denominator == 0 ? 0 : ($udgiftSensorer * $levetidSensor + $udgiftArmatur * $levetidArmatur + $udgiftLyskilde * $levetidLyskilde) / $denominator;
    }
  }

  private function _computeUdgiftSensorer() {
    // BN
    if ($this->nyeSensorerStkLokale == 0) {
      return 0;
    }
    else {
      return $this->nyeSensorerStkLokale * $this->standardinvestSensorKrStk * $this->prisfaktor * $this->lokale_antal;
    }
  }

  private function _computeLevetidSensor() {
    return 10;
  }

  private function _computeUdgiftArmatur() {
    // BO
    if ($this->standardinvestArmaturElLyskildeKrStk == 0) {
      return 0;
    }
    else {
      return $this->standardinvestArmaturElLyskildeKrStk * $this->nyeArmaturerStkLokale * $this->lokale_antal * $this->prisfaktor;
    }
  }

  private function _computeUdgiftLyskilde() {
    // BP
    if ($this->standardinvestLyskildeKrStk == 0) {
      return 0;
    }
    else {
      return $this->standardinvestLyskildeKrStk * $this->nyLyskildeStkArmatur * $this->prisfaktor;
    }
  }

  private function _computeLevetidArmatur() {
    // BQ
    $nyLyskilde = $this->getNyLyskilde(true);
    $levetid = $nyLyskilde ? $nyLyskilde->getLevetid() : 0;

    if ($levetid == 0 || $this->nyDriftstid == 0) {
      return 0;
    }
    else {
      return min(25, $levetid / $this->nyDriftstid);
    }
  }

  private function _computeLevetidLyskilde() {
    // BR
    return $this->_computeLevetidArmatur();
  }

  private function calculateNutidsvaerdiSetOver15AarKr() {
    // BU
    $faktorForReinvestering = $this->_computeFaktorForReinvestering();
    if ($this->vaegtetLevetidAar == 0 || $faktorForReinvestering == 0) {
      return 0;
    }
    elseif ($this->getNyLyskilde(true) == null) {
      return $this->nvPTO2($this->investeringAlleLokalerKr, $this->kWhBesparelseVarmeFraVarmevaerket, $this->kWhBesparelseEl, 0, 0, 0, round($this->vaegtetLevetidAar), $faktorForReinvestering, 0);
    }
    else {
      return $this->nvPTO2($this->investeringAlleLokalerKr, $this->kWhBesparelseVarmeFraVarmevaerket, $this->kWhBesparelseEl, 0, $this->driftsbesparelseTilLyskilderKrAar, 0, round($this->vaegtetLevetidAar), $faktorForReinvestering, 0);
    }
  }

  private function _computeFaktorForReinvestering() {
    return 1;
  }

  private function _computeArmaturEffekt() {
    return $this->__computeArmaturEffekt($this->getLyskilde(true), $this->lyskildeStkArmatur, $this->lyskildeWLyskilde, $this->forkoblingStkArmatur);
  }

  private function __computeArmaturEffekt(BelysningTiltagDetailLyskilde $lyskilde, $lyskildeStkArmatur, $lyskildeWLyskilde, $forkoblingStkArmatur) {
    // Z, AW
    if (!$lyskilde || $lyskildeStkArmatur == 0 || $lyskildeWLyskilde == 0) {
      return 0;
    }
    else {
      switch ($lyskilde->getType()) {
        case 'LED-rør':
        case 'LEDpære':
          return ($lyskildeWLyskilde) * $lyskildeStkArmatur;

        case 'Hal.':
        case 'Gl':
        case 'Sp.':
        case 'LED-arm.':
          return $lyskildeWLyskilde * $lyskildeStkArmatur;

        case 'Kom. K':
          return $lyskildeStkArmatur * $lyskildeWLyskilde * 1.1817 + 2.44275 + (1.2794 * ($lyskildeStkArmatur - 1)) * 0.9432;

        case 'Hal.': // !!!
          return 1.0832 * $lyskildeWLyskilde + 0.192;

        default:
          switch ($lyskilde->getForkobling()) {
            case 'konv.':
              if ($lyskildeWLyskilde < 14.99) {
                return 8.5 * $forkoblingStkArmatur + $lyskildeStkArmatur * $lyskildeWLyskilde;
              }
              elseif ($lyskildeWLyskilde < 35.99) {
                return 10 * $forkoblingStkArmatur + $lyskildeStkArmatur * $lyskildeWLyskilde;
              }
              else {
                return 12 * $forkoblingStkArmatur + $lyskildeStkArmatur * $lyskildeWLyskilde;
              }
            case 'hf':
              return $forkoblingStkArmatur * 2 + $lyskildeWLyskilde * $lyskildeStkArmatur;
            default:
              return null;
          }
      }
    }
  }

}
