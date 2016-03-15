<?php

namespace AppBundle\Calculation;

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
    $entity = $args->getEntity();

    if (!$entity instanceof Baseline) {
      return;
    }

    $this->calculate($entity);
  }

  public function calculate(Baseline $baseline) {
    $GDNormalAar = NULL;
    $normtal = $this->container->getRepository('GraddageFordeling')->getOneByTitle('Normtal');
    if ($normtal) {
      $GDNormalAar = $normtal->getSumAar();
    }

    $baseline->calculate($GDNormalAar);
    return $baseline;
  }
}