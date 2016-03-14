<?php
/**
 * @file
 * Contains BaselineTest - test cases for Baseline entity.
 */

namespace AppBundle\Tests\Entity;

use AppBundle\DBAL\Types\Baseline\GUFFastsaettesEfterType;
use AppBundle\DBAL\Types\Baseline\VarmeKildePrimaerType;
use AppBundle\Entity\ELOKategori;
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

  public function testCalculateGUFRegAar() {
    $eloKategori = new ELOKategori();
    $eloKategori->setAndelVarmeGUFFaktor(.2);

    $baseline = new Baseline();
    $baseline->setEloKategori($eloKategori);
    $baseline->calculate();

    $this->assertNull($baseline->getVarmeForbrugsdataPrimaer1GUFRegAar());
    $this->assertInstanceOf(ELOKategori::class, $baseline->getEloKategori());

    $baseline->setVarmeForbrugsdataPrimaer1Forbrug(50.0);
    $baseline->setVarmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter(GUFFastsaettesEfterType::GUF_ANDEL_I_PROCENT_PBA_ELO_NOEGLETAL);
    $baseline->calculate();

    $this->assertEquals(10.0, $baseline->getVarmeForbrugsdataPrimaer1GUFRegAar());

    $baseline->setVarmeForbrugsdataPrimaer1SamletVarmeforbrugJuniJuliAugust(12.0);
    $baseline->calculate();

    $this->assertEquals(10.0, $baseline->getVarmeForbrugsdataPrimaer1GUFRegAar());

    $baseline->setVarmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter(GUFFastsaettesEfterType::SAMLET_MAANEDSFORBRUG_FOR_JUNI_JULI_AUGUST);
    $baseline->calculate();

    $this->assertEquals(48.0, $baseline->getVarmeForbrugsdataPrimaer1GUFRegAar());
  }
}
