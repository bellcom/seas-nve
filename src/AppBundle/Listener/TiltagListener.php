<?php
namespace AppBundle\Listener;

use AppBundle\Entity\BaselineKorrektion;
use AppBundle\Entity\Configuration;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Baseline;
use AppBundle\Entity\Rapport;
use AppBundle\Entity\Tiltag;
use AppBundle\Entity\SolcelleTiltag;
use AppBundle\Entity\TiltagDetail;

class TiltagListener {
  private static $rapportFieldsThatTriggerRecalculationOfTiltag = [ 'faktorPaaVarmebesparelse' ];

  /**
   * Recalculate Tiltag when it is updated or when any related TiltagDetail is updated
   * @param OnFlushEventArgs $args
   */
  public function onFlush(OnFlushEventArgs $args) {
    $em = $args->getEntityManager();
    $uow = $em->getUnitOfWork();

    $entities = array_merge(
      $uow->getScheduledEntityInsertions(),
      $uow->getScheduledEntityUpdates(),
      $uow->getScheduledEntityDeletions()
    );

    $targets = array();

    foreach ($entities as $entity) {
      if ($entity instanceof Baseline) {
        $targets[] = $entity;
        if ($entity->getBygning()->getRapport()) {
          $targets[] = $entity->getBygning()->getRapport();
        }
      }
      if ($entity instanceof BaselineKorrektion) {
        $targets[] = $entity->getBaseline();
        if ($entity->getBaseline()->getBygning()->getRapport()) {
          $targets[] = $entity->getBaseline()->getBygning()->getRapport();
        }
      }
      if ($entity instanceof Tiltag) {
        $targets[] = $entity;
        $targets[] = $entity->getRapport();

        if ($entity instanceof SolcelleTiltag) {
          $changeSet = $uow->getEntityChangeSet($entity);
          // Calculation of nutidsvaerdiSetOver15AarKr on SolcelleTiltagDetail
          // depends on SolcelleTiltag.reelAnlaegsinvestering.
          $field = 'reelAnlaegsinvestering';
          if (isset($changeSet[$field]) && $changeSet[$field][0] != $changeSet[$field][1]) {
            foreach ($entity->getDetails() as $detail) {
              $targets[] = $detail;
            }
          }
        }
      }
      elseif ($entity instanceof TiltagDetail) {
        $targets[] = $entity;
        $targets[] = $entity->getTiltag();
        $targets[] = $entity->getTiltag()->getRapport();
      }
      elseif ($entity instanceof Rapport) {
        $changeSet = $uow->getEntityChangeSet($entity);
        // Add each Tiltag from Rapport that has changes in select values.
        foreach (self::$rapportFieldsThatTriggerRecalculationOfTiltag as $field) {
          if (isset($changeSet[$field]) && $changeSet[$field][0] != $changeSet[$field][1]) {
            foreach ($entity->getTiltag() as $tiltag) {
              $targets[] = $tiltag;
            }
            break;
          }
        }
      }
    }

    // Process only non-deleted entities and process each entity only once.
    $targets = array_unique(array_filter($targets, function ($target) use ($uow) {
        return !in_array($target, $uow->getScheduledEntityDeletions());
    }));
    foreach ($targets as $target) {
      // We need to set the configuration before calculating a Rapport.
      if ($target instanceof Rapport) {
        $target->setConfiguration($em->getRepository(Configuration::class)->getConfiguration());
      }
      $target->calculate();
      $em->persist($target);
      $md = $em->getClassMetadata(get_class($target));
      $uow->recomputeSingleEntityChangeSet($md, $target);
    }
  }
}
