<?php
/**
 * @file
 * VarmePumpeTiltag.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Annotations\Formula;
use AppBundle\Entity\Traits\FormulableCalculationEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * VarmePumpeTiltag.
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class VarmePumpeTiltag extends VarmeTiltag {

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
            $this->setTitle('VarmePumpe');
        }
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
