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
   * @inheritDoc
   * @Formula("$this->calculateVarmebesparelseGAFValue() * $this->calculateEnergiledelseFaktor()")
   */
  protected function calculateVarmebesparelseGAF($value = null) {
    $value = $this->calculateVarmebesparelseGAFValue();

    return parent::calculateVarmebesparelseGAF($value);
  }

  /**
   * {@inheritDoc}
   */
  protected function calculateForbrugFoerEl() {
    return $this->sum(function($detail) { return $detail->calculateElForbrugFoerKWhAar(); });
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
