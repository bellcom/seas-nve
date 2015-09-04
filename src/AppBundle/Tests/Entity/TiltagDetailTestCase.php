<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Configuration;
use AppBundle\Entity\Bygning;
use AppBundle\Entity\Forsyningsvaerk;
use AppBundle\Entity\Rapport;

abstract class TiltagDetailTestCase extends EntityTestCase {
  public function testCalculate() {
    $detailClassName = str_replace('\\Tests\\', '\\', preg_replace('/Test$/', '', get_class($this)));
    $tiltagClassName = preg_replace('/Detail$/', '', $detailClassName);
    $fixtures = $this->loadTestFixtures(preg_replace('/^.+\\\\([^\\\\]+)$/', '$1', $tiltagClassName));

    $this->assertNotEmpty($fixtures, 'Cannot load fixtures for class ' . $detailClassName);

    foreach ($fixtures as $name => $tiltag) {
      foreach ($tiltag as $type => $fixture) {
        $rapport = $this->loadEntity(new Rapport(), $fixture['rapport']);
        $tiltag = $this->loadEntity(new $tiltagClassName(), $fixture['tiltag'])
                ->setRapport($rapport);

        foreach ($fixture['details'] as $test) {
          $properties = $this->loadProperties($test['_input']);
          $expected = $test['_calculated'];

          $detail = new $detailClassName();
          $detail->setTiltag($tiltag);

          if ($tiltag->getForsyningVarme()) {
            $tiltag->getForsyningVarme()->calculate();
          }
          if ($tiltag->getForsyningEl()) {
            $tiltag->getForsyningEl()->calculate();
          }

          $this->setProperties($detail, $properties)
            ->calculate();

          $this->assertProperties($expected, $detail);
        }
      }
    }
  }

  public function loadProperties(array $properties) {
    return $properties;
  }

}
