<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\BelysningTiltagDetail;
use AppBundle\Entity\BelysningTiltagDetail\Lyskilde;

class BelysningTiltagDetailTest extends TiltagDetailTestCase {
  protected function loadProperties(array $properties) {
    $properties['lyskilde'] = $this->getLyskilde($properties['lyskilde']);
    $properties['nylyskilde'] = $this->getLyskilde($properties['nylyskilde']);
    return $properties;
  }

  private function getLyskilde(array $properties = null) {
    return $properties ? $this->loadEntity(new Lyskilde(), $properties) : null;
  }

}
