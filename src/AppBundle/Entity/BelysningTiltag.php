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
class BelysningTiltag extends Tiltag {

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
  public function __construct() {
    parent::__construct();

    // @Todo: Find af way to use the translations system or move this to some place else....
    $this->setTitle('Belysning');
  }

  /**
   * Calculates value that is using in varmebesparelseGAF calculation.
   *
   * @return float
   */
  protected function calculateVarmebesparelseGAFValue() {
    return $this->sum('kWhBesparelseVarmeFraVarmevaerket') * $this->getRapport()->getFaktorPaaVarmebesparelse();
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
   * Calculates expressions that is using in Elbesparelse calculation.
   *
   * @return float
   */
  protected function calculateElbesparelseValueExpr() {
    return $this->sum('kwhBesparelseEl', TRUE);
  }

  /**
   * @inheritDoc
   * @Formula("$this->calculateElbesparelseValueExpr() * $this->calculateRisikoFaktor() * $this->calculateEnergiledelseFaktor()")
   */
  protected function calculateElbesparelse($value = null) {
    $value = $this->sum('kwhBesparelseEl');

    return parent::calculateElbesparelse($value);
  }

  /**
   * Calculates expressions that is using in Anlaegsinvestering calculation.
   *
   * @return float
   */
  protected function calculateAnlaegsinvesteringValueExpr() {
    return $this->sum('investeringAlleLokalerKr', TRUE);
  }
  
  /**
   * @inheritDoc
   * @Formula("$this->calculateAnlaegsinvesteringValueExpr() * $this->calculateAnlaegsinvesteringFaktor()")
   */
  protected function calculateAnlaegsinvestering($value = NULL) {
    $value = $this->sum('investeringAlleLokalerKr');

    return parent::calculateAnlaegsinvestering($value);
  }

  protected function calculateReinvestering() {
    if ($this->levetid >= 15) {
      return 0;
    }
    else {
      return $this->faktorForReinvesteringer * $this->getAaplusInvestering();
    }
  }

  protected function calculateBesparelseDriftOgVedligeholdelseExpr() {
    return $this->sum('driftsbesparelseTilLyskilderKrAar', TRUE);
  }

  /**
   * @Formula("$this->calculateBesparelseDriftOgVedligeholdelseExpr()")
   */
  protected function calculateBesparelseDriftOgVedligeholdelse() {
    return $this->sum('driftsbesparelseTilLyskilderKrAar');
  }

  protected function calculateLevetid() {
    return round($this->divide($this->sum(function($detail) { return $detail->getUdgiftSensorer() * $detail->getLevetidSensor(); }) + $this->sum('armaturvaegtning') + $this->sum('lyskildevaegtning'),
                               $this->sum('udgiftSensorer') + $this->sum('udgiftArmaturer') + $this->sum('udgiftLyskilde')));
  }

  protected function calculateMaengde() {
    return $this->sum('rumstoerrelseM2');
  }

  protected function calculateEnhed() {
    return 'm2';
  }

}
