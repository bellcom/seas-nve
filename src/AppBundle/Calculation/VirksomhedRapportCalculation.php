<?php

namespace AppBundle\Calculation;

use AppBundle\Entity\VirksomhedRapport;
use Symfony\Component\DependencyInjection\Container;

class VirksomhedRapportCalculation extends Calculation {
  public function __construct(Container $container) {
    parent::__construct($container);
  }

  /**
   * Calculate rapport by dispatching to appropriate calculation service.
   *
   * Note: The passed is modified.
   *
   * @param VirksomhedRapport $rapport
   *   The rapport.
   *
   * @return VirksomhedRapport
   *   The rapport.
   */
  public function calculate(VirksomhedRapport $rapport) {
    $rapport->calculate();

    return $rapport;
  }

  public function getChanges($entity) {
    $changes = [];

    $changes += parent::getChanges($entity);

    return $changes;
  }
}
