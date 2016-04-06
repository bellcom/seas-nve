<?php

namespace AppBundle\Calculation;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use AppBundle\Entity\Energiforsyning;
use AppBundle\Entity\Energiforsyning\InternProduktion;

class EnergiforsyningCalculation extends Calculation {
  public function __construct(Container $container) {
    parent::__construct($container);
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

  /**
   * Recalculate owning Energiforsyning when InternProduktion has changed.
   *
   * @param OnFlushEventArgs $args
   */
  public function onFlush(OnFlushEventArgs $args) {
    $em = $args->getEntityManager();
    $uow = $em->getUnitOfWork();

    $entities = array_merge(
      $uow->getScheduledEntityInsertions(),
      $uow->getScheduledEntityUpdates()
    );

    foreach ($entities as $entity) {
      if (!($entity instanceof InternProduktion)) {
        continue;
      }

      $energiForsyning = $entity->getEnergiforsyning();
      if ($energiForsyning) {
        $this->calculate($energiForsyning);

        $em->persist($energiForsyning);
        $md = $em->getClassMetadata(get_class($energiForsyning));
        $uow->recomputeSingleEntityChangeSet($md, $energiForsyning);
      }
    }
  }

}