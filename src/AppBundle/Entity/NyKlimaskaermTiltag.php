<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Formula;
use Doctrine\ORM\Mapping as ORM;

/**
 * NyKlimaskaermTiltag.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class NyKlimaskaermTiltag extends Tiltag {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // @Todo: Find af way to use the translations system or move this to some place else....
        $this->setTitle('Klimaskærm');
    }

    /**
     * Calculates value that is using in varmebesparelseGAF calculation.
     *
     * @return float
     */
    protected function calculateVarmebesparelseGAFValue() {
        return $this->sum('kWhBesparVarmevaerkEksternEnergikilde');
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
     * Calculates value that is using in elbesparelse calculation.
     *
     * @return float
     */
    protected function calculateElbesparelseValue() {
        return  $this->sum('kWhBesparElvaerkEksternEnergikilde');
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
     * Calculates value that is using in Anlaegsinvestering calculation.
     *
     * @return float
     */
    protected function calculateAnlaegsinvesteringValue() {
        return  $this->sum('samletInvesteringKr');
    }

    /**
     * @inheritDoc
     * @Formula("$this->calculateAnlaegsinvesteringValue() * $this->calculateAnlaegsinvesteringFaktor()")
     */
    protected function calculateAnlaegsinvestering($value = NULL) {
        $value = $this->calculateAnlaegsinvesteringValue();

        return parent::calculateAnlaegsinvestering($value);
    }

    /**
     * {@inheritDoc}
     */
    protected function calculateForbrugFoerVarme() {
        return $this->sum(function($detail) { return $detail->calculateForbrugFoer(); });
    }

    protected function calculateLevetid() {
        $denominator = $this->sum(function($detail) {
            // AI
            return $detail->getEnhedsprisEksklMoms() * $detail->getArealM2();
        });
        if ($denominator == 0) {
            return 1;
        }

        return round($this->divide(
            $this->sum(function($detail) {
                // AK
                if ($detail->getLevetidAar() > 0) {
                    return $detail->getLevetidAar() * $detail->getEnhedsprisEksklMoms() * $detail->getArealM2();
                }
                else {
                    return 0;
                }
            }),
            $denominator
        ));
    }

    protected function calculateMaengde() {
        return $this->sum('arealM2');
    }

    protected function calculateEnhed() {
        return 'm2';
    }

}
