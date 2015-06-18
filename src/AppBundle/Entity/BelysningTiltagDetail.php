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
   * @ORM\Column(name="armaturhoejde_m", type="decimal", scale=2)
   */
  private $armaturhoejde_m;

  /**
   * @var float
   *
   * @ORM\Column(name="rumstoerrelse_m2", type="decimal", scale=2)
   */
  private $rumstoerrelse_m2;

  /**
   * @var integer
   *
   * @ORM\Column(name="lokale_antal", type="integer")
   */
  private $lokale_antal;

  /**
   * @var string
   *
   * @ORM\Column(name="drifttid_t_aar", type="integer")
   */
  private $drifttid_t_aar;

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
   * @ORM\Column(name="lyskilde_stk_armatur", type="integer")
   */
  private $lyskilde_stk_armatur;

  /**
   * @var integer
   *
   * @ORM\Column(name="lyskilde_w_lyskilde", type="integer")
   */
  private $lyskilde_w_lyskilde;

  /**
   * @var integer
   *
   * @ORM\Column(name="forkobling_stk_armatur", type="integer")
   */
  private $forkobling_stk_armatur;

  /**
   * @var integer
   *
   * @ORM\Column(name="armaturer_stk_lokale", type="integer")
   */
  private $armaturer_stk_lokale;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="elforbrug_w_m2", type="float")
   */
  private $elforbrug_w_m2;

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
   * @ORM\Column(name="nye_sensorer_stk_lokale", type="integer")
   */
  private $nye_sensorer_stk_lokale;

  /**
   * @var float
   *
   * @ORM\Column(name="standardinvest_sensor_kr_stk", type="decimal", scale=2)
   */
  private $standardinvest_sensor_kr_stk;

  /**
   * @var float
   *
   * @ORM\Column(name="reduktion_af_drifttid", type="decimal", scale=2)
   */
  private $reduktion_af_drifttid;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="ny_driftstid", type="float")
   */
  private $ny_driftstid;

  /**
   * @var float
   *
   * @ORM\Column(name="standardinvest_armatur_el_lyskilde_kr_stk", type="decimal", scale=2)
   */
  private $standardinvest_armatur_el_lyskilde_kr_stk;

  /**
   * @var float
   *
   * @ORM\Column(name="standardinvest_lyskilde_kr_stk", type="decimal", scale=2)
   */
  private $standardinvest_lyskilde_kr_stk;

  /**
   * @var BelysningTiltagDetailLyskilde
   *
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BelysningTiltagDetail\Lyskilde")
   * ORM\JoinColumn(name="lyskilde_id", referencedColumnName="id")
   */
  private $ny_lyskilde;

  /**
   * @var integer
   *
   * @ORM\Column(name="ny_lyskilde_stk_armatur", type="integer")
   */
  private $ny_lyskilde_stk_armatur;

  /**
   * @var integer
   *
   * @ORM\Column(name="ny_lyskilde_w_lyskilde", type="integer")
   */
  private $ny_lyskilde_w_lyskilde;

  /**
   * @var integer
   *
   * @ORM\Column(name="ny_forkobling_stk_armatur", type="integer")
   */
  private $ny_forkobling_stk_armatur;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="ny_armatureffekt_w_stk", type="float")
   */
  private $ny_armatureffekt_w_stk;

  /**
   * @var integer
   *
   * @ORM\Column(name="nye_armaturer_stk_lokale", type="integer")
   */
  private $nye_armaturer_stk_lokale;

  /**
   * @var float
   *
   * @ORM\Column(name="nyttiggjort_varme_af_el_besparelse", type="decimal", scale=2)
   */
  private $nyttiggjort_varme_af_el_besparelse;

  /**
   * @var float
   *
   * @ORM\Column(name="prisfaktor", type="decimal", scale=2)
   */
  private $prisfaktor;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="prisfaktor_tillaeg_kr_lokale", type="float")
   */
  private $prisfaktor_tillaeg_kr_lokale;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="investering_alle_lokaler_kr", type="float")
   */
  private $investering_alle_lokaler_kr;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="nyt_elforbrug_w_m2", type="float")
   */
  private $nyt_elforbrug_w_m2;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="driftsbesparelse_til_lyskilder_kr_aar", type="float")
   */
  private $driftsbesparelse_til_lyskilder_kr_aar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="simpel_tilbagebetalingstid_aar", type="float")
   */
  private $simpel_tilbagebetalingstid_aar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="vaegtet_levetid_aar", type="float")
   */
  private $vaegtet_levetid_aar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="nutidsvaerdi_set_over_15_aar_kr", type="float")
   */
  private $nutidsvaerdi_set_over_15_aar_kr;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="kwh_besparelse_el", type="float")
   */
  private $kwh_besparelse_el;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="kwh_besparelse_varme_fra_varmevaerket", type="float")
   */
  private $kwh_besparelse_varme_fra_varmevaerket;

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
   * Set armaturhoejde_m.
   *
   * @param float $armaturhoejdeM
   * @return BelysningTiltagDetail
   */
  public function setArmaturhoejdeM($armaturhoejdeM) {
    $this->armaturhoejde_m = $armaturhoejdeM;

    return $this;
  }

  /**
   * Get armaturhoejde_m
   *
   * @return float
   */
  public function getArmaturhoejdeM() {
    return $this->armaturhoejde_m;
  }

  /**
   * Set rumstoerrelse_m2
   *
   * @param float $rumstoerrelseM2
   * @return BelysningTiltagDetail
   */
  public function setRumstoerrelseM2($rumstoerrelseM2) {
    $this->rumstoerrelse_m2 = $rumstoerrelseM2;

    return $this;
  }

  /**
   * Get rumstoerrelse_m2
   *
   * @return float
   */
  public function getRumstoerrelseM2() {
    return $this->rumstoerrelse_m2;
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
   * Set drifttid_t_aar
   *
   * @param string $drifttidTAar
   * @return BelysningTiltagDetail
   */
  public function setDrifttidTAar($drifttidTAar) {
    $this->drifttid_t_aar = $drifttidTAar;

    return $this;
  }

  /**
   * Get drifttid_t_aar
   *
   * @return float
   */
  public function getDrifttidTAar() {
    return $this->drifttid_t_aar;
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
   * Set lyskilde_stk_armatur
   *
   * @param integer $lyskildeStkArmatur
   * @return BelysningTiltagDetail
   */
  public function setLyskildeStkArmatur($lyskildeStkArmatur) {
    $this->lyskilde_stk_armatur = $lyskildeStkArmatur;

    return $this;
  }

  /**
   * Get lyskilde_stk_armatur
   *
   * @return integer
   */
  public function getLyskildeStkArmatur() {
    return $this->lyskilde_stk_armatur;
  }

  /**
   * Set lyskilde_w_lyskilde
   *
   * @param integer $lyskildeWLyskilde
   * @return BelysningTiltagDetail
   */
  public function setLyskildeWLyskilde($lyskildeWLyskilde) {
    $this->lyskilde_w_lyskilde = $lyskildeWLyskilde;

    return $this;
  }

  /**
   * Get lyskilde_w_lyskilde
   *
   * @return integer
   */
  public function getLyskildeWLyskilde() {
    return $this->lyskilde_w_lyskilde;
  }

  /**
   * Set forkobling_stk_armatur
   *
   * @param integer $forkoblingStkArmatur
   * @return BelysningTiltagDetail
   */
  public function setForkoblingStkArmatur($forkoblingStkArmatur) {
    $this->forkobling_stk_armatur = $forkoblingStkArmatur;

    return $this;
  }

  /**
   * Get forkobling_stk_armatur
   *
   * @return integer
   */
  public function getForkoblingStkArmatur() {
    return $this->forkobling_stk_armatur;
  }

  /**
   * Set armaturer_stk_lokale
   *
   * @param integer $armaturerStkLokale
   * @return BelysningTiltagDetail
   */
  public function setArmaturerStkLokale($armaturerStkLokale) {
    $this->armaturer_stk_lokale = $armaturerStkLokale;

    return $this;
  }

  /**
   * Get armaturer_stk_lokale
   *
   * @return integer
   */
  public function getArmaturerStkLokale() {
    return $this->armaturer_stk_lokale;
  }

  /**
   * Get elforbrug_w_m2
   *
   * @return float
   */
  public function getElforbrugWM2() {
    return $this->elforbrug_w_m2;
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
   * Set nye_sensorer_stk_lokale
   *
   * @param integer $nyeSensorerStkLokale
   * @return BelysningTiltagDetail
   */
  public function setNyeSensorerStkLokale($nyeSensorerStkLokale) {
    $this->nye_sensorer_stk_lokale = $nyeSensorerStkLokale;

    return $this;
  }

  /**
   * Get nye_sensorer_stk_lokale
   *
   * @return integer
   */
  public function getNyeSensorerStkLokale() {
    return $this->nye_sensorer_stk_lokale;
  }

  /**
   * Set standardinvest_sensor_kr_stk
   *
   * @param string $standardinvestSensorKrStk
   * @return BelysningTiltagDetail
   */
  public function setStandardinvestSensorKrStk($standardinvestSensorKrStk) {
    $this->standardinvest_sensor_kr_stk = $standardinvestSensorKrStk;

    return $this;
  }

  /**
   * Get standardinvest_sensor_kr_stk
   *
   * @return float
   */
  public function getStandardinvestSensorKrStk() {
    return $this->standardinvest_sensor_kr_stk;
  }

  /**
   * Set reduktion_af_drifttid
   *
   * @param string $reduktionAfDrifttid
   * @return BelysningTiltagDetail
   */
  public function setReduktionAfDrifttid($reduktionAfDrifttid) {
    $this->reduktion_af_drifttid = $reduktionAfDrifttid;

    return $this;
  }

  /**
   * Get reduktion_af_drifttid
   *
   * @return float
   */
  public function getReduktionAfDrifttid() {
    return $this->reduktion_af_drifttid;
  }

  /**
   * Get ny_driftstid
   *
   * @return float
   */
  public function getNyDriftstid() {
    return $this->ny_driftstid;
  }

  /**
   * Set standardinvest_armatur_el_lyskilde_kr_stk
   *
   * @param string $standardinvestArmaturElLyskildeKrStk
   * @return BelysningTiltagDetail
   */
  public function setStandardinvestArmaturElLyskildeKrStk($standardinvestArmaturElLyskildeKrStk) {
    $this->standardinvest_armatur_el_lyskilde_kr_stk = $standardinvestArmaturElLyskildeKrStk;

    return $this;
  }

  /**
   * Get standardinvest_armatur_el_lyskilde_kr_stk
   *
   * @return float
   */
  public function getStandardinvestArmaturElLyskildeKrStk() {
    return $this->standardinvest_armatur_el_lyskilde_kr_stk;
  }

  /**
   * Set standardinvest_lyskilde_kr_stk
   *
   * @param string $standardinvestLyskildeKrStk
   * @return BelysningTiltagDetail
   */
  public function setStandardinvestLyskildeKrStk($standardinvestLyskildeKrStk) {
    $this->standardinvest_lyskilde_kr_stk = $standardinvestLyskildeKrStk;

    return $this;
  }

  /**
   * Get standardinvest_lyskilde_kr_stk
   *
   * @return float
   */
  public function getStandardinvestLyskildeKrStk() {
    return $this->standardinvest_lyskilde_kr_stk;
  }

  /**
   * Set ny_lyskilde
   *
   * @param BelysningTiltagDetailLyskilde $nyLyskilde
   * @return BelysningTiltagDetail
   */
  public function setNyLyskilde($nyLyskilde) {
    $this->ny_lyskilde = $nyLyskilde;
    $this->addData('ny_lyskilde', $nyLyskilde);

    return $this;
  }

  /**
   * Get ny_lyskilde.
   *
   * @see getLyskilde()
   *
   * @param bool $useCached
   * @return BelysningTiltagDetailLyskilde
   */
  public function getNyLyskilde($useCached = false) {
    return $useCached ? $this->getData('ny_lyskilde') : $this->ny_lyskilde;
  }

  /**
   * Set ny_lyskilde_stk_armatur
   *
   * @param integer $nyLyskildeStkArmatur
   * @return BelysningTiltagDetail
   */
  public function setNyLyskildeStkArmatur($nyLyskildeStkArmatur) {
    $this->ny_lyskilde_stk_armatur = $nyLyskildeStkArmatur;

    return $this;
  }

  /**
   * Get ny_lyskilde_stk_armatur
   *
   * @return integer
   */
  public function getNyLyskildeStkArmatur() {
    return $this->ny_lyskilde_stk_armatur;
  }

  /**
   * Set ny_lyskilde_w_lyskilde
   *
   * @param integer $nyLyskildeWLyskilde
   * @return BelysningTiltagDetail
   */
  public function setNyLyskildeWLyskilde($nyLyskildeWLyskilde) {
    $this->ny_lyskilde_w_lyskilde = $nyLyskildeWLyskilde;

    return $this;
  }

  /**
   * Get ny_lyskilde_w_lyskilde
   *
   * @return integer
   */
  public function getNyLyskildeWLyskilde() {
    return $this->ny_lyskilde_w_lyskilde;
  }

  /**
   * Set ny_forkobling_stk_armatur
   *
   * @param integer $nyForkoblingStkArmatur
   * @return BelysningTiltagDetail
   */
  public function setNyForkoblingStkArmatur($nyForkoblingStkArmatur) {
    $this->ny_forkobling_stk_armatur = $nyForkoblingStkArmatur;

    return $this;
  }

  /**
   * Get ny_forkobling_stk_armatur
   *
   * @return integer
   */
  public function getNyForkoblingStkArmatur() {
    return $this->ny_forkobling_stk_armatur;
  }

  /**
   * Get ny_armatureffekt_w_stk
   *
   * @return float
   */
  public function getNyArmatureffektWStk() {
    return $this->ny_armatureffekt_w_stk;
  }

  /**
   * Set nye_armaturer_stk_lokale
   *
   * @param integer $nyeArmaturerStkLokale
   * @return BelysningTiltagDetail
   */
  public function setNyeArmaturerStkLokale($nyeArmaturerStkLokale) {
    $this->nye_armaturer_stk_lokale = $nyeArmaturerStkLokale;

    return $this;
  }

  /**
   * Get nye_armaturer_stk_lokale
   *
   * @return integer
   */
  public function getNyeArmaturerStkLokale() {
    return $this->nye_armaturer_stk_lokale;
  }

  /**
   * Set nyttiggjort_varme_af_el_besparelse
   *
   * @param string $nyttiggjortVarmeAfElBesparelse
   * @return BelysningTiltagDetail
   */
  public function setNyttiggjortVarmeAfElBesparelse($nyttiggjortVarmeAfElBesparelse) {
    $this->nyttiggjort_varme_af_el_besparelse = $nyttiggjortVarmeAfElBesparelse;

    return $this;
  }

  /**
   * Get nyttiggjort_varme_af_el_besparelse
   *
   * @return float
   */
  public function getNyttiggjortVarmeAfElBesparelse() {
    return $this->nyttiggjort_varme_af_el_besparelse;
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
   * Get prisfaktor_tillaeg_kr_lokale
   *
   * @return float
   */
  public function getPrisfaktorTillaegKrLokale() {
    return $this->prisfaktor_tillaeg_kr_lokale;
  }

  /**
   * Get investering_alle_lokaler_kr
   *
   * @return float
   */
  public function getInvesteringAlleLokalerKr() {
    return $this->investering_alle_lokaler_kr;
  }

  /**
   * Get nyt_elforbrug_w_m2
   *
   * @return float
   */
  public function getNytElforbrugWM2() {
    return $this->nyt_elforbrug_w_m2;
  }

  /**
   * Get driftsbesparelse_til_lyskilder_kr_aar
   *
   * @return float
   */
  public function getDriftsbesparelseTilLyskilderKrAar() {
    return $this->driftsbesparelse_til_lyskilder_kr_aar;
  }

  /**
   * Get simpel_tilbagebetalingstid_aar
   *
   * @return float
   */
  public function getSimpelTilbagebetalingstidAar() {
    return $this->simpel_tilbagebetalingstid_aar;
  }

  /**
   * Get vaegtet_levetid_aar
   *
   * @return float
   */
  public function getVaegtetLevetidAar() {
    return $this->vaegtet_levetid_aar;
  }

  /**
   * Get nutidsvaerdi_set_over_15_aar_kr
   *
   * @return float
   */
  public function getNutidsvaerdiSetOver15AarKr() {
    return $this->nutidsvaerdi_set_over_15_aar_kr;
  }

  /**
   * Get kwh_besparelse_el
   *
   * @return float
   */
  public function getKwhBesparelseEl() {
    return $this->kwh_besparelse_el;
  }

  /**
   * Get kwh_besparelse_varme_fra_varmevaerket
   *
   * @return float
   */
  public function getKwhBesparelseVarmeFraVarmevaerket() {
    return $this->kwh_besparelse_varme_fra_varmevaerket;
  }

  public function compute(\Symfony\Component\DependencyInjection\Container $container = NULL) {
    $this->elforbrug_w_m2 = $this->computeElforbrugWM2();
    $this->ny_driftstid = $this->computeNyDriftstid();
    $this->ny_armatureffekt_w_stk = $this->computeNyArmatureffektWStk();
    $this->prisfaktor_tillaeg_kr_lokale = $this->computePrisfaktorTillaegKrLokale();
    $this->investering_alle_lokaler_kr = $this->computeInvesteringAlleLokalerKr();
    $this->nyt_elforbrug_w_m2 = $this->computeNytElforbrugWM2();
    $this->driftsbesparelse_til_lyskilder_kr_aar = $this->computeDriftsbesparelseTilLyskilderKrAar();
    $this->kwh_besparelse_el = $this->computeKwhBesparelseEl();
    $this->kwh_besparelse_varme_fra_varmevaerket = $this->computeKwhBesparelseVarmeFraVarmevaerket();
    $this->simpel_tilbagebetalingstid_aar = $this->computeSimpelTilbagebetalingstidAar();
    $this->vaegtet_levetid_aar = $this->computeVaegtetLevetidAar();
    $this->nutidsvaerdi_set_over_15_aar_kr = $this->computeNutidsvaerdiSetOver15AarKr();
    parent::compute();
  }

  private function computeElforbrugWM2() {
    // AC
    $armaturEffekt = $this->_computeArmaturEffekt($this->getLyskilde(true));

    if ($this->rumstoerrelse_m2 == 0 || $armaturEffekt == 0 || $this->armaturer_stk_lokale == 0) {
      return 0;
    }
    else {
      return $armaturEffekt * $this->armaturer_stk_lokale / $this->rumstoerrelse_m2;
    }
  }

  private function computeNyDriftstid() {
    // AN
    if ($this->drifttid_t_aar == 0 || $this->belysningstiltagId == null) {
      return 0;
    }
    else {
      return $this->drifttid_t_aar - $this->reduktion_af_drifttid * $this->drifttid_t_aar;
    }
  }

  private function computeNyArmatureffektWStk() {
    // AW
    return $this->__computeArmaturEffekt($this->getNyLyskilde(true), $this->ny_lyskilde_stk_armatur, $this->ny_lyskilde_w_lyskilde, $this->ny_forkobling_stk_armatur);
  }

  private function computePrisfaktorTillaegKrLokale() {
    // BA
    if ($this->prisfaktor == 0) {
      return 0;
    }
    else {
      return ($this->nye_sensorer_stk_lokale * $this->standardinvest_sensor_kr_stk
              + $this->standardinvest_armatur_el_lyskilde_kr_stk * $this->nye_armaturer_stk_lokale
              + $this->standardinvest_lyskilde_kr_stk * $this->ny_lyskilde_stk_armatur)
        * ($this->prisfaktor - 1);
    }
  }

  private function computeInvesteringAlleLokalerKr() {
    // BB
    $nyLyskilde = $this->getNyLyskilde(true);
    if (!$nyLyskilde) {
      return 0;
    }
    elseif ($nyLyskilde->getId() == 12) { // !!!
      return (($this->nye_sensorer_stk_lokale * $this->standardinvest_sensor_kr_stk
               + $this->standardinvest_armatur_el_lyskilde_kr_stk * $this->nye_armaturer_stk_lokale * $this->ny_lyskilde_stk_armatur) + $this->prisfaktor_tillaeg_kr_lokale) * $this->lokale_antal;
    }
    else {
      return (($this->nye_sensorer_stk_lokale * $this->standardinvest_sensor_kr_stk
               + $this->nye_armaturer_stk_lokale * $this->standardinvest_armatur_el_lyskilde_kr_stk
               + $this->ny_lyskilde_stk_armatur * $this->standardinvest_lyskilde_kr_stk)
              + $this->prisfaktor_tillaeg_kr_lokale)
        * $this->lokale_antal;
    }
  }

  private function computeNytElforbrugWM2() {
    // BD
    if ($this->rumstoerrelse_m2 == 0) {
      return 0;
    }
    else {
      if ($this->ny_armatureffekt_w_stk == 0) {
        return $this->elforbrug_w_m2;
      }
      else {
        return $this->ny_armatureffekt_w_stk * $this->nye_armaturer_stk_lokale / $this->rumstoerrelse_m2;
      }
    }
  }

  private function computeDriftsbesparelseTilLyskilderKrAar() {
    // BK
    $lyskilde = $this->getLyskilde(true);
    $nyLyskilde = $this->getNyLyskilde(true);

    if (!$lyskilde || $lyskilde->getLevetid() == 0 || !$nyLyskilde || $nyLyskilde->getLevetid() == 0) {
      return 0;
    }
    else {
      return ($this->lyskilde_stk_armatur * $this->armaturer_stk_lokale * $lyskilde->getUdgift() * $this->drifttid_t_aar / $lyskilde->getLevetid()
              - $this->ny_lyskilde_stk_armatur * $this->nye_armaturer_stk_lokale * $nyLyskilde->getUdgift() * $this->ny_driftstid / $nyLyskilde->getLevetid())
        * $this->lokale_antal;
    }
  }

  private function computeKwhBesparelseEl() {
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
      if ($armaturEffekt == 0 || $this->armaturer_stk_lokale == 0) {
        return 0;
      }
      else {
        return $armaturEffekt * $this->drifttid_t_aar * $this->armaturer_stk_lokale / 1000;
      }
    };

    $computeNytElforbrugPrLokale = function() {
      // BC
      if ($this->ny_driftstid == 0) {
        return 0;
      }
      elseif ($this->ny_armatureffekt_w_stk == 0) {
        $armaturEffekt = $this->_computeArmaturEffekt($this->getLyskilde(true));
        return $armaturEffekt * $this->ny_driftstid * $this->armaturer_stk_lokale / 1000;
      }
      else {
        return $this->ny_armatureffekt_w_stk * $this->ny_driftstid * $this->nye_armaturer_stk_lokale / 1000;
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
      return $elbesparelse * -$this->nyttiggjort_varme_af_el_besparelse;
    }
  }

  private function computeKwhBesparelseVarmeFraVarmevaerket() {
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

  private function computeSimpelTilbagebetalingstidAar() {
    // BL
    if ($this->investering_alle_lokaler_kr == 0) {
      return 0;
    }
    else {
      return $this->investering_alle_lokaler_kr / ($this->kwh_besparelse_el * $this->getRapport()->getElKrKWh() + $this->kwh_besparelse_varme_fra_varmevaerket * $this->getRapport()->getVarmeKrKWh() + $this->driftsbesparelse_til_lyskilder_kr_aar);
    }
  }

  private function computeVaegtetLevetidAar() {
    // BM
    if ($this->investering_alle_lokaler_kr == 0) {
      return 0;
    }
    elseif ($this->ny_lyskilde == null) {
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
    if ($this->nye_sensorer_stk_lokale == 0) {
      return 0;
    }
    else {
      return $this->nye_sensorer_stk_lokale * $this->standardinvest_sensor_kr_stk * $this->prisfaktor * $this->lokale_antal;
    }
  }

  private function _computeLevetidSensor() {
    return 10;
  }

  private function _computeUdgiftArmatur() {
    // BO
    if ($this->standardinvest_armatur_el_lyskilde_kr_stk == 0) {
      return 0;
    }
    else {
      return $this->standardinvest_armatur_el_lyskilde_kr_stk * $this->nye_armaturer_stk_lokale * $this->lokale_antal * $this->prisfaktor;
    }
  }

  private function _computeUdgiftLyskilde() {
    // BP
    if ($this->standardinvest_lyskilde_kr_stk == 0) {
      return 0;
    }
    else {
      return $this->standardinvest_lyskilde_kr_stk * $this->ny_lyskilde_stk_armatur * $this->prisfaktor;
    }
  }

  private function _computeLevetidArmatur() {
    // BQ
    $nyLyskilde = $this->getNyLyskilde(true);
    $levetid = $nyLyskilde ? $nyLyskilde->getLevetid() : 0;

    if ($levetid == 0 || $this->ny_driftstid == 0) {
      return 0;
    }
    else {
      return min(25, $levetid / $this->ny_driftstid);
    }
  }

  private function _computeLevetidLyskilde() {
    // BR
    return $this->_computeLevetidArmatur();
  }

  private function computeNutidsvaerdiSetOver15AarKr() {
    // BU
    $faktorForReinvestering = $this->_computeFaktorForReinvestering();
    if ($this->vaegtet_levetid_aar == 0 || $faktorForReinvestering == 0) {
      return 0;
    }
    elseif ($this->getNyLyskilde(true) == null) {
      return $this->nvPTO2($this->investering_alle_lokaler_kr, $this->kwh_besparelse_varme_fra_varmevaerket, $this->kwh_besparelse_el, 0, 0, 0, round($this->vaegtet_levetid_aar), $faktorForReinvestering, 0);
    }
    else {
      return $this->nvPTO2($this->investering_alle_lokaler_kr, $this->kwh_besparelse_varme_fra_varmevaerket, $this->kwh_besparelse_el, 0, $this->driftsbesparelse_til_lyskilder_kr_aar, 0, round($this->vaegtet_levetid_aar), $faktorForReinvestering, 0);
    }
  }

  private function _computeFaktorForReinvestering() {
    return 1;
  }

  private function _computeArmaturEffekt() {
    return $this->__computeArmaturEffekt($this->getLyskilde(true), $this->lyskilde_stk_armatur, $this->lyskilde_w_lyskilde, $this->forkobling_stk_armatur);
  }

  private function __computeArmaturEffekt(BelysningTiltagDetailLyskilde $lyskilde, $lyskilde_stk_armatur, $lyskilde_w_lyskilde, $forkobling_stk_armatur) {
    // Z, AW
    if (!$lyskilde || $lyskilde_stk_armatur == 0 || $lyskilde_w_lyskilde == 0) {
      return 0;
    }
    else {
      switch ($lyskilde->getType()) {
        case 'LED-rør':
        case 'LEDpære':
          return ($lyskilde_w_lyskilde) * $lyskilde_stk_armatur;

        case 'Hal.':
        case 'Gl':
        case 'Sp.':
        case 'LED-arm.':
          return $lyskilde_w_lyskilde * $lyskilde_stk_armatur;

        case 'Kom. K':
          return $lyskilde_stk_armatur * $lyskilde_w_lyskilde * 1.1817 + 2.44275 + (1.2794 * ($lyskilde_stk_armatur - 1)) * 0.9432;

        case 'Hal.': // !!!
          return 1.0832 * $lyskilde_w_lyskilde + 0.192;

        default:
          switch ($lyskilde->getForkobling()) {
            case 'konv.':
              if ($lyskilde_w_lyskilde < 14.99) {
                return 8.5 * $forkobling_stk_armatur + $lyskilde_stk_armatur * $lyskilde_w_lyskilde;
              }
              elseif ($lyskilde_w_lyskilde < 35.99) {
                return 10 * $forkobling_stk_armatur + $lyskilde_stk_armatur * $lyskilde_w_lyskilde;
              }
              else {
                return 12 * $forkobling_stk_armatur + $lyskilde_stk_armatur * $lyskilde_w_lyskilde;
              }
            case 'hf':
              return $forkobling_stk_armatur * 2 + $lyskilde_w_lyskilde * $lyskilde_stk_armatur;
            default:
              return null;
          }
      }
    }
  }

}
