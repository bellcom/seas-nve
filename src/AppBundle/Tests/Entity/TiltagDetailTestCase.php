<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Rapport;

abstract class TiltagDetailTestCase extends EntityTestCase {
  /**
   * Delta to use when comparing floats.
   *
   * @var float
   */
  protected $delta = 0.0;

  public function testCompute() {
    $detailClassName = str_replace('\\Tests\\', '\\', preg_replace('/Test$/', '', get_class($this)));
    $tiltagClassName = preg_replace('/Detail$/', '', $detailClassName);
    $fixtures = $this->loadTestFixtures(preg_replace('/^.+\\\\([^\\\\]+)$/', '$1', $detailClassName));

    $this->assertNotEmpty($fixtures, 'Cannot load fixtures for class ' . $detailClassName);

    foreach ($fixtures as $fixture) {
      $rapport = $this->loadEntity(new Rapport(), $fixture['rapport']);
      $tiltag = $this->loadEntity(new $tiltagClassName(), $fixture['tiltag']);
      $tiltag->setRapport($rapport);

      foreach ($fixture['tests'] as $test) {
        $properties = $this->loadProperties($test[0]);
        $expected = $test[1];

        $detail = new $detailClassName();
        $detail->setTiltag($tiltag);
        $this->loadEntity($detail, $properties);

        $this->assertProperties($expected, $detail);
      }
    }
  }

  protected function loadProperties(array $properties) {
    return $properties;
  }

}
