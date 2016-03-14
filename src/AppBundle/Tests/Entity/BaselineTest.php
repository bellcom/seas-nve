<?php
namespace AppBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Baseline;

class BaselineTest extends KernelTestCase {
  public function testCalculateElPrimaer() {
    $baseline = new Baseline();
    $baseline->setArealTilNoegletalsanalyse(96.0);
    $baseline->setElForbrugsdataPrimaer1Forbrug(32.0);
    $baseline->setElForbrugsdataPrimaer3Forbrug(64.0);
    $baseline->calculate();
    $this->assertEquals(48.0, $baseline->getElForbrugsdataPrimaerGennemsnit());
    $this->assertEquals(0.5, $baseline->getElForbrugsdataPrimaerNoegetal());
  }

  public function testCalculateElPrimaerNullAreal() {
    $baseline = new Baseline();
    $baseline->setArealTilNoegletalsanalyse(null);
    $baseline->setElForbrugsdataPrimaer1Forbrug(32.0);
    $baseline->setElForbrugsdataPrimaer2Forbrug(64.0);
    $baseline->calculate();
    $this->assertEquals(48.0, $baseline->getElForbrugsdataPrimaerGennemsnit());
    $this->assertEquals(null, $baseline->getElForbrugsdataPrimaerNoegetal());
  }

  public function testCalculateElSekundaer() {
    $baseline = new Baseline();
    $baseline->setArealTilNoegletalsanalyse(96.0);
    $baseline->setElForbrugsdataSekundaer1Forbrug(32.0);
    $baseline->setElForbrugsdataSekundaer3Forbrug(64.0);
    $baseline->calculate();
    $this->assertEquals(48.0, $baseline->getElForbrugsdataSekundaerGennemsnit());
    $this->assertEquals(0.5, $baseline->getElForbrugsdataSekundaerNoegetal());
  }

  public function testCalculateElSekundaerNullAreal() {
    $baseline = new Baseline();
    $baseline->setArealTilNoegletalsanalyse(null);
    $baseline->setElForbrugsdataSekundaer1Forbrug(32.0);
    $baseline->setElForbrugsdataSekundaer2Forbrug(64.0);
    $baseline->calculate();
    $this->assertEquals(48.0, $baseline->getElForbrugsdataSekundaerGennemsnit());
    $this->assertEquals(null, $baseline->getElForbrugsdataSekundaerNoegetal());
  }

  public function testCalculateElBaselineNoegletalForEjendom() {
    $baseline = new Baseline();
    $baseline->setArealTilNoegletalsanalyse(160.0);
    $baseline->setElBaselineFastsatForEjendom(80.0);
    $baseline->calculate();
    $this->assertEquals(0.5, $baseline->getElBaselineNoegletalForEjendom());
  }

  public function testCalculateElBaselineNoegletalForEjendomNullAreal() {
    $baseline = new Baseline();
    $baseline->setElBaselineFastsatForEjendom(80.0);
    $baseline->calculate();
    $this->assertEquals(null, $baseline->getElBaselineNoegletalForEjendom());
  }

  public function testCalculateElBaselineNoegletalForEjendomNullBaseline() {
    $baseline = new Baseline();
    $baseline->setArealTilNoegletalsanalyse(160.0);
    $baseline->calculate();
    $this->assertEquals(null, $baseline->getElBaselineNoegletalForEjendom());
  }
}
