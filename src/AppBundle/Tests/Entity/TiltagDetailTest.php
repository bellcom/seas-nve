<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Configuration;
use AppBundle\Entity\Forsyningsvaerk;
use AppBundle\Entity\Bygning;
use AppBundle\Entity\Rapport;
use AppBundle\Entity\SpecialTiltag;
use AppBundle\Entity\SpecialTiltagDetail;

class TiltagDetailTest extends EntityTestCase {
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
      array(
        'variables' => array(
          'Invest' => 1933.1,
          'BesparKwhVarme' => 0,
          'BesparKwhEl' => 110.2464,
          'Besparm3Vand' => 0,
          'DogV' => 13.3056,
          'Straf' => 0,
          'Levetid' => 10,
          'FaktorReInvest' => 1,
          'SalgAfEnergibesparelse' => 0,
        ),
        'expected' => 6.421993941587971,
      ),
    );
    foreach ($tests as $test) {
      extract($test['variables']);
      $expected = $test['expected'];

      $configuration = $this->setProperties(new Configuration(), array(
        'kalkulationsrente' => 0.0292,
        'inflation' => 0.019,
        'lobetid' => 15,
        'varmeledningsevneEksistLamelmaatter' => 0.05,
        'varmeledningsevneNyIsolering' => 0.044
      ));

      $rapport = $this->setProperties(new Rapport(), array())
               ->setConfiguration($configuration)
               ->setBygning(
                 $this->setProperties(new Bygning(), array(
                 ))
                 ->setForsyningsvaerkEl($this->setProperties(new Forsyningsvaerk(), array(
                   'pris2015' => 1.609478,
                   'pris2016' => 1.65776234,
                   'pris2017' => 1.7074952102,
                   'pris2018' => 1.758720066506,
                   'pris2019' => 1.81148166850118,
                   'pris2020' => 1.865826118556215,
                   'pris2021' => 1.921800902112902,
                   'pris2022' => 1.979454929176289,
                   'pris2023' => 2.038838577051578,
                   'pris2024' => 2.100003734363125,
                   'pris2025' => 2.163003846394019,
                   'pris2026' => 2.22789396178584,
                   'pris2027' => 2.294730780639415,
                   'pris2028' => 2.363572704058597,
                   'pris2029' => 2.434479885180355,
                   'pris2030' => 2.507514281735766,
                   'pris2031' => 2.582739710187839,
                   'pris2032' => 2.660221901493474,
                   'pris2033' => 2.740028558538278,
                   'pris2034' => 2.822229415294427,
                   'pris2035' => 2.90689629775326,
                   'pris2036' => 2.962127327410572,
                   'pris2037' => 3.018407746631372,
                   'pris2038' => 3.075757493817368,
                   'pris2039' => 3.134196886199897,
                   'pris2040' => 3.193746627037695,
                   'pris2041' => 3.254427812951411,
                   'pris2042' => 3.316261941397487,
                   'pris2043' => 3.379270918284039,
                   'pris2044' => 3.443477065731436,
                   'pris2045' => 3.508903129980333,
                 )))
                 ->setForsyningsvaerkVarme($this->setProperties(new Forsyningsvaerk(), array(
                   'pris2015' => 0.491,
                   'pris2016' => 0.49,
                   'pris2017' => 0.459,
                   'pris2018' => 0.462,
                   'pris2019' => 0.46,
                   'pris2020' => 0.462,
                   'pris2021' => 0.48,
                   'pris2022' => 0.476,
                   'pris2023' => 0.472,
                   'pris2024' => 0.479,
                   'pris2025' => 0.473,
                   'pris2026' => 0.469,
                   'pris2027' => 0.467,
                   'pris2028' => 0.464,
                   'pris2029' => 0.462,
                   'pris2030' => 0.459,
                   'pris2031' => 0.459,
                   'pris2032' => 0.459,
                   'pris2033' => 0.459,
                   'pris2034' => 0.459,
                   'pris2035' => 0.459,
                   'pris2036' => 0.459,
                   'pris2037' => 0.459,
                   'pris2038' => 0.459,
                   'pris2039' => 0.459,
                   'pris2040' => 0.459,
                   'pris2041' => 0.459,
                   'pris2042' => 0.459,
                   'pris2043' => 0.459,
                   'pris2044' => 0.459,
                   'pris2045' => 0.459,
                 )))
                 ->setForsyningsvaerkVand($this->setProperties(new Forsyningsvaerk(), array(
                   'pris2015' => 41.64652999999999,
                   'pris2016' => 42.43781406999999,
                   'pris2017' => 43.24413253732998,
                   'pris2018' => 44.06577105553924,
                   'pris2019' => 44.90302070559449,
                   'pris2020' => 45.75617809900078,
                   'pris2021' => 46.62554548288179,
                   'pris2022' => 47.51143084705654,
                   'pris2023' => 48.41414803315061,
                   'pris2024' => 49.33401684578047,
                   'pris2025' => 50.27136316585029,
                   'pris2026' => 51.22651906600144,
                   'pris2027' => 52.19982292825546,
                   'pris2028' => 53.1916195638923,
                   'pris2029' => 54.20226033560625,
                   'pris2030' => 55.23210328198277,
                   'pris2031' => 56.28151324434043,
                   'pris2032' => 57.3508619959829,
                   'pris2033' => 58.44052837390657,
                   'pris2034' => 59.55089841301078,
                   'pris2035' => 60.68236548285798,
                   'pris2036' => 61.83533042703228,
                   'pris2037' => 63.01020170514588,
                   'pris2038' => 64.20739553754365,
                   'pris2039' => 65.42733605275697,
                   'pris2040' => 66.67045543775934,
                   'pris2041' => 67.93719409107676,
                   'pris2042' => 69.22800077880721,
                   'pris2043' => 70.54333279360455,
                   'pris2044' => 71.88365611668303,
                   'pris2045' => 73.24944558289999
                 )))
               );
      $tiltag = $this->setProperties(new SpecialTiltag(), array())
              ->setRapport($rapport)
              ->setLevetid(15);
      $detail = (new SpecialTiltagDetail())->setTiltag($tiltag);
      $this->setProperties($detail, array());

      $nvPTO2 = new \ReflectionMethod($detail, 'nvPTO2');
      $nvPTO2->setAccessible(true);
      $actual = $nvPTO2->invoke($detail, $Invest, $BesparKwhVarme, $BesparKwhEl, $Besparm3Vand, $DogV, $Straf, $Levetid, $FaktorReInvest, $SalgAfEnergibesparelse);

      $this->assertAlmostEquals($expected, $actual, null, 0.001);
    }
  }

}
