<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Formula;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * Tiltag
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PumpeTiltagRepository")
 */
class PumpeTiltag extends Tiltag {

  protected function setDefault() {
    parent::setDefault();

    if ($this->getTitle() == NULL) {
      // @Todo: Find af way to use the translations system or move this to some place else....
      $this->setTitle('Pumpeudskiftninger');
    }
  }

  /**
   * Calculates value that is using in VarmebesparelseGAF calculation.
   *
   * @return float
   */
  protected function calculateVarmebesparelseGAFValue() {
    return $this->sum('kwhBesparelseVarmeFraVaerket');
  }

  /**
   * Expression function for calculateVarmebesparelseGAFValue.
   *
   * @return float
   */
  protected function calculateVarmebesparelseGAFValueExp() {
    return $this->sum('kwhBesparelseVarmeFraVaerket', TRUE);
  }

  /**
   * @inheritDoc
   * @Formula("($this->calculateVarmebesparelseGAFValueExp()) * $this->calculateEnergiledelseFaktor()")
   */
  protected function calculateVarmebesparelseGAF($value = null) {
    $value = $this->calculateVarmebesparelseGAFValue();

    return parent::calculateVarmebesparelseGAF($value);
  }

  /**
   * {@inheritDoc}
   */
  protected function calculateForbrugFoerEl() {
    $result = $this->sum(function($detail) { return $detail->calculateElForbrugFoerKWhAar(); });
    return $result;
  }

  /**
   * {@inheritDoc}
   */
  protected function calculateForbrugEfter() {
    return $this->calculateForbrugEfterEl();
  }

  /**
   * Calculates based on value before El - savings El.
   *
   * @Formula("$this->calculateForbrugFoerEl() - $this->getElbesparelse()")
   * @return float|int
   */
  public function calculateForbrugEfterEl() {
    return $this->calculateForbrugFoerEl() - $this->getElbesparelse();
  }

  /**
   * Calculates based on value before Varme - savings Varme.
   *
   * @Formula("$this->calculateForbrugFoerVarme() - $this->getVarmebesparelseGAF() - $this->getVarmebesparelseGUF()")
   * @return float|int
   */
  public function calculateForbrugEfterVarme() {
    return $this->calculateForbrugFoerVarme() - $this->getVarmebesparelseGAF() - $this->getVarmebesparelseGUF();
  }

  /**
   * Calculates based on value before - savings.
   *
   * @Formula("$this->calculateForbrugEfterKrEl() + $this->calculateForbrugEfterKrVarme()")
   * @return float|int
   */
  protected function calculateForbrugEfterKr() {
    return $this->calculateForbrugEfterKrEl();
  }

  /**
   * Calculates based on value efter El * Elpris.
   *
   * @Formula("$this->calculateForbrugEfterEl() * $this->getElPris()")
   * @return float|int
   */
  public function calculateForbrugEfterKrEl() {
    return $this->calculateForbrugEfterEl() * $this->getElPris();
  }

  /**
   * Calculates based on value efter Varme * Varmepris.
   *
   * @Formula("$this->calculateForbrugEfterVarme() * $this->getVarmePris()")
   * @return float|int
   */
  public function calculateForbrugEfterKrVarme() {
    return $this->calculateForbrugEfterVarme() * $this->getVarmePris();
  }

  /**
   * Calculates based on value before - savings.
   *
   * @Formula("$this->calculateForbrugEfterCo2El() + $this->calculateForbrugEfterCo2Varme()")
   * @return float|int
   */
  protected function calculateForbrugEfterCo2() {
    return $this->calculateForbrugEfterCo2El();
  }

  /**
   * Calculates based on value efter El * ElCO2forbrug.
   *
   * @Formula("$this->calculateForbrugEfterEl() / 1000 * $this->getElKgCo2MWh() / 1000")
   * @return float|int
   */
  public function calculateForbrugEfterCo2El() {
    return $this->calculateForbrugEfterEl() / 1000 * $this->getElKgCo2MWh() / 1000;
  }

  /**
   * Calculates based on value efter Varme * VarmeCO2forbrug.
   *
   * @Formula("$this->calculateForbrugEfterVarme() / 1000 * $this->getVarmeKgCo2MWh() / 1000")
   * @return float|int
   */
  public function calculateForbrugEfterCo2Varme() {
    return $this->calculateForbrugEfterVarme() / 1000 * $this->getVarmeKgCo2MWh() / 1000;
  }

  /**
   * Calculates value that is using in Elbesparelse calculation.
   *
   * @return float
   */
  protected function calculateElbesparelseValue() {
    return $this->sum('kwhBesparelseElFraVaerket');
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
    return $this->sum('samletInvesteringInklPristillaeg');
  }

  /**
   * @inheritDoc
   * @Formula("$this->calculateAnlaegsinvesteringValue() * $this->calculateAnlaegsinvesteringFaktor()")
   */
  protected function calculateAnlaegsinvestering($value = NULL) {
    $value = $this->calculateAnlaegsinvesteringValue();

    return parent::calculateAnlaegsinvestering($value);
  }

  protected function calculateMaengde() {
    return count($this->getTilvalgteDetails());
  }

  protected function calculateEnhed() {
    return 'stk';
  }

}
