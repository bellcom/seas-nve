<?php

namespace AppBundle\Calculation;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Energiforsyning;

class EnergiforsyningCalculation extends Calculation {
  protected $container = null;

  public function __construct(Container $container) {
    $this->container = $container;
  }

  public function prePersist(LifecycleEventArgs $args) {
    $this->preUpdate($args);
  }

  /**
   * Calculate energiforsyning before saving to data store.
   *
   * @param LifecycleEventArgs $args
   */
  public function preUpdate(LifecycleEventArgs $args) {
    $entity = $args->getEntity();

    if (!$entity instanceof Energiforsyning) {
      return;
    }

    $this->calculate($entity);
  }

  /*
   * Calculate energiforsyning.
   *
   * Note: The passed energiforsyning is modified.
   *
   * @param Energiforsyning $energiforsyning
   *   The energiforsyning.
   *
   * @return Energiforsyning
   *   The energiforsyning.
   */
  public function calculate(Energiforsyning $energiforsyning) {
    $energiforsyning->calculate();

    return $energiforsyning;
  }

}