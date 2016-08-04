<?php

namespace AppBundle\Calculation;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Tiltag;

class TiltagCalculation extends Calculation {
  public function __construct(Container $container) {
    parent::__construct($container);
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

  public function getChanges($entity) {
    $changes = parent::getChanges($entity);

    if ($entity instanceof Tiltag) {
      $detailCalculation = $this->container->get('aaplus.tiltagdetail_calculation');
      foreach ($entity->getDetails() as $detail) {
        $detailChanges = $detailCalculation->getChanges($detail);
        if ($detailChanges) {
          $changes['tiltag_detail:' . $detail->getId()] = [
            'property' => $detail->getIndexNumber() . '. ' . ($detail->getTitle() ?: 'Detail'),
            'type' => 'tiltag_detail',
            'entity' => $detail,
            'changes' => $detailChanges,
          ];
        }
      }
    }

    return $changes;
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