<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Rapport;
use AppBundle\Entity\Pumpe;
use AppBundle\Entity\PumpeTiltag;
use AppBundle\Entity\PumpeTiltagDetail;

class PumpeTiltagDetailTest extends TiltagDetailTestCase {
  protected $allowedDeviance = 0.001;

  public function loadProperties(array $properties) {
    $properties['pumpe'] = $this->getPumpe($properties['pumpe']);
    return $properties;
  }

  private function getPumpe(array $properties = null) {
    return $properties ? $this->loadEntity(new Pumpe(), $properties) : null;
  }

}
