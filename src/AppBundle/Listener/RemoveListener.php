<?php
namespace AppBundle\Listener;

use AppBundle\Entity\Tiltag;
use Doctrine\ORM\Event\LifecycleEventArgs;

class RemoveListener {
  public function preRemove(LifecycleEventArgs $event) {
    $entity = $event->getEntity();

    $repository = $event->getEntityManager()->getRepository(get_class($entity));

    if ($repository && method_exists($repository, 'getRemoveErrorMessage')) {
      $message = $repository->getRemoveErrorMessage($entity);
      if ($message) {
        throw new \Exception($message);
      }
    }

    if ($entity instanceof Tiltag) {
      $rapport = $entity->getRapport();
      $rapport->getTiltag()->removeElement($entity);
      $rapport->calculate();
      $event->getEntityManager()->persist($rapport);
    }
  }
}
