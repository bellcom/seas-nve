<?php

namespace AppBundle\Calculation;

use AppBundle\Entity\Bygning;
use AppBundle\Entity\Rapport;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Baseline;

class BaselineCalculation extends Calculation {
  protected $container = null;

  public function __construct(Container $container) {
    $this->container = $container;
  }

  /**
   * Calculate baseline before an update.
   *
   * @param LifecycleEventArgs $args
   */
  public function preUpdate(LifecycleEventArgs $args) {
    /** @var Baseline $entity */
    $entity = $args->getEntity();

    if (!$entity instanceof Baseline) {
      return;
    }

    $this->calculate($entity);
  }

  /**
   * Calculate baseline before a persist.
   *
   * @param LifecycleEventArgs $args
   */
  public function prePersist(LifecycleEventArgs $args) {
    $this->preUpdate($args);
  }

  public function calculate(Baseline $baseline) {
    $GDNormalAar = null;
    $normtal = $this->container->get('doctrine')->getRepository('AppBundle:GraddageFordeling')->findOneByTitel('Normtal');
    if ($normtal) {
      $GDNormalAar = $normtal->getSumAar();
    }
    $baseline->calculate($GDNormalAar);
    return $baseline;
  }
}
