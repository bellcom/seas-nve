<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\BelysningTiltagDetail;
use AppBundle\Entity\BelysningTiltagDetail\Lyskilde;

class BelysningTiltagDetailTest extends TiltagDetailTestCase {
  protected $allowedDeviance = 0.001;

  public function loadProperties(array $properties) {
    $properties['lyskilde'] = $this->getLyskilde($properties['lyskilde']);
    $properties['nyLyskilde'] = $this->getLyskilde($properties['nyLyskilde']);
    return $properties;
  }

  private function getLyskilde(array $properties = null) {
    return $properties ? $this->loadEntity(new Lyskilde(), $properties) : null;
  }

}
