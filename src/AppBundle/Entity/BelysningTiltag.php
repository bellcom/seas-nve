<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Formula;
use Doctrine\ORM\Mapping as ORM;

/**
 * BelysningTiltag.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BelysningTiltagRepository")
 */
class BelysningTiltag extends Tiltag
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
        $this->setTitle('Belysning');
    }


    /**
     * Calculate values in this Tiltag
     */
    public function calculate() {
        parent::calculate();
        $this->forbrugFoer = $this->calculateForbrugFoer();
        $this->forbrugEfter = $this->calculateForbrugEfter();
    }

    /**
     * Calculates forbrug før value.
     */
    protected function calculateForbrugFoer($value = null)
    {
        return $this->sum('elforbrugkWtAar');
    }

    /**
     * Calculates forbrug efter value.
     */
    protected function calculateForbrugEfter($value = null)
    {
        return $this->sum('nytElforbrugkWtAar');
    }

    /**
     * @inheritDoc
     */
    protected function calculateVarmebesparelseGAF($value = null)
    {
        return 0;
    }

    /**
     * Calculates expressions that is using in Elbesparelse calculation.
     *
     * @return float
     */
    protected function calculateElbesparelseValueExpr($exp = TRUE)
    {
        return $this->sum('kwhBesparelseEl', $exp);
    }

    /**
     * @inheritDoc
     * @Formula("$this->calculateElbesparelseValueExpr() * $this->calculateEnergiledelseFaktor()")
     */
    protected function calculateElbesparelse($value = null)
    {
        $value = $this->calculateElbesparelseValueExpr(FALSE);

        return parent::calculateElbesparelse($value);
    }

    /**
     * Calculates expressions that is using in Anlaegsinvestering calculation.
     *
     * @return float
     */
    protected function calculateAnlaegsinvesteringValueExpr()
    {
        return $this->sum('investeringAlleLokalerKr', TRUE);
    }

    /**
     * @inheritDoc
     * @Formula("$this->calculateAnlaegsinvesteringValueExpr() * $this->calculateAnlaegsinvesteringFaktor()")
     */
    protected function calculateAnlaegsinvestering($value = NULL)
    {
        $value = $this->sum('investeringAlleLokalerKr');

        return parent::calculateAnlaegsinvestering($value);
    }

    protected function calculateReinvestering()
    {
        if ($this->levetid >= 15) {
            return 0;
        } else {
            return $this->faktorForReinvesteringer * $this->getAaplusInvestering();
        }
    }

    protected function calculateMaengde()
    {
        return $this->sum('rumstoerrelseM2');
    }

    protected function calculateEnhed()
    {
        return 'm2';
    }

    /**
     * @Formula("$this->aaplusInvestering / $this->samletEnergibesparelse")
     */
    protected function calculateSimpelTilbagebetalingstidAar() {
        return $this->divide(($this->aaplusInvestering),
            $this->samletEnergibesparelse);
    }

}
