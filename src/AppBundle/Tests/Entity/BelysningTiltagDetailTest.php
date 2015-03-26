<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\BelysningTiltagDetail;
use AppBundle\Entity\BelysningTiltagDetail\Lyskilde;

class BelysningTiltagDetailTest extends EntityTestCase {
  public function testCompute() {
    $detail = $this->getBelysningTiltagDetail();

    $this->assertProperties($detail, array(
      'ElforbrugWM2' => 9.5,
      'SimpelTilbagebetalingstidAar' => 600,
    ));
  }

  public function ignore_testAllCells() {
    $detail = $this->getBelysningTiltagDetail();
    foreach (array('AA', 'AB', 'AC', 'AE', 'AG', 'AH', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'Armaturer (stk/lokale)', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'Drifttid (t/år)', 'Eksist. lyskildes levetid (t)', 'Forkobling (stk/armatur)', 'Forkobling SKJULES', 'J', 'L', 'Lokale, antal', 'Lyskilde,  (stk/armatur)', 'Lyskilde, (W/lyskilde)', 'Lyskilde, type', 'M', 'N', 'Ny Forkobling SKJULES', 'Ny Lyskilde,  (stk/armatur)', 'Ny Udgift til lyskilder (kr/stk)', 'Ny driftstid', 'Ny forkobling (stk/armatur)', 'Ny lyskilde, (W/lyskilde)', 'Ny lyskilde, type', 'Ny lyskildes levetid (t)', 'Nye armaturer (stk/lokale)', 'P', 'Q', 'S', 'Udgift til lyskilder (kr/stk)', 'V', 'Varmebespar., Alle lokaler (kWh/år)', 'W', 'X', 'Y', 'Z', 'Elbesparelse, Alle lokaler (kWh/år)', '$C$13', 'AB', 'AM', 'AR', 'AU', 'AV', 'AY', 'AZ', 'Armaturer (stk/lokale)', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BQ', 'BR', 'BS', 'Drifttid (t/år)', 'Eksist. lyskildes levetid (t)', 'Elbesparelse, Alle lokaler (kWh/år)', 'Forkobling (stk/armatur)', 'Forkobling SKJULES', 'INDIRECT("\'2.Forsyning\'!$H$3")', 'Lokale, antal', 'Lyskilde,  (stk/armatur)', 'Lyskilde, (W/lyskilde)', 'Lyskilde, type', 'Ny Forkobling SKJULES', 'Ny Lyskilde,  (stk/armatur)', 'Ny Udgift til lyskilder (kr/stk)', 'Ny driftstid', 'Ny forkobling (stk/armatur)', 'Ny lyskilde, (W/lyskilde)', 'Ny lyskilde, type', 'Ny lyskildes levetid (t)', 'Nye armaturer (stk/lokale)', 'Q', 'Udgift til lyskilder (kr/stk)', 'V', 'Varmebespar., Alle lokaler (kWh/år)', 'Z', 'el_pris_i_aar_1_kr_kwh', 'lyssensors_levetid_i_aar', 'varmepris_aar_1_kr_kwh') as $key) {
      $detail->__get($key);
    }
  }

  private function getBelysningTiltagDetail(array $values = null) {
    if (!$values) {
      $lyskilde = $this->getLyskilde();
      $nyLyskilde = $this->getNyLyskilde();

      $values = array(
        'LokaleNavn' => 'lokale_navn',
        'LokaleType' => 'lokale_type',
        'ArmaturhoejdeM' => 1,
        'RumstoerrelseM2' => 1,
        'LokaleAntal' => 1,
        'DrifttidTAar' => 1,
        'Lyskilde' => $lyskilde,
        'LyskildeStkArmatur' => 1,
        'LyskildeWLyskilde' => 1,
        'ForkoblingStkArmatur' => 1,
        'ArmaturerStkLokale' => 1,
        'PlaceringId' => 1,
        'StyringId' => 1,
        'Noter' => 'noter',
        'BelysningstiltagId' => 1,
        'NyeSensorerStkLokale' => 1,
        'StandardinvestSensorKrStk' => 1,
        'ReduktionAfDrifttid' => 1,
        'StandardinvestArmaturElLyskildeKrStk' => 1,
        'NyLyskilde' => $nyLyskilde,
        'NyLyskildeStkArmatur' => 1,
        'NyLyskildeWLyskilde' => 1,
        'NyForkoblingStkArmatur' => 1,
        'NyeArmaturerStkLokale' => 1,
        'NyttiggjortVarmeAfElBesparelse' => 1,
      );
    }

    $detail = $this->loadEntity(new BelysningTiltagDetail(), $values);

    // Call the protected compute method (!) (cf. https://sebastian-bergmann.de/archives/881-Testing-Your-Privates.html)
    $compute = new \ReflectionMethod($detail, 'compute');
    $compute->setAccessible(true);
    $compute->invoke($detail);

    return $detail;
  }

  private function getLyskilde(array $values = null) {
    if (!$values) {
      $values = array(
        'navn' => 'T8 lysstofrør Konventionel forkobling',
        'type' => 'T8 K',
        'forkobling' => 'konv.',
        'udgift' => 50,
        'levetid' => 15000,
      );
    }

    return $this->loadEntity(new Lyskilde(), $values);
  }

  private function getNyLyskilde(array $values = null) {
    if (!$values) {
      $values = array(
        'navn' => 'Kompaktrør, butterflyrør, 2- 4- og 6 stavs 2-Pins indstik. Konv.',
        'type' => 'Kom. K',
        'forkobling' => 'konv.',
        'udgift' => 50,
        'levetid' => 15000,
      );
    }

    return $this->getLyskilde($values);
  }

}
