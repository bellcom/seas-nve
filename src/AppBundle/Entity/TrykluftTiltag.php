<?php
/**
 * @file
 * TrykluftTiltag.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Annotations\Formula;
use AppBundle\Entity\Traits\FormulableCalculationEntity;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * TrykluftTiltag.
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class TrykluftTiltag extends Tiltag {

    /**
     * @Formula("$this->calculateSamletEnergibesparelserExpr()")
     */
    protected $samletEnergibesparelse;

    /**
    * Constructor
    */
    public function __construct() {
        parent::__construct();
        $this->setDefault();
    }

    protected function setDefault() {
        parent::setDefault();

        if ($this->getTitle() == NULL) {
            // @Todo: Find af way to use the translations system or move this to some place else....
            $this->setTitle('Trykluft');
        }
    }

    /**
     * Calculate values in this Tiltag
     */
    public function calculate() {
        $this->varmebesparelseGUF = $this->calculateVarmebesparelseGUF();
        $this->varmebesparelseGAF = $this->calculateVarmebesparelseGAF();
        $this->elbesparelse = $this->calculateElbesparelse();
        $this->vandbesparelse = $this->calculateVandbesparelse();
        $this->samletEnergibesparelse = $this->calculateSamletEnergibesparelse();

        // Calculating values by formulas from annotation.
        $this->samletCo2besparelse = $this->calculateByFormula('samletCo2besparelse');

        // This may be computed, may be an input
        if (($value = $this->calculateBesparelseDriftOgVedligeholdelse()) !== NULL) {
            $this->besparelseDriftOgVedligeholdelse = $value;
        }
        // This may be computed, may be an input
        if (($value = $this->calculateLevetid()) !== NULL) {
            $this->levetid = $value;
        }
        $this->antalReinvesteringer = $this->calculateAntalReinvesteringer();
        $this->anlaegsinvestering_beregnet = $this->calculateAnlaegsinvestering();
        $this->anlaegsinvestering = $this->anlaegsinvestering_beregnet;
        if ($this->reelAnlaegsinvestering > 0) {
            $this->anlaegsinvestering = $this->reelAnlaegsinvestering;
        }
        if ($this->opstartsomkostninger > 0) {
            $this->anlaegsinvestering += $this->opstartsomkostninger;
        }
        $this->aaplusInvestering = $this->calculateAaplusInvestering();
        $this->reinvestering = $this->calculateReinvestering();
        $this->scrapvaerdi = $this->calculateScrapvaerdi();
        $this->cashFlow15 = $this->calculateCashFlow(15);
        $this->cashFlow30 = $this->calculateCashFlow(30);
        $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
        $this->nutidsvaerdiSetOver15AarKr = $this->calculateNutidsvaerdiSetOver15AarKr();
        $this->besparelseAarEt = $this->calculateSavingsForYear(1);
        $this->maengde = $this->calculateMaengde();
        $this->enhed = $this->calculateEnhed();
    }

    /**
     * Calculates value that is using in elbesparelse calculation.
     *
     * @return float
     */
    protected function calculateElbesparelseValue() {
        return  $this->sum('elbespKwhAar');
    }

    /**
     * @inheritDoc
     * @Formula("$this->calculateElbesparelseValue() * $this->calculateEnergiledelseFaktor()")
     */
    protected function calculateElbesparelse($value = null) {
        $value = $this->calculateElbesparelseValue();

        return parent::calculateElbesparelse($value);
    }

    /**
     * Calculates value that is using in varmebesparelseGAF calculation.
     *
     * @return float
     */
    protected function calculateVarmebesparelseGAFValue() {
        return $this->sum('varmebespKwhAar');
    }

    /**
     * @inheritDoc
     * @Formula("$this->calculateVarmebesparelseGAFValue() * $this->calculateEnergiledelseFaktor()")
     */
    protected function calculateVarmebesparelseGAF($value = null) {
        $value = $this->calculateVarmebesparelseGAFValue();

        return parent::calculateVarmebesparelseGAF($value);
    }


    function calculateSamletEnergibesparelserExpr() {
        return $this->calculateSamletEnergibesparelse(TRUE);
    }

    /**
     * Accumulate varmebespKrAar and elbespKrAar from tiltagDetails .
     *
     * @return float
     */
    protected function calculateSamletEnergibesparelse($exp = FALSE) {
      $result = array(
          $this->sum('varmebespKrAar', $exp),
          $this->sum('elbespKrAar', $exp)
      );
      if ($exp) {
          return implode(' + ', $result);
      }

      return array_sum($result);
    }

}
