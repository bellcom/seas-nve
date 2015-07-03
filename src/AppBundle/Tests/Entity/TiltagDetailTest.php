<?php
namespace AppBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use AppBundle\Entity\Configuration;
use AppBundle\Entity\Forsyningsvaerk;
use AppBundle\Entity\Bygning;
use AppBundle\Entity\Rapport;
use AppBundle\Entity\SpecialTiltag;
use AppBundle\Entity\SpecialTiltagDetail;

class TiltagDetailTest extends EntityTestCase {
  protected $allowedDeviance = 0.001;

  public function testSetGetData() {
    $detail = new SpecialTiltagDetail();

    $data = array(__FILE__);

    $actual = $detail->setData('data', $data);

    $this->assertEquals($detail, $actual);

    $actual = $detail->getData('data');

    $this->assertEquals($data, $actual);
  }

  public function test_nvPTO2() {
    $tests = array(
      array(
        'variables' => array(
          'Invest' => 13200,
          'BesparKwhVarme' => 384.73776,
          'BesparKwhEl' => 3246,
          'Besparm3Vand' => 0,
          'DogV' => 0,
          'Straf' => 0,
          'Levetid' => 15,
          'FaktorReInvest' => 1,
          'SalgAfEnergibesparelse' => 0,
        ),
        'expected' => 65910.54549,
      ),
      array(
        'variables' => array(
          'Invest' => 11350,
          'BesparKwhVarme' => -234.66045708,
          'BesparKwhEl' => 586.6511427,
          'Besparm3Vand' => 0,
          'DogV' => 45.0702,
          'Straf' => 0,
          'Levetid' => 15,
          'FaktorReInvest' => 1,
          'SalgAfEnergibesparelse' => 0,
        ),
        'expected' => 2104.661029,
      ),
    );
    foreach ($tests as $test) {
      extract($test['variables']);
      $expected = $test['expected'];

      $configuration = $this->loadEntity(new Configuration(), array(
        'kalkulationsrente' => 0.0292,
        'inflation' => 0.019,
        'lobetid' => 15,
        'varmeledningsevneEksistLamelmaatter' => 0.05,
        'varmeledningsevneNyIsolering' => 0.044
      ));

      $rapport = $this->loadEntity(new Rapport(), array())
               ->setConfiguration($configuration)
               ->setBygning(
                 $this->loadEntity(new Bygning(), array(
                 ))
                 ->setForsyningsvaerkEl($this->loadEntity(new Forsyningsvaerk(), array(
                   'pris2015' => 1.61,
                   'pris2016' => 1.66,
                   'pris2017' => 1.71,
                   'pris2018' => 1.76,
                   'pris2019' => 1.81,
                   'pris2020' => 1.87,
                   'pris2021' => 1.92,
                   'pris2022' => 1.98,
                   'pris2023' => 2.04,
                   'pris2024' => 2.10,
                   'pris2025' => 2.16,
                   'pris2026' => 2.23,
                   'pris2027' => 2.29,
                   'pris2028' => 2.36,
                   'pris2029' => 2.43,
                   'pris2030' => 2.51,
                   'pris2031' => 2.58,
                   'pris2032' => 2.66,
                   'pris2033' => 2.74,
                   'pris2034' => 2.82,
                   'pris2035' => 2.91,
                   'pris2036' => 2.96,
                   'pris2037' => 3.02,
                   'pris2038' => 3.08,
                   'pris2039' => 3.13,
                   'pris2040' => 3.19,
                   'pris2041' => 3.25,
                   'pris2042' => 3.32,
                   'pris2043' => 3.38,
                   'pris2044' => 3.44,
                   'pris2045' => 3.51,
                 )))
                 ->setForsyningsvaerkVarme($this->loadEntity(new Forsyningsvaerk(), array(
                   'pris2015' => 0.49,
                   'pris2016' => 0.490,
                   'pris2017' => 0.459,
                   'pris2018' => 0.462,
                   'pris2019' => 0.460,
                   'pris2020' => 0.462,
                   'pris2021' => 0.480,
                   'pris2022' => 0.476,
                   'pris2023' => 0.472,
                   'pris2024' => 0.479,
                   'pris2025' => 0.473,
                   'pris2026' => 0.469,
                   'pris2027' => 0.47,
                   'pris2028' => 0.46,
                   'pris2029' => 0.46,
                   'pris2030' => 0.46,
                   'pris2031' => 0.46,
                   'pris2032' => 0.46,
                   'pris2033' => 0.46,
                   'pris2034' => 0.46,
                   'pris2035' => 0.46,
                   'pris2036' => 0.46,
                   'pris2037' => 0.46,
                   'pris2038' => 0.46,
                   'pris2039' => 0.46,
                   'pris2040' => 0.46,
                   'pris2041' => 0.46,
                   'pris2042' => 0.46,
                   'pris2043' => 0.46,
                   'pris2044' => 0.46,
                   'pris2045' => 0.46,
                 )))
                 ->setForsyningsvaerkVand($this->loadEntity(new Forsyningsvaerk(), array(
                   'pris2015' => 41.65,
                   'pris2016' => 42.44,
                   'pris2017' => 43.24,
                   'pris2018' => 44.07,
                   'pris2019' => 44.90,
                   'pris2020' => 45.76,
                   'pris2021' => 46.63,
                   'pris2022' => 47.51,
                   'pris2023' => 48.41,
                   'pris2024' => 49.33,
                   'pris2025' => 50.27,
                   'pris2026' => 51.23,
                   'pris2027' => 52.20,
                   'pris2028' => 53.19,
                   'pris2029' => 54.20,
                   'pris2030' => 55.23,
                   'pris2031' => 56.28,
                   'pris2032' => 57.35,
                   'pris2033' => 58.44,
                   'pris2034' => 59.55,
                   'pris2035' => 60.68,
                   'pris2036' => 61.84,
                   'pris2037' => 63.01,
                   'pris2038' => 64.21,
                   'pris2039' => 65.43,
                   'pris2040' => 66.67,
                   'pris2041' => 67.94,
                   'pris2042' => 69.23,
                   'pris2043' => 70.54,
                   'pris2044' => 71.88,
                   'pris2045' => 73.25,
                 )))
               );
      $tiltag = $this->loadEntity(new SpecialTiltag(), array())
              ->setRapport($rapport)
              ->setLevetid(15);
      $detail = (new SpecialTiltagDetail())->setTiltag($tiltag);
      $this->loadEntity($detail, array());

      $nvPTO2 = new \ReflectionMethod($detail, 'nvPTO2');
      $nvPTO2->setAccessible(true);
      $actual = $nvPTO2->invoke($detail, $Invest, $BesparKwhVarme, $BesparKwhEl, $Besparm3Vand, $DogV, $Straf, $Levetid, $FaktorReInvest, $SalgAfEnergibesparelse);

      $this->assertAlmostEquals($expected, $actual, null, 0.001);
    }
  }

}
