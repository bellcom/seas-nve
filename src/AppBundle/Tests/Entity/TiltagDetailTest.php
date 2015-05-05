<?php
namespace AppBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use AppBundle\Entity\Rapport;
use AppBundle\Entity\SpecialTiltag;
use AppBundle\Entity\SpecialTiltagDetail;

class TiltagDetailTest extends KernelTestCase {
  public function testSetGetData() {
    $detail = new SpecialTiltagDetail();

    $data = array(__FILE__);

    $actual = $detail->setData('data', $data);

    $this->assertEquals($detail, $actual);

    $actual = $detail->getData('data');

    $this->assertEquals($data, $actual);
  }

  public function test_nvPTO2() {
    $Invest = 13200;
    $BesparKwhVarme = 384.73776;
    $BesparKwhEl = 3246;
    $Besparm3Vand = 0;
    $DogV = 0;
    $Straf = 0;
    $Levetid = 15;
    $FaktorReInvest = 1;
    $SalgAfEnergibesparelse = 0;

    $expected = 65910.54549;

    $rapport = new Rapport();
    $tiltag = new SpecialTiltag();
    $tiltag->setRapport($rapport);
    $detail = new SpecialTiltagDetail();
    $detail->setTiltag($tiltag);

    $nvPTO2 = new \ReflectionMethod($detail, 'nvPTO2');
    $nvPTO2->setAccessible(true);
    $actual = $nvPTO2->invoke($detail, $Invest, $BesparKwhVarme, $BesparKwhEl, $Besparm3Vand, $DogV, $Straf, $Levetid, $FaktorReInvest, $SalgAfEnergibesparelse);

    $this->assertEquals($expected, $actual, null, 0.2);
  }

}
