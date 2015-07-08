<?php

namespace AppBundle\Calculation;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\TiltagDetail;
use AppBundle\Entity\SolcelleTiltagDetail;

class SolcelleTiltagDetailCalculation extends TiltagDetailCalculation {
  /**
   * Calculate SolcelleTiltagDetail(s).
   *
   * @param TiltagDetail $detail
   *   The entity to calculate.
   *
   * @return TiltagDetail
   *   The calculated entity.
   */
  public function calculate(TiltagDetail $detail) {
    if ($detail instanceof SolcelleTiltagDetail) {
      $solcelle = $this->container->get('doctrine')->getManager()->getRepository('AppBundle:Solcelle')->findByKWp($detail->getAnlaegsstoerrelseKWp());
      $detail->setSolcelle($solcelle);
      $detail->calculate();
    }

    return $detail;
  }

}