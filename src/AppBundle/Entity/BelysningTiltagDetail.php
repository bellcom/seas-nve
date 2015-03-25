<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\BelysningTiltagDetail\Lyskilde as BelysningTiltagDetailLyskilde;
use AppBundle\Entity\BelysningTiltagDetail\Placering as BelysningTiltagDetailPlacering;
use AppBundle\Entity\BelysningTiltagDetail\Styring as BelysningTiltagDetailStyring;
use AppBundle\Entity\BelysningTiltagDetail\Tiltag as BelysningTiltagDetailTiltag;

/**
 * BelysningTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
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
   * @var double
   *
   * @ORM\Column(name="armaturhoejde_m", type="decimal", scale=2)
   */
  private $armaturhoejde_m;

  /**
   * @var double
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
   * @var double
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
   * @var double
   *
   * @ORM\Column(name="standardinvest_sensor_kr_stk", type="decimal", scale=2)
   */
  private $standardinvest_sensor_kr_stk;

  /**
   * @var double
   *
   * @ORM\Column(name="reduktion_af_drifttid", type="decimal", scale=2)
   */
  private $reduktion_af_drifttid;

  /**
   * @var double
   */
  private $ny_driftstid;

  /**
   * @var double
   *
   * @ORM\Column(name="standardinvest_armatur_el_lyskilde_kr_stk", type="decimal", scale=2)
   */
  private $standardinvest_armatur_el_lyskilde_kr_stk;

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
   * @var double
   */
  private $ny_armatureffekt_w_stk;

  /**
   * @var integer
   *
   * @ORM\Column(name="nye_armaturer_stk_lokale", type="integer")
   */
  private $nye_armaturer_stk_lokale;

  /**
   * @var double
   *
   * @ORM\Column(name="nyttiggjort_varme_af_el_besparelse", type="decimal", scale=2)
   */
  private $nyttiggjort_varme_af_el_besparelse;

  /**
   * @var double
   *
   * @ORM\Column(name="prisfaktor", type="decimal", scale=2)
   */
  private $prisfaktor;

  /**
   * @var string
   */
  private $prisfaktor_tillaeg_kr_lokale;

  /**
   * @var double
   */
  private $investering_alle_lokaler_kr;

  /**
   * @var double
   */
  private $nyt_elforbrug_w_m2;

  /**
   * @var double
   */
  private $driftsbesparelse_til_lyskilder_kr_aar;

  /**
   * @var double
   */
  private $simpel_tilbagebetalingstid_aar;

  /**
   * @var double
   */
  private $vaegtet_levetid_aar;

  /**
   * @var double
   */
  private $nutidsvaerdi_set_over_15_aar_kr;

  /**
   * @var double
   */
  private $kwh_besparelse_el;

  /**
   * @var double
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
   * Set armaturhoejde_m
   *
   * @param double $armaturhoejdeM
   * @return BelysningTiltagDetail
   */
  public function setArmaturhoejdeM($armaturhoejdeM) {
    $this->armaturhoejde_m = $armaturhoejdeM;

    return $this;
  }

  /**
   * Get armaturhoejde_m
   *
   * @return double
   */
  public function getArmaturhoejdeM() {
    return $this->armaturhoejde_m;
  }

  /**
   * Set rumstoerrelse_m2
   *
   * @param double $rumstoerrelseM2
   * @return BelysningTiltagDetail
   */
  public function setRumstoerrelseM2($rumstoerrelseM2) {
    $this->rumstoerrelse_m2 = $rumstoerrelseM2;

    return $this;
  }

  /**
   * Get rumstoerrelse_m2
   *
   * @return double
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
   * @return string
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
   * Get lyskilde
   *
   * @return integer
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
   * @return string
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

  /**
   * Get placering
   *
   * @return BelysningTiltagDetailPlacering
   */
  public function getPlacering() {
  }

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
   * @return string
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
   * @return string
   */
  public function getReduktionAfDrifttid() {
    return $this->reduktion_af_drifttid;
  }

  /**
   * Get ny_driftstid
   *
   * @return string
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
   * @return string
   */
  public function getStandardinvestArmaturElLyskildeKrStk() {
    return $this->standardinvest_armatur_el_lyskilde_kr_stk;
  }

  /**
   * Set ny_lyskilde
   *
   * @param integer $nyLyskilde
   * @return BelysningTiltagDetail
   */
  public function setNyLyskilde($nyLyskilde) {
    $this->ny_lyskilde = $nyLyskilde;
    $this->addData('ny_lyskilde', $nyLyskilde);

    return $this;
  }

  /**
   * Get ny_lyskilde
   *
   * @return integer
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
   * @return string
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
   * @return string
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
   * @return string
   */
  public function getPrisfaktor() {
    return $this->prisfaktor;
  }

  /**
   * Set prisfaktor_tillaeg_kr_lokale
   *
   * @param string $prisfaktorTillaegKrLokale
   * @return BelysningTiltagDetail
   */
  public function setPrisfaktorTillaegKrLokale($prisfaktorTillaegKrLokale) {
    $this->prisfaktor_tillaeg_kr_lokale = $prisfaktorTillaegKrLokale;

    return $this;
  }

  /**
   * Get prisfaktor_tillaeg_kr_lokale
   *
   * @return string
   */
  public function getPrisfaktorTillaegKrLokale() {
    return $this->prisfaktor_tillaeg_kr_lokale;
  }

  /**
   * Set investering_alle_lokaler_kr
   *
   * @param string $investeringAlleLokalerKr
   * @return BelysningTiltagDetail
   */
  public function setInvesteringAlleLokalerKr($investeringAlleLokalerKr) {
    $this->investering_alle_lokaler_kr = $investeringAlleLokalerKr;

    return $this;
  }

  /**
   * Get investering_alle_lokaler_kr
   *
   * @return string
   */
  public function getInvesteringAlleLokalerKr() {
    return $this->investering_alle_lokaler_kr;
  }

  /**
   * Set nyt_elforbrug_w_m2
   *
   * @param string $nytElforbrugWM2
   * @return BelysningTiltagDetail
   */
  public function setNytElforbrugWM2($nytElforbrugWM2) {
    $this->nyt_elforbrug_w_m2 = $nytElforbrugWM2;

    return $this;
  }

  /**
   * Get nyt_elforbrug_w_m2
   *
   * @return string
   */
  public function getNytElforbrugWM2() {
    return $this->nyt_elforbrug_w_m2;
  }

  /**
   * Set driftsbesparelse_til_lyskilder_kr_aar
   *
   * @param string $driftsbesparelseTilLyskilderKrAar
   * @return BelysningTiltagDetail
   */
  public function setDriftsbesparelseTilLyskilderKrAar($driftsbesparelseTilLyskilderKrAar) {
    $this->driftsbesparelse_til_lyskilder_kr_aar = $driftsbesparelseTilLyskilderKrAar;

    return $this;
  }

  /**
   * Get driftsbesparelse_til_lyskilder_kr_aar
   *
   * @return string
   */
  public function getDriftsbesparelseTilLyskilderKrAar() {
    return $this->driftsbesparelse_til_lyskilder_kr_aar;
  }

  /**
   * Set simpel_tilbagebetalingstid_aar
   *
   * @param string $simpelTilbagebetalingstidAar
   * @return BelysningTiltagDetail
   */
  public function setSimpelTilbagebetalingstidAar($simpelTilbagebetalingstidAar) {
    $this->simpel_tilbagebetalingstid_aar = $simpelTilbagebetalingstidAar;

    return $this;
  }

  /**
   * Get simpel_tilbagebetalingstid_aar
   *
   * @return string
   */
  public function getSimpelTilbagebetalingstidAar() {
    return $this->simpel_tilbagebetalingstid_aar;
  }

  /**
   * Set vaegtet_levetid_aar
   *
   * @param string $vaegtetLevetidAar
   * @return BelysningTiltagDetail
   */
  public function setVaegtetLevetidAar($vaegtetLevetidAar) {
    $this->vaegtet_levetid_aar = $vaegtetLevetidAar;

    return $this;
  }

  /**
   * Get vaegtet_levetid_aar
   *
   * @return string
   */
  public function getVaegtetLevetidAar() {
    return $this->vaegtet_levetid_aar;
  }

  /**
   * Set nutidsvaerdi_set_over_15_aar_kr
   *
   * @param string $nutidsvaerdiSetOver15AarKr
   * @return BelysningTiltagDetail
   */
  public function setNutidsvaerdiSetOver15AarKr($nutidsvaerdiSetOver15AarKr) {
    $this->nutidsvaerdi_set_over_15_aar_kr = $nutidsvaerdiSetOver15AarKr;

    return $this;
  }

  /**
   * Get nutidsvaerdi_set_over_15_aar_kr
   *
   * @return string
   */
  public function getNutidsvaerdiSetOver15AarKr() {
    return $this->nutidsvaerdi_set_over_15_aar_kr;
  }

  /**
   * Set kwh_besparelse_el
   *
   * @param string $kwhBesparelseEl
   * @return BelysningTiltagDetail
   */
  public function setKwhBesparelseEl($kwhBesparelseEl) {
    $this->kwh_besparelse_el = $kwhBesparelseEl;

    return $this;
  }

  /**
   * Get kwh_besparelse_el
   *
   * @return string
   */
  public function getKwhBesparelseEl() {
    return $this->kwh_besparelse_el;
  }

  /**
   * Set kwh_besparelse_varme_fra_varmevaerket
   *
   * @param string $kwhBesparelseVarmeFraVarmevaerket
   * @return BelysningTiltagDetail
   */
  public function setKwhBesparelseVarmeFraVarmevaerket($kwhBesparelseVarmeFraVarmevaerket) {
    $this->kwh_besparelse_varme_fra_varmevaerket = $kwhBesparelseVarmeFraVarmevaerket;

    return $this;
  }

  /**
   * Get kwh_besparelse_varme_fra_varmevaerket
   *
   * @return string
   */
  public function getKwhBesparelseVarmeFraVarmevaerket() {
    return $this->kwh_besparelse_varme_fra_varmevaerket;
  }

  /** @ORM\PostLoad */
  public function postLoad(LifecycleEventArgs $event) {
    $this->elforbrug_w_m2 = $this->__get('AB');
    $this->ny_driftstid = $this->__get('AM');
    $this->ny_armatureffekt_w_stk = $this->__get('AU');
    $this->prisfaktor_tillaeg_kr_lokale = $this->__get('AY');
    $this->investering_alle_lokaler_kr = $this->__get('AZ');
    $this->nyt_elforbrug_w_m2 = $this->__get('BB');
    $this->driftsbesparelse_til_lyskilder_kr_aar = $this->__get('BI');
    $this->simpel_tilbagebetalingstid_aar = $this->__get('BJ');
    $this->vaegtet_levetid_aar = $this->__get('BK');
    $this->nutidsvaerdi_set_over_15_aar_kr = $this->__get('BQ');
    $this->kwh_besparelse_el = $this->__get('BR');
    $this->kwh_besparelse_varme_fra_varmevaerket = $this->__get('BS');
  }

  public function __get($key) {
    switch ($key) {
      case 'Elbesparelse, Alle lokaler (kWh/år)':
        return $this->__get('BC');
      case 'Varmebespar., Alle lokaler (kWh/år)':
        return $this->__get('BD');
      case 'Lyskilde,  (stk/armatur)':
        return $this->__get('V');
      case 'Armaturer (stk/lokale)':
        return $this->__get('Z');
      case 'Udgift til lyskilder (kr/stk)':
        return $this->__get('BG');
      case 'Drifttid (t/år)':
        return $this->__get('Q');
      case 'Eksist. lyskildes levetid (t)':
        return $this->__get('BE');
      case 'Ny Lyskilde,  (stk/armatur)':
        return $this->__get('AR');
      case 'Nye armaturer (stk/lokale)':
        return $this->__get('AV');
      case 'Ny Udgift til lyskilder (kr/stk)':
        return $this->__get('BH');
      case 'Ny driftstid':
        return $this->__get('AM');
      case 'Ny lyskildes levetid (t)':
        return $this->__get('BF');
      case 'Lokale, antal':
        return $this->lokale_antal;
      case 'Lyskilde, type':
        return $this->getLyskilde(true) ? $this->getLyskilde(true)->getType() : null;
      case 'Ny lyskilde, type':
        return $this->getNyLyskilde(true) ? $this->getNyLyskilde(true)->getType() : null;
      case 'Lyskilde, (W/lyskilde)':
        return $this->lyskilde_w_lyskilde;
      case 'Ny lyskilde, (W/lyskilde)':
        return $this->ny_lyskilde_w_lyskilde;
      case 'Forkobling SKJULES':
        return $this->getLyskilde(true) ? $this->getLyskilde(true)->getForkobling() : null;
      case 'Ny Forkobling SKJULES':
        return $this->getNyLyskilde(true) ? $this->getNyLyskilde(true)->getForkobling() : null;
      case 'Forkobling (stk/armatur)':
        return $this->forkobling_stk_armatur;
      case 'Ny forkobling (stk/armatur)':
        return $this->ny_forkobling_stk_armatur;

      case 'J':
        return $this->lokale_navn;
      case 'L':
        return $this->lokale_type;
      case 'M':
        return $this->armaturhoejde_m;
      case 'N':
        return $this->rumstoerrelse_m2;
      case 'P':
        return $this->lokale_antal;
      case 'Q':
        return $this->drifttid_t_aar;
      case 'S':
        return $this->lyskilde;
      case 'U': // Forkobling SKJULES
        // return (!$this->S ? null : (($this->S == 1 || $this->S == 4 || $this->S == 8) ? 'konv.' : (($this->S == 2 || $this->S == 3 || $this->S == 5) ? 'hf' : (($this->S == 6 || $this->S == 7 || $this->S == 9 || $this->S == 10 || $this->S == 11) ? "Ingen" : ($this->S == 12 ? "LED-driver" : null)))));
        throw new \Exception($key . '=IF(S="";"";IF(OR(S=1;S=4;S=8);"konv.";IF(OR(S=2;S=3;S=5);"hf";IF(OR(S=6;S=7;S=9;S=10;S=11);"Ingen";IF(S=12;"LED-driver";"")))))');
      case 'V':
        return $this->lyskilde_stk_armatur;
      case 'W':
        return $this->lyskilde_w_lyskilde;
      case 'X':
        return $this->forkobling_stk_armatur;
      case 'Y': // Armatureffekt (W/stk)
        return ((!$this->__get('Lyskilde, type')
                 || !$this->__get('Lyskilde,  (stk/armatur)')
                 || !$this->__get('Lyskilde, (W/lyskilde)'))
                ? null
                : (($this->__get('Lyskilde, type') == 'LED-rør'
                    || $this->__get('Lyskilde, type') == 'LEDpære'
                   ? ($this->__get('Lyskilde, (W/lyskilde)')+1)*$this->__get('Lyskilde,  (stk/armatur)')
                   : (($this->__get('Lyskilde, type') == 'Hal.'
                       || $this->__get('Lyskilde, type') == 'Gl'
                       || $this->__get('Lyskilde, type') == 'Sp.'
                       || $this->__get('Lyskilde, type') == 'LED-arm.'
                      ? $this->__get('Lyskilde, (W/lyskilde)')*$this->__get('Lyskilde,  (stk/armatur)')
                      : ($this->__get('Lyskilde, type') == 'Kom. K'
                         ? ($this->__get('Lyskilde,  (stk/armatur)')*$this->__get('Lyskilde, (W/lyskilde)')*1.1817+2.44275+(1.2794*($this->__get('Lyskilde,  (stk/armatur)')-1)*0.9432))
                         : ($this->__get('Lyskilde, type') == 'Hal.'
                            ? 1.0832*$this->__get('Lyskilde, (W/lyskilde)') + 0.192
                            : (($this->__get('Forkobling SKJULES') == 'konv.'
                                && $this->__get('Lyskilde, (W/lyskilde)') < 14.99)
                               ? 8.5*$this->__get('Forkobling (stk/armatur)')+$this->__get('Lyskilde,  (stk/armatur)')*$this->__get('Lyskilde, (W/lyskilde)')
                               : (($this->__get('Forkobling SKJULES') == 'konv.'
                                   && $this->__get('Lyskilde, (W/lyskilde)') > 14.99
                                   && $this->__get('Lyskilde, (W/lyskilde)') < 35.99)
                                  ? 10*$this->__get('Forkobling (stk/armatur)')+$this->__get('Lyskilde,  (stk/armatur)')*$this->__get('Lyskilde, (W/lyskilde)')
                                  : (($this->__get('Forkobling SKJULES') == 'konv.'
                                      && $this->__get('Lyskilde, (W/lyskilde)') > 35.99)
                                     ? 12*$this->__get('Forkobling (stk/armatur)')+$this->__get('Lyskilde,  (stk/armatur)')*$this->__get('Lyskilde, (W/lyskilde)')
                                     : ($this->__get('Forkobling SKJULES') == 'hf'
                                        ? $this->__get('Forkobling (stk/armatur)')*2+$this->__get('Lyskilde, (W/lyskilde)')*$this->__get('Lyskilde,  (stk/armatur)')
                                        : null
                                     )
                                  )
                               )
                            )
                         )
                      )
                   )
                   )
                )
                )
        );

        throw new \Exception($key . '=
IF(
  OR(
    Table10[[#This Row],[Lyskilde, type]]="",
    Table10[[#This Row],[Lyskilde,  (stk/armatur)]]="",
    Table10[[#This Row],[Lyskilde, (W/lyskilde)]]=""
  ),
  "",
  IF(
    OR(
      Table10[[#This Row],[Lyskilde, type]]=$R$34,
      Table10[[#This Row],[Lyskilde, type]]=$R$35
    ),
    (Table10[[#This Row],[Lyskilde, (W/lyskilde)]]+1)*Table10[[#This Row],[Lyskilde,  (stk/armatur)]],
    IF(
      OR(
        Table10[[#This Row],[Lyskilde, type]]=$R$32,
        Table10[[#This Row],[Lyskilde, type]]=$R$36,
        Table10[[#This Row],[Lyskilde, type]]=$R$31,
        Table10[[#This Row],[Lyskilde, type]]=$R$37
      ),
      Table10[[#This Row],[Lyskilde, (W/lyskilde)]]*Table10[[#This Row],[Lyskilde,  (stk/armatur)]],
      IF(
        Table10[[#This Row],[Lyskilde, type]]=$R$29,
        (Table10[[#This Row],[Lyskilde,  (stk/armatur)]]*Table10[[#This Row],[Lyskilde, (W/lyskilde)]]*1.1817+2.44275+(1.2794*(Table10[[#This Row],[Lyskilde,  (stk/armatur)]]-1)*0.9432)),
        IF(
          Table10[[#This Row],[Lyskilde, type]]=$R$33,
          1.0832*Table10[[#This Row],[Lyskilde, (W/lyskilde)]] + 0.192,
          IF(
            AND(
              Table10[[#This Row],[Forkobling SKJULES]]="konv.",
              Table10[[#This Row],[Lyskilde, (W/lyskilde)]]<14.99
            ),
            8.5*Table10[[#This Row],[Forkobling (stk/armatur)]]+Table10[[#This Row],[Lyskilde,  (stk/armatur)]]*Table10[[#This Row],[Lyskilde, (W/lyskilde)]],
            IF(
              AND(
                Table10[[#This Row],[Forkobling SKJULES]]="konv.",
                Table10[[#This Row],[Lyskilde, (W/lyskilde)]]>14.99,
                Table10[[#This Row],[Lyskilde, (W/lyskilde)]]<35.99
              ),
              10*Table10[[#This Row],[Forkobling (stk/armatur)]]+Table10[[#This Row],[Lyskilde,  (stk/armatur)]]*Table10[[#This Row],[Lyskilde, (W/lyskilde)]],
              IF(
                AND(
                  Table10[[#This Row],[Forkobling SKJULES]]="konv.",
                  Table10[[#This Row],[Lyskilde, (W/lyskilde)]]>35.99
                ),
                12*Table10[[#This Row],[Forkobling (stk/armatur)]]+Table10[[#This Row],[Lyskilde,  (stk/armatur)]]*Table10[[#This Row],[Lyskilde, (W/lyskilde)]],
                IF(
                  Table10[[#This Row],[Forkobling SKJULES]]="hf",
                  Table10[[#This Row],[Forkobling (stk/armatur)]]*2+Table10[[#This Row],[Lyskilde, (W/lyskilde)]]*Table10[[#This Row],[Lyskilde,  (stk/armatur)]]
                )
              )
            )
          )
        )
      )
    )
  )
)
');
      case 'Z':
        return $this->armaturer_stk_lokale;
      case 'AA': // Elforbrug(kWh pr. lokale/år)
        return (!$this->Y || !$this->Z) ? null : $this->Y*$this->Q*$this->Z/1000;
        throw new \Exception($key . '=IF(OR(Y="";Z="");"";Y*Q*Z/1000)');
      case 'AB': // Elforbrug(W/m2)
        // list($n, $y, $z) = $this->_getValues('N', 'Y', 'Z');
        return (empty($this->N) || empty($this->Y) || empty($this->Z)) ? null : $this->N * $this->Y / $this->Z;
        // throw new \Exception($key . '=IF(OR(N="";Y="";Z="");"";Y*Z/N)');
      case 'AC':
        return $this->placering;
      case 'AE':
        return $this->styring;
      case 'AG':
        return $this->noter;
      case 'AH':
        return $this->belysningstiltagId;
      case 'AJ':
        return $this->nye_sensorer_stk_lokale;
      case 'AK':
        return $this->standardinvest_sensor_kr_stk;
      case 'AL':
        return $this->reduktion_af_drifttid;
      case 'AM': // Ny driftstid
        // list($q, $ah, $al) = $this->_getValues('Q', 'AH', 'AL');
        return (empty($q) || empty($ah)) ? null : $q-$al*$q;
        throw new \Exception($key . '=IF(OR(Q="";AH="");"";Q−AL*Q)');
      case 'AN':
        return $this->standardinvest_armatur_el_lyskilde_kr_stk;
      case 'AO':
        return $this->ny_lyskilde;
      case 'AQ': // Ny Forkobling SKJULES
        throw new \Exception($key . '=IF(AO="";"";IF(OR(AO=1;AO=4;AO=8);"konv.";IF(OR(AO=2;AO=3;AO=5);"hf";IF(OR(AO=6;AO=7;AO=9;AO=10;AO=11);"Ingen";IF(AO=12;"LED-driver";"")))))');
      case 'AR':
        return $this->ny_lyskilde_stk_armatur;
      case 'AS':
        return $this->ny_lyskilde_w_lyskilde;
      case 'AT':
        return $this->ny_forkobling_stk_armatur;
      case 'AU': // Ny armatureffekt (W/stk)

                return ((!$this->__get('Ny lyskilde, type')
                 || !$this->__get('Ny Lyskilde,  (stk/armatur)')
                 || !$this->__get('Ny lyskilde, (W/lyskilde)'))
                ? null
                : (($this->__get('Ny lyskilde, type') == 'LED-rør'
                    || $this->__get('Ny lyskilde, type') == 'LEDpære'
                   ? ($this->__get('Ny lyskilde, (W/lyskilde)')+1)*$this->__get('Ny Lyskilde,  (stk/armatur)')
                   : (($this->__get('Ny lyskilde, type') == 'Hal.'
                       || $this->__get('Ny lyskilde, type') == 'Gl'
                       || $this->__get('Ny lyskilde, type') == 'Sp.'
                       || $this->__get('Ny lyskilde, type') == 'LED-arm.'
                      ? $this->__get('Ny lyskilde, (W/lyskilde)')*$this->__get('Ny Lyskilde,  (stk/armatur)')
                      : ($this->__get('Ny lyskilde, type') == 'Kom. K'
                         ? ($this->__get('Ny Lyskilde,  (stk/armatur)')*$this->__get('Ny lyskilde, (W/lyskilde)')*1.1817+2.44275+(1.2794*($this->__get('Ny Lyskilde,  (stk/armatur)')-1)*0.9432))
                         : ($this->__get('Ny lyskilde, type') == 'Hal.'
                            ? 1.0832*$this->__get('Ny lyskilde, (W/lyskilde)') + 0.192
                            : (($this->__get('Ny Forkobling SKJULES') == 'konv.'
                                && $this->__get('Ny lyskilde, (W/lyskilde)') < 14.99)
                               ? 8.5*$this->__get('Ny forkobling (stk/armatur)')+$this->__get('Ny Lyskilde,  (stk/armatur)')*$this->__get('Ny lyskilde, (W/lyskilde)')
                               : (($this->__get('Ny Forkobling SKJULES') == 'konv.'
                                   && $this->__get('Ny lyskilde, (W/lyskilde)') > 14.99
                                   && $this->__get('Ny lyskilde, (W/lyskilde)') < 35.99)
                                  ? 10*$this->__get('Ny forkobling (stk/armatur)')+$this->__get('Ny Lyskilde,  (stk/armatur)')*$this->__get('Ny lyskilde, (W/lyskilde)')
                                  : (($this->__get('Ny Forkobling SKJULES') == 'konv.'
                                      && $this->__get('Ny lyskilde, (W/lyskilde)') > 35.99)
                                     ? 12*$this->__get('Ny forkobling (stk/armatur)')+$this->__get('Ny Lyskilde,  (stk/armatur)')*$this->__get('Ny lyskilde, (W/lyskilde)')
                                     : ($this->__get('Ny Forkobling SKJULES') == 'hf'
                                        ? $this->__get('Ny forkobling (stk/armatur)')*2+$this->__get('Ny lyskilde, (W/lyskilde)')*$this->__get('Ny Lyskilde,  (stk/armatur)')
                                        : null
                                     )
                                  )
                               )
                            )
                         )
                      )
                   )
                   )
                )
                )
        );

        throw new \Exception($key . '=
IF(
  OR(
    Table10[[#This Row],[Ny lyskilde, type]]="",
    Table10[[#This Row],[Ny Lyskilde,  (stk/armatur)]]="",
    Table10[[#This Row],[Ny lyskilde, (W/lyskilde)]]=""
  ),
  "",
  IF(
    OR(
      Table10[[#This Row],[Ny lyskilde, type]]=$R$34,
      Table10[[#This Row],[Ny lyskilde, type]]=$R$35
    ),
    (Table10[[#This Row],[Ny lyskilde, (W/lyskilde)]]+1)*Table10[[#This Row],[Ny Lyskilde,  (stk/armatur)]],
    IF(
      OR(
        Table10[[#This Row],[Ny lyskilde, type]]=$R$32,
        Table10[[#This Row],[Ny lyskilde, type]]=$R$36,
        Table10[[#This Row],[Ny lyskilde, type]]=$R$31,
        Table10[[#This Row],[Ny lyskilde, type]]=$R$37
      ),
      Table10[[#This Row],[Ny lyskilde, (W/lyskilde)]]*Table10[[#This Row],[Ny Lyskilde,  (stk/armatur)]],
      IF(
        Table10[[#This Row],[Ny lyskilde, type]]=$R$29,
        (Table10[[#This Row],[Ny Lyskilde,  (stk/armatur)]]*Table10[[#This Row],[Ny lyskilde, (W/lyskilde)]]*1.1817+2.44275+(1.2794*(Table10[[#This Row],[Ny Lyskilde,  (stk/armatur)]]-1)*0.9432)),
        IF(
          Table10[[#This Row],[Ny lyskilde, type]]=$R$33,
          1.0832*Table10[[#This Row],[Ny lyskilde, (W/lyskilde)]] + 0.192,
          IF(
            AND(
              Table10[[#This Row],[Ny Forkobling SKJULES]]="konv.",
              Table10[[#This Row],[Ny lyskilde, (W/lyskilde)]]<14.99
            ),
            8.5*Table10[[#This Row],[Ny forkobling (stk/armatur)]]+Table10[[#This Row],[Ny Lyskilde,  (stk/armatur)]]*Table10[[#This Row],[Ny lyskilde, (W/lyskilde)]],
            IF(
              AND(
                Table10[[#This Row],[Ny Forkobling SKJULES]]="konv.",
                Table10[[#This Row],[Ny lyskilde, (W/lyskilde)]]>14.99,
                Table10[[#This Row],[Ny lyskilde, (W/lyskilde)]]<35.99
              ),
              10*Table10[[#This Row],[Ny forkobling (stk/armatur)]]+Table10[[#This Row],[Ny Lyskilde,  (stk/armatur)]]*Table10[[#This Row],[Ny lyskilde, (W/lyskilde)]],
              IF(
                AND(
                  Table10[[#This Row],[Ny Forkobling SKJULES]]="konv.",
                  Table10[[#This Row],[Ny lyskilde, (W/lyskilde)]]>35.99
                ),
                12*Table10[[#This Row],[Ny forkobling (stk/armatur)]]+Table10[[#This Row],[Ny Lyskilde,  (stk/armatur)]]*Table10[[#This Row],[Ny lyskilde, (W/lyskilde)]],
                IF(
                  Table10[[#This Row],[Ny Forkobling SKJULES]]="hf",
                  Table10[[#This Row],[Ny forkobling (stk/armatur)]]*2+Table10[[#This Row],[Ny lyskilde, (W/lyskilde)]]*Table10[[#This Row],[Ny Lyskilde,  (stk/armatur)]]
                )
              )
            )
          )
        )
      )
    )
  )
)
');
      case 'AV':
        return $this->nye_armaturer_stk_lokale;
      case 'AW':
        return $this->nyttiggjort_varme_af_el_besparelse;
      case 'AX':
        return $this->prisfaktor;
      case 'AY': // Prisfaktor-tillæg  (kr/lokale)
        return empty($this->AX) ? null : ($this->AJ*$this->AK+$this->AN*$this->AV)*($this->AX−1);
        throw new \Exception($key . '=IF(AX="";"";(AJ*AK+AN*AV)*(AX−1))');
      case 'AZ': // Investering, alle lokaler (kr)
        return (empty($this->AK) && empty($this->AN)) ? null : ($this->AO == 12 ? (($this->AJ*$this->AK+$this->AN*$this->AV*$this->AR)+$this->AY)*$this->P:(($this->AJ*$this->AK+$this->AN*$this->AV)+$this->AY)*$this->P);
        throw new \Exception($key . '=IF(AND(AK="";AN="");"";IF(AO=12;((AJ*AK+AN*AV*AR)+AY)*P;((AJ*AK+AN*AV)+AY)*P))');
      case 'BA': // Nyt Elforbrug(kWh pr. lokale/år)
        return !$this->AM ? null : (!$this->AU ? $this->AM*$this->Y*$this->Z/1000 : $this->AM*$this->AU*$this->AV/1000);
        throw new \Exception($key . '=IF(AM="";"";IF(AU="";AM*Y*Z/1000;AM*AU*AV/1000))');
      case 'BB': // Nyt Elforbrug(W/m2)
        return empty($this->N) ? null : (empty($this->AU) ? $this->AB : $this->AU*$this->AV/$this->N);
        throw new \Exception($key . '=IF(N="";"";IF(AU="";AB;AU*AV/N))');
      case 'BC': // Elbesparelse, Alle lokaler (kWh/år)
        return (!$this->AA || !$this->P || !$this->BA) ? null : ($this->AA - $this->BA) * $this->P;
        throw new \Exception($key . '=IF(OR(AA="";P="";BA="");"";(AA−BA)*P)');
      case 'BD': // Varmebespar., Alle lokaler (kWh/år)
        return !$this->BC ? null : $this->BC * (-$this->AW);
        throw new \Exception($key . '=IF(BC="";"";BC*−AW)');
      case 'BE': // Eksist. lyskildes levetid (t)
        return (!$this->getLyskilde(true) || !$this->getLyskilde(true)->getUdgift()) ? null : $this->getLyskilde(true)->getLevetid();
        throw new \Exception($key . '=IF(S="";"";VLOOKUP(S;$M$26:$Y$37;12;FALSE))'); //
      case 'BF': // Ny lyskildes levetid (t)
        return (!$this->AO && !$this->AJ) ? null : ((!$this->AO && $this->AJ) ? $this->BE : $this->getNyLyskilde(true)->getLevetid());
        throw new \Exception($key . '=IF(AND(AO="";AJ="");"";IF(AND(AO="";AJ≠"");BE;VLOOKUP(AO;$M$26:$Y$37;12;FALSE)))'); //
      case 'BG': // Udgift til lyskilder (kr/stk)
        return (!$this->getLyskilde(true) || !$this->getLyskilde(true)->getUdgift()) ? null : $this->getLyskilde(true)->getUdgift();
        throw new \Exception($key . '=IF(S="";"";VLOOKUP(S;$M$26:$Y$37;8;FALSE))');
      case 'BH': // Ny Udgift til lyskilder (kr/stk)
        return (!$this->AO && !$this->AJ) ? null : ((!$this->AO && $this->AJ) ? $this->BG : $this->getNyLyskilde(true)->getUdgift());
        throw new \Exception($key . '=IF(AND(AO="";AJ="");"";IF(AND(AO="";AJ≠0);BG;VLOOKUP(AO;$M$26:$Y$37;8;FALSE)))');
      case 'BI': // "Driftsbesparelse til lyskilder Alle lokaler (kr/år)"
        return (!$this->getLyskilde(true) || !$this->getLyskilde(true)->getLevetid()
                || !$this->getNyLyskilde(true) || !$this->getNyLyskilde(true)->getLevetid()) ? null
          : ($this->__get('Lyskilde,  (stk/armatur)')*$this->__get('Armaturer (stk/lokale)')*$this->__get('Udgift til lyskilder (kr/stk)')*$this->__get('Drifttid (t/år)')/$this->__get('Eksist. lyskildes levetid (t)')
            -$this->__get('Ny Lyskilde,  (stk/armatur)')*$this->__get('Nye armaturer (stk/lokale)')*$this->__get('Ny Udgift til lyskilder (kr/stk)')*$this->__get('Ny driftstid')/$this->__get('Ny lyskildes levetid (t)'))
                                  *$this->__get('Lokale, antal');

        throw new \Exception($key . '=
IF(
	OR(
		Table10[[#This Row],[Eksist. lyskildes levetid (t)]]="",
		Table10[[#This Row],[Ny lyskildes levetid (t)]]=""
	),
  "",
  (Table10[[#This Row],[Lyskilde,  (stk/armatur)]]*Table10[[#This Row],[Armaturer (stk/lokale)]]*Table10[[#This Row],[Udgift til lyskilder (kr/stk)]]*Table10[[#This Row],[Drifttid (t/år)]]/Table10[[#This Row],[Eksist. lyskildes levetid (t)]]
-Table10[[#This Row],[Ny Lyskilde,  (stk/armatur)]]*Table10[[#This Row],[Nye armaturer (stk/lokale)]]*Table10[[#This Row],[Ny Udgift til lyskilder (kr/stk)]]*Table10[[#This Row],[Ny driftstid]]/Table10[[#This Row],[Ny lyskildes levetid (t)]])
*Table10[[#This Row],[Lokale, antal]]
)
');
      case 'BJ': // Simpel tilbagebetalingstid (år)
        return empty($this->AZ) ? null : $this->AZ/($this->BR*Tiltag::el_pris_i_aar_1_kr_kwh+$this->BS*Tiltag::varmepris_aar_1_kr_kwh+$this->BI);
        throw new \Exception($key . '=IF(AZ="";"";AZ/(BR*$L$27+BS*$L$28+BI))');
      case 'BK': // Vægtet Levetid (år)
        return ($this->BL == 0 && $this->BM == 0) ? null : (empty($this->AO) ? 10 : ($this->BL*self::lyssensors_levetid_i_aar+$this->BM*$this->BF/$this->AM)/($this->BL+$this->BM));
        throw new \Exception($key . '=IF(AND(BL=0;BM=0);"";IF(AO="";10;(BL*$X$38+BM*BF/AM)/(BL+BM)))');
      case 'BL': // udgift sensorer
        return empty($this->AJ) ? null : $this->AJ*$this->AK*$this->AX*$this->P;
        throw new \Exception($key . '=IF(AJ="";0;AJ*AK*AX*P)');
      case 'BM': // udgift armaturer
        return empty($this->AN) ? null : $this->AN*$this->AV*$this->P*$this->AX;
        throw new \Exception($key . '=IF(AN="";0;AN*AV*P*AX)');
      case 'BN': // Levetid, armaturer
        throw new \Exception($key . '=IF(BF="";"";BF/AM)');
      case 'BO': // Armatur vægtning
        throw new \Exception($key . '=IF(AND(BM=0;BN="");"";BN*BM)');
      case 'BP': // Faktor for reinvestering (ALTID 1 INDTIL VIDERE)
        throw new \Exception($key . '=1');
      case 'BQ': // Nutidsværdi set over 15 år (kr)
        return 0;
        // throw new \Exception($key . '=0');
      case 'BR': // kWh-besparelse El
        return (!$this->__get('Elbesparelse, Alle lokaler (kWh/år)') && !$this->__get('Varmebespar., Alle lokaler (kWh/år)')) ? null
          : ($this->__get('INDIRECT("\'2.Forsyning\'!$H$3")') == 1
             ? $this->__get('Elbesparelse, Alle lokaler (kWh/år)')
             : $this->fordelbesparelse($this->__get('Varmebespar., Alle lokaler (kWh/år)'), $this->__get('$C$13'), 'EL')+$this->__get('Elbesparelse, Alle lokaler (kWh/år)'));
        throw new \Exception($key . '=
IF(
  AND(
	  Table10[[#This Row],[Elbesparelse, Alle lokaler (kWh/år)]]="",
		Table10[[#This Row],[Varmebespar., Alle lokaler (kWh/år)]]=""
	),"",
	IF(
		INDIRECT("\'2.Forsyning\'!$H$3")=1,
		Table10[[#This Row],[Elbesparelse, Alle lokaler (kWh/år)]],
		fordelbesparelse(Table10[[#This Row],[Varmebespar., Alle lokaler (kWh/år)]],$C$13,"EL")+Table10[[#This Row],[Elbesparelse, Alle lokaler (kWh/år)]]
	)
)
');
      case 'BS': // kWh-besparelse Varme fra varmeværket
        return !$this->__get('Varmebespar., Alle lokaler (kWh/år)') ? null
          : ($this->__get('INDIRECT("\'2.Forsyning\'!$H$3")') == 1 ? $this->__get('Varmebespar., Alle lokaler (kWh/år)') : $this->fordelbesparelse($this->__get('Varmebespar., Alle lokaler (kWh/år)'), $this->__get('$C$13'), 'VARME'));
        throw new \Exception($key . '=
IF(
  Table10[[#This Row],[Varmebespar., Alle lokaler (kWh/år)]]="",
	"",
	IF(
	  INDIRECT("\'2.Forsyning\'!$H$3")=1,
		Table10[[#This Row],[Varmebespar., Alle lokaler (kWh/år)]],
		fordelbesparelse(Table10[[#This Row],[Varmebespar., Alle lokaler (kWh/år)]],$C$13,"VARME")
	)
)
');
    }

    throw new \Exception('Invalid key: '.$key);
  }

  const lyssensors_levetid_i_aar = 10;

  // INDIRECT("\'2.Forsyning\'!$H$3"): =IF(AND(A15="Hovedforsyning El",J15="El",I15=1,H15=1,A16="Fjernvarme",J16="Varme",I16=1,H16=1),1,"ikke standardforsyning")
  const forsyning = 1;

}
