<?php
namespace AppBundle\Listener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Tiltag;
use AppBundle\Entity\TiltagDetail;

class TiltagListener {
  /**
   * Recalculate Tiltag when it is updated or when any related TiltagDetail is updated
   * @param OnFlushEventArgs $args
   */
  public function onFlush(OnFlushEventArgs $args) {
    $em = $args->getEntityManager();
    $uow = $em->getUnitOfWork();

    $entities = array_merge(
      $uow->getScheduledEntityInsertions(),
      $uow->getScheduledEntityUpdates()
    );

    $targets = array();

    foreach ($entities as $entity) {
      if ($entity instanceof Tiltag) {
        $targets[] = $entity;
        $targets[] = $entity->getRapport();;
      }
      elseif ($entity instanceof TiltagDetail) {
        $targets[] = $entity;
        $targets[] = $entity->getTiltag();
        $targets[] = $entity->getTiltag()->getRapport();
      }
    }

    foreach ($targets as $target) {
      $target->calculate();
      $em->persist($target);
      $md = $em->getClassMetadata(get_class($target));
      $uow->recomputeSingleEntityChangeSet($md, $target);
    }
  }
}
