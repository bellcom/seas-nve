<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KoeleanlaegTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class KoeleanlaegTiltagDetail extends TiltagDetail {

  /**
   * @var array
   *
   * @ORM\Column(name="tilstandDataFoer", type="array")
   */
  private $tilstandDataFoer;

  /**
   * @var array
   *
   * @ORM\Column(name="tilstandDataEfter", type="array")
   */
  private $tilstandDataEfter;

  /**
   * @var float
   *
   * @ORM\Column(name="etotReduktion", type="float")
   */
  private $etotReduktion;

  /**
   * @var float
   *
   * @ORM\Column(name="samletBesparelse", type="float")
   */
  private $samletBesparelse;

  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
    foreach (self::getTilstandDataFoerInputKeys() as $key) {
      $this->tilstandDataFoer[$key] = NULL;
    }
    foreach (self::getTilstandDataEfterInputKeys() as $key) {
      $this->tilstandDataEfter[$key] = NULL;
    }
  }

  /**
   * Sets tilstandDataFoer.
   *
   * @param array $tilstandDataFoer
   */
  public function setTilstandDataFoer($tilstandDataFoer) {
    $this->tilstandDataFoer = $tilstandDataFoer;
  }

  /**
   * Gets tilstandDataFoer.
   *
   * @return array
   */
  public function getTilstandDataFoer() {
    return $this->tilstandDataFoer;
  }

  /**
   * Sets tilstandDataEfter.
   *
   * @param array $tilstandDataEfter
   */
  public function setTilstandDataEfter($tilstandDataEfter) {
    $this->tilstandDataEfter = $tilstandDataEfter;
  }

  /**
   * Gets tilstandDataEfter.
   *
   * @return array
   */
  public function getTilstandDataEfter() {
    return $this->tilstandDataEfter;
  }

  /**
   * Get tilstandDataFoer keys that should be filled in form.
   *
   * @return array
   */
  public static function getTilstandDataFoerInputKeys()
  {
    return array(
      'to',
      'tc',
      'etaC',
      'etaKapa',
      'ek',
      'ehjK',
      'ehjV',
    );
  }

  /**
   * Get tilstandDataFoer key value
   *
   * @return float
   */
  public function getTilstandDataFoerKeyValue($key)
  {
    return isset($this->tilstandDataFoer[$key]) ? $this->tilstandDataFoer[$key] : NULL;
  }

  public function getTilstandDataFoerTo() { return $this->getTilstandDataFoerKeyValue('to'); }
  public function getTilstandDataFoerTc() { return $this->getTilstandDataFoerKeyValue('tc'); }
  public function getTilstandDataFoerEtac() { return $this->getTilstandDataFoerKeyValue('etaC'); }
  public function getTilstandDataFoerEtaKapa() { return $this->getTilstandDataFoerKeyValue('etaKapa'); }
  public function getTilstandDataFoerEk() { return $this->getTilstandDataFoerKeyValue('ek'); }
  public function getTilstandDataFoerEhjK() { return $this->getTilstandDataFoerKeyValue('ehjK'); }
  public function getTilstandDataFoerEhjV() { return $this->getTilstandDataFoerKeyValue('ehjV'); }
  public function getTilstandDataFoerQbehov() { return $this->getTilstandDataFoerKeyValue('qbehov'); }
  public function getTilstandDataFoerEtot() { return $this->getTilstandDataFoerKeyValue('etot'); }

  /**
   * Get tilstandaDataEfter keys that should be filled in form.
   *
   * @return array
   */
  public static function getTilstandDataEfterInputKeys()
  {
    return array(
      'to',
      'tc',
      'etaC',
      'etaKapa',
      'ehjK',
      'ehjV',
    );
  }

  /**
   * Get getTilstandDataEfterInputKeys tilstandDataEfter key value
   *
   * @return float
   */
  public function getTilstandDataEfterKeyValue($key)
  {
    return isset($this->tilstandDataEfter[$key]) ? $this->tilstandDataEfter[$key] : NULL;
  }

  public function getTilstandDataEfterTo() { return $this->getTilstandDataEfterKeyValue('to'); }
  public function getTilstandDataEfterTc() { return $this->getTilstandDataEfterKeyValue('tc'); }
  public function getTilstandDataEfterEtac() { return $this->getTilstandDataEfterKeyValue('etaC'); }
  public function getTilstandDataEfterEtaKapa() { return $this->getTilstandDataEfterKeyValue('etaKapa'); }
  public function getTilstandDataEfterEk() { return $this->getTilstandDataEfterKeyValue('ek'); }
  public function getTilstandDataEfterEhjK() { return $this->getTilstandDataEfterKeyValue('ehjK'); }
  public function getTilstandDataEfterEhjV() { return $this->getTilstandDataEfterKeyValue('ehjV'); }
  public function getTilstandDataEfterQbehov() { return $this->getTilstandDataEfterKeyValue('qbehov'); }
  public function getTilstandDataEfterEtot() { return $this->getTilstandDataEfterKeyValue('etot'); }

  /**
   * Gets etotReduktion.
   *
   * @return float
   */
  public function getEtotReduktion() {
    if ($this->etotReduktion == NULL) {
      $this->etotReduktion = $this->calculateEtotReduktion();
    }
    return $this->etotReduktion;
  }

  /**
   * Gets samletBesparelse.
   *
   * @return float
   */
  public function getSamletBesparelse() {
    if ($this->samletBesparelse == NULL) {
      $this->samletBesparelse = $this->calculateSamletBesparelse();
    }
    return $this->samletBesparelse;
  }

  /**
   * Calculate stuff.
   *
   * See calculation file xls/KoeleanlaegTiltagDetail/Beregning_og_Noegletal_for_Koeleanlaeg.xlsx
   */
  public function calculate() {
    $this->tilstandDataFoer['qbehov'] = $this->calculateQbehovFoer();
    $this->tilstandDataFoer['etot'] = $this->calculateEtotFoer();
    $this->tilstandDataEfter['ek'] = $this->calculateEkEfter();
    $this->tilstandDataEfter['qbehov'] = $this->calculateQbehovEfter();
    $this->tilstandDataEfter['etot'] = $this->calculateEtotEfter();
    $this->etotReduktion = $this->calculateEtotReduktion();
    $this->samletBesparelse = $this->calculateSamletBesparelse();
  }

  /**
   * See calculation file, cell C14.
   */
  public function calculateQbehovFoer() {
    $to = $this->getTilstandDataFoerTo();
    $tc = $this->getTilstandDataFoerTc();
    $etaC = $this->getTilstandDataFoerEtac();
    $etaKapa = $this->getTilstandDataFoerEtaKapa();
    $ek = $this->getTilstandDataFoerEk();

    if ($tc > $to) {
      return ($ek * $etaC * $etaKapa * ($to + 273)) / ($tc - $to);
    }
    else {
      return 0;
    }
  }

  /**
   * See calculation file, cell C15.
   */
  public function calculateEtotFoer() {
    $ek = $this->getTilstandDataFoerEk();
    $ehjK = $this->getTilstandDataFoerEhjK();
    $ehjV = $this->getTilstandDataFoerEhjV();

    return $ek + $ehjK + $ehjV;
  }

  /**
   * See calculation file, cell E11.
   */
  public function calculateEkEfter() {
    $to = $this->getTilstandDataEfterTo();
    $tc = $this->getTilstandDataEfterTc();
    $etaC = $this->getTilstandDataEfterEtac();
    $etaKapa = $this->getTilstandDataEfterEtaKapa();
    $qbehov = $this->getTilstandDataEfterQbehov();

    if ($etaC > 0 && $etaKapa > 0) {
      return $qbehov * ($tc-$to) / ($to + 273) / $etaC / $etaKapa;
    }
    else {
      return 0;
    }
  }

  /**
   * See calculation file, cell E14.
   */
  public function calculateQbehovEfter() {
    return $this->calculateQbehovFoer();
  }

  /**
   * See calculation file, cell E15.
   */
  public function calculateEtotEfter() {
    $ek = $this->getTilstandDataEfterEk();
    $ehjK = $this->getTilstandDataEfterEhjK();
    $ehjV = $this->getTilstandDataEfterEhjV();

    return $ek + $ehjK + $ehjV;
  }

  /**
   * See calculation file, cell E17.
   */
  public function calculateEtotReduktion() {
    $etotFoer = $this->getTilstandDataFoerEtot();
    $etotEfter = $this->getTilstandDataEfterEtot();

    if ($etotFoer != $etotEfter) {
      return ($etotFoer - $etotEfter) / $etotFoer * 100;
    }
    else {
      return 0;
    }
  }

  /**
   * See calculation file, cell I15.
   */
  public function calculateSamletBesparelse() {
    $etotFoer = $this->getTilstandDataFoerEtot();
    $etotEfter = $this->getTilstandDataEfterEtot();

    return $etotFoer - $etotEfter;
  }

}
