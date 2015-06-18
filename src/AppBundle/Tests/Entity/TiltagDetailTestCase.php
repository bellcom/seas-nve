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
    $fixtures = $this->loadTestFixtures(preg_replace('/^.+\\\\([^\\\\]+)$/', '$1', $detailClassName));

    $this->assertNotEmpty($fixtures, 'Cannot load fixtures for class ' . $detailClassName);

    foreach ($fixtures as $fixture) {
      $bygning = $this->loadEntity(new Bygning(), $fixture['bygning'])
               ->setForsyningsvaerkVarme($this->loadEntity(new Forsyningsvaerk(), $fixture['bygning.forsyningsvaerkVarme']))
               ->setForsyningsvaerkEl($this->loadEntity(new Forsyningsvaerk(), $fixture['bygning.forsyningsvaerkEl']))
               ->setForsyningsvaerkVand($this->loadEntity(new Forsyningsvaerk(), $fixture['bygning.forsyningsvaerkVand']));
      $rapport = $this->loadEntity(new Rapport(), $fixture['rapport'])
               ->setBygning($bygning);
      $rapport->setConfiguration($this->loadEntity(new Configuration(), $fixture['configuration']));
      $tiltag = new $tiltagClassName();
      $tiltag->setRapport($rapport);
      $this->loadEntity($tiltag, $fixture['tiltag']);

      foreach ($fixture['tests'] as $test) {
        $properties = $this->loadProperties($test[0]);
        $expected = $test[1];

        $detail = new $detailClassName();
        $detail->setTiltag($tiltag);

        $this->loadEntity($detail, $properties)
          ->calculate();

        $this->assertProperties($expected, $detail);
      }
    }
  }

  protected function loadProperties(array $properties) {
    return $properties;
  }

}
