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
      $uow->getScheduledEntityUpdates()
    );

    $targets = array();

    foreach ($entities as $entity) {
      $target = NULL;
      if ($entity instanceof Tiltag) {
        $target = $entity;
      }
      elseif ($entity instanceof TiltagDetail) {
        $target = $entity->getTiltag();
      }

      if ($target !== null && !in_array($target, $targets)) {
        $targets[] = $target;
      }

      foreach ($targets as $target) {
        if ($target->calculate($em)) {
          $em->persist($target);
          $md = $em->getClassMetadata(get_class($target));
          $uow->recomputeSingleEntityChangeSet($md, $target);
        }
      }
    }
  }
}
