<?php

namespace AppBundle\Calculation;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\TiltagDetail;

class TiltagDetailCalculation extends Calculation {
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

    if (!$entity instanceof TiltagDetail) {
      return;
    }

    $this->calculate($entity);
  }

  /*
   * Calculate tiltag detail by dispatching to appropriate calculation service.
   *
   * Note: The passed detail is modified.
   *
   * @param TiltagDetail $detail
   *   The tiltag detail.
   *
   * @return TiltagDetail
   *   The tiltag detail.
   */
  public function calculate(TiltagDetail $detail) {
    $calculationService = $this->getCalculationService($detail);
    if ($calculationService) {
      $calculationService->calculate($detail);
    } else {
      $detail->calculate();
    }

    return $detail;
  }

  /**
   * Decide if this class can calculate the given entity.
   *
   * @param object $entity
   *   The entity.
   *
   * @return boolean
   *   Whether this class can calculate values in the given entity.
   */
  protected function canCalculate($entity) {
    $className = get_class($entity);
    if (preg_match('@\\\\([^\\\\]+)$@', $className, $matches)) {
      $entityName = $matches[1];
      return strpos(get_class($this), $entityName);
    }

    return false;
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