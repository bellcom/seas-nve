<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\KlimaskaermTiltagDetail;
use AppBundle\Entity\KlimaskaermTiltag;

class KlimaskaermTiltagDetailTest extends EntityTestCase {
  public function testCompute() {
    $tests = $this->loadTestFixtures('KlimaskaermTiltagDetail');
    foreach ($tests as $test) {
      $properties = $test[0];
      $expected = $test[1];

      $detail = $this->getKlimaskaermTiltagDetail($properties);
      $this->assertProperties($expected, $detail);
    }
  }

  private function getKlimaskaermTiltagDetail(array $values) {
    $tiltag = new KlimaskaermTiltag();
    $tiltag->setLevetid(10);
    $detail = new KlimaskaermTiltagDetail();
    $detail->setTiltag($tiltag);
    $this->loadEntity($detail, $values);

    return $detail;
  }

}
