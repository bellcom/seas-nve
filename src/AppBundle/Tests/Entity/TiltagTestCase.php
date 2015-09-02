<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Configuration;
use AppBundle\Entity\Bygning;
use AppBundle\Entity\Forsyningsvaerk;
use AppBundle\Entity\Rapport;

abstract class TiltagTestCase extends EntityTestCase {
  public function testCalculate() {
    $tiltagClassName = str_replace('\\Tests\\', '\\', preg_replace('/Test$/', '', get_class($this)));
    $detailClassName = $tiltagClassName . 'Detail';
    $fixtures = $this->loadTestFixtures(preg_replace('/^.+\\\\([^\\\\]+)$/', '$1', $tiltagClassName));

    $this->assertNotEmpty($fixtures, 'Cannot load fixtures for class ' . $tiltagClassName);

    foreach ($fixtures as $name => $tiltag) {
      foreach ($tiltag as $type => $fixture) {
        $rapport = $this->loadEntity(new Rapport(), $fixture['rapport']);
        $tiltag = $this->loadEntity(new $tiltagClassName(), $fixture['tiltag'])
                ->setRapport($rapport);

        foreach ($fixture['details'] as $test) {
          $detail = new $detailClassName();
          $detail->setTiltag($tiltag);

          $detailTestClassName = $this->getTestClassName($detail);
          $properties = (new $detailTestClassName())->loadProperties($test['_input']);

          if ($tiltag->getForsyningVarme()) {
            $tiltag->getForsyningVarme()->calculate();
          }
          if ($tiltag->getForsyningEl()) {
            $tiltag->getForsyningEl()->calculate();
          }

          $this->setProperties($detail, $properties)
            ->calculate();
        }

        $expected = $fixture['tiltag']['_calculated'];
        $tiltag->calculate();
        $this->assertProperties($expected, $tiltag);
      }
    }
  }

}
