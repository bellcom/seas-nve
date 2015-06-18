<?php

namespace AppBundle\Calculation;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\TiltagDetail;

class TiltagDetailCalculation {
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

  /**
   * Decide if any calculated values (numeric only) in entity will have different values if re-calculated.
   *
   * @FIXME:
   *
   * @param object $entity.
   *   The entity.
   *
   * @return array of string
   *   Whether any numeric value will if re-calculating values.
   */
  public function getChanges($entity) {
    $old = $entity;
    $new = $this->calculate(clone $old);

    $getters = array_filter(get_class_methods($entity), function($method) { return strpos($method, 'get') === 0; });
    $changes = array();
    foreach ($getters as $getter) {
      $oldValue = $old->{$getter}();
      $newValue = $new->{$getter}();
      // Compare numeric values with a fixed scale
      if (is_numeric($oldValue) && is_numeric($newValue)) {
        $oldValueFormatted = $this->formatNumber($oldValue);
        $newValueFormatted = $this->formatNumber($newValue);
        if ($oldValueFormatted != $newValueFormatted) {
          $changes[] = array(
            'property' => lcfirst(preg_replace('/^get/', '', $getter)),
            'oldValue' => $oldValue,
            'newValue' => $newValue,
            'oldValueFormatted' => $oldValueFormatted,
            'newValueFormatted' => $newValueFormatted,
          );
        }
      }
    }

    return $changes;
  }

  private function formatNumber($value) {
    return number_format($value, 2, '.', '');
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