<?php
namespace AppBundle\Listener;

use AppBundle\Entity\Baseline;
use Doctrine\ORM\Event\OnFlushEventArgs;

class BaselineListener {
  /**
   * Update Bruttoetageareal on Bygning when changing arealTilNoegletalsanalyse on Baseline.
   *
   * @param OnFlushEventArgs $args
   */
  public function onFlush(OnFlushEventArgs $args) {
    $em = $args->getEntityManager();
    $uow = $em->getUnitOfWork();

    $entities = array_merge(
      $uow->getScheduledEntityUpdates()
    );

    foreach ($entities as $entity) {
      if ($entity instanceof Baseline) {
        $changeSet = $uow->getEntityChangeSet($entity);
        $change = isset($changeSet['arealTilNoegletalsanalyse']) ? $changeSet['arealTilNoegletalsanalyse'] : null;
        if ($change && $change[0] != $change[1]) {
          $bygning = $entity->getBygning();
          if ($bygning->getBruttoetageareal() != $change[1]) {
            $bygning = $entity->getBygning()->setBruttoetageareal($change[1]);
            $em->persist($bygning);
            $md = $em->getClassMetadata(get_class($bygning));
            $uow->recomputeSingleEntityChangeSet($md, $bygning);
          }
        }
      }
    }
  }
}
