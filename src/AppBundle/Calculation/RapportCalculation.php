<?php

namespace AppBundle\Calculation;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Rapport;

class RapportCalculation extends Calculation {
  public function __construct(Container $container) {
    parent::__construct($container);
  }

  /*
   * Calculate rapport by dispatching to appropriate calculation service.
   *
   * Note: The passed is modified.
   *
   * @param Rapport $rapport
   *   The rapport.
   *
   * @return Rapport
   *   The rapport.
   */
  public function calculate(Rapport $rapport) {
    $traepillefyr = $this->container->get('doctrine')->getManager()->getRepository('AppBundle:Forsyningsvaerk')->findOneByNavn('Træpillefyr');
    $rapport->setTraepillefyr($traepillefyr);
    $rapport->calculate();

    return $rapport;
  }

  public function getChanges($entity) {
    $changes = parent::getChanges($entity);

    if ($entity instanceof Rapport) {
      $tiltagCalculation = $this->container->get('aaplus.tiltag_calculation');
      foreach ($entity->getTilvalgteTiltag() as $tiltag) {
        $tiltagChanges = $tiltagCalculation->getChanges($tiltag);
        if ($tiltagChanges) {
          $changes['tiltag:' . $tiltag->getId()] = [
            'property' => $tiltag->getIndexNumber() . '. '. $tiltag->getTitle(),
            'type' => 'tiltag',
            'entity' => $tiltag,
            'changes' => $tiltagChanges,
          ];
        }
      }
    }

    return $changes;
  }
}