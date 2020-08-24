<?php
/**
 * @file
 * VentilationTiltag.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Annotations\Formula;
use AppBundle\Entity\Traits\FormulableCalculationEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * VentilationTiltag.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class VentilationTiltag extends Tiltag {

    /**
    * Constructor
    */
    public function __construct() {
        parent::__construct();

        // @Todo: Find af way to use the translations system or move this to some place else....
        $this->setTitle('Ventilation');
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

}
