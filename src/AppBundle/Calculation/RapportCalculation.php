<?php

namespace AppBundle\Calculation;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Rapport;

class RapportCalculation extends Calculation {
  protected $container = null;

  public function __construct(Container $container) {
    $this->container = $container;
  }

  /**
   * Calculate rapport after loading from data store.
   *
   * @param LifecycleEventArgs $args
   */
  public function postLoad(LifecycleEventArgs $args) {
    $entity = $args->getEntity();

    if (!$entity instanceof Rapport) {
      return;
    }

    $this->calculate($entity);
  }

  /*
   * Calculate rapport by dispatching to appropriate calculation service.
   *
   * Note: The passed is modified.
   *
   * @param Rapport $rapport
   *   The rapport.
   *
   * @return Rapport
   *   The rapport.
   */
  public function calculate(Rapport $rapport) {
    $rapport->calculate();

    return $rapport;
  }

}