<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Configuration;
use AppBundle\Entity\Rapport;

class RapportTest extends EntityTestCase {
  // protected $allowedDeviance = 0.001;

  public function testInflationsfaktor() {
    $rapport = $this->loadEntity(new Rapport(), array(
    ))->setConfiguration($this->loadEntity(new Configuration(), array(
      'kalkulationsrente' => 0.0292,
      'inflation' => 0.0190,
    )));

    $this->assertNotNull($rapport->getConfiguration(), 'Configuration is not null');

    $this->assertProperties(array(
      'kalkulationsrente' => 0.0292,
      'inflation' => 0.0190,
      'inflationsfaktor' => 13.863999842761,

    ), $rapport);
  }

}
