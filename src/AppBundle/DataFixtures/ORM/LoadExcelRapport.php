<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DBAL\Types\BygningStatusType;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Forsyningsvaerk;
use AppBundle\Entity\Solcelle;
use AppBundle\Entity\Bygning;
use AppBundle\Entity\Rapport;
use AppBundle\Entity\Energiforsyning;
use AppBundle\DBAL\Types\Energiforsyning\NavnType;
use AppBundle\Entity\Energiforsyning\InternProduktion;
use AppBundle\DBAL\Types\Energiforsyning\InternProduktion\PrisgrundlagType;
use AppBundle\Entity\Tiltag;
use AppBundle\Entity\TiltagDetail;
use AppBundle\Entity\BelysningTiltag;
use AppBundle\Entity\BelysningTiltagDetail;
use AppBundle\DBAL\Types\BelysningTiltagDetail\PlaceringType;
use AppBundle\DBAL\Types\BelysningTiltagDetail\StyringType;
use AppBundle\DBAL\Types\BelysningTiltagDetail\TiltagType;
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
use AppBundle\Entity\SpecialTiltag;
use AppBundle\Entity\SpecialTiltagDetail;

/**
 * Class LoadExcelRapport
 * @package AppBundle\DataFixtures\ORM
 */
class LoadExcelRapport extends LoadData {
  protected $order = 10;

  private $manager;
  private $workbook;
  private $name;

  /**
   * @var callable
   */
  private $isSelected;

  /**
   * {@inheritDoc}
   */
  public function load(ObjectManager $manager) {
    $this->manager = $manager;

    $basepath = $this->container->get('kernel')
              ->locateResource('@AppBundle/DataFixtures/Data/');
    foreach (glob($basepath . '*.xlsm') as $filepath) {
      $this->name = basename($filepath, '.xlsm');

      $reader = \PHPExcel_IOFactory::createReaderForFile($filepath);
      $reader->setReadDataOnly(true);
      $this->writeInfo('Loading Excel workbook %s ... %s', $filepath, (new \DateTime())->format('c'));
      $this->workbook = $reader->load($filepath);
      $this->writeInfo('Done. %s', (new \DateTime())->format('c'));

      $this->isSelected = function($value) {
        return $value == 'x';
      };

      $this->loadForsyningsvaerker();
      $this->loadSolceller();
      $this->loadBygning();
      $this->loadKlimaskaerm();
      $this->loadRapport();

      $this->clearEntityReferences();
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
        // 'F' => 'pris2009',
        // 'G' => 'pris2014',
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

      $this->setEntityReference('forsyningsvaerk', $values['A'], $forsyningsvaerk);

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

      $forsyningsvaerk = $this->getEntityReference('forsyningsvaerk', $values['A'], FALSE) ?: new Forsyningsvaerk();
      $forsyningsvaerk = $this->loadEntity($forsyningsvaerk, array(
        'A' => 'navn',
        // 'B' => 'energiform',
        'C' => 'co2noter',
        // 'F' => 'co2y2009',
        // 'G' => 'co2y2014',
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

      $this->setEntityReference('forsyningsvaerk', $values['A'], $forsyningsvaerk);

      $this->persist($forsyningsvaerk);
    }
  }

  private $calculatedValues = array();

  private function setCalculatedValues($entity, $values) {
    if ($entity) {
      $this->calculatedValues[spl_object_hash($entity)] = $values;
    }
  }

  private function getCalculatedValues($entity) {
    if (!$entity) {
      return NULL;
    }
    $key = spl_object_hash($entity);
    return isset($this->calculatedValues[$key]) ? $this->calculatedValues[$key] : NULL;
  }

  private function clearEntityReferences() {
    $this->setReferenceRepository(new \Doctrine\Common\DataFixtures\ReferenceRepository($this->manager));
  }

  /**
   * Get an entity by type and id.
   *
   * @param string $type
   * @param string $id
   *
   * @return object
   */
  private function getEntityReference($type, $id, $errorOnMissing = TRUE) {
    if (!$type || !$id) {
      return null;
    }
    $key = $type . ':' . $id;
    if (!$this->hasReference($key) || !$this->getReference($key)) {
      if ($errorOnMissing) {
        $this->writeError('No such ' . $type .': ' . $id);
      }
      return null;
    }
    return $this->getReference($key);

  }

  private function loadSolceller() {
    $sheet = $this->workbook->getSheetByName('Detailark (1)');
    $data = $sheet->rangeToArray('AD25:AH35', null, false, false, true);
    $data = $this->getCalculatedCells($data, $sheet);

    foreach ($data as $rowId => $row) {
      $values = $row;

      if (!$values['AF']) {
        break;
      }

      $solcelle = $this->loadEntity(new Solcelle(), array(
        'AE' => 'KWp',
        'AF' => 'inverterpris',
        'AG' => 'drift',
      ), $values);

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
        'P' => array('Bruttoetageareal', 'integer'),
        'Q' => 'Maalertype',
        'R' => array('forsyningsvaerkVand', function($value) { return $this->getEntityReference('forsyningsvaerk', $value); }),
        // 'S' => 'Vand_InstNr',
        // 'T' => 'Vand_MaalerNr',
        // 'U' => 'Vand_Qn',
        'V' => 'kundenummer',
        'W' => 'kode',
        'X' => array('forsyningsvaerkVarme', function($value) { return $this->getEntityReference('forsyningsvaerk', $value); }),
        'Y' => 'kundenr_1',
        'Z' => 'kode_1',
        'AA' => 'MaalerskifteAFV',
        'AB' => 'AFVInstnr_1',
        // 'AC' => 'Varme_MaalerNr',
        // 'AD' => 'Varme_Qn',
        'AE' => array('forsyningsvaerkEl', function($value) { return $this->getEntityReference('forsyningsvaerk', $value); }),
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

      $this->setEntityReference('bygning', $bygning->getEnhedsys(), $bygning);
      $bygning->setStatus(BygningStatusType::IKKE_STARTET);

      $this->persist($bygning);
    }
  }

  private function loadKlimaskaerm() {
    $sheet = $this->workbook->getSheetByName('Klimaskærmspriser');

    $data = $sheet->rangeToArray('A2:F100', null, false, false, true);
    $data = $this->getCalculatedCells($data, $sheet);

    // Copy previous 'klimaskaerm' value down when not specfied.
    $currentValue = NULL;
    foreach ($data as &$row) {
      if ($row['B']) {
        $currentValue = $row['B'];
      }
      else if ($currentValue) {
        $row['B'] = $currentValue;
      }
    }

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

      $this->setEntityReference('klimaskaerm', $values['A'], $klimaskaerm);

      $this->persist($klimaskaerm);
    }
  }

  private $configuration;

  /**
   * Load a complete Rapport from an Excel workbook
   */
  private function loadRapport() {
    $sheet = $this->workbook->getSheetByName('1.TiltagslisteRådgiver');
    $enhedsys = $sheet->getCell('C4');

    $this->loadConfiguration($sheet);

    //Faktor er hardcodet til 25000 i excel arket, men skal kunne ændres
    $this->configuration->setDriftomkostningerfaktor(25000);

    $bygning = $this->getEntityReference('bygning', $enhedsys);
    $rapport = new Rapport();
    $rapport
      ->setBygning($bygning)
      ->setVersion($sheet->getCell('C24')->getOldCalculatedValue())
      ->setDatering($this->getDateTime($sheet->getCell('F23')))
      ->setFaktorPaaVarmebesparelse($this->getCellValue($sheet->getCell('F21')))
      ->setLaanLoebetid($this->getCellValue($this->getCell('TiltagslisteBruger', 'Q108')))
      ->setConfiguration($this->configuration);

    $this->setCalculatedValues($rapport, array(
      'standardforsyning' => $this->getCellValue($this->getCell('2.Forsyning', 'H3')) == 1,
      'mtmFaellesomkostninger' => $this->getCellValue($sheet->getCell('P5')),
      'implementering' => $this->getCellValue($sheet->getCell('P6')),
      'faellesomkostninger' => $this->getCellValue($sheet->getCell('P8')),
    ));

    $this->loadEnergiforsyning($rapport);
    $this->loadTekniskIsoleringTiltag($rapport);
    $this->loadBelysningTiltag($rapport);
    $this->loadPumpeTiltag($rapport);
    $this->loadKlimaskaermTiltag($rapport);
    $this->loadSolcelleTiltag($rapport);
    $this->loadSpecialTiltag($rapport);

    $this->persist($rapport);

    $this->writeInfo(get_class($rapport) . ' ' . $rapport->getId() . ' loaded');

    $this->persist($this->configuration);
    $this->writeInfo(get_class($this->configuration) . ' loaded');
  }

  private function loadConfiguration(\PHPExcel_Worksheet $sheet) {
    $repository = $this->manager->getRepository('AppBundle:Configuration');
    $this->configuration = $repository->getConfiguration();
    $this->configuration
      ->setKalkulationsrente($this->getCellValue($sheet->getCell('AI23')))
      ->setInflation($this->getCellValue($sheet->getCell('AK23')))
      ->setLobetid($this->getCellValue($sheet->getCell('AN23')));
  }

  protected function loadEnergiforsyning(Rapport $rapport) {
    $sheet = $this->workbook->getSheetByName('2.Forsyning');
    $data = $sheet->rangeToArray('A15:AK25', null, false, false, true);

    foreach ($data as $rowId => $row) {
      if ($row['A']) {
        $energiforsyning = $this->loadEntity(new Energiforsyning(), array(
          'A' => array('navn', function($value) {
            switch ($value) {
              case 'Hovedforsyning El':
                return NavnType::HOVEDFORSYNING_EL;
              case 'Fjernvarme':
                return NavnType::FJERNVARME;
              default:
                return NavnType::NONE;
            }
          }),
          'B' => 'beskrivelse',
        ), $row);

        $rapport->addEnergiforsyning($energiforsyning);

        for ($index = ord('H'); $index <= ord('V'); $index += 6) {
          if ($row[chr($index)] && $row[chr($index+1)]) {
            $columnMapping = array();
            $columnMapping[chr($index-1)] = array('navn', function($value) { return $value ? $value : ''; });
            $columnMapping[chr($index)] = 'fordeling';
            $columnMapping[chr($index+1)] = 'effektivitet';
            $columnMapping[chr($index+2)] = array('prisgrundlag', function($value) {
              switch ($value) {
                case 'EL':
                  return PrisgrundlagType::EL;
                case 'VAND':
                  return PrisgrundlagType::VAND;
                case 'VARME':
                  return PrisgrundlagType::VARME;
                default:
                  return PrisgrundlagType::NONE;
              }
            });

            $internProduktion = $this->loadEntity(new InternProduktion(), $columnMapping, $row);
            $energiforsyning->addInternProduktion($internProduktion);

            $this->persist($internProduktion);
            $this->writeInfo(get_class($internProduktion) . ' ' . $internProduktion->getId() . ' loaded');
          }
        }

        $this->setEntityReference('energiforsyning', $row['A'], $energiforsyning);
        $this->setCalculatedValues($energiforsyning, array(
          'samletVarmeeffektivitet' => $this->getCellValue($sheet->getCell('AJ' . $rowId)),
          'samletEleffektivitet' => $this->getCellValue($sheet->getCell('AK' . $rowId)),
        ));
        $this->persist($energiforsyning);

        $this->writeInfo(get_class($energiforsyning) . ' ' . $energiforsyning->getId() . ' loaded');
      }
    }
  }

  private function getCell($sheet, $coordinate) {
    if (is_string($sheet)) {
      $sheet = $this->workbook->getSheetByName($sheet);
    }
    return $sheet->getCell($coordinate);
  }

  private function getRange(\PHPExcel_Worksheet $sheet, $range) {
    return $this->getCellValues($sheet->rangeToArray($range, null, false, false, true), $sheet);
  }

  private function getCellValues(array $cells, \PHPExcel_Worksheet $sheet) {
    $values = $cells;
    array_walk($values, function(&$array, $rowId) use ($sheet) {
        array_walk($array, function(&$value, $colId, $rowId) use ($sheet) {
            $cell = $sheet->getCell($colId . $rowId);
            if ($cell && $cell->getDataType() == \PHPExcel_Cell_DataType::TYPE_FORMULA) {
              try {
                $value = $cell->getOldCalculatedValue();
              } catch (\Exception $ex) {}
            }
          }, $rowId);
      });

    return $values;
  }

  /**
   * Load a Tiltag with properties shared by all Tiltag
   */
  private function loadTiltag(Tiltag $tiltag, Rapport $rapport, \PHPExcel_Worksheet $sheet) {
    $tiltag
      ->setRapport($rapport)
      ->setForsyningVarme($this->getEntityReference('energiforsyning', $sheet->getCell('C13')->getValue()))
      ->setForsyningEl($this->getEntityReference('energiforsyning', $sheet->getCell('F13')->getValue()))
      ->setFaktorForReinvesteringer($this->getCellValue($sheet->getCell('C11')))
      ->setTiltagskategori($this->getEntityReference('tiltagskategori', $sheet->getCell('D12')->getValue()))
      ->setPrimaerEnterprise($this->getCellValue($sheet->getCell('B12')))
      ->setRisikovurdering($this->getCellValue($sheet->getCell('C17')))
      ->setPlacering($this->getCellValue($sheet->getCell('C19')))
      ->setBeskrivelseDriftOgVedligeholdelse($this->getCellValue($sheet->getCell('A21')))
      ->setIndeklima($this->getCellValue($sheet->getCell('A23')));

    $rapportSheet = $this->workbook->getSheetByName('1.TiltagslisteRådgiver');
    $tilvalgtData = $this->getRange($rapportSheet, 'B31:D64');

    $tiltagNumber = 0;
    if ($tiltag instanceof TekniskIsoleringTiltag) {
      $tiltagNumber = 3;
    }
    elseif ($tiltag instanceof BelysningTiltag) {
      $tiltagNumber = 4;
    }
    elseif ($tiltag instanceof KlimaskaermTiltag) {
      $tiltagNumber = 7;
    }
    elseif ($tiltag instanceof PumpeTiltag) {
      $tiltagNumber = 5;
    }
    elseif ($tiltag instanceof SolcelleTiltag) {
      $tiltagNumber = 1;
    }
    elseif ($tiltag instanceof SpecialTiltag) {
      $tiltagNumber = 10;
    }
    if ($tiltagNumber) {
      foreach ($tilvalgtData as $rowId => $row) {
        if ($row['B'] == $tiltagNumber) {
          $tiltag->setTilvalgtAfRaadgiver($row['D'] == 'TILVALGT');
        }
      }
    }

    $beskrivelse = $this->getCellValue($sheet->getCell('A15'));
    $tokens = array_map('trim', preg_split('/(Nuværende forhold|Forslag|Øvrige bemærkninger):/i', $beskrivelse));
    if (count($tokens) == 4) {
      $tiltag->setBeskrivelseNuvaerende($tokens[1]);
      $tiltag->setBeskrivelseForslag($tokens[2]);
      $tiltag->setBeskrivelseOevrige($tokens[3]);
    }

    // Calculated values.
    $calculatedValues = array(
      'varmebesparelseGUF' => 'C4',
      'varmebesparelseGAF' => 'C5',
      'elbesparelse' => 'C6',
      'vandbesparelse' => 'C7',
      'samletEnergibesparelse' => 'C8',
      'samletCo2besparelse' => 'C9',
      'besparelseDriftOgVedligeholdelse' => 'G5',
      'levetid' => 'G7',
      'antalReinvesteringer' => 'C10',
      'anlaegsinvestering' => 'G4',
      'reinvestering' => 'G11',
      'besparelseStrafafkoelingsafgift' => 'G6',
      'scrapvaerdi' => 'G10',
      'simpelTilbagebetalingstidAar' => 'G8',
      'nutidsvaerdiSetOver15AarKr' => 'G9',
    );

    $convertToInput = function(array $properties) use ($sheet, $tiltag, $calculatedValues) {
      foreach ($properties as $property) {
        $tiltag->{'set' . $property}($this->getCellValue($sheet->getCell($calculatedValues[$property])));
        unset($calculatedValues[$property]);
      }
    };

    if ($tiltag instanceof TekniskIsoleringTiltag || $tiltag instanceof PumpeTiltag) {
      $convertToInput(array(
        'besparelseDriftOgVedligeholdelse',
        'besparelseStrafafkoelingsafgift',
        'levetid',
      ));
    }
    elseif ($tiltag instanceof SolcelleTiltag) {
      $convertToInput(array(
        'levetid',
      ));
    }
    elseif ($tiltag instanceof KlimaskaermTiltag) {
      $convertToInput(array(
        'besparelseDriftOgVedligeholdelse',
      ));
    }
    elseif ($tiltag instanceof SpecialTiltag) {
      $convertToInput(array(
        'besparelseDriftOgVedligeholdelse',
        'besparelseStrafafkoelingsafgift',
        'levetid',
        'anlaegsinvestering',
      ));
      $tiltag
        ->setBesparelseGUF($this->getCellValue($sheet->getCell('J29')))
        ->setBesparelseGAF($this->getCellValue($sheet->getCell('J30')))
        ->setBesparelseEl($this->getCellValue($sheet->getCell('J31')));
    }

    $values = array();
    foreach ($calculatedValues as $key => $cell) {
      $values[$key] = floatval($this->getCellValue($sheet->getCell($cell)));
    }
    $this->setCalculatedValues($tiltag, $values);

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
      ->setVarmeledningsevneEksistLamelmaatter($this->getCellValue($sheet->getCell('N38')))
      ->setVarmeledningsevneNyIsolering($this->getCellValue($sheet->getCell('N39')));

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
      'I' => array('laastAfEnergiraadgiver', $this->isSelected),
      'J' => array('tilvalgt', $this->isSelected),
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
      'I' => array('laastAfEnergiraadgiver', $this->isSelected),
      'J' => array('tilvalgt', $this->isSelected),
      'K' => 'lokale_navn',
      // 'L' => '',
      'M' => 'lokale_type',
      'N' => 'armaturhoejdeM',
      'O' => 'rumstoerrelseM2',
      // 'P' => '',
      'Q' => 'lokale_antal',
      'R' => 'drifttidTAar',
      // 'S' => '',
      'T' => array('lyskilde', function($value) { return $this->getEntityReference('lyskilde', $value); }),
      // 'U' => '',
      // 'V' => '',
      'W' => 'lyskildeStkArmatur',
      'X' => 'lyskildeWLyskilde',
      'Y' => 'forkoblingStkArmatur',
      'AA' => 'armaturerStkLokale',
      // 'AB' => ''
      // 'AC' => ''
      'AD' => array('placering', function($value) {
        switch ($value) {
          case 1:
            return PlaceringType::NEDHAENGT;
          case 2:
            return PlaceringType::INDBYGGET;
          case 3:
            return PlaceringType::PAABYGGET;
          case 4:
            return PlaceringType::STAAENDE;
          case 5:
            return PlaceringType::ANDET_SE_NOTER;
          default:
            return PlaceringType::NONE;
        }
      }),
      // 'AE' => '',
      'AF' => array('styring', function($value) {
        switch ($value) {
          case 2:
            return StyringType::PIR_ON_OFF;
          case 3:
            return StyringType::PIR_DGS;
          case 4:
            return StyringType::SKUMRINGSRELAE;
          case 5:
            return StyringType::PIR_I_AFBRYDER;
          case 8:
            return StyringType::ANDET_SE_NOTER;
          default:
            return StyringType::NONE;
        }
      }),
      // 'AG' => '',
      'AH' => 'noter',
      'AI' => array('belysningstiltag', function($value) {
        switch ($value) {
          case 4:
            return TiltagType::ARMATUR;
          case 5:
            return TiltagType::LED_I_EKSIST_ARM;
          case 6:
            return TiltagType::NY_INDSATS_I_ARM;
          case 7:
            return TiltagType::ANDET_SE_NOTER;
          default:
            return TiltagType::NONE;
        }
      }),
      // 'AJ' => '',
      'AK' => 'nyeSensorerStkLokale',
      'AL' => 'standardinvestSensorKrStk',
      'AO' => 'standardinvestArmaturKrStk',
      'AP' => 'standardinvestLyskildeKrStk',
      'AQ' => array('nyLyskilde', function($value) { return $this->getEntityReference('lyskilde', $value); }),
      // 'AR' => ''
      // 'AS' => ''
      'AT' => 'nyLyskildeStkArmatur',
      'AU' => 'nyLyskildeWLyskilde',
      'AV' => 'nyForkoblingStkArmatur',
      // 'AW' => '',
      'AX' => 'nyeArmaturerStkLokale',
      'AY' => 'nyttiggjortVarmeAfElBesparelse',
      'AZ' => 'prisfaktor',

      // Calculated
      // 'Z' => 'armatureffekt',
      // 'AB' => 'elforbrugKwhPrLokaleAar',
      'AC' => 'elforbrugWM2',
      'AN' => 'nyDriftstid',
      'AW' => 'nyArmatureffektWStk',
      'BA' => 'prisfaktorTillaegKrLokale',
      'BB' => 'investeringAlleLokalerKr',
      // 'BC' => 'nytElforbrugKwhPrLokaleAar',
      'BD' => 'nytElforbrugWM2',
      // 'BE' => 'elbesparelseAlleLokalerKwhAar',
      // 'BF' => 'varmebesparelseAlleLokalerKwhAar',
      // 'BG' => 'eksistLyskildesLevetidT',
      // 'BH' => 'nyLyskildesLevetidT',
      // 'BI' => 'udgiftTilLyskilderKrStk',
      // 'BJ' => 'nyUdgiftTilLyskilderKrStk',
      'BK' => 'driftsbesparelseTilLyskilderKrAar',
      'BL' => 'simpelTilbagebetalingstidAar',
      'BM' => 'vaegtetLevetidAar',
      // 'BN' => 'udgiftSensor',
      // 'BO' => 'udgiftArmaturer',
      // 'BP' => 'udgiftLyskilde',
      // 'BQ' => 'levetidArmaturer',
      // 'BR' => 'levetidLyskilde',
      // 'BS' => 'armaturVaegtning',
      // 'BT' => 'lyskildeVaegtning',
      // 'BU' => 'faktorForReinvestering',
      'BV' => 'nutidsvaerdiSetOver15AarKr',
      'BW' => 'kwhBesparelseEl',
      'BX' => 'kwhBesparelseVarmeFraVarmevaerket',
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

      $this->setEntityReference('lyskilde', $values[0], $lyskilde);

      $this->persist($lyskilde);
    }
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
        'R' => array('StandInvestering', 'float'),
        // 'S' => 'Besparelse ved isoleringskappe',
        'T' => 'Roerlaengde',
        'U' => 'Roerstoerrelse',
        'V' => 'Fabrikant',
      ), $values);

      $this->setEntityReference('pumpe', $values['A'], $pumpe);

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
      'I' => array('laastAfEnergiraadgiver', $this->isSelected),
      'J' => array('tilvalgt', $this->isSelected),
      'K' => 'pumpeID',
      'L' => 'forsyningsomraade',
      'M' => 'placering',
      'N' => 'applikation',
      'N' => array('applikation', function($value, $row) { return $this->getEntityReference('PumpeTiltagDetailApplikation', $value); }),
      'O' => 'isoleringskappe',
      'P' => 'bFaktor',
      'Q' => 'noter',
      'R' => 'eksisterendeDrifttid',
      'S' => 'nyDrifttid',
      'T' => 'prisfaktor',
      'U' => array('pumpe', function($value, $row) { return $this->getEntityReference('pumpe', $value); }),
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
      'I' => array('laastAfEnergiraadgiver', $this->isSelected),
      'J' => array('tilvalgt', $this->isSelected),
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
      'AA' => array('klimaskaerm', function($value) { return $this->getEntityReference('klimaskaerm', $value); }),
      'AC' => 'prisfaktor',
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
    // Copy some values down in the rows
    for ($row = 39; $row <= 39; $row++) {
      $sheet->getCell('AB' . $row)->setValue($sheet->getCell('J26')->getValue());
      $sheet->getCell('AC' . $row)->setValue($sheet->getCell('J27')->getValue());
      $sheet->getCell('AD' . $row)->setValue($sheet->getCell('J29')->getValue());
      $sheet->getCell('AE' . $row)->setValue($sheet->getCell('J30')->getValue());
    }

    $columnMapping = array(
      'H' => array('laastAfEnergiraadgiver', $this->isSelected),
      // Only one SolcelleTiltagDetail exists and it is selected
      'I' => array('tilvalgt', function() { return true; }),
      'J' => 'anlaegsstoerrelseKWp',
      'K' => 'produktionKWh',
      'L' => 'tilNettetPct',
      'P' => 'inverterskift1Aar',
      'Q' => 'inverterskift2Aar',
      'S' => 'investeringKr',
      'T' => 'screeningOgProjekteringKr',
      'W' => 'omkostningTilMaalerKr',
      'AB' => 'forringetYdeevnePrAar',
      'AC' => 'energiprisstigningPctPrAar',
      'AD' => 'salgsprisFoerste10AarKrKWh',
      'AE' => 'salgsprisEfter10AarKrKWh',
      'AF' => array('solcelle', function($value, $row) { return $this->manager->getRepository('AppBundle:Solcelle')->findByKWp($row['J']); }),

      // Calculated
      'M' => 'tilEgetForbrugPct',
      'N' => 'egetForbrugAfProduktionenKWh',
      'O' => 'produktionTilNettetKWh',
      'R' => 'prisForNyInverterKr',
      // 'U' => 'scrapvaerdi',
      'V' => 'driftPrAarKr',
      'X' => 'raadighedstarifKr',
      'Y' => 'totalDriftomkostningerPrAar',
      'Z' => 'simpelTilbagebetalingstidAar',
      'AA' => 'nutidsvaerdiSetOver15AarKr',
    );

    $this->loadTiltagDetail($tiltag, new SolcelleTiltagDetail(), $sheet, 'H38:AF42', $columnMapping, function($row) {
      return $row['J'];
    });
  }

  private function loadSpecialTiltag(Rapport $rapport) {
    $sheet = $this->workbook->getSheetByName('Detailark (10)');
    $tiltag = $this->loadTiltag(new SpecialTiltag(), $rapport, $sheet);

    $this->loadSpecialTiltagDetail($tiltag, $sheet);

    $this->persist($tiltag);

    $this->writeInfo(get_class($tiltag) . ' ' . $tiltag->getId() . ' loaded');
  }

  private function loadSpecialTiltagDetail(SpecialTiltag $tiltag, \PHPExcel_Worksheet $sheet) {
    $columnMapping = array();
    $this->loadTiltagDetail($tiltag, new SpecialTiltagDetail(), $sheet, 'J29:J29', $columnMapping, function($row) {
      return false;
    });
  }

  private function loadTiltagDetail(Tiltag $tiltag, TiltagDetail $detail, \PHPExcel_Worksheet $sheet, $range, array $columnMapping, callable $includeRow) {
    list($data, $columns) = $this->getData($range, $sheet, $columnMapping, $includeRow, $tiltag);
    $data = $this->getCalculatedCells($data, $sheet);

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

    $this->dumpUnittestData($sheet, $columns, $data, $tiltag);

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
    return is_string($value) && strlen($value) > 0 && $value[0] == '=';
  }

  /**
   * @param \PHPExcel_Cell $cell
   * @return \DateTime
   */
  private function getDateTime(\PHPExcel_Cell $cell) {
    return \PHPExcel_Shared_Date::ExcelToPHPObject($this->getCellValue($cell));
  }

  private function dumpUnittestData(\PHPExcel_Worksheet $sheet, array $columns, array $cells, Tiltag $tiltag) {
    $formats = getenv('DUMP_UNITTEST_DATA') ? preg_split('/\s*,\s*/', getenv('DUMP_UNITTEST_DATA')) : array();

    $calculatedCells = $this->getCalculatedCells($cells, $sheet);
    $inputColumns = array_filter($columns, function($column) { return !$column['calculated']; });
    $inputData = array();
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
          if (self::isCalculatedValue($value)) {
            $value = $this->getCellValue($sheet->getCell($colId . $rowId));
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
    }

    $type = preg_replace('/^.+\\\\([^\\\\]+)$/', '$1', get_class($tiltag));

    if (in_array('json', $formats)) {
      echo PHP_EOL, '=== JSON ' . $type .' start =============================================================================', PHP_EOL;
      echo json_encode(array(
        'type' => $type,
        'columns' => $columns,
        'cells' => $cells,
        'calculated' => $calculatedCells,
      ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
      echo PHP_EOL, '=== JSON ' . $type .' end ===============================================================================', PHP_EOL;
    }

    if (in_array('php', $formats)) {
      if ($type) {
        $details = array();
        foreach ($inputData as $rowId => $inputRow) {
          $properties = $this->mapRow($inputRow, $columns);
          foreach ($properties as $key => $value) {
            if (is_object($value)) {
              $properties[$key] = $this->getProperties($value);
            }
          }
          $expected = $this->mapRow($calculatedData[$rowId], $columns);
          $details[] = array(
            '_input' => $properties,
            '_calculated' => $expected,
          );
        }

        $testFixturesPath = null;
        try {
          $testFixturesPath = $this->container->get('kernel')
                            ->locateResource('@AppBundle/DataFixtures/Data/').'fixtures/';

          if (!is_dir($testFixturesPath) && !@mkdir($testFixturesPath, 0777, true)) {
            $testFixturesPath = null;
            throw new \Exception(sprintf('Unable to create "%s" directory.', $testFixturesPath));
          }
        } catch (\Exception $ex) {}

        if ($testFixturesPath) {
          $dir = $testFixturesPath . $this->name;
          if (!is_dir($dir) && !@mkdir($dir, 0777, true)) {
            $testFixturesPath = null;
            throw new \Exception(sprintf('Unable to create "%s" directory.', $dir));
          }
          $filepath = $dir . '/' . $type;

          $data = array(
            'details' => $details,

            'tiltag' => $this->serialize($tiltag, array(
              'forsyningVarme' => array(
                'internProduktioner' => NULL,
              ),
              'forsyningEl' => array(
                'internProduktioner' => NULL,
              ),
            )),

            'rapport' => $this->serialize($tiltag->getRapport(), array(
              'configuration' => NULL,
              'bygning' => array(
                'forsyningsvaerkVarme' => NULL,
                'forsyningsvaerkEl' => NULL,
                'forsyningsvaerkVand' => NULL,
              ),
              'energiforsyninger' => array(
                'internProduktioner' => NULL,
              ),
            )),

            'bygning' => array(
              '_input' => $this->getProperties($tiltag->getRapport()->getBygning()),
            ),
            'bygning.forsyningsvaerkVarme' => $this->getProperties($tiltag->getRapport()->getBygning()->getForsyningsvaerkVarme(TRUE)),
            'bygning.forsyningsvaerkEl' => $this->getProperties($tiltag->getRapport()->getBygning()->getForsyningsvaerkEl(TRUE)),
            'bygning.forsyningsvaerkVand' => $this->getProperties($tiltag->getRapport()->getBygning()->getForsyningsvaerkVand(TRUE)),
            'configuration' => $this->getProperties($tiltag->getRapport()->getConfiguration()),
          );
          $content = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
          if (@file_put_contents($filepath, $content) !== false) {
            $this->writeInfo('Unittest data fixtures written to file ' . $filepath);
          }
        }
      }
    }
  }

  private function serialize($object, array $additionalProperties = array()) {
    if ($object instanceof \Doctrine\Common\Collections\ArrayCollection) {
      $object = $object->toArray();
    }

    if (is_array($object)) {
      return array_map(function($item) use ($additionalProperties) {
          return $this->serializeObject($item, $additionalProperties);
        }, $object);
    }

    return $this->serializeObject($object, $additionalProperties);
  }

  private function serializeObject($object, array $additionalProperties) {
    if (!$object) {
      return NULL;
    }
    $properties = $this->getProperties($object);
    $result = array(
      '_input' => $properties,
    );
    if ($calculatedValues = $this->getCalculatedValues($object)) {
      $result['_calculated'] = $calculatedValues;
    }
    foreach ($additionalProperties as $property => $subProperties) {
      if (method_exists($object, 'get' . $property)) {
        $result[$property] = $this->serialize($object->{'get' . $property}(), $subProperties ?: array());
      }
    }
    return $result;
  }

  /**
   * Get all properties exposed through set/get methods
   * @param $object
   * @return array
   */
  private function getProperties($object) {
    $properties = array();
    $methods = get_class_methods($object);
    if ($methods) {
      foreach ($methods as $method) {
        if (preg_match('/^set([A-Z].*)$/', $method, $matches)) {
          $property = $matches[1];
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

  private function getCellValue(\PHPExcel_Cell $cell) {
    $value = 0;
    if ($cell) {
      $value = ($cell->getDataType() == \PHPExcel_Cell_DataType::TYPE_FORMULA) ? $cell->getOldCalculatedValue() : $cell->getValue();
    }
    return $value;
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
