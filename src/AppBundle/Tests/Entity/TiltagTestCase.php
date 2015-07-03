<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Configuration;
use AppBundle\Entity\Bygning;
use AppBundle\Entity\Forsyningsvaerk;
use AppBundle\Entity\Rapport;

abstract class TiltagTestCase extends EntityTestCase {
  protected $tiltagClassName;
  protected $detailClassName;

  public function testCalculate() {
    $this->tiltagClassName = str_replace('\\Tests\\', '\\', preg_replace('/Test$/', '', get_class($this)));
    $this->detailClassName = $this->tiltagClassName . 'Detail';
    $fixtures = $this->loadTestFixtures(preg_replace('/^.+\\\\([^\\\\]+)$/', '$1', $this->tiltagClassName));

    $this->assertNotEmpty($fixtures, 'Cannot load fixtures for class ' . $this->tiltagClassName);

    foreach ($fixtures as $fixture) {
      $bygning = $this->loadEntity(new Bygning(), $fixture['bygning'])
               ->setForsyningsvaerkVarme($this->loadEntity(new Forsyningsvaerk(), $fixture['bygning.forsyningsvaerkVarme']))
               ->setForsyningsvaerkEl($this->loadEntity(new Forsyningsvaerk(), $fixture['bygning.forsyningsvaerkEl']))
               ->setForsyningsvaerkVand($this->loadEntity(new Forsyningsvaerk(), $fixture['bygning.forsyningsvaerkVand']));
      $rapport = $this->loadEntity(new Rapport(), $fixture['rapport']['input'])
               ->setBygning($bygning);
      $rapport->setConfiguration($this->loadEntity(new Configuration(), $fixture['configuration']));
      $tiltag = new $this->tiltagClassName();
      $tiltag->setRapport($rapport);
      $this->loadEntity($tiltag, $this->loadProperties($fixture['tiltag']['input']));

      foreach ($fixture['details'] as $test) {
        $detail = new $this->detailClassName();
        $detail->setTiltag($tiltag);

        $detailTestClassName = $this->getTestClassName($detail);
        $properties = (new $detailTestClassName())->loadProperties($test['input']);

        $this->loadEntity($detail, $properties)
          ->calculate();
      }

      $expected = $fixture['tiltag']['calculated'];
      $tiltag->calculate();
      $this->assertProperties($expected, $tiltag);
    }
  }

}
