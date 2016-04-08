<?php
namespace AppBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Forsyningsvaerk;

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
  }
}
