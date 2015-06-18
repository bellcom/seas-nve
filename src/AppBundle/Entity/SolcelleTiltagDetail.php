<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * SolcelleTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SolcelleDetailRepository")
 */
class SolcelleTiltagDetail extends TiltagDetail {
  /**
   * @var float
   *
   * @ORM\Column(name="anlaegsstoerrelseKWp", type="decimal", scale=2)
   */
  protected $anlaegsstoerrelseKWp;

  /**
   * @var BelysningTiltagDetailLyskilde
   *
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Solcelle")
   * ORM\JoinColumn(name="solcelle_id", referencedColumnName="id")
   */
  protected $solcelle;

  /**
   * @var float
   *
   * @ORM\Column(name="produktionKWh", type="decimal", scale=2)
   */
  protected $produktionKWh;

  /**
   * @var float
   *
   * @ORM\Column(name="tilNettetPct", type="decimal", scale=2)
   */
  protected $tilNettetPct;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="tilEgetForbrugPct", type="float")
   */
  protected $tilEgetForbrugPct;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="egetForbrugAfProduktionenKWh", type="float")
   */
  protected $egetForbrugAfProduktionenKWh;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="produktionTilNettetKWh", type="float")
   */
  protected $produktionTilNettetKWh;

  /**
   * @var float
   *
   * @ORM\Column(name="forringetYdeevnePrAar", type="decimal", scale=2)
   */
  protected $forringetYdeevnePrAar;

  /**
   * @var int
   *
   * @ORM\Column(name="inverterskift1Aar", type="integer")
   */
  protected $inverterskift1Aar;

  /**
   * @var int
   *
   * @ORM\Column(name="inverterskift2Aar", type="integer")
   */
  protected $inverterskift2Aar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="prisForNyInverterKr", type="float")
   */
  protected $prisForNyInverterKr;

  /**
   * @var float
   *
   * @ORM\Column(name="salgsprisFoerste10AarKrKWh", type="decimal", scale=2)
   */
  protected $salgsprisFoerste10AarKrKWh;

  /**
   * @var float
   *
   * @ORM\Column(name="salgsprisEfter10AarKrKWh", type="decimal", scale=2)
   */
  protected $salgsprisEfter10AarKrKWh;

  /**
   * @var float
   *
   * @ORM\Column(name="energiprisstigningPctPrAar", type="decimal", scale=2)
   */
  protected $energiprisstigningPctPrAar;

  /**
   * @var float
   *
   * @ORM\Column(name="investeringKr", type="decimal", scale=2)
   */
  protected $investeringKr;

  /**
   * @var float
   *
   * @ORM\Column(name="screeningOgProjekteringKr", type="decimal", scale=2)
   */
  protected $screeningOgProjekteringKr;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="driftPrAarKr", type="float")
   */
  protected $driftPrAarKr;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="omkostningTilMaalerKr", type="float")
   */
  protected $omkostningTilMaalerKr;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="raadighedstarifKr", type="float")
   */
  protected $raadighedstarifKr;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="totalDriftomkostningerPrAar", type="float")
   */
  protected $totalDriftomkostningerPrAar;

  public function setAnlaegsstoerrelseKWp($anlaegsstoerrelseKWp) {
    $this->anlaegsstoerrelseKWp = $anlaegsstoerrelseKWp;

    return $this;
  }

  public function getAnlaegsstoerrelseKWp() {
    return $this->anlaegsstoerrelseKWp;
  }

  /**
   * Set solcelle
   *
   * @param Solcelle $solcelle
   * @return SolcelleTiltagDetail
   */
  public function setSolcelle(Solcelle $solcelle) {
    $this->solcelle = $solcelle;
    $this->addData('solcelle', $solcelle);

    return $this;
  }

  /**
   * Get solcelle.
   *
   * @param bool $useCached
   *   If set, then that cached value is returned. Otherwise the current value is returned.
   *
   * @return Solcelle
   */
  public function getSolcelle($useCached = false) {
    return $useCached ? $this->getData('solcelle') : $this->solcelle;
  }

  public function setProduktionKWh($produktionKWh) {
    $this->produktionKWh = $produktionKWh;

    return $this;
  }

  public function getProduktionKWh() {
    return $this->produktionKWh;
  }

  public function setTilNettetPct($tilNettetPct) {
    $this->tilNettetPct = $tilNettetPct;

    return $this;
  }

  public function getTilNettetPct() {
    return $this->tilNettetPct;
  }

  public function setForringetYdeevnePrAar($forringetYdeevnePrAar) {
    $this->forringetYdeevnePrAar = $forringetYdeevnePrAar;

    return $this;
  }

  public function getForringetYdeevnePrAar() {
    return $this->forringetYdeevnePrAar;
  }

  public function setInverterskift1Aar($inverterskift1Aar) {
    $this->inverterskift1Aar = $inverterskift1Aar;

    return $this;
  }

  public function getInverterskift1Aar() {
    return $this->inverterskift1Aar;
  }

  public function setInverterskift2Aar($inverterskift2Aar) {
    $this->inverterskift2Aar = $inverterskift2Aar;

    return $this;
  }

  public function getInverterskift2Aar() {
    return $this->inverterskift2Aar;
  }

  public function setSalgsprisFoerste10AarKrKWh($salgsprisFoerste10AarKrKWh) {
    $this->salgsprisFoerste10AarKrKWh = $salgsprisFoerste10AarKrKWh;

    return $this;
  }

  public function getSalgsprisFoerste10AarKrKWh() {
    return $this->salgsprisFoerste10AarKrKWh;
  }

  public function setSalgsprisEfter10AarKrKWh($salgsprisEfter10AarKrKWh) {
    $this->salgsprisEfter10AarKrKWh = $salgsprisEfter10AarKrKWh;

    return $this;
  }

  public function getSalgsprisEfter10AarKrKWh() {
    return $this->salgsprisEfter10AarKrKWh;
  }

  public function setEnergiprisstigningPctPrAar($energiprisstigningPctPrAar) {
    $this->energiprisstigningPctPrAar = $energiprisstigningPctPrAar;

    return $this;
  }

  public function getEnergiprisstigningPctPrAar() {
    return $this->energiprisstigningPctPrAar;
  }

  public function setInvesteringKr($investeringKr) {
    $this->investeringKr = $investeringKr;

    return $this;
  }

  public function getInvesteringKr() {
    return $this->investeringKr;
  }

  public function setScreeningOgProjekteringKr($screeningOgProjekteringKr) {
    $this->screeningOgProjekteringKr = $screeningOgProjekteringKr;

    return $this;
  }

  public function getScreeningOgProjekteringKr() {
    return $this->screeningOgProjekteringKr;
  }

  public function setOmkostningTilMaalerKr($omkostningTilMaalerKr) {
    $this->omkostningTilMaalerKr = $omkostningTilMaalerKr;

    return $this;
  }

  public function getOmkostningTilMaalerKr() {
    return $this->omkostningTilMaalerKr;
  }

  public function getTilEgetForbrugPct() {
    return $this->tilEgetForbrugPct;
  }

  public function getEgetForbrugAfProduktionenKWh() {
    return $this->egetForbrugAfProduktionenKWh;
  }

  public function getProduktionTilNettetKWh() {
    return $this->produktionTilNettetKWh;
  }

  public function getPrisForNyInverterKr() {
    return $this->prisForNyInverterKr;
  }

  public function getDriftPrAarKr() {
    return $this->driftPrAarKr;
  }

  public function getRaadighedstarifKr() {
    return $this->raadighedstarifKr;
  }

  public function getTotalDriftomkostningerPrAar() {
    return $this->totalDriftomkostningerPrAar;
  }

  public function calculate() {
    $this->tilEgetForbrugPct = $this->calculateTilEgetForbrugPct();
    $this->egetForbrugAfProduktionenKWh = $this->calculateEgetForbrugAfProduktionenKWh();
    $this->produktionTilNettetKWh = $this->calculateProduktionTilNettetKWh();
    $this->prisForNyInverterKr = $this->calculatePrisForNyInverterKr();
    $this->driftPrAarKr = $this->calculateDriftPrAarKr();
    $this->raadighedstarifKr = $this->calculateRaadighedstarifKr();
    $this->totalDriftomkostningerPrAar = $this->calculateTotalDriftomkostningerPrAar();
    parent::calculate();
  }

  private function calculateTilEgetForbrugPct() {
    return 1 - $this->tilNettetPct;
  }

  private function calculateEgetForbrugAfProduktionenKWh() {
    return $this->produktionKWh - ($this->produktionKWh * $this->tilNettetPct);
  }

  private function calculateProduktionTilNettetKWh() {
    return $this->produktionKWh - $this->egetForbrugAfProduktionenKWh;
  }

  private function calculatePrisForNyInverterKr() {
    $solcelle = $this->getSolcelle(true);
    return $solcelle ? $solcelle->getInverterpris() : 0;
  }

  private function calculateDriftPrAarKr() {
    $solcelle = $this->getSolcelle(true);
    return $solcelle ? $solcelle->getDrift() : 0;
  }

  private function calculateRaadighedstarifKr() {
    return $this->produktionKWh * 0.14;
  }

  private function calculateTotalDriftomkostningerPrAar() {
    return $this->driftPrAarKr + $this->omkostningTilMaalerKr + $this->raadighedstarifKr;
  }

}
