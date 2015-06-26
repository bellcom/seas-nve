<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Klimaskaerm;
use AppBundle\Entity\KlimaskaermTiltag;
use AppBundle\Entity\KlimaskaermTiltagDetail;

class KlimaskaermTiltagDetailTest extends TiltagDetailTestCase {
  protected $allowedDeviance = 0.001;

  public function loadProperties(array $properties) {
    $properties['klimaskaerm'] = $this->getKlimaskaerm($properties['klimaskaerm']);
    return $properties;
  }

  private function getKlimaskaerm(array $properties = null) {
    return $properties ? $this->loadEntity(new Klimaskaerm(), $properties) : null;
  }

}
