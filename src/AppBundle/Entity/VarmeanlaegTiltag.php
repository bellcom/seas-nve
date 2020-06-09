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
        $this->setTitle('Varmeanlæg');
        $this->setDefault();
    }

    protected function setDefault() {
        $this->setPriserOverride($this->getPriserOverride() + $this->getPriserOverrideDefault());
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
     * Get elReduktion default value
     *
     * @return array
     */
    public function getPriserOverrideDefault() {
        $energiTyper = array_filter(array_keys(EnergiType::getChoices()));
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
     * Get varmePris
     *
     * @return float
     */
    public function getVarmePris() {
        return $this->getRapportVarmeKrKWh();
    }

    /**
     * Get elPris
     *
     * @return float
     */
    public function getElPris() {
        return $this->getRapportElKrKWh();
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
        $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
        $this->nutidsvaerdiSetOver15AarKr = $this->calculateNutidsvaerdiSetOver15AarKr();
        $this->besparelseAarEt = $this->calculateSavingsForYear(1);
        $this->maengde = $this->calculateMaengde();
        $this->enhed = $this->calculateEnhed();
    }

    /**
     * Accumulate samletBesparelse from tiltagDetails .
     *
     * @return float
     */
    protected function calculateSamletEnergibesparelse() {
        return $this->sum('samletBesparelse');
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
