<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Rapport;
use AppBundle\Entity\KlimaskaermTiltag;
use AppBundle\Entity\KlimaskaermTiltagDetail;

class KlimaskaermTiltagDetailTest extends EntityTestCase {
  public function testCompute() {
    $fixtures = $this->loadTestFixtures('KlimaskaermTiltagDetail');

    foreach ($fixtures as $fixture) {
      $rapport = $this->loadEntity(new Rapport(), $fixture['rapport']);
      $tiltag = $this->loadEntity(new KlimaskaermTiltag(), $fixture['tiltag']);
      $tiltag->setRapport($rapport);

      foreach ($fixture['tests'] as $test) {
        $properties = $test[0];
        $expected = $test[1];

        $detail = new KlimaskaermTiltagDetail();
        $detail->setTiltag($tiltag);
        $this->loadEntity($detail, $properties);

        $this->assertProperties($expected, $detail);
      }
    }
  }

}
