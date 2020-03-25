<?php
/**
 * @file
 * TrykluftTiltag.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Annotations\Formula;
use AppBundle\Entity\Traits\FormulableCalculationEntity;
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
     * @Formula("$this->varmebesparelseGAF * $this->calculateVarmepris() + $this->elbesparelse * $this->getRapportElKrKWh()")
     */
    protected $samletEnergibesparelse;

    /**
     * @Formula("(($this->varmebesparelseGAF / 1000) * $this->getRapportVarmeKgCo2MWh() + ($this->elbesparelse / 1000) * $this->getRapportElKgCo2MWh()) / 1000")
     */
    protected $samletCo2besparelse;

    /**
     *
     * @var array
     * @ORM\Column(name="priserOverride", type="array")
     */
    protected $priserOverride;

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
        return $this->getRapportVarmeKrKWh();
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
        return $this->getRapportElKrKWh();
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
        $this->samletTilskud = $this->calculateByFormula('samletTilskud');

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
        $this->tilskudsstoerrelse = $this->getTilskudsstoerrelse();
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
     * @Formula("$this->calculateElbesparelseValue() * $this->calculateRisikoFaktor() * $this->calculateEnergiledelseFaktor()")
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
     * @Formula("$this->calculateVarmebesparelseGAFValue() * $this->calculateRisikoFaktor() * $this->calculateEnergiledelseFaktor()")
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
     */
    public function postLoad() {
        parent::postLoad();
        $this->setDefault();
    }

}
