<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Bygning;
use AppBundle\Entity\Rapport;
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
  // Must run after LoadBygningsData and LoadLyskildeData
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
      ->setDatering(\PHPExcel_Shared_Date::ExcelToPHPObject($sheet->getCell('F23')->getValue()));

    $this->loadTekniskIsoleringTiltag($rapport);
    $this->loadBelysningTiltag($rapport);
    $this->loadPumpeTiltag($rapport);
    $this->loadKlimaskaermTiltag($rapport);

    $this->persist($rapport);

    $this->writeInfo(get_class($rapport) . ' ' . $rapport->getId() . ' loaded');
  }


  /* -------------------------------------------------------------------------------- *
   * Teknisk isolering
   * -------------------------------------------------------------------------------- */

  private function loadTekniskIsoleringTiltag(Rapport $rapport) {
    $sheet = $this->workbook->getSheetByName('Detailark (3)');

    $tiltag = new TekniskIsoleringTiltag();
    $tiltag
      ->setRapport($rapport)
      // ->setBeskrivelseForslag($sheet->getCell('A15')->getValue())
      ;

    $this->loadTekniskIsoleringTiltagDetail($tiltag, $sheet);

    $this->persist($tiltag);

    $this->writeInfo(get_class($tiltag) . ' ' . $tiltag->getId() . ' loaded');
  }

  private function loadTekniskIsoleringTiltagDetail(TekniskIsoleringTiltag $tiltag, \PHPExcel_Worksheet $sheet) {
    $data = $this->getData('I48:AI99', $sheet);

    foreach ($data as $values) {
      if (!($values['Beskrivelse (type)'])) {
        break;
      }

      $detail = new TekniskIsoleringTiltagDetail();
      $detail
        ->setTiltag($tiltag)
        ->setTilvalgt(!!$values['Tilvalgt'])
        ;

      $this->persist($detail);

      $this->writeInfo(get_class($detail) . ' ' . $detail->getId() . ' loaded');
    }
  }


  /* -------------------------------------------------------------------------------- *
   * Belysning/El
   * -------------------------------------------------------------------------------- */

  private function loadBelysningTiltag(Rapport $rapport) {
    $sheet = $this->workbook->getSheetByName('Detailark (4)');

    $this->loadLyskilde($sheet);

    $tiltag = new BelysningTiltag();
    $tiltag
      ->setRapport($rapport)
      ->setBeskrivelseForslag($sheet->getCell('A15')->getValue());

    $this->loadBelysningTiltagDetail($tiltag, $sheet);

    $this->persist($tiltag);

    $this->writeInfo(get_class($tiltag) . ' ' . $tiltag->getId() . ' loaded');
  }

  private function loadBelysningTiltagDetail(BelysningTiltag $tiltag, \PHPExcel_Worksheet $sheet) {
    $data = $this->getData('I41:BS99', $sheet);

    foreach ($data as $values) {
      if (!($values['Lokale, navn'])) {
        break;
      }

      $detail = new BelysningTiltagDetail();
      $detail
        ->setTiltag($tiltag)
        ->setTilvalgt(!!$values['Tilvalgt'])
        ->setLokaleNavn($values['Lokale, navn'])
        ->setLokaleType($values['Lokale, type'])
        ->setArmaturhoejdeM($values['Armaturhøjde [m]'])
        ->setRumstoerrelseM2($values['Rumstørrelse [m2]'])
        ->setLokaleAntal($values['Lokale, antal'])
        ->setDrifttidTAar($values['Drifttid (t/år)'])
        ->setLyskilde($this->getLyskilde($values['Lyskilde, input']))
        ->setLyskildeStkArmatur($values['Lyskilde,  (stk/armatur)'])
        ->setLyskildeWLyskilde($values['Lyskilde, (W/lyskilde)'])
        ->setForkoblingStkArmatur($values['Forkobling (stk/armatur)'])
        ->setArmaturerStkLokale($values['Armaturer (stk/lokale)'])
        ->setPlaceringId($values['Placering, input'])
        ->setStyringId($values['Styring, input'])
        ->setNoter($values["Noter \n(se huskeliste over tabel)"])
        ->setBelysningstiltagId($values['Tiltag, input'])
        ->setNyeSensorerStkLokale($values['Nye Sensorer (stk/lokale)'])
        ->setStandardinvestSensorKrStk($values['Standardinvest. Sensor(kr/stk)'])
        ->setReduktionAfDrifttid($values['Reduktion af drifttid (%)'])
        ->setStandardinvestArmaturElLyskildeKrStk($values['Standardinvest. armatur el. lyskilde (kr/stk)'])
        ->setNyLyskilde($this->getLyskilde($values['Ny lyskilde, input']))
        ->setNyLyskildeStkArmatur($values['Ny Lyskilde,  (stk/armatur)'])
        ->setNyLyskildeWLyskilde($values['Ny lyskilde, (W/lyskilde)'])
        ->setNyForkoblingStkArmatur($values['Ny forkobling (stk/armatur)'])
        ->setNyeArmaturerStkLokale($values['Nye armaturer (stk/lokale)'])
        ->setNyttiggjortVarmeAfElBesparelse($values['Nyttiggjort varme(% af el-besparelse)'])
        ->setPrisfaktor($values['Prisfaktor (1 er neutral)']);

      $this->persist($detail);

      $this->writeInfo(get_class($detail) . ' ' . $detail->getId() . ' loaded');
    }
  }

  private function loadLyskilde(\PHPExcel_Worksheet $sheet) {
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

  private function loadPumpeTiltag(Rapport $rapport) {
    $sheet = $this->workbook->getSheetByName('Detailark (5)');

    $tiltag = new PumpeTiltag();
    $tiltag
      ->setRapport($rapport)
      // ->setBeskrivelseForslag($sheet->getCell('A15')->getValue())
      ;

    $this->loadPumpeTiltagDetail($tiltag, $sheet);

    $this->persist($tiltag);

    $this->writeInfo(get_class($tiltag) . ' ' . $tiltag->getId() . ' loaded');
  }

  private function loadPumpeTiltagDetail(PumpeTiltag $tiltag, \PHPExcel_Worksheet $sheet) {
    $data = $this->getData('I36:AV99', $sheet);

    foreach ($data as $values) {
      if (!($values['Pumpe ID'])) {
        break;
      }

      $detail = new PumpeTiltagDetail();
      $detail
        ->setTiltag($tiltag)
        ->setTilvalgt(!!$values['Tilvalgt'])
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

    $tiltag = new KlimaskaermTiltag();
    $tiltag
      ->setRapport($rapport)
      // ->setBeskrivelseForslag($sheet->getCell('A15')->getValue())
      ;

    $this->loadKlimaskaermTiltagDetail($tiltag, $sheet);

    $this->persist($tiltag);

    $this->writeInfo(get_class($tiltag) . ' ' . $tiltag->getId() . ' loaded');
  }

  private function loadKlimaskaermTiltagDetail(KlimaskaermTiltag $tiltag, \PHPExcel_Worksheet $sheet) {
    $data = $this->getData('I38:AU99', $sheet);

    foreach ($data as $values) {
      if (!($values['Tiltagsnr.'] || $values['Tiltagsnr. Delpriser'])) {
        break;
      }

      $detail = new KlimaskaermTiltagDetail();
      $detail
        ->setTiltag($tiltag)
        ->setTilvalgt(!!$values['Tilvalgt'])
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
   */
  private function getData($range, \PHPExcel_Worksheet $sheet) {
    $data = $sheet->rangeToArray($range, null, false, false, true);
    $headers = array_map(function($value) {
      // return preg_replace('/\s{2,}/', ' ', trim($value));
      return $value;
    }, array_shift($data));

    echo '--------------------------------------------------------------------------------', "\n";
    echo '--------------------------------------------------------------------------------', "\n";
    echo '--------------------------------------------------------------------------------', "\n";
    echo json_encode(array('sheet' => $sheet->getTitle(), 'headers' => $headers, 'data' => $data, 'comments' => $sheet->getComments()));
    echo '--------------------------------------------------------------------------------', "\n";
    echo '--------------------------------------------------------------------------------', "\n";
    echo '--------------------------------------------------------------------------------', "\n";

    $rows = array();
    foreach ($data as $rowId => $row) {
      $rows[] = array_combine($headers, $row);
    }

    // $dumpData = function(array $headers, array $data) {
    //   foreach ($data as $rowId => $row) {
    //     $this->writeInfo('--- DATA START ' . $rowId);
    //     foreach ($row as $colId => $value) {
    //       $this->writeInfo($headers[$colId] . ';' . $colId . ':' . $rowId . ';'. $value);
    //     }
    //     $this->writeInfo('--- DATA END ' . $rowId);
    //   }
    // };

    // $dumpData($headers, $data);

    return $rows;
  }

}
