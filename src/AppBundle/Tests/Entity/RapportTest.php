<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Configuration;
use AppBundle\Entity\Rapport;
use AppBundle\Entity\Bygning;
use AppBundle\Entity\Forsyningsvaerk;
use AppBundle\Entity\Energiforsyning;
use AppBundle\Entity\Energiforsyning\InternProduktion;

class RapportTest extends EntityTestCase {
  public function testCalculate() {
    $fixtures = $this->loadTestFixtures();

    $this->assertNotEmpty($fixtures, 'Cannot load fixtures for class ' . get_class($this));

    foreach ($fixtures as $name => $tiltag) {
      $rapport = NULL;
      $expected = NULL;
      foreach ($tiltag as $type => $fixture) {
        if (!$rapport) {
          $rapport = $this->loadEntity(new Rapport(), $fixture['rapport']);
          $expected = $fixture['rapport']['_calculated'];
        }

        $tiltagClassName = 'AppBundle\\Entity\\' . $type;
        $detailClassName = 'AppBundle\\Entity\\' . $type . 'Detail';

        $tiltag = $this->loadEntity(new $tiltagClassName(), $fixture['tiltag'])
                ->setRapport($rapport);

        foreach ($fixture['details'] as $test) {
          $detail = new $detailClassName();
          $detail->setTiltag($tiltag);

          $detailTestClassName = $this->getTestClassName($detail);
          $properties = (new $detailTestClassName())->loadProperties($test['_input']);

          $this->setProperties($detail, $properties)
            ->calculate();
        }

        $tiltag->calculate();
        $rapport->addTiltag($tiltag);
      }

      $rapport->calculate();
      $this->assertProperties($expected, $rapport);
    }
  }

  public function testInflationsfaktor() {
    $rapport = $this->setProperties(new Rapport(), array(
    ))->setConfiguration($this->setProperties(new Configuration(), array(
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
