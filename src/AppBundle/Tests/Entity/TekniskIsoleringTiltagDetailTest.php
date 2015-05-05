<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Rapport;
use AppBundle\Entity\TekniskIsoleringTiltag;
use AppBundle\Entity\TekniskIsoleringTiltagDetail;

class TekniskIsoleringTiltagDetailTest extends EntityTestCase {
  protected $delta = 0.25;

  public function testCompute() {
    $fixtures = $this->loadTestFixtures('TekniskIsoleringTiltagDetail');

    foreach ($fixtures as $fixture) {
      $rapport = $this->loadEntity(new Rapport(), $fixture['rapport']);
      $tiltag = $this->loadEntity(new TekniskIsoleringTiltag(), $fixture['tiltag']);
      $tiltag->setRapport($rapport);

      foreach ($fixture['tests'] as $test) {
        $properties = $test[0];
        $expected = $test[1];

        $detail = new TekniskIsoleringTiltagDetail();
        $detail->setTiltag($tiltag);
        $this->loadEntity($detail, $properties);

        $this->assertProperties($expected, $detail);
      }
    }
  }

}
