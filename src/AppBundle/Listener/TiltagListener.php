<?php
namespace AppBundle\Listener;

use AppBundle\Entity\BaselineKorrektion;
use AppBundle\Entity\Bygning;
use AppBundle\Entity\Configuration;
use Doctrine\Common\Collections\ArrayCollection;
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

  /** @var ArrayCollection */
  private $targets;

  public function __construct()
  {
    $this->targets = new ArrayCollection();
  }

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

    foreach ($entities as $entity) {
      if ($entity instanceof Baseline && $entity->getVirksomhed()) {
        $this->addTarget($entity);
        /** @var Bygning $bygning */
        foreach ($entity->getBygninger() as $bygning) {
          $this->addTarget($bygning->getRapport());
        }
        $this->addTarget($entity->getVirksomhed()->getRapport());
      }
      if ($entity instanceof BaselineKorrektion && $entity->getBaseline()) {
        $targets[] = $entity->getBaseline();
        /** @var Bygning $bygning */
        foreach ($entity->getBaseline()->getBygninger() as $bygning) {
          $this->addTarget($bygning->getRapport());
        }
        $this->addTarget($entity->getBaseline()->getVirksomhed()->getRapport());
      }
      if ($entity instanceof Tiltag && $entity->getRapport()) {
        $this->addTarget($entity);
        $this->addTarget($entity->getRapport());

        if ($entity instanceof SolcelleTiltag) {
          $changeSet = $uow->getEntityChangeSet($entity);
          // Calculation of nutidsvaerdiSetOver15AarKr on SolcelleTiltagDetail
          // depends on SolcelleTiltag.reelAnlaegsinvestering.
          $field = 'reelAnlaegsinvestering';
          if (isset($changeSet[$field]) && $changeSet[$field][0] != $changeSet[$field][1]) {
            foreach ($entity->getDetails() as $detail) {
              $this->addTarget($detail);
            }
          }
        }
      }
      elseif ($entity instanceof TiltagDetail && $entity->getTiltag()) {
        $this->addTarget($entity);
        $this->addTarget($entity->getTiltag());
        $this->addTarget($entity->getTiltag()->getRapport());
      }
      elseif ($entity instanceof Rapport && $entity->getBygning()) {
        $changeSet = $uow->getEntityChangeSet($entity);
        // Add each Tiltag from Rapport that has changes in select values.
        foreach (self::$rapportFieldsThatTriggerRecalculationOfTiltag as $field) {
          if (isset($changeSet[$field]) && $changeSet[$field][0] != $changeSet[$field][1]) {
            foreach ($entity->getTiltag() as $tiltag) {
              $this->addTarget($tiltag);
            }
            break;
          }
        }
      }
    }

    // Process only non-deleted entities and process each entity only once.
    $targets = array_filter($this->targets->toArray(), function ($target) use ($uow) {
      return  !in_array($target, $uow->getScheduledEntityDeletions());
    });
    foreach ($targets as $target) {
      if (empty($target)) {
        continue;
      }
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

  /**
   * Adds entity to targets array.
   *
   * @param $entity
   */
  private function addTarget($entity) {
    if (!$this->targets->contains($entity)) {
      $this->targets->add($entity);
    }
  }

}
