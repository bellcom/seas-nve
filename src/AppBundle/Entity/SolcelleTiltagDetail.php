<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Calculation\Calculation;
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
   * @inheritdoc
   */
  public function init(Tiltag $tiltag) {
    $configuration = $tiltag->getRapport()->getConfiguration();

    $this->energiprisstigningPctPrAar = $configuration->getSolcelletiltagdetailEnergiprisstigningPctPrAar();
    $this->salgsprisFoerste10AarKrKWh = $configuration->getSolcelletiltagdetailSalgsprisFoerste10AarKrKWh();
    $this->salgsprisEfter10AarKrKWh = $configuration->getSolcelletiltagdetailSalgsprisEfter10AarKrKWh();
  }

  /**
   * @var float
   *
   * @ORM\Column(name="anlaegsstoerrelseKWp", type="decimal", scale=4, precision=14)
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
   * @ORM\Column(name="produktionKWh", type="decimal", scale=4, precision=14)
   */
  protected $produktionKWh;

  /**
   * @var float
   *
   * @ORM\Column(name="tilNettetPct", type="decimal", scale=4)
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
   * @ORM\Column(name="forringetYdeevnePrAar", type="decimal", scale=4, precision=14)
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
   * @ORM\Column(name="salgsprisFoerste10AarKrKWh", type="decimal", scale=4, precision=14)
   */
  protected $salgsprisFoerste10AarKrKWh;

  /**
   * @var float
   *
   * @ORM\Column(name="salgsprisEfter10AarKrKWh", type="decimal", scale=4, precision=14)
   */
  protected $salgsprisEfter10AarKrKWh;

  /**
   * @var float
   *
   * @ORM\Column(name="energiprisstigningPctPrAar", type="decimal", scale=4)
   */
  protected $energiprisstigningPctPrAar;

  /**
   * @var float
   *
   * @ORM\Column(name="investeringKr", type="decimal", scale=4, precision=14)
   */
  protected $investeringKr;

  /**
   * @var float
   *
   * @ORM\Column(name="screeningOgProjekteringKr", type="decimal", scale=4, precision=14)
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

  /**
   * @var array
   *
   * @Calculated
   * @ORM\Column(name="cashFlow", type="array")
   */
  protected $cashFlow;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="simpelTilbagebetalingstidAar", type="float")
   */
  protected $simpelTilbagebetalingstidAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="nutidsvaerdiSetOver15AarKr", type="float")
   */
  protected $nutidsvaerdiSetOver15AarKr;

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
  public function setSolcelle(Solcelle $solcelle = NULL) {
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

  public function getCashFlow() {
    if (!$this->cashFlow) {
      $cashFlow = $this->calculateCashFlow();
      $this->cashFlow = $cashFlow;
    }
    return $this->cashFlow;
  }

  public function getSimpelTilbagebetalingstidAar() {
    return $this->simpelTilbagebetalingstidAar;
  }

  public function getNutidsvaerdiSetOver15AarKr() {
    return $this->nutidsvaerdiSetOver15AarKr;
  }

  public function calculate() {
    $this->tilEgetForbrugPct = $this->calculateTilEgetForbrugPct();
    $this->egetForbrugAfProduktionenKWh = $this->calculateEgetForbrugAfProduktionenKWh();
    $this->produktionTilNettetKWh = $this->calculateProduktionTilNettetKWh();
    $this->prisForNyInverterKr = $this->calculatePrisForNyInverterKr();
    $this->driftPrAarKr = $this->calculateDriftPrAarKr();
    $this->raadighedstarifKr = $this->calculateRaadighedstarifKr();
    $this->totalDriftomkostningerPrAar = $this->calculateTotalDriftomkostningerPrAar();
    $this->cashFlow = $this->calculateCashFlow();
    $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
    $this->nutidsvaerdiSetOver15AarKr = $this->calculateNutidsvaerdiSetOver15AarKr();
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

  private function calculateSimpelTilbagebetalingstidAar() {
    return array_sum($this->cashFlow['TBT']);
  }

  private function calculateNutidsvaerdiSetOver15AarKr() {
    return Calculation::npv($this->getRapport()->getKalkulationsrente(), $this->cashFlow['Cash flow']);
  }

  /**
   * Calculate cash flow for a number of years.
   *
   * @param integer $numberOfYears
   *   The number of years.
   *
   * @return array
   *   The cash flow.
   */
  private function calculateCashFlow($numberOfYears = 15) {
    $inflation = $this->getRapport()->getInflation();
    $elKrKWh = $this->getRapport()->getElKrKWh();

    $flow = array(
      'Investering' => array_fill(0, $numberOfYears + 1, 0),
      'Drift' => array_fill(0, $numberOfYears + 1, 0),
      'Eget forbrug' => array_fill(0, $numberOfYears + 1, 0),
      'Salg til nettet' => array_fill(0, $numberOfYears + 1, 0),
      'Inv. skift' => array_fill(0, $numberOfYears + 1, 0),
      'Cash flow' => array_fill(0, $numberOfYears + 1, 0),
      'STATUS' => array_fill(0, $numberOfYears + 1, 0),
      'TBT' => array_fill(0, $numberOfYears + 1, 0),
    );

    $flow['Investering'][1] = -$this->tiltag->getAnlaegsinvestering();

    $tilNettetPct = $this->tilNettetPct;
    if (!empty($this->tiltag->getRisikovurderingAendringIBesparelseFaktor())) {
      $tilNettetPct *= 1 + $this->tiltag->getRisikovurderingAendringIBesparelseFaktor();
    }

    for ($year = 1; $year <= $numberOfYears; $year++) {
      $flow['Drift'][$year] = -$this->totalDriftomkostningerPrAar * pow(1 + $inflation, $year);
      $flow['Eget forbrug'][$year] = $this->produktionKWh * $this->tilEgetForbrugPct * $elKrKWh
                                   * pow(1 - $this->forringetYdeevnePrAar, $year -1 ) * pow(1 + $inflation + $this->energiprisstigningPctPrAar, $year - 1);
      $flow['Salg til nettet'][$year] = $this->produktionKWh * $tilNettetPct *
                                      (($year > 10) ? $this->salgsprisEfter10AarKrKWh : $this->salgsprisFoerste10AarKrKWh)
                                      * pow(1 - $this->forringetYdeevnePrAar, $year);
      $flow['Inv. skift'][$year] = ($year == $this->inverterskift1Aar || $year == $this->inverterskift2Aar)
                                 ? -$this->prisForNyInverterKr // -$R$39
                                 * pow(1 + $inflation, $year) // *(1+$'1.TiltagslisteRådgiver'.$AK$23)^L44
                                 : 0;
      $flow['Cash flow'][$year] = $flow['Investering'][$year] + $flow['Drift'][$year] + $flow['Eget forbrug'][$year] + $flow['Salg til nettet'][$year] + $flow['Inv. skift'][$year];
      if ($year == $numberOfYears) {
        // Add scrapvaerdi
        $flow['Cash flow'][$year] += (1 - ($numberOfYears / $this->tiltag->getLevetid())) * pow(1 + $inflation, $numberOfYears) * ($this->investeringKr + $this->screeningOgProjekteringKr);
      }
      $flow['STATUS'][$year] = $flow['STATUS'][$year - 1] + $flow['Cash flow'][$year];
      $flow['TBT'][$year] = $flow['STATUS'][$year] > 0 ? 0 : 1;
    }

    return $flow;
  }

}
