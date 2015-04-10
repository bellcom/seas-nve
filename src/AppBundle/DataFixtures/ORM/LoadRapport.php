<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Bygning;
use AppBundle\Entity\Rapport;
use AppBundle\Entity\Tiltag;
use AppBundle\Entity\BelysningTiltag;
use AppBundle\Entity\BelysningTiltagDetail;
use AppBundle\Entity\BelysningTiltagDetail\Lyskilde as BelysningTiltagDetailLyskilde;
use AppBundle\Entity\KlimaskaermTiltag;
use AppBundle\Entity\KlimaskaermTiltagDetail;
use AppBundle\Entity\PumpeTiltag;
use AppBundle\Entity\PumpeTiltagDetail;
use AppBundle\Entity\TekniskIsoleringTiltag;
use AppBundle\Entity\TekniskIsoleringTiltagDetail;

/**
 * Class LoadRapport
 * @package AppBundle\DataFixtures\ORM
 */
class LoadRapport extends LoadData {
  // Must run after LoadBygningsData
  protected $order = 1001;

  private $manager;
  private $workbook;

  /**
   * {@inheritDoc}
   */
  public function load(ObjectManager $manager) {
    $this->manager = $manager;

    $basepath = $this->container->get('kernel')
              ->locateResource('@AppBundle/DataFixtures/Data/Excel/');
    $filename = '10200083, 19-03-2015, Arbejdsmarkedscenter Aarhus Syd_Version 2.1.08.xlsm';
    $filepath = $basepath . $filename;

    $reader = \PHPExcel_IOFactory::createReaderForFile($filepath);
    $reader->setReadDataOnly(true);
    $this->writeInfo('Loading Excel workbook %s ... %s', $filename, (new \DateTime())->format('c'));
    $this->workbook = $reader->load($filepath);
    $this->writeInfo('Done. %s', (new \DateTime())->format('c'));

    $this->loadRapport();

    $this->done($manager);
  }

  /**
   * Load a complete Rapport from an Excel workbook
   */
  private function loadRapport() {
    $sheet = $this->workbook->getSheetByName('1.TiltagslisteRådgiver');
    $enhedsys = $sheet->getCell('C4')->getValue();

    $bygning = $this->manager->getRepository('AppBundle:Bygning')->findOneByEnhedsys($enhedsys);

    if ($bygning == null) {
      $this->writeError('No such Bygning ' . $enhedsys);
      return null;
    }

    $rapport = new Rapport();

    $rapport
      ->setBygning($bygning)
      ->setVersion($sheet->getCell('C24')->getOldCalculatedValue())
      ->setDatering($this->getDateTime($sheet->getCell('F23')));

    $this->loadTekniskIsoleringTiltag($rapport);
    $this->loadBelysningTiltag($rapport);
    $this->loadPumpeTiltag($rapport);
    $this->loadKlimaskaermTiltag($rapport);

    $this->persist($rapport);

    $this->writeInfo(get_class($rapport) . ' ' . $rapport->getId() . ' loaded');
  }

  /**
   * Load a Tiltag with properties shared by all Tiltag
   */
  private function loadTiltag(Tiltag $tiltag, Rapport $rapport, \PHPExcel_Worksheet $sheet) {
    $tiltag
      ->setRapport($rapport)
      ->setBeskrivelseForslag($sheet->getCell('A15')->getValue())
      ->setForsyningVarme($sheet->getCell('C13')->getValue())
      ->setForsyningEl($sheet->getCell('F13')->getValue());


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
    $data = $this->getData('I48:AL99', $sheet);

    foreach ($data as $values) {
      if (!($values["Beskrivelse (type)"])) {
        break;
      }

      $detail = new TekniskIsoleringTiltagDetail();
      $detail
        ->setTiltag($tiltag)
        ->setLaastAfEnergiraadgiver(!!$values["Låst af energirådgiver"])
        ->setTilvalgt(!!$values["Tilvalgt"])
        ->setBeskrivelseType($values["Beskrivelse (type)"])
        ->setType($values["Type"])
        ->setDriftstidTAar($values["Driftstid (t/år)"])
        ->setUdvDiameterMm($values["Udv. diameter [mm]"])
        ->setEksistIsolMm($values["Eksist. \nisol. \n[mm]"])
        ->setTankVolL($values["Tank-\nvol. (L)"])
        ->setTempOmgivelC($values["Temp. omgivel. \n[°C]"])
        ->setTempMedieC($values["Temp. \nMedie \n[°C]"])
        ->setRoerlaengdeEllerHoejdeAfVvbM($values["Rør-længde  eller højde af VVB\n[m]"])
        ->setNyttiggjortVarme($values["Nyttiggjort varme [-]"])
        ->setNyIsolMm($values["Ny \nisol. \n[mm]"])
        ->setStandardinvestKrM2EllerKrM($values["Standard- \nInvest. \n[kr/m2 eller kr/m]"])
        ->setPrisfaktor($values["Pris-\nfaktor"]);

      $this->persist($detail);

      $this->writeInfo(get_class($detail) . ' ' . $detail->getId() . ' loaded');
    }
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
    $data = $this->getData('I41:BU99', $sheet);

    foreach ($data as $values) {
      if (!($values["Lokale, navn"])) {
        break;
      }

      $detail = new BelysningTiltagDetail();
      $detail
        ->setTiltag($tiltag)
        ->setTilvalgt(!!$values["Tilvalgt"])
        ->setLokaleNavn($values["Lokale, navn"])
        ->setLokaleType($values["Lokale, type"])
        ->setArmaturhoejdeM($values["Armaturhøjde [m]"])
        ->setRumstoerrelseM2($values["Rumstørrelse [m2]"])
        ->setLokaleAntal($values["Lokale, antal"])
        ->setDrifttidTAar($values["Drifttid (t/år)"])
        ->setLyskilde($this->getLyskilde($values["Lyskilde, input"]))
        ->setLyskildeStkArmatur($values["Lyskilde,  (stk/armatur)"])
        ->setLyskildeWLyskilde($values["Lyskilde, (W/lyskilde)"])
        ->setForkoblingStkArmatur($values["Forkobling (stk/armatur)"])
        ->setArmaturerStkLokale($values["Armaturer (stk/lokale)"])
        ->setPlaceringId($values["Placering, input"])
        ->setStyringId($values["Styring, input"])
        ->setNoter($values["Noter \n(se huskeliste over tabel)"])
        ->setBelysningstiltagId($values["Tiltag, input"])
        ->setNyeSensorerStkLokale($values["Nye Sensorer (stk/lokale)"])
        ->setStandardinvestSensorKrStk($values["Standardinvest. Sensor(kr/stk)"])
        ->setReduktionAfDrifttid($values["Reduktion af drifttid (%)"])
        ->setStandardinvestArmaturElLyskildeKrStk($values["Standardinvest. armatur el. lyskilde (kr/stk)"])
        ->setNyLyskilde($this->getLyskilde($values["Ny lyskilde, input"]))
        ->setNyLyskildeStkArmatur($values["Ny Lyskilde,  (stk/armatur)"])
        ->setNyLyskildeWLyskilde($values["Ny lyskilde, (W/lyskilde)"])
        ->setNyForkoblingStkArmatur($values["Ny forkobling (stk/armatur)"])
        ->setNyeArmaturerStkLokale($values["Nye armaturer (stk/lokale)"])
        ->setNyttiggjortVarmeAfElBesparelse($values["Nyttiggjort varme(% af el-besparelse)"])
        ->setPrisfaktor($values["Prisfaktor (1 er neutral)"]);

      $this->persist($detail);

      $this->writeInfo(get_class($detail) . ' ' . $detail->getId() . ' loaded');
    }
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

      $this->addReference('lyskilde:' . $values[0], $lyskilde);

      $this->persist($lyskilde);
    }
  }

  private function getLyskilde($id) {
    $key = 'lyskilde:' . $id;
    return $this->hasReference($key) ? $this->getReference($key) : null;
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
    $data = $this->getData('I36:AV99', $sheet);

    foreach ($data as $values) {
      if (!($values["Pumpe ID"])) {
        break;
      }

      $detail = new PumpeTiltagDetail();
      $detail
        ->setTiltag($tiltag)
        ->setTilvalgt(!!$values["Tilvalgt"])
        ;

      $this->persist($detail);

      $this->writeInfo(get_class($detail) . ' ' . $detail->getId() . ' loaded');
    }
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
    $data = $this->getData('I38:AU99', $sheet);

    foreach ($data as $values) {
      if (!($values["Tiltagsnr."] || $values["Tiltagsnr. Delpriser"])) {
        break;
      }

      $detail = new KlimaskaermTiltagDetail();
      $detail
        ->setTiltag($tiltag)
        ->setLaastAfEnergiraadgiver(!!$values["Låst af energirådgiver"])
        ->setTilvalgt(!!$values["Tilvalgt"])
        ->setTiltagsnr($values["Tiltagsnr."])
        ->setTiltagsnrDelpriser($values["Tiltagsnr. Delpriser"])
        ->setTypePlaceringJfPlantegning($values["Type / \nPlacering jf. \nplantegning"])
        ->setHoejdeElLaengdeM($values["Højde el. Længde\n(m)"])
        ->setBreddeM($values["Bredde\n(m)"])
        ->setAntalStk($values["Antal (stk)"])
        ->setAndelAfArealDerEfterisoleres($values["Andel af areal der  efterisoleres"])
        ->setUEksWM2K($values["Ueks (W/m²K)"])
        ->setUNyWM2K($values["Uny (W/m²K)"])
        ->setTIndeC($values["Tinde (°C)"])
        ->setTUdeC($values["Tude (°C)"])
        ->setTOpvarmningTimerAar($values["topvarmning (timer/år)"])
        ->setYderligereBesparelserPct($values["Yderligere besparelser (%)"])
        ->setNoterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet($values["Noter til \nPrisfaktor \nValgte løsning/tiltag\nspecielle forhold \npå stedet"])
        ->setLevetidAar($values["Levetid [år]"])
        ;

      $this->persist($detail);

      $this->writeInfo(get_class($detail) . ' ' . $detail->getId() . ' loaded');
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
  private function getData($range, \PHPExcel_Worksheet $sheet) {
    $cells = $sheet->rangeToArray($range, null, false, false, true);

    $values = $cells;
    $headers = array_map(function($value) {
      // return preg_replace('/\s{2,}/', ' ', trim($value));
      return $value;
    }, array_shift($values));

    $data = array();
    foreach ($values as $rowId => $row) {
      $data[] = array_combine($headers, $row);
    }

    if (getenv('DUMP_UNITTEST_DATA')) {
      $this->dumpUnittestData($sheet, $headers, $cells, getenv('DUMP_UNITTEST_DATA'));
    }

    return $data;
  }

  /**
   * @param \PHPExcel_Cell $cell
   * @return \DateTime
   */
  private function getDateTime(\PHPExcel_Cell $cell) {
    return \PHPExcel_Shared_Date::ExcelToPHPObject($cell->getValue());
  }

  private function dumpUnittestData(\PHPExcel_Worksheet $sheet, array $headers, array $cells, $formats) {
    $calculated = $cells;
    array_walk($calculated, function(&$array, $rowId) use ($sheet) {
        array_walk($array, function(&$value, $colId, $rowId) use ($sheet) {
            $cell = $sheet->getCell($colId . $rowId);
            if ($cell && $cell->getDataType() == \PHPExcel_Cell_DataType::TYPE_FORMULA) {
              try {
                $value = $cell->getOldCalculatedValue();
              } catch (\Exception $ex) {}
            }
          }, $rowId);
      });

    $values = array();
    foreach ($calculated as $rowId => $row) {
      $values[] = array_combine($headers, $row);
    }

    $getValues = function($fields) use ($values) {
      return array_map(function($row) use ($fields) {
          $result = array();
          foreach ($fields as $key => $spec) {
            $index = is_array($spec) ? $spec[0] : $spec;
            $value = $row[$key];
            if (is_array($spec) && count($spec) > 1) {
              if (is_array($spec) && count($spec) > 1) {
                settype($value, $spec[1]);
              }
            }
            $result[$index] = $value;
          }
          return $result;
        }, $values);
    };

    $type = null;
    $properties = array();
    $expected = array();

    switch ($sheet->getTitle()) {
      case 'Detailark (3)':
        $type = 'TekniskIsoleringTiltagDetail';
        $properties = $getValues(array(
          "Låst af energirådgiver" => array('LaastAfEnergiraadgiver', 'boolean'),
          "Tilvalgt" => array('Tilvalgt', 'boolean'),
          "Beskrivelse (type)" => 'BeskrivelseType',
          "Type" => 'Type',
          "Driftstid (t/år)" => 'DriftstidTAar',
          "Udv. diameter [mm]" => 'UdvDiameterMm',
          "Eksist. \nisol. \n[mm]" => 'EksistIsolMm',
          "Tank-\nvol. (L)" => 'TankVolL',
          "Temp. omgivel. \n[°C]" => 'TempOmgivelC',
          "Temp. \nMedie \n[°C]" => 'TempMedieC',
          "Rør-længde  eller højde af VVB\n[m]" => 'RoerlaengdeEllerHoejdeAfVvbM',
          "Nyttiggjort varme [-]" => 'NyttiggjortVarme',
          "Ny \nisol. \n[mm]" => 'NyIsolMm',
          "Standard- \nInvest. \n[kr/m2 eller kr/m]" => 'StandardinvestKrM2EllerKrM',
          "Pris-\nfaktor" => 'Prisfaktor',
        ));
        $expected = $getValues(array(
          "Rørstørrelse [mm] ækvivalent" => 'roerstoerrelseMmAekvivalent',
          "Varmeledningsevne på eksist isolering [W/m·K]" => 'varmeledningsevnePaaEksistIsoleringWMK',
          "Varmeledningsevne på ny isolering [W/m·K]" => 'varmeledningsevnePaaNyIsoleringWMK',
          "Areal af beholder [m2]" => 'arealAfBeholderM2',
          "Investering  \n[kr]" => 'investeringKr',
          "Eksist. Varme-\ntab [kwh]" => 'eksistVarmetabKwh',
          "Nyt Varme-\ntab [kwh]" => 'nytVarmetabKwh',
          "Varme-\nbesp. \n[kWh/år]" => 'varmebespKwhAar',
          "Simpel tilbagebetalingstid (år)" => 'simpelTilbagebetalingstidAar',
          "Nutidsværdi set over 15 år (kr)" => 'nutidsvaerdiSetOver15AarKr',
          "kWh-besparelse El fra værket" => 'kwhBesparelseElFraVaerket',
          "kWh-besparelse Varme fra værket" => 'kwhBesparelseVarmeFraVaerket',
          // "Driftparameter  [°Cs/år]",
          // "Eksisterende U-værdi ",
          // "Ukorrigeret ",
        ));
        break;

      case 'Detailark (4)':
        $type = 'BelysningTiltagDetail';
        $properties = $getValues(array(
          "Tilvalgt" => array('Tilvalgt', 'boolean'),
          "Lokale, navn" => 'LokaleNavn',
          "Lokale, type" => 'LokaleType',
          "Armaturhøjde [m]" => 'ArmaturhoejdeM',
          "Rumstørrelse [m2]" => 'RumstoerrelseM2',
          "Lokale, antal" => 'LokaleAntal',
          "Drifttid (t/år)" => 'DrifttidTAar',
          // Lyskilde($this->getLyskilde($values["Lyskilde, input"]))
          "Lyskilde, input" => 'Lyskilde',
          "Lyskilde,  (stk/armatur)" => 'LyskildeStkArmatur',
          "Lyskilde, (W/lyskilde)" => 'LyskildeWLyskilde',
          "Forkobling (stk/armatur)" => 'ForkoblingStkArmatur',
          "Armaturer (stk/lokale)" => 'ArmaturerStkLokale',
          "Placering, input" => 'PlaceringId',
          "Styring, input" => 'StyringId',
          "Noter \n(se huskeliste over tabel)" => 'Noter',
          "Tiltag, input" => 'BelysningstiltagId',
          "Nye Sensorer (stk/lokale)" => 'NyeSensorerStkLokale',
          "Standardinvest. Sensor(kr/stk)" => 'StandardinvestSensorKrStk',
          "Reduktion af drifttid (%)" => 'ReduktionAfDrifttid',
          "Standardinvest. armatur el. lyskilde (kr/stk)" => 'StandardinvestArmaturElLyskildeKrStk',
          // NyLyskilde($this->getLyskilde($values["Ny lyskilde, input"]))
          "Ny lyskilde, input" => 'NyLyskilde',
          "Ny Lyskilde,  (stk/armatur)" => 'NyLyskildeStkArmatur',
          "Ny lyskilde, (W/lyskilde)" => 'NyLyskildeWLyskilde',
          "Ny forkobling (stk/armatur)" => 'NyForkoblingStkArmatur',
          "Nye armaturer (stk/lokale)" => 'NyeArmaturerStkLokale',
          "Nyttiggjort varme(% af el-besparelse)" => 'NyttiggjortVarmeAfElBesparelse',
          "Prisfaktor (1 er neutral)" => 'Prisfaktor',
        ));
        break;

      case 'Detailark (5)':
        $type = 'PumpeTiltagDetail';
        break;

      case 'Detailark (7)':
        $type = 'KlimaskaermTiltagDetail';
        $properties = $getValues(array(
          "Låst af energirådgiver" => 'LaastAfEnergiraadgiver',
          "Tilvalgt" => 'Tilvalgt',
          "Tiltagsnr." => 'Tiltagsnr',
          "Tiltagsnr. Delpriser" => 'TiltagsnrDelpriser',
          "Type / \nPlacering jf. \nplantegning" => 'TypePlaceringJfPlantegning',
          "Højde el. Længde\n(m)" => 'HoejdeElLaengdeM',
          "Bredde\n(m)" => 'BreddeM',
          "Antal (stk)" => 'AntalStk',
          "Andel af areal der  efterisoleres" => 'AndelAfArealDerEfterisoleres',
          "Ueks (W/m²K)" => 'UEksWM2K',
          "Uny (W/m²K)" => 'UNyWM2K',
          "Tinde (°C)" => 'TIndeC',
          "Tude (°C)" => 'TUdeC',
          "topvarmning (timer/år)" => 'TOpvarmningTimerAar',
          "Yderligere besparelser (%)" => 'YderligereBesparelserPct',
          "Noter til \nPrisfaktor \nValgte løsning/tiltag\nspecielle forhold \npå stedet" => 'NoterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet',
          "Levetid [år]" => 'LevetidAar',
        ));
        $expected = $getValues(array(
          "Areal\n(m²)" => 'arealM2',
          "Besparelse\n(kWh/år)" => 'besparelseKWhAar',
          "Samlet Besparelse (kWh/år) \ninkl. delbesparelser" => 'samletBesparelseKWhAarInklDelbesparelser',
          "Priskategori" => 'priskategori',
          "Delpris (kr/m2)" => 'delprisKrM2',
          "Samlet investering (kr)" => 'samletInvesteringKr',
          "Simpel tilbagebetalingstid (år)" => 'simpelTilbagebetalingstidAar',
          "Til sortering" => 'tilSortering',
          "Til summering af delpriser" => 'tilSummeringAfDelpriser',
          "VaegtetGnm" => 'vaegtetGnm',
          "Vægtet levetid for tiltaget (afrundet)" => 'vaegtetLevetidForTiltagetAfrundet',
          "Faktor for reinvestering" => 'faktorForReinvestering',
          "Nutidsværdi set over 15 år (kr)" => 'nutidsvaerdiSetOver15AarKr',
          "kWh-bespar. Elværk (Ekstern energikilde)" => 'KWhBesparElvaerkEksternEnergikilde',
          "kWh-bespar. Varmeværk (ekstern energikilde)" => 'KWhBesparVarmevaerkEksternEnergikilde',
          "Tilvalgte (deltiltag)" => 'tilvalgteDeltiltag',
        ));

        break;

    }

    if (stripos($formats, 'json') !== false) {
      echo PHP_EOL, '=== JSON ' . $type .' start =============================================================================', PHP_EOL;
      echo json_encode(array(
        'type' => $type,
        'properties' => $properties,
        'expected' => $expected,
        'headers' => $headers,
        'cells' => $cells,
        'calculated' => $calculated,
        'values' => $values,
      ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
      echo PHP_EOL, '=== JSON ' . $type .' end ===============================================================================', PHP_EOL;
    }

    if (stripos($formats, 'php') !== false) {
      if ($type) {
        if (count($properties) == count($expected) && count($properties) > 1) {
          $tests = array();
          for ($i = 1; $i < count($properties); $i++) {
            $tests[] = array($properties[$i], $expected[$i]);
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
            $filepath = $testFixturesPath.$type;
            $content = json_encode($tests, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            if (@file_put_contents($filepath, $content) !== false) {
              $this->writeInfo('Unittest data fixtures written to file ' . $filepath);
            }
          }
        }
      }
    }
  }

}
