<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Solcelle;

class SolcelleTiltagDetailTest extends TiltagDetailTestCase {
  public function loadProperties(array $properties) {
    $properties['solcelle'] = $this->getSolcelle($properties['solcelle']);

    return $properties;
  }

  private function getSolcelle(array $properties = null) {
    return $properties ? $this->setProperties(new Solcelle(), $properties) : null;
  }

}
