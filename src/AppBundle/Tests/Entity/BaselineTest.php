<?php
namespace AppBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Baseline;

class BaselineTest extends KernelTestCase {
  public function testCalculate() {
    $baseline = new Baseline();
    $baseline->setArealTilNoegletalsanalyse(96.0);
    $baseline->setElForbrugsdataPrimaer1Forbrug(32.0);
    $baseline->setElForbrugsdataPrimaer3Forbrug(64.0);
    $baseline->calculate();
    $this->assertEquals(48.0, $baseline->getElForbrugsdataPrimaerGennemsnit());
    $this->assertEquals(0.5, $baseline->getElForbrugsdataPrimaerNoegetal());
  }
}
