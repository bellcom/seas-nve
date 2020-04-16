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
        $default = array(
            'elrumvarme' => array(
                'pris' => NULL,
            )
        );

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
