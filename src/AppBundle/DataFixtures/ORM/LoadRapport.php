<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Forsyningsvaerk;
use AppBundle\Entity\Solcelle;
use AppBundle\Entity\Bygning;
use AppBundle\Entity\Rapport;
use AppBundle\Entity\Tiltag;
use AppBundle\Entity\BelysningTiltag;
use AppBundle\Entity\BelysningTiltagDetail;
use AppBundle\Entity\BelysningTiltagDetail\Lyskilde as BelysningTiltagDetailLyskilde;
use AppBundle\Entity\Klimaskaerm;
use AppBundle\Entity\KlimaskaermTiltag;
use AppBundle\Entity\KlimaskaermTiltagDetail;
use AppBundle\Entity\Pumpe;
use AppBundle\Entity\PumpeTiltag;
use AppBundle\Entity\PumpeTiltagDetail;
use AppBundle\Entity\TekniskIsoleringTiltag;
use AppBundle\Entity\TekniskIsoleringTiltagDetail;
use AppBundle\Entity\SolcelleTiltag;
use AppBundle\Entity\SolcelleTiltagDetail;

/**
 * Class LoadRapport
 * @package AppBundle\DataFixtures\ORM
 */
class LoadRapport extends LoadData {
  protected $order = 1;

  private $manager;
  private $workbook;
  private $name;

  /**
   * {@inheritDoc}
   */
  public function load(ObjectManager $manager) {
    $this->manager = $manager;

    $basepath = $this->container->get('kernel')
              ->locateResource('@AppBundle/DataFixtures/Data/Excel/');
    foreach (glob($basepath . '*.xlsm') as $filepath) {
      $this->name = basename($filepath, '.xlsm');

      $reader = \PHPExcel_IOFactory::createReaderForFile($filepath);
      $reader->setReadDataOnly(true);
      $this->writeInfo('Loading Excel workbook %s ... %s', $filepath, (new \DateTime())->format('c'));
      $this->workbook = $reader->load($filepath);
      $this->writeInfo('Done. %s', (new \DateTime())->format('c'));

      $this->loadForsyningsvaerker();
      $this->loadSolceller();
      $this->loadBygning();
      $this->loadKlimaskaerm();
      $this->loadRapport();
    }
    $this->done($manager);
  }

  private function loadForsyningsvaerker() {
    $sheet = $this->workbook->getSheetByName('Energipriser');
    $data = $sheet->rangeToArray('A2:AL100', null, false, false, true);
    $data = $this->getCalculatedCells($data, $sheet);

    foreach ($data as $rowId => $row) {
      $values = $row;

      if (!$values['A']) {
        break;
      }

      $forsyningsvaerk = $this->loadEntity(new Forsyningsvaerk(), array(
        'A' => 'navn',
        'B' => 'energiform',
        'C' => 'noter',
        'D' => 'noterTBeregningAfRabat', // @FIXME: How is this actually used?
        'E' => 'vedForbrugOverKWh',
        'F' => 'pris2009',
        'G' => 'pris2014',
        'H' => 'pris2015',
        'I' => 'pris2016',
        'J' => 'pris2017',
        'K' => 'pris2018',
        'L' => 'pris2019',
        'M' => 'pris2020',
        'N' => 'pris2021',
        'O' => 'pris2022',
        'P' => 'pris2023',
        'Q' => 'pris2024',
        'R' => 'pris2025',
        'S' => 'pris2026',
        'T' => 'pris2027',
        'U' => 'pris2028',
        'V' => 'pris2029',
        'W' => 'pris2030',
        'X' => 'pris2031',
        'Y' => 'pris2032',
        'Z' => 'pris2033',
        'AA' => 'pris2034',
        'AB' => 'pris2035',
        'AC' => 'pris2036',
        'AD' => 'pris2037',
        'AE' => 'pris2038',
        'AF' => 'pris2039',
        'AG' => 'pris2040',
        'AH' => 'pris2041',
        'AI' => 'pris2042',
        'AJ' => 'pris2043',
        'AK' => 'pris2044',
        'AL' => 'pris2045',
      ), $values);

      $key = 'forsyningsvaerk:' . $values['A'];
      $this->setReference($key, $forsyningsvaerk);

      $this->persist($forsyningsvaerk);
    }

    $sheet = $this->workbook->getSheetByName('co2database');
    $data = $sheet->rangeToArray('A2:AF100', null, false, false, true);
    $data = $this->getCalculatedCells($data, $sheet);

    foreach ($data as $rowId => $row) {
      $values = $row;

      if (!$values['A']) {
        break;
      }

      $key = 'forsyningsvaerk:' . $values['A'];
      $forsyningsvaerk = $this->hasReference($key) ? $this->getReference($key) : new Forsyningsvaerk();
      $forsyningsvaerk = $this->loadEntity($forsyningsvaerk, array(
        'A' => 'navn',
        // 'B' => 'energiform',
        'C' => 'co2noter',
        'F' => 'co2y2009',
        'G' => 'co2y2014',
        'H' => 'co2y2015',
        'I' => 'co2y2016',
        'J' => 'co2y2017',
        'K' => 'co2y2018',
        'L' => 'co2y2019',
        'M' => 'co2y2020',
        'N' => 'co2y2021',
        'O' => 'co2y2022',
        'P' => 'co2y2023',
        'Q' => 'co2y2024',
        'R' => 'co2y2025',
        'S' => 'co2y2026',
        'T' => 'co2y2027',
        'U' => 'co2y2028',
        'V' => 'co2y2029',
        'W' => 'co2y2030',
        'X' => 'co2y2031',
        'Y' => 'co2y2032',
        'Z' => 'co2y2033',
        'AA' => 'co2y2034',
        'AB' => 'co2y2035',
        'AC' => 'co2y2036',
        'AD' => 'co2y2037',
        'AE' => 'co2y2038',
        'AF' => 'co2y2039',
      ), $values);

      $this->setReference($key, $forsyningsvaerk);

      $this->persist($forsyningsvaerk);
    }
  }

  private function getForsyningsvaerk($id) {
    if (!$id) {
      return null;
    }
    $key = 'forsyningsvaerk:' . $id;
    if (!$this->hasReference($key)) {
      $this->writeError('No such Forsyningsvaerk ' . $id);
      return null;
    }
    return $this->getReference($key);
  }

  private function loadSolceller() {
    $sheet = $this->workbook->getSheetByName('Detailark (1)');
    $data = $sheet->rangeToArray('J65:M100', null, false, false, true);
    $data = $this->getCalculatedCells($data, $sheet);

    foreach ($data as $rowId => $row) {
      $values = $row;

      if (!$values['J']) {
        break;
      }

      $solcelle = $this->loadEntity(new Solcelle(), array(
        'K' => 'KWp',
        'L' => 'inverterpris',
        'M' => 'drift',
      ), $values);

      $key = 'solcelle:' . $values['J'];
      $this->setReference($key, $solcelle);

      $this->persist($solcelle);
    }
  }

  private function loadBygning() {
    $sheet = $this->workbook->getSheetByName('Eksport_Bygningsliste_Med_Notat');

    $data = $sheet->rangeToArray('A2:BL3000', null, false, false, true);

    foreach ($data as $rowId => $row) {
      $values = $row;

      if (!$values['A']) {
        break;
      }

      $bygning = $this->loadEntity(new Bygning(), array(
        'A' => 'bygId',
        'B' => 'Ident',
        'C' => 'Enhedsys',
        'D' => 'Enhedskode',
        'E' => 'Type',
        'F' => 'Kommentarer',
        'G' => 'Adresse',
        'H' => 'postnummer',
        'I' => 'POSTBY',
        'J' => 'Navn',
        'K' => 'Ejer',
        // 'L' => 'Bruger',
        // 'M' => 'Afdelingnavn',
        'N' => 'Ejer_A',
        'O' => 'Anvendelse',
        'P' => 'Bruttoetageareal',
        'Q' => 'Maalertype',
        'R' => 'Vand',
        // 'S' => 'Vand_InstNr',
        // 'T' => 'Vand_MaalerNr',
        // 'U' => 'Vand_Qn',
        'V' => 'kundenummer',
        'W' => 'kode',
        'X' => array('forsyningsvaerkVarme', function($value) { return $this->getForsyningsvaerk($value); }), // @TODO: Foreign key
        'Y' => 'kundenr_1',
        'Z' => 'kode_1',
        'AA' => 'MaalerskifteAFV',
        'AB' => 'AFVInstnr_1',
        // 'AC' => 'Varme_MaalerNr',
        // 'AD' => 'Varme_Qn',
        'AE' => array('forsyningsvaerkEl', function($value) { return $this->getForsyningsvaerk($value); }), // @TODO: Foreign key
        'AF' => 'Instnr',
        // 'AG' => 'El_MaalerNr',
        'AH' => 'kundenr_NRGI',
        'AI' => 'internetkode',
        'AJ' => 'Aftagenr',
        'AK' => 'Divisionnavn',
        'AL' => 'Omraadenavn',
        'AM' => 'Kommune',
        'AN' => 'Ejerforhold',
        // 'AO' => 'AnsvarligAnsvarlig',
        'AP' => 'Magistrat',
        'AQ' => 'Lokation',
        'AR' => 'Lokationsnavn',
        'AS' => 'Lederbetegnelse',
        'AT' => 'Kontakt_Notat',
        'AU' => 'Stamdata_Notat',
        'AV' => 'Vand_Notat',
        'AW' => 'El_Notat',
        'AX' => 'Varme_Notat',
        // 'AY' => 'Energimaerke',
        // 'AZ' => 'EnergimaerkeDato',
        // 'BA' => 'Net_Lokation',
        // 'BB' => 'Net_AarhusNet',
        // 'BC' => 'Net_Leverandoer',
        // 'BD' => 'Kontakt1_Kontakt',
        // 'BE' => 'Kontakt1_Mail',
        // 'BF' => 'Kontakt1_Telefon',
        // 'BG' => 'Kontakt2_Kontakt',
        // 'BH' => 'Kontakt2_Mail',
        // 'BI' => 'Kontakt2_Telefon',
        // 'BJ' => 'Kontakt3_Kontakt',
        // 'BK' => 'Kontakt3_Mail',
        // 'BL' => 'Kontakt3_Telefon',
      ), $values);

      $key = 'bygning:' . $bygning->getEnhedsys();
      $this->setReference($key, $bygning);

      $this->persist($bygning);
    }
  }

  private function loadKlimaskaerm() {
    $sheet = $this->workbook->getSheetByName('Klimaskærmspriser');

    $data = $sheet->rangeToArray('A2:F100', null, false, false, true);

    foreach ($data as $rowId => $row) {
      $values = $row;

      if (!$values['A']) {
        break;
      }

      $klimaskaerm = $this->loadEntity(new Klimaskaerm(), array(
        'A' => 'post',
        'B' => 'klimaskaerm',
        'C' => 'arbejdeOmfang',
        'D' => 'enhedsprisEksklMoms',
        'E' => 'enhed',
        'F' => 'noter',
      ), $values);

      $key = 'klimaskaerm:' . $values['A'];
      $this->setReference($key, $klimaskaerm);

      $this->persist($klimaskaerm);
    }
  }

  private function getKlimaskaerm($id) {
    if (!$id) {
      return null;
    }
    $key = 'klimaskaerm:' . $id;
    if (!$this->hasReference($key)) {
      $this->writeError('No such Klimaskaerm ' . $id);
      return null;
    }
    return $this->getReference($key);
  }

  private $configuration;

  /**
   * Load a complete Rapport from an Excel workbook
   */
  private function loadRapport() {
    $sheet = $this->workbook->getSheetByName('1.TiltagslisteRådgiver');
    $enhedsys = $sheet->getCell('C4')->getValue();

    $this->loadConfiguration($sheet);

    $bygning = $this->getBygning($enhedsys);
    $rapport = new Rapport();
    $rapport
      ->setBygning($bygning)
      ->setVersion($sheet->getCell('C24')->getOldCalculatedValue())
      ->setDatering($this->getDateTime($sheet->getCell('F23')))
      ->setConfiguration($this->configuration);

    $this->loadTekniskIsoleringTiltag($rapport);
    $this->loadBelysningTiltag($rapport);
    $this->loadPumpeTiltag($rapport);
    $this->loadKlimaskaermTiltag($rapport);
    $this->loadSolcelleTiltag($rapport);

    $this->persist($rapport);

    $this->writeInfo(get_class($rapport) . ' ' . $rapport->getId() . ' loaded');

    $this->persist($this->configuration);
    $this->writeInfo(get_class($this->configuration) . ' loaded');
  }

  private function loadConfiguration(\PHPExcel_Worksheet $sheet) {
    $repository = $this->manager->getRepository('AppBundle:Configuration');
    $this->configuration = $repository->getConfiguration();
    $this->configuration
      ->setKalkulationsrente($sheet->getCell('AI23')->getValue())
      ->setInflation($sheet->getCell('AK23')->getValue())
      ->setLobetid($sheet->getCell('AN23')->getValue());
  }

  /**
   * Load a Tiltag with properties shared by all Tiltag
   */
  private function loadTiltag(Tiltag $tiltag, Rapport $rapport, \PHPExcel_Worksheet $sheet) {
    $tiltag
      ->setRapport($rapport)
      ->setForsyningVarme($sheet->getCell('C13')->getValue())
      ->setForsyningEl($sheet->getCell('F13')->getValue())
      ->setLevetid($sheet->getCell('G7')->getValue())
      ->setFaktorForReinvesteringer($sheet->getCell('C11')->getValue())
      ->setTiltagskategori($sheet->getCell('D12')->getValue())
      ->setPrimaerEnterprise($sheet->getCell('B12')->getValue())
      ->setRisikovurdering($sheet->getCell('C17')->getValue())
      ->setPlacering($sheet->getCell('C19')->getValue())
      ->setBeskrivelseBV($sheet->getCell('A21')->getValue())
      ->setIndeklima($sheet->getCell('A23')->getValue());

    $beskrivelse = $sheet->getCell('A15')->getValue();
    $tokens = array_map('trim', preg_split('/(Nuværende forhold|Forslag|Øvrige bemærkninger):/i', $beskrivelse));
    if (count($tokens) == 4) {
      $tiltag->setBeskrivelseNuvaerende($tokens[1]);
      $tiltag->setBeskrivelseForslag($tokens[2]);
      $tiltag->setBeskrivelseOevrige($tokens[3]);
    }

    return $tiltag;
  }

  /* -------------------------------------------------------------------------------- *
   * Teknisk isolering
   * -------------------------------------------------------------------------------- */

  /**
   * Load all TekniskIsoleringTiltag for a Rapport
   *
   * @param Rapport $rapport
   */
  private function loadTekniskIsoleringTiltag(Rapport $rapport) {
    $sheet = $this->workbook->getSheetByName('Detailark (3)');

    $this->configuration
      ->setVarmeledningsevneEksistLamelmaatter($sheet->getCell('N38')->getValue())
      ->setVarmeledningsevneNyIsolering($sheet->getCell('N39')->getValue());

    $tiltag = $this->loadTiltag(new TekniskIsoleringTiltag(), $rapport, $sheet);
    $this->loadTekniskIsoleringTiltagDetail($tiltag, $sheet);
    $this->persist($tiltag);
    $this->writeInfo(get_class($tiltag) . ' ' . $tiltag->getId() . ' loaded');
  }

  /**
   * Load details for a tiltag
   *
   * @param TekniskIsoleringTiltag $tiltag
   * @param \PHPExcel_Worksheet $sheet
   */
  private function loadTekniskIsoleringTiltagDetail(TekniskIsoleringTiltag $tiltag, \PHPExcel_Worksheet $sheet) {
    // Column name => class property (, type)
    $columnMapping = array(
      'I' => array('laastAfEnergiraadgiver', 'boolean'),
      'J' => array('tilvalgt', 'boolean'),
      'K' => 'beskrivelseType',
      'L' => 'type',
      'M' => 'driftstidTAar',
      'N' => 'udvDiameterMm',
      'O' => 'eksistIsolMm',
      'Q' => 'tankVolL',
      'R' => 'tempOmgivelC',
      'S' => 'tempMedieC',
      'T' => 'roerlaengdeEllerHoejdeAfVvbM',
      'U' => 'nyttiggjortVarme',
      'V' => 'nyIsolMm',
      'Z' => 'standardinvestKrM2EllerKrM',
      'AA' => 'prisfaktor',

      // Calculated
      'P' => 'roerstoerrelseMmAekvivalent',
      'W' => 'varmeledningsevnePaaEksistIsoleringWMK',
      'X' => 'varmeledningsevnePaaNyIsoleringWMK',
      'Y' => 'arealAfBeholderM2',
      'AB' => 'investeringKr',
      'AC' => 'eksistVarmetabKwh',
      'AD' => 'nytVarmetabKwh',
      'AE' => 'varmebespKwhAar',
      'AH' => 'kwhBesparelseElFraVaerket',
      'AI' => 'kwhBesparelseVarmeFraVaerket',
      // 'AJ' => 'driftparameterCsAar',
      'AF' => 'simpelTilbagebetalingstidAar',
      'AG' => 'nutidsvaerdiSetOver15AarKr',
    );

    $this->loadTiltagDetail($tiltag, new TekniskIsoleringTiltagDetail(), $sheet, 'I48:AL99', $columnMapping, function($row) {
      return $row['K'];
    });
  }

  /* -------------------------------------------------------------------------------- *
   * Belysning/El
   * -------------------------------------------------------------------------------- */

  /**
   * Load all BelysningTiltag for a Rapport
   *
   * @param Rapport $rapport
   */
  private function loadBelysningTiltag(Rapport $rapport) {
    $sheet = $this->workbook->getSheetByName('Detailark (4)');
    $tiltag = $this->loadTiltag(new BelysningTiltag(), $rapport, $sheet);
    $this->loadBelysningTiltagDetailLyskilde($sheet);
    $this->loadBelysningTiltagDetail($tiltag, $sheet);
    $this->persist($tiltag);
    $this->writeInfo(get_class($tiltag) . ' ' . $tiltag->getId() . ' loaded');
  }

  /**
   * Load details for a tiltag
   *
   * @param BelysningTiltag $tiltag
   * @param \PHPExcel_Worksheet $sheet
   */
  private function loadBelysningTiltagDetail(BelysningTiltag $tiltag, \PHPExcel_Worksheet $sheet) {
    $columnMapping = array(
      // Column name => class property (, type)
      'I' => array('laastAfEnergiraadgiver', 'boolean'),
      'J' => array('tilvalgt', 'boolean'),
      'K' => 'lokale_navn',
      // 'L' => '',
      'M' => 'lokale_type',
      'N' => 'armaturhoejde_m',
      'O' => 'rumstoerrelse_m2',
      // 'P' => '',
      'Q' => 'lokale_antal',
      'R' => 'drifttid_t_aar',
      // 'S' => '',
      'T' => array('lyskilde', function($value) { return $this->getLyskilde($value); }),
      // 'U' => '',
      // 'V' => '',
      'W' => 'lyskilde_stk_armatur',
      'X' => 'lyskilde_w_lyskilde',
      'Y' => 'forkobling_stk_armatur',
      'AA' => 'armaturer_stk_lokale',
      // 'AB' => ''
      // 'AC' => ''
      'AD' => 'placeringId',
      // 'AE' => '',
      'AF' => 'styringId',
      // 'AG' => '',
      'AH' => 'noter',
      'AI' => 'belysningstiltagId',
      // 'AJ' => '',
      'AK' => 'nye_sensorer_stk_lokale',
      'AL' => 'standardinvest_sensor_kr_stk',
      'AM' => 'reduktion_af_drifttid',
      'AO' => 'standardinvest_armatur_el_lyskilde_kr_stk',
      'AP' => 'standardinvest_lyskilde_kr_stk',
      'AQ' => array('ny_lyskilde', function($value) { return $this->getLyskilde($value); }),
      // 'AR' => ''
      // 'AS' => ''
      'AT' => 'ny_lyskilde_stk_armatur',
      'AU' => 'ny_lyskilde_w_lyskilde',
      'AV' => 'ny_forkobling_stk_armatur',
      // 'AW' => '',
      'AX' => 'nye_armaturer_stk_lokale',
      'AY' => 'nyttiggjort_varme_af_el_besparelse',
      'AZ' => 'prisfaktor',

      // Calculated
      // 'Z' => 'armatureffekt',
      // 'AB' => 'elforbrug_kwh_pr_lokale_aar',
      'AC' => 'elforbrug_w_m2',
      'AN' => 'ny_driftstid',
      'AW' => 'ny_armatureffekt_w_stk',
      'BA' => 'prisfaktor_tillaeg_kr_lokale',
      'BB' => 'investering_alle_lokaler_kr',
      // 'BC' => 'nyt_elforbrug_kwh_pr_lokale_aar',
      'BD' => 'nyt_elforbrug_w_m2',
      // 'BE' => 'elbesparelse_alle_lokaler_kwh_aar',
      // 'BF' => 'varmebesparelse_alle_lokaler_kwh_aar',
      // 'BG' => 'eksist_lyskildes_levetid_t',
      // 'BH' => 'ny_lyskildes_levetid_t',
      // 'BI' => 'udgift_til_lyskilder_kr_stk',
      // 'BJ' => 'ny_udgift_til_lyskilder_kr_stk',
      'BK' => 'driftsbesparelse_til_lyskilder_kr_aar',
      'BL' => 'simpel_tilbagebetalingstid_aar',
      'BM' => 'vaegtet_levetid_aar',
      // 'BN' => 'udgift_sensor',
      // 'BO' => 'udgift_armaturer',
      // 'BP' => 'udgift_lyskilde',
      // 'BQ' => 'levetid_armaturer',
      // 'BR' => 'levetid_lyskilde',
      // 'BS' => 'armatur_vaegtning',
      // 'BT' => 'faktorForReinvestering',
      'BU' => 'nutidsvaerdi_set_over_15_aar_kr',
      'BV' => 'kwh_besparelse_el',
      'BW' => 'kwh_besparelse_varme_fra_varmevaerket',
    );

    $this->loadTiltagDetail($tiltag, new BelysningTiltagDetail(), $sheet, 'I41:BW99', $columnMapping, function($row) {
      return $row['K'];
    });
  }

  /**
   * Load all BelysningTiltagDetailLyskilde for use when loading BelysningTiltagDetail
   * @param \PHPExcel_Worksheet $sheet
   */
  private function loadBelysningTiltagDetailLyskilde(\PHPExcel_Worksheet $sheet) {
    $data = $sheet->rangeToArray('M26:X37', null, false, false, false);

    $getForkobling = function($id) {
      switch ($id) {
        case 1:
        case 4:
        case 8:
          return 'konv.';
        case 2:
        case 3:
        case 5:
          return 'hf';
        case 6:
        case 7:
        case 9:
        case 10:
        case 11:
          return 'Ingen';
        case 12:
          return 'LED-driver';
      }

      return '';
    };

    foreach ($data as $rowId => $row) {
      $values = $row;

      if (!$values[0]) {
        break;
      }

      $lyskilde = new BelysningTiltagDetailLyskilde();
      $lyskilde
        ->setNavn($values[1])
        ->setType($values[5])
        ->setForkobling($getForkobling($values[0]))
        ->setUdgift($values[7])
        ->setLevetid($values[11]);

      $key = 'lyskilde:' . $values[0];
      $this->setReference($key, $lyskilde);

      $this->persist($lyskilde);
    }
  }

  private function getLyskilde($id) {
    if (!$id) {
      return null;
    }
    $key = 'lyskilde:' . $id;
    if (!$this->hasReference($key)) {
      $this->writeError('No such Lyskilde ' . $id);
      return null;
    }
    return $this->getReference($key);
  }

  private function loadPumpe() {
    $sheet = $this->workbook->getSheetByName('Pumpelisten');
    $data = $sheet->rangeToArray('A3:V1000', null, false, false, true);

    foreach ($data as $rowId => $row) {
      $values = $row;

      if (!$values['A']) {
        break;
      }

      $pumpe = $this->loadEntity(new Pumpe(), array(
        'B' => 'NuvaerendeType',
        'C' => 'Byggemaal',
        'D' => 'Tilslutning',
        'E' => array('Indst', 'integer'),
        'F' => 'Forbrug',
        'G' => array('Q', 'integer'),
        'H' => array('H', 'integer'),
        'I' => 'Aarsforbrug',
        'J' => 'NyPumpe',
        'K' => 'NyByggemaal',
        'L' => 'NyTilslutning',
        'M' => 'VvsNr',
        'N' => 'NytAarsforbrug',
        'O' => 'Elbesparelse',
        'P' => array('Udligningssaet', 'string'),
        'Q' => array('Kommentarer', 'string'),
        'R' => 'StandInvestering',
        // 'S' => 'Besparelse ved isoleringskappe',
        'T' => 'Roerlaengde',
        'U' => 'Roerstoerrelse',
        'V' => 'Fabrikant',
      ), $values);

      $key = 'pumpe:' . $values['A'];
      $this->setReference($key, $pumpe);

      $this->persist($pumpe);
    }
  }

  private function loadEntity($entity, $mapping, $values) {
    foreach ($mapping as $index => $property) {
      $value = $values[$index];
      if (is_array($property)) {
        $value = $this->getValue($value, array('type' => $property[1]), $values);
        $property = $property[0];
      }
      $setter = self::getSetterName($property, $entity);
      $entity->{$setter}($value);
    }
    return $entity;
  }

  private function getPumpe($id) {
    if (!$id) {
      return null;
    }
    $key = 'pumpe:' . $id;
    if (!$this->hasReference($key)) {
      $this->writeError('No such Pumpe ' . $id);
      return null;
    }
    return $this->getReference($key);
  }

  private function getBygning($id) {
    if (!$id) {
      return null;
    }
    $key = 'bygning:' . $id;
    if (!$this->hasReference($key)) {
      $this->writeError('No such Bygning ' . $id);
      return null;
    }
    return $this->getReference($key);
  }

  /* -------------------------------------------------------------------------------- *
   * Pumpe
   * -------------------------------------------------------------------------------- */

  /**
   * Load all PumpeTiltag for a Rapport
   *
   * @param Rapport $rapport
   */
  private function loadPumpeTiltag(Rapport $rapport) {
    $sheet = $this->workbook->getSheetByName('Detailark (5)');
    $tiltag = $this->loadTiltag(new PumpeTiltag(), $rapport, $sheet);
    $this->loadPumpe();
    $this->loadPumpeTiltagDetail($tiltag, $sheet);
    $this->persist($tiltag);
    $this->writeInfo(get_class($tiltag) . ' ' . $tiltag->getId() . ' loaded');
  }

  /**
   * Load details for a tiltag
   *
   * @param PumpeTiltag $tiltag
   * @param \PHPExcel_Worksheet $sheet
   */
  private function loadPumpeTiltagDetail(PumpeTiltag $tiltag, \PHPExcel_Worksheet $sheet) {
    // Column name => class property (, type)
    $columnMapping = array(
      'I' => array('laastAfEnergiraadgiver', 'boolean'),
      'J' => array('tilvalgt', 'boolean'),
      'K' => 'pumpeID',
      'L' => 'forsyningsomraade',
      'M' => 'placering',
      'N' => 'applikation',
      'O' => 'isoleringskappe',
      'P' => 'bFaktor',
      'Q' => 'noter',
      'R' => 'eksisterendeDrifttid',
      'S' => 'nyDrifttid',
      'T' => 'prisfaktor',
      'U' => array('pumpe', function($value, $row) { return $this->getPumpe($value, $row); }),
      // 'V' => '',
      // 'W' => '',
      // 'X' => '',
      // 'Y' => '',
      // 'Z' => '',
      // 'AA' => '',
      // 'AB' => '',
      // 'AC' => '',
      // 'AD' => '',
      // 'AE' => '',
      // 'AF' => '',
      // 'AG' => '',
      // 'AH' => '',
      // 'AI' => '',
      // 'AJ' => '',
      // 'AK' => '',
      // 'AL' => '',
      // 'AM' => '',

      // Calculated
      'AN' => 'pristillaeg',
      'AO' => 'samletInvesteringInklPristillaeg',
      'AP' => 'elforbrugVedNyeDriftstidKWhAar',
      'AQ' => 'elbespKWhAar',
      'AU' => 'kwhBesparelseElFraVaerket',
      'AV' => 'kwhBesparelseVarmeFraVaerket',
      'AR' => 'varmebespIsokappeKWh',
      'AS' => 'simpelTilbagebetalingstidAar',
      'AT' => 'nutidsvaerdiSetOver15AarKr',
    );

    $this->loadTiltagDetail($tiltag, new PumpeTiltagDetail(), $sheet, 'I36:AV99', $columnMapping, function($row) {
      return $row['K'];
    });
  }


  /* -------------------------------------------------------------------------------- *
   * Klimeskærm
   * -------------------------------------------------------------------------------- */

  private function loadKlimaskaermTiltag(Rapport $rapport) {
    $sheet = $this->workbook->getSheetByName('Detailark (7)');
    $tiltag = $this->loadTiltag(new KlimaskaermTiltag(), $rapport, $sheet);

    $this->loadKlimaskaermTiltagDetail($tiltag, $sheet);

    $this->persist($tiltag);

    $this->writeInfo(get_class($tiltag) . ' ' . $tiltag->getId() . ' loaded');
  }

  private function loadKlimaskaermTiltagDetail(KlimaskaermTiltag $tiltag, \PHPExcel_Worksheet $sheet) {
    // Column name => class property (, type)
    $columnMapping = array(
      'I' => array('laastAfEnergiraadgiver', 'boolean'),
      'J' => array('tilvalgt', 'boolean'),
      'M' => 'typePlaceringJfPlantegning',
      'N' => 'hoejdeElLaengdeM',
      'O' => 'breddeM',
      'P' => 'antalStk',
      'R' => 'andelAfArealDerEfterisoleres',
      'S' => 'uEksWM2K',
      'T' => 'uNyWM2K',
      'U' => 'tIndeC',
      'V' => 'tUdeC',
      'W' => 'tOpvarmningTimerAar',
      'X' => 'yderligereBesparelserPct',
      'AA' => 'priskategori',
      'AG' => 'noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet',
      'AJ' => 'levetidAar',

      // Calculated
      'Q' => 'arealM2',
      'Y' => 'besparelseKWhAar',
      'AE' => 'samletInvesteringKr',
      'AF' => 'simpelTilbagebetalingstidAar',
      'AM' => 'faktorForReinvestering',
      'AN' => 'nutidsvaerdiSetOver15AarKr',
      'AO' => 'KWhBesparElvaerkEksternEnergikilde',
      'AP' => 'KWhBesparVarmevaerkEksternEnergikilde',
    );

    $this->loadTiltagDetail($tiltag, new KlimaskaermTiltagDetail(), $sheet, 'I38:AU99', $columnMapping, function($row) {
      return $row['K'] || $row['L'];
    });

  }

  private function loadSolcelleTiltag(Rapport $rapport) {
    $sheet = $this->workbook->getSheetByName('Detailark (1)');
    $tiltag = $this->loadTiltag(new SolcelleTiltag(), $rapport, $sheet);

    $this->loadSolcelleTiltagDetail($tiltag, $sheet);

    $this->persist($tiltag);

    $this->writeInfo(get_class($tiltag) . ' ' . $tiltag->getId() . ' loaded');
  }

  private function loadSolcelleTiltagDetail(SolcelleTiltag $tiltag, \PHPExcel_Worksheet $sheet) {
    $data = $sheet->rangeToArray('J37:P54', null, false, false, true);
    $data = $this->getCalculatedCells($data, $sheet);

    $detail = (new SolcelleTiltagDetail())
            ->setTiltag($tiltag)
            ->setLaastAfEnergiraadgiver(false)
            ->setTilvalgt(false)
            ->setAnlaegsstoerrelseKWp($data[37]['J'])
            ->setProduktionKWh($data[40]['J'])
            ->setTilNettetPct($data[41]['J'])
            ->setForringetYdeevnePrAar($data[46]['J'])
            ->setInverterskift1Aar($data[51]['J'])
            ->setInverterskift2Aar($data[52]['J'])
            ->setSalgsprisFoerste10AarKrKWh($data[37]['P'])
            ->setSalgsprisEfter10AarKrKWh($data[38]['P'])
            ->setEnergiprisstigningPctPrAar($data[40]['P'])
            ->setInvesteringKr($data[42]['P'])
            ->setScreeningOgProjekteringKr($data[43]['P'])
            ->setOmkostningTilMaalerKr($data[46]['P']);

    $this->persist($detail);
  }

  private function loadTiltagDetail(Tiltag $tiltag, $detail, \PHPExcel_Worksheet $sheet, $range, array $columnMapping, callable $includeRow) {
    list($data, $columns) = $this->getData($range, $sheet, $columnMapping, $includeRow, $tiltag);

    foreach ($data as $row) {
      $clone = clone $detail;
      $clone->setTiltag($tiltag);

      foreach ($row as $colId => $value) {
        $column = $columns[$colId];
        if (isset($column['property']) && $column['property'] && !$column['calculated']) {
          $clone->{'set'.$column['property']}($value);
        }
      }

      $this->persist($clone);
      $this->writeInfo(get_class($clone) . ' ' . $clone->getId() . ' loaded');
    }
  }

  protected function createWriter(ObjectManager $manager) {
    throw new \Exception('Not implemented: ' . __METHOD__);
  }

  private function persist($entity) {
    $this->manager->persist($entity);
  }

  /**
   * Get data from spread sheet. First row used as header.
   * @param $range
   * @param \PHPExcel_Worksheet $sheet
   * @return array
   */
  private function getData($range, \PHPExcel_Worksheet $sheet, array $columnMapping, callable $includeRow, Tiltag $tiltag) {
    $cells = array_filter($sheet->rangeToArray($range, null, false, false, true), $includeRow);
    $columns = $this->getColumns($cells, $columnMapping);
    $inputColumns = array_filter($columns, function($column) { return !$column['calculated']; });

    $data = array();
    $inputData = array();

    $first = true;
    foreach ($cells as $rowId => $row) {
      if (!$first) {
        $data[$rowId] = $row;
        $inputRow = array();
        foreach ($row as $colId => $value) {
          if (isset($inputColumns[$colId])) {
            $column = $inputColumns[$colId];
            $inputRow[$colId] = $this->getValue($value, $column, $row);
          }
        }
        $inputData[$rowId] = $inputRow;
      }
      $first = false;
    }

    if (getenv('DUMP_UNITTEST_DATA')) {
      $this->dumpUnittestData($sheet, $columns, $data, $tiltag, getenv('DUMP_UNITTEST_DATA'));
    }

    return array($inputData, $inputColumns);
  }

  /**
   * Check if a value is calculated (by Excel)
   *
   * @param object $value
   *
   * @return boolean
   */
  private static function isCalculatedValue($value) {
    return is_string($value) && $value[0] == '=';
  }

  /**
   * @param \PHPExcel_Cell $cell
   * @return \DateTime
   */
  private function getDateTime(\PHPExcel_Cell $cell) {
    return \PHPExcel_Shared_Date::ExcelToPHPObject($cell->getValue());
  }

  private function dumpUnittestData(\PHPExcel_Worksheet $sheet, array $columns, array $cells, Tiltag $tiltag, $formats) {
    $calculatedCells = $this->getCalculatedCells($cells, $sheet);
    $inputColumns = array_filter($columns, function($column) { return !$column['calculated']; });
    $calculatedColumns = array_filter($columns, function($column) { return $column['calculated']; });
    $calculatedData = array();

    foreach ($cells as $rowId => $row) {
      $inputRow = array();
      $calculatedRow = array();
      foreach ($row as $colId => $value) {
        if (isset($columns[$colId])) {
          $column = $columns[$colId];
          if (isset($calculatedColumns[$colId])) {
            $value = $calculatedCells[$rowId][$colId];
          }
          $value = $this->getValue($value, $column, $row);
          if (isset($calculatedColumns[$colId])) {
            $calculatedRow[$colId] = $value;
          }
          elseif (isset($inputColumns[$colId])) {
            $inputRow[$colId] = $value;
          }
        }
      }
      $inputData[$rowId] = $inputRow;
      $calculatedData[$rowId] = $calculatedRow;
      $first = false;
    }

    $type = null;

    switch ($sheet->getTitle()) {
      case 'Detailark (3)':
        $type = 'TekniskIsoleringTiltagDetail';
        break;

      case 'Detailark (4)':
        $type = 'BelysningTiltagDetail';
        break;

      case 'Detailark (5)':
        $type = 'PumpeTiltagDetail';
        break;

      case 'Detailark (7)':
        $type = 'KlimaskaermTiltagDetail';
        break;
    }

    if (stripos($formats, 'json') !== false) {
      echo PHP_EOL, '=== JSON ' . $type .' start =============================================================================', PHP_EOL;
      echo json_encode(array(
        'type' => $type,
        'columns' => $columns,
        'cells' => $cells,
        'calculated' => $calculatedCells,
      ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
      echo PHP_EOL, '=== JSON ' . $type .' end ===============================================================================', PHP_EOL;
    }

    if (stripos($formats, 'php') !== false) {
      if ($type) {
        $tests = array();
        foreach ($inputData as $rowId => $inputRow) {
          $properties = $this->mapRow($inputRow, $columns);
          foreach ($properties as $key => $value) {
            if (is_object($value)) {
              $properties[$key] = $this->getProperties($value);
            }
          }
          $expected = $this->mapRow($calculatedData[$rowId], $columns);
          $tests[] = array($properties, $expected);
        }

        $testFixturesPath = null;
        try {
          $testFixturesPath = $this->container->get('kernel')
                            ->locateResource('@AppBundle/DataFixtures/Data/').'fixtures/';

          if (!is_dir($testFixturesPath) && !@mkdir($testFixturesPath, 0777, true)) {
            $testFixturesPath = null;
            throw new UploadableInvalidPathException(sprintf('Unable to create "%s" directory.', $testFixturesPath));
          }
        } catch (\Exception $ex) {}

        if ($testFixturesPath) {
          $filepath = $testFixturesPath . $type . '.data.' . $this->name;
          $content = json_encode(array(
            'tests' => $tests,
            'tiltag' => $this->getProperties($tiltag),
            'rapport' => $this->getProperties($tiltag->getRapport()),
            'configuration' => $this->getProperties($tiltag->getRapport()->getConfiguration()),
          ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
          if (@file_put_contents($filepath, $content) !== false) {
            $this->writeInfo('Unittest data fixtures written to file ' . $filepath);
          }
        }
      }
    }
  }

  /**
   * Get all properties exposed through set/get methods
   */
  private function getProperties($object) {
    $properties = array();
    $methods = get_class_methods($object);
    if ($methods) {
      foreach ($methods as $method) {
        if (strpos($method, 'set') === 0) {
          $property = substr($method, 3);
          if (method_exists($object, 'get'.$property)) {
            $value = $object->{'get'.$property}();
            if ($value !== null) {
              if (!is_array($value) && !is_object($value)) {
                if (!preg_match('/CreatedAt|UpdatedAt/', $property)) {
                  $properties[$property] = $value;
                }
              }
            }
          }
        }
      }
    }

    return $properties;
  }

  private function getCalculatedCells(array $cells, \PHPExcel_Worksheet $sheet) {
    $calculated = $cells;
    array_walk($calculated, function(&$array, $rowId) use ($sheet) {
        array_walk($array, function(&$value, $colId, $rowId) use ($sheet) {
            $cell = $sheet->getCell($colId . $rowId);
            if ($cell && $cell->getDataType() == \PHPExcel_Cell_DataType::TYPE_FORMULA) {
              try {
                $value = floatval($cell->getOldCalculatedValue());
              } catch (\Exception $ex) {}
            }
            $staticHeaders[$colId] = true;
          }, $rowId);
      });

    return $calculated;
  }

  private function getColumns(array $cells, array $columnMapping) {
    $columns = array();
    $first = true;
    foreach ($cells as $rowId => $row) {
      if ($first) {
        $columns = array_map(function($value) {
          return array(
            'calculated' => null,
            'name' => $value,
          );
        }, $row);
        $first = false;
      } else {
        foreach ($row as $colId => $value) {
          if (self::isCalculatedValue($value)) {
            if ($columns[$colId]['calculated'] === null) {
              $columns[$colId]['calculated'] = $value;
            }
          } else {
            $columns[$colId]['calculated'] = false;
          }
          if (isset($columnMapping[$colId])) {
            $spec = $columnMapping[$colId];
            $property = is_array($spec) ? $spec[0] : $spec;
            $columns[$colId]['property'] = self::getPropertyName($property);
            if (is_array($spec) && count($spec) > 1) {
              $columns[$colId]['type'] = $spec[1];
            }
          }
        }
      }
    }

    return $columns;
  }

  private function mapRow(array $row, array $columns) {
    $mappedRow = array();

    foreach ($row as $colId => $value) {
      if (isset($columns[$colId])) {
        $column = $columns[$colId];
        if (isset($column['property'])) {
          $mappedRow[$column['property']] = $value;
        }
      }
    }

    return $mappedRow;
  }

  private function getValue($value, $column, array $row) {
    if (isset($column['type'])) {
      $type = $column['type'];
      if (is_callable($type)) {
        $value = $type($value, $row);
      } else {
        settype($value, $type);
      }
    }
    return $value;
  }

  private static function getPropertyName($name) {
    return str_replace('_', '', $name);
  }

  private static function getSetterName($property, $entity) {
    foreach (array('set' . $property, 'set' . str_replace('_', '', $property)) as $setter) {
      if (method_exists($entity, $setter)) {
        return $setter;
      }
    }

    throw new \Exception('Cannot find setter for property ' . $property);
  }

}
