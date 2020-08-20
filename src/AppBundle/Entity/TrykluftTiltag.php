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
     * @Formula("$this->varmebesparelseGAF * $this->getVarmePris() + $this->elbesparelse * $this->getElPris()")
     */
    protected $samletEnergibesparelse;

    /**
     * @Formula("(($this->varmebesparelseGAF / 1000) * $this->getVarmeKgCo2MWh() + ($this->elbesparelse / 1000) * $this->getElKgCo2MWh()) / 1000")
     */
    protected $samletCo2besparelse;

    /**
     *
     * @var array
     * @ORM\Column(name="priserOverride", type="array")
     */
    protected $priserOverride;

    /**
     *
     * @var array
     * @ORM\Column(name="co2Override", type="array")
     */
    protected $co2Override;

    /**
    * Constructor
    */
    public function __construct() {
        parent::__construct();
        $this->setDefault();
    }

    protected function setDefault() {
        if ($this->getPriserOverride() == NULL) {
            $this->priserOverride = array(
                'el' => array(
                    'overriden' => FALSE,
                    'pris' => NULL,
                ),
                'varme' => array(
                    'overriden' => FALSE,
                    'pris' => NULL,
                ),
            );
        }
        if ($this->getCo2Override() == NULL) {
            $this->co2Override = array(
                'el' => array(
                    'overriden' => FALSE,
                    'value' => NULL,
                ),
                'varme' => array(
                    'overriden' => FALSE,
                    'value' => NULL,
                ),
            );
        }

        if ($this->getTitle() == NULL) {
            // @Todo: Find af way to use the translations system or move this to some place else....
            $this->setTitle('Trykluft');
        }
    }

    /**
     * Set priserOverride
     *
     * @param array $priserOverride
     * @return TrykluftTiltag
     */
    public function setPriserOverride($priserOverride) {
        $this->priserOverride = $priserOverride;

        return $this;
    }

    /**
     * Get priser
     *
     * @return array
     */
    public function getPriserOverride() {
        return $this->priserOverride;
    }
    /**
     * Set co2Override
     *
     * @param array $co2Override
     * @return TrykluftTiltag
     */
    public function setCo2Override($co2Override) {
        $this->co2Override = $co2Override;

        return $this;
    }

    /**
     * Get CO2
     *
     * @return array
     */
    public function getCo2Override() {
        return $this->co2Override;
    }

    /**
     * Get priser
     *
     * @return float
     */
    public function getPriserOverrideKeyValue($type, $key) {
        $priser = $this->getPriserOverride();
        return isset($priser[$type][$key]) ? $priser[$type][$key] : NULL;
    }

    public function getVarmePrisOverriden() { return $this->getPriserOverrideKeyValue('varme', 'pris'); }
    public function isVarmePrisOverriden() { return $this->getPriserOverrideKeyValue('varme', 'overriden'); }
    public function getElPrisOverriden() { return $this->getPriserOverrideKeyValue('el', 'pris'); }
    public function isElPrisOverriden() { return $this->getPriserOverrideKeyValue('el', 'overriden'); }

    /**
     * Get varmePris
     *
     * @return float
     */
    public function getVarmePris() {
        if ($this->isVarmePrisOverriden()) {
            return $this->getVarmePrisOverriden();
        }
        return $this->calculateVarmepris();
    }

    /**
     * Get elPris
     *
     * @return float
     */
    public function getElPris() {
        if ($this->isElPrisOverriden()) {
            return $this->getElPrisOverriden();
        }
        return $this->calculateElpris();
    }

    /**
     * Get CO2
     *
     * @return float
     */
    public function getCo2OverrideKeyValue($type, $key) {
        $co2 = $this->getCo2Override();
        return isset($co2[$type][$key]) ? $co2[$type][$key] : NULL;
    }

    public function getVarmeCo2Overriden() { return $this->getCo2OverrideKeyValue('varme', 'value'); }
    public function isVarmeCo2Overriden() { return $this->getCo2OverrideKeyValue('varme', 'overriden'); }
    public function getElCo2Overriden() { return $this->getCo2OverrideKeyValue('el', 'value'); }
    public function isElCo2Overriden() { return $this->getCo2OverrideKeyValue('el', 'overriden'); }

    /**
     * Get varmeCo2
     *
     * @return float
     */
    public function getVarmeKgCo2MWh() {
        if ($this->isVarmeCo2Overriden()) {
            return $this->getVarmeCo2Overriden();
        }
        return $this->calculateVarmeCo2();
    }

    /**
     * Get elPris
     *
     * @return float
     */
    public function getElKgCo2MWh() {
        if ($this->isElCo2Overriden()) {
            return $this->getElCo2Overriden();
        }
        return $this->calculateElCo2();
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


    /**
     * Accumulate varmebespKrAar and elbespKrAar from tiltagDetails .
     *
     * @return float
     */
    protected function calculateSamletEnergibesparelse() {
        return $this->sum('varmebespKrAar') +  $this->sum('elbespKrAar');
    }

    /**
     * @ORM\PostLoad()
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     */
    public function postLoad(LifecycleEventArgs $event) {
        parent::postLoad($event);
        $this->setDefault();
    }

}
