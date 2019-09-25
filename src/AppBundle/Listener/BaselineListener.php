<?php
namespace AppBundle\Listener;

use AppBundle\Entity\Baseline;
use AppBundle\Entity\Virksomhed;
use Doctrine\ORM\Event\OnFlushEventArgs;

class BaselineListener {
  /**
   * Update Erhvervsareal on Virksomhed when changing arealTilNoegletalsanalyse on Baseline.
   *
   * @param OnFlushEventArgs $args
   */
  public function onFlush(OnFlushEventArgs $args) {
    $em = $args->getEntityManager();
    $uow = $em->getUnitOfWork();

    $entities = array_merge(
      $uow->getScheduledEntityUpdates()
    );
    // @TODO Do we need update for Erhvervsareal on Virksomhed when changing arealTilNoegletalsanalyse on Baseline?
//    foreach ($entities as $entity) {
//      if ($entity instanceof Baseline) {
//        $changeSet = $uow->getEntityChangeSet($entity);
//        $change = isset($changeSet['arealTilNoegletalsanalyse']) ? $changeSet['arealTilNoegletalsanalyse'] : null;
//        if ($change && $change[0] != $change[1]) {
//          /** @var Virksomhed $virksomhed */
//          $virksomhed = $entity->getVirksomhed();
//          if ($virksomhed->getErhvervsareal() != $change[1]) {
//            $virksomhed->setErhvervsareal($change[1]);
//            $em->persist($virksomhed);
//            $md = $em->getClassMetadata(get_class($virksomhed));
//            $uow->recomputeSingleEntityChangeSet($md, $virksomhed);
//          }
//        }
//      }
//    }
  }
}
