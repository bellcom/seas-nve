<?php
namespace AppBundle\Listener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use AppBundle\Entity\Rapport;

class RapportListener {
  public function postLoad(LifecycleEventArgs $args) {
    $entity = $args->getObject();
    if ($entity instanceof Rapport) {
      $traepillefyr = $args->getObjectManager()->getRepository('AppBundle:Forsyningsvaerk')->findOneByNavn('Træpillefyr');
      $entity->setTraepillefyr($traepillefyr);
      $olie = $args->getObjectManager()->getRepository('AppBundle:Forsyningsvaerk')->findOneByNavn('Olie');
      $entity->setOlie($olie);
    }
  }
}
