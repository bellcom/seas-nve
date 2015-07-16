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
    $fixtures = $this->loadTestFixtures(NULL);

    $this->assertNotEmpty($fixtures, 'Cannot load fixtures for class ' . get_class($this));

    foreach ($fixtures as $fixture) {
      $rapport = $this->loadEntity(new Rapport(), $fixture['rapport']);

      $expected = $fixture['rapport']['_calculated'];

      $rapport->calculate();
      $this->assertProperties($expected, $rapport);
    }
  }

  protected function loadEnergiforsyning(array $data) {
    $energiforsyning = $this->setProperties(new Energiforsyning(), $data['_input']);

    $internProduktioner = new \Doctrine\Common\Collections\ArrayCollection(array_map(function($data) {
      return $this->loadInternProduktion($data);
    }, $data['internproduktioner']));

    $energiforsyning->setInternProduktioner($internProduktioner);

    return $energiforsyning;
  }

  protected function loadInternProduktion(array $data) {
    $internProduktion = $this->setProperties(new InternProduktion(), $data['_input']);

    return $internProduktion;
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
