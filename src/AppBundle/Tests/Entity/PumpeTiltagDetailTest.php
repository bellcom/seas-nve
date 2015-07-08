<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Pumpe;

class PumpeTiltagDetailTest extends TiltagDetailTestCase {
  public function loadProperties(array $properties) {
    $properties['pumpe'] = $this->getPumpe($properties['pumpe']);
    return $properties;
  }

  private function getPumpe(array $properties = null) {
    return $properties ? $this->loadEntity(new Pumpe(), $properties) : null;
  }

}
