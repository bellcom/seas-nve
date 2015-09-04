<?php

namespace AppBundle\Calculation;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Tiltag;

class TiltagCalculation extends Calculation {
  protected $container = null;

  public function __construct(Container $container) {
    $this->container = $container;
  }

  public function prePersist(LifecycleEventArgs $args) {
    $this->preUpdate($args);
  }

  /**
   * Calculate tiltag detail before saving to data store.
   *
   * @param LifecycleEventArgs $args
   */
  public function preUpdate(LifecycleEventArgs $args) {
    $entity = $args->getEntity();

    if (!$entity instanceof Tiltag) {
      return;
    }

    $this->calculate($entity);
  }

  /*
   * Calculate tiltag by dispatching to appropriate calculation service.
   *
   * Note: The passed is modified.
   *
   * @param Tiltag $tiltag
   *   The tiltag.
   *
   * @return Tiltag
   *   The tiltag.
   */
  public function calculate(Tiltag $tiltag) {
    $calculationService = $this->getCalculationService($tiltag);
    if ($calculationService) {
      $calculationService->calculate($tiltag);
    } else {
      $tiltag->calculate();
    }

    return $tiltag;
  }

  private function getCalculationService($entity) {
    $entityName = $this->getEntityName($entity);
    if (!$entityName) {
      return null;
    }

    $calculationName = 'aaplus.' . strtolower($entityName) . '_calculation';

    return $this->container->get($calculationName, Container::NULL_ON_INVALID_REFERENCE);
  }

  /**
   * Get entity name, i.e. the part after last \ in fully qualified class name
   *
   * @param object $entity
   *   The entity.
   *
   * @return string
   *   The entity name.
   */
  private function getEntityName($entity) {
    $className = get_class($entity);
    if (preg_match('@\\\\([^\\\\]+)$@', $className, $matches)) {
      return $matches[1];
    }

    return $className;
  }

}