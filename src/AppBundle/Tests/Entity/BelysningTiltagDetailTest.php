<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\BelysningTiltagDetail;
use AppBundle\Entity\BelysningTiltagDetail\Lyskilde;

class BelysningTiltagDetailTest extends TiltagDetailTestCase {
  public function loadProperties(array $properties) {
    $properties['lyskilde'] = $this->getLyskilde($properties['lyskilde']);
    $properties['nyLyskilde'] = $this->getLyskilde($properties['nyLyskilde']);
    return $properties;
  }

  private function getLyskilde(array $properties = null) {
    return $properties ? $this->setProperties(new Lyskilde(), $properties) : null;
  }

}
