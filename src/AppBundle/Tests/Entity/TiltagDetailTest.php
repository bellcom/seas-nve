<?php
namespace AppBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use AppBundle\Entity\Configuration;
use AppBundle\Entity\Rapport;
use AppBundle\Entity\SpecialTiltag;
use AppBundle\Entity\SpecialTiltagDetail;

class TiltagDetailTest extends EntityTestCase {
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

    $configuration = $this->loadEntity(new Configuration(), array(
      'kalkulationsrente' => 0.0292,
      'inflationsfaktor' => 13.86399984276068,
      'inflation' => 0.019,
      'lobetid' => 15,
      'elfaktor' => 23.58528364162932,
      'varmefaktor' => 5.661552095900807,
      'vandfaktor' => 566.6216735736286,
      'varmeKrKWh' => 0.491,
      'elKrKWh' => 1.609478,
      'varmeledningsevneEksistLamelmaatter' => 0.05,
      'varmeledningsevneNyIsolering' => 0.044
    ));

    $rapport = $this->loadEntity(new Rapport(), array())
             ->setConfiguration($configuration);
    $tiltag = $this->loadEntity(new SpecialTiltag(), array())
            ->setRapport($rapport);
    $detail = (new SpecialTiltagDetail())->setTiltag($tiltag);
    $this->loadEntity($detail, array());

    $nvPTO2 = new \ReflectionMethod($detail, 'nvPTO2');
    $nvPTO2->setAccessible(true);
    $actual = $nvPTO2->invoke($detail, $Invest, $BesparKwhVarme, $BesparKwhEl, $Besparm3Vand, $DogV, $Straf, $Levetid, $FaktorReInvest, $SalgAfEnergibesparelse);

    $this->assertEquals($expected, $actual, null, 0.2);
  }

}
