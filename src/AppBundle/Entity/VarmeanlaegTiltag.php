<?php
/**
 * @file
 * VarmeTiltag.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Annotations\Formula;
use AppBundle\DBAL\Types\VarmeanlaegTiltag\EnergiType;
use AppBundle\Entity\Traits\FormulableCalculationEntity;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * VarmeTiltag.
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class VarmeanlaegTiltag extends Tiltag {

    /**
     * @Formula("$this->calculateSamletEnergibesparelserExpr()")
     */
    protected $samletEnergibesparelse;

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
        global $kernel;
        $configuration = $kernel->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Configuration')->getConfiguration();
        $this->setConfiguration($configuration);
        parent::__construct();
        $this->setTitle('Varmeanlæg');
        $this->setDefault();

    }

    protected function setDefault() {
        $this->setPriserOverride($this->getPriserOverride() + $this->getPriserOverrideDefault());
        $this->setCo2Override($this->getCo2Override() + $this->getCo2OverrideDefault());
    }

    /**
     * Set priserOverride
     *
     * @param array $priserOverride
     * @return VarmeanlaegTiltag
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
        return $this->priserOverride == NULL ? array() : $this->priserOverride;
    }

    /**
     * Get Priser Override default value
     *
     * @return array
     */
    public function getPriserOverrideDefault() {
        $energiTyper = array_filter(array_keys(EnergiType::getChoices()));
        $default = [];
        foreach ($energiTyper as $type) {
            $default[$type] = array(
                'pris' => NULL,
            );
        }
        return $default;
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

    /**
     * Get Priser Override default value
     *
     * @return array
     */
    public function getCo2OverrideDefault() {
        $varmeEnergiCo2 = $this->configuration->getVarmeEnergiCo2();
        $energiTyper = array_filter(array_keys(EnergiType::getChoices()));
        $default = [];
        foreach ($energiTyper as $type) {
            $default[$type] = array(
                'value' => isset($varmeEnergiCo2[$type]) ? $varmeEnergiCo2[$type] : NULL,
            );
        }
        return $default;
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
     * @Formula("0")
     */
    protected function calculateElbesparelse($value = null) {
      return parent::calculateElbesparelse($value);
    }

    /**
     * Calculate values in this Tiltag
     */
    public function calculate() {
        $this->varmebesparelseGUF = $this->calculateVarmebesparelseGUF();
        $this->varmebesparelseGAF = $this->calculateVarmebesparelseGAF();

        // Calculating values by formulas from annotation.
        $this->samletEnergibesparelse = $this->calculateSamletEnergibesparelse();
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
        $this->cashFlowSet = $this->calculateCashFlow($this->getConfiguration()->getNutidsvaerdiBeregnAar());
        $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
        $this->nutidsvaerdiSet = $this->calculateNutidsvaerdiSet();
        $this->akkumuleretNutidsvaerdiSet = $this->calculateAkkumuleterNutidsvaerdiSet();
        $this->nutidsvaerdiSetOver15AarKr = $this->calculateNutidsvaerdiSetOver15AarKr();
        $this->besparelseAarEt = $this->calculateSavingsForYear(1);
        $this->maengde = $this->calculateMaengde();
        $this->enhed = $this->calculateEnhed();
    }

  /**
     * Cashflow calculation.
     *
     * @param $numberOfYears
     * @param int $yderligereBesparelseKrAar
     * @return array
     */
    protected function calculateCashFlow($numberOfYears, $yderligereBesparelseKrAar = 0) {
        $inflation = $this->getRapport()->getInflation();
        $besparelseStrafafkoelingsafgift = floatval($this->besparelseStrafafkoelingsafgift);
        $besparelseDriftOgVedligeholdelse = floatval($this->besparelseDriftOgVedligeholdelse);

        $cashFlow = array_fill(1, $numberOfYears, 0);
        for ($year = 1; $year <= $numberOfYears; $year++) {
            $value = $this->getSamletEnergibesparelse() + ($besparelseStrafafkoelingsafgift + $besparelseDriftOgVedligeholdelse) * pow(1 + $inflation, $year);
            $cashFlow[$year] = $value + $yderligereBesparelseKrAar;
        }

      return $cashFlow;
    }

    function calculateSamletEnergibesparelserExpr() {
      return $this->calculateSamletEnergibesparelse(TRUE);
    }

    /**
     * Accumulate samletBesparelse from tiltagDetails .
     *
     * @return float
     */
    protected function calculateSamletEnergibesparelse($exp = FALSE) {
        return $this->sum('samletBesparelse', $exp);
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
