<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Formula;
use AppBundle\Calculation\Calculation;
use Doctrine\ORM\Mapping as ORM;

/**
 * BelysningTiltag.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class TekniskIsoleringTiltag extends Tiltag
{

    /**
     * @Formula("$this->varmebesparelseGAF * $this->calculateVarmepris() + $this->elbesparelse * $this->getRapportElKrKWh()")
     */
    protected $samletEnergibesparelse;

    /**
     * @Formula("(($this->varmebesparelseGAF / 1000) * $this->getRapportVarmeKgCo2MWh() + ($this->elbesparelse / 1000) * $this->getRapportElKgCo2MWh()) / 1000")
     */
    protected $samletCo2besparelse;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        // @Todo: Find af way to use the translations system or move this to some place else....
        $this->setTitle('Teknisk isolering');
    }

    /**
     * Calculates value that is using in VarmebesparelseGAF calculation.
     *
     * @return float
     */
    protected function calculateVarmebesparelseGAFValue()
    {
        return $this->sum('kwhBesparelseVarmeFraVaerket') * $this->getRapport()->getFaktorPaaVarmebesparelse();
    }

    /**
     * @inheritDoc
     * @Formula("$this->calculateVarmebesparelseGAFValue() * $this->calculateRisikoFaktor() * $this->calculateEnergiledelseFaktor()")
     */
    protected function calculateVarmebesparelseGAF($value = null)
    {
        $value = $this->calculateVarmebesparelseGAFValue();

        return parent::calculateVarmebesparelseGAF($value);
    }

    /**
     * Calculates value that is using in Elbesparelse calculation.
     *
     * @return float
     */
    protected function calculateElbesparelseValue()
    {
        return $this->sum('kwhBesparelseElFraVaerket');
    }

    /**
     * @inheritDoc
     * @Formula("$this->calculateElbesparelseValue() * $this->calculateRisikoFaktor() * $this->calculateEnergiledelseFaktor()")
     */
    protected function calculateElbesparelse($value = null)
    {
        $value = $this->calculateElbesparelseValue();

        return parent::calculateElbesparelse($value);
    }

    /**
     * Calculates value that is using in Anlaegsinvestering calculation.
     *
     * @return float
     */
    protected function calculateAnlaegsinvesteringValue()
    {
        return $this->sum('investeringKr');
    }

    /**
     * @inheritDoc
     * @Formula("$this->calculateAnlaegsinvesteringValue() * $this->calculateAnlaegsinvesteringFaktor()")
     */
    protected function calculateAnlaegsinvestering($value = NULL)
    {
        $value = $this->calculateAnlaegsinvesteringValue();

        return parent::calculateAnlaegsinvestering($value);
    }

    protected function calculateMaengde()
    {
        return $this->sum('roerlaengdeEllerHoejdeAfVvbM');
    }

    protected function calculateEnhed()
    {
        return 'm';
    }

}
