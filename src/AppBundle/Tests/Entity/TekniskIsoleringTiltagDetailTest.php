<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\TekniskIsoleringTiltagDetail;
use AppBundle\Entity\TekniskIsoleringTiltag;

class TekniskIsoleringTiltagDetailTest extends EntityTestCase {
  public function testCompute() {
    $tests = $this->loadTestFixtures('TekniskIsoleringTiltagDetail');
    foreach ($tests as $test) {
      $properties = $test[0];
      $expected = $test[1];

      $detail = $this->getTekniskIsoleringTiltagDetail($properties);
      $this->assertProperties($expected, $detail);
    }
  }

  private function getTekniskIsoleringTiltagDetail(array $values) {
    $tiltag = new TekniskIsoleringTiltag();
    $tiltag->setLevetid(10);
    $detail = new TekniskIsoleringTiltagDetail();
    $detail->setTiltag($tiltag);
    $this->loadEntity($detail, $values);

    return $detail;
  }

}
