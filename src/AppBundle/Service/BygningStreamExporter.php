<?php

namespace AppBundle\Service;

use AppBundle\Entity\Bygning;
use AppBundle\Entity\Tiltag;
use Box\Spout\Writer\Style\Style;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;
use Symfony\Component\PropertyAccess\PropertyAccess;

class BygningStreamExporter {

  private $data = [ '' ];
  private $row = 1;
  private $col = 0;

  /**
   * @var ContainerInterface
   */
  protected $container;

  /**
   * @var TranslatorInterface
   */
  protected $translator;

  /**
   * @var PropertyAccessor
   */
  protected $accessor;

  /**
   * @var StyleBuilder
   */
  protected $headerStyle;

  public function __construct(ContainerInterface $container, TranslatorInterface $translator) {
    $this->container = $container;
    $this->translator = $translator;
    $this->accessor = PropertyAccess::createPropertyAccessor();

    $this->headerStyle = (new StyleBuilder())->setFontBold()->setFontSize(14)->build();
  }

  public function setConfig(array $config) {
    $this->type = isset($config['type']) ? $config['type'] : null;
    $this->groups = isset($config['columns']['groups']) ? $config['columns']['groups'] : [];
    $this->showAll = isset($this->groups['alt']) ? $this->groups['alt'] : false;
  }

  /**
   * @var WriterInterface
   */
  private $writer;

  public function start($filepath, $format) {
    $this->format = $format;
    $this->writer = WriterFactory::create($format);
    $this->writer->openToFile($filepath);
  }

  public function header() {
    $this->writeHeader();
  }

  public function item(Bygning $bygning) {
    if ($this->type === 'tiltag' && $bygning->getRapport() && $bygning->getRapport()->getTiltag()) {
      foreach ($bygning->getRapport()->getTiltag() as $index => $tiltag) {
        $this->writeBygning($bygning, $tiltag, $index);
      }
    } else {
      $this->writeBygning($bygning);
    }
  }

  public function end() {
    $this->writer->close();
  }

  private $showAll = false;
  private $type = null;
  private $groups = [];

  private function writeHeader() {
    $this->addCell('Standardinformation', 9);
    if ($this->showAll || $this->groups['bygningsinformation']) {
      $this->addCell('Bygningsinformation', 11);
    }
    if ($this->showAll || $this->groups['baselineinformation']) {
      $this->addCell('Baselineinformation', 15);
    }
    if ($this->showAll || $this->groups['aa_screeningsinformation']) {
      $this->addCell('Aa+/Screeningsinformation', 8);
    }
    if ($this->showAll || $this->groups['besparelsesinformation']) {
      $this->addCell('Besparelsesinformation (Energi og økonomi)', 19);
    }
    if ($this->showAll || $this->groups['oekonomi']) {
      $this->addCell('Økonomiinformation (Set over 30 år)', 60);
    }
    if ($this->type === 'tiltag') {
      $this->addCell('Tiltag', 29);
    }
    $this->addRow($this->headerStyle);

    $this->addCell('ID');
    $this->addCell('Enhedsys');
    $this->addCell('Navn');
    $this->addCell('Adresse');
    $this->addCell('Postnummer');
    $this->addCell('By');
    $this->addCell('Status');
    $this->addCell('Version');
    $this->addCell('Opdateret');

    if ($this->showAll || $this->groups['bygningsinformation']) {
      $this->addCell('Type');
      $this->addCell('Opførelsesår');
      $this->addCell('Afdelingsnavn');
      $this->addCell('Ejer/Lejer');
      $this->addCell('Anvendelse');
      $this->addCell('Divisionnavn');
      $this->addCell('Områdenavn');
      $this->addCell('Ejerforhold');
      $this->addCell('Segment Navn');
      $this->addCell('Magistrat Forkortelse');
      $this->addCell('Segment Magistrat');
    }

    if ($this->showAll || $this->groups['baselineinformation']) {
      $this->addFormatedStringCell('%s (%s)', [$this->trans('Bruttoetageareal'), $this->trans('appbundle.bygning.bruttoetageareal.unit')]);
      $this->addFormatedStringCell('Varmeværk');
      $this->addFormatedStringCell('%s (%s)', ['CO2-faktor Varme 2009', 'Kg CO2/mWh']);
      $this->addFormatedStringCell('%s (%s)', [$this->trans('CO2 Varme 2009'), $this->trans('appbundle.rapport.BaselineCO2Varme.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['CO2-faktor Varme screeningsdato', 'Kg CO2/mWh']);
      $this->addFormatedStringCell('Elværk');
      $this->addFormatedStringCell('%s (%s)', ['CO2-faktor El 2009', 'Kg CO2/mWh']);
      $this->addFormatedStringCell('%s (%s)', ['CO2 El 2009', $this->trans('appbundle.rapport.BaselineCO2El.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['CO2-faktor El screeningsdato', 'Kg CO2/mWh']);
      $this->addFormatedStringCell('%s (%s)', ['Varmeforbrug GAF (Baseline)', $this->trans('appbundle.rapport.BaselineVarmeGAF.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Varmeforbrug GUF (Baseline)', $this->trans('appbundle.rapport.BaselineVarmeGUF.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Elforbrug (Baseline)', $this->trans('appbundle.rapport.BaselineEl.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Straffeafkøling', $this->trans('appbundle.rapport.BaselineStrafAfkoeling.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Energibudget, varme', $this->trans('appbundle.rapport.energibudgetVarme.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Energibudget, el', $this->trans('appbundle.rapport.energibudgetEl.unit')]);
    }

    if ($this->showAll || $this->groups['aa_screeningsinformation']) {
      $this->addCell('Aa+ Ansvarlig');
      $this->addCell('Rådgiver');
      $this->addCell('Projektleder');
      $this->addCell('Projekterende');
      $this->addCell('Screeningsdato');
      $this->addCell('Dato f. drift (Bygn.)');
      $this->addCell('Elena');
      $this->addCell('AVA-støtte');
    }

    if ($this->showAll || $this->groups['besparelsesinformation']) {
      $this->addFormatedStringCell('%s (%s)', ['Varmebesparelse GAF', $this->trans('appbundle.rapport.besparelseVarmeGAF.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Varmebesparelse GUF', $this->trans('appbundle.rapport.besparelseVarmeGUF.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Elbesparelse', $this->trans('appbundle.rapport.besparelseEl.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Solcelleproduktion, eget forbrug', $this->trans('appbundle.tiltag.solcelleproduktion.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Solcelleproduktion, salg til nettet år 1', $this->trans('appbundle.tiltag.salgTilNettetAar1.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['CO2-besparelse Varme', $this->trans('appbundle.rapport.besparelseCO2varme.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['CO2-besparelse El', $this->trans('appbundle.rapport.besparelseCO2el.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Samlet CO2-besparelse', $this->trans('appbundle.rapport.besparelseCO2.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Total Entreprisesum', $this->trans('appbundle.rapport.anlaegsinvestering.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Genopretning', $this->trans('appbundle.rapport.genopretning.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Modernisering', $this->trans('appbundle.rapport.modernisering.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Aa+ Investering eksl. øvrige omkostninger', $this->trans('appbundle.rapport.investeringEksFaellesomkostninger.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['MTM fællesomkostninger', $this->trans('appbundle.rapport.mtmFaellesomkostninger.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Energiscreeningspris', $this->trans('appbundle.rapport.energiscreening.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Implementeringsomkostninger', $this->trans('appbundle.rapport.implementering.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Aa+ Investering inkl. øvrige omkostninger', $this->trans('appbundle.rapport.investeringInklFaellesomkostninger.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Intern rente inkl. øvrige omkostninger', $this->trans('appbundle.rapport.internRenteInklFaellesomkostninger.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Nutidsværdi inkl. øvrige omkostninger', $this->trans('appbundle.rapport.nutidsvaerdiInklFaellesomkostninger.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Økonomisk besparelse i år 1', $this->trans('appbundle.rapport.besparelseAarEt.unit')]);
    }

    if ($this->showAll || $this->groups['oekonomi']) {
      for ($y = 1; $y <= 30; $y++) {
        $this->addCell('Varmebesparelse år ' . $y . ' (kWh/år)');
      }
      for ($y = 1; $y <= 30; $y++) {
        $this->addCell('Elbesparelse år ' . $y . ' (kWh/år)');
      }
    }

    if ($this->type === 'tiltag') {
      $this->addCell('Tiltagsnr.');
      $this->addCell('Tiltagsid');
      $this->addCell('Type');
      $this->addCell('Kategori');
      $this->addCell('Title');
      $this->addCell('Tilvalgt (Rådgiver)');
      $this->addCell('Tilvalgt (Aa+)');
      $this->addCell('Begrundelse (Aa+)');
      $this->addCell('Tilvalgt/fravalgt (Mag)');
      $this->addCell('Begrundelse (mag)');
      $this->addCell('Mængde');
      $this->addCell('Enheder');
      $this->addCell('Funktionsdygtig levetid');
      $this->addCell('Dato f. drift (Tiltag)');
      $this->addFormatedStringCell('%s (%s)', ['Varmebesparelse GAF', $this->trans('appbundle.tiltag.varmebesparelseGAF.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Varmebesparelse GUF', $this->trans('appbundle.tiltag.varmebesparelseGUF.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Elbesparelse', $this->trans('appbundle.tiltag.elbesparelse.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Solcelleproduktion, eget forbrug', $this->trans('appbundle.tiltag.solcelleproduktion.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Solcelleproduktion, salg til nettet år 1', $this->trans('appbundle.tiltag.salgTilNettetAar1.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['samlet energibesparelse', $this->trans('appbundle.tiltag.samletEnergibesparelse.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Besparelse på straffeafkøling', $this->trans('appbundle.tiltag.besparelseStrafafkoelingsafgift.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Besparelse D & V', $this->trans('appbundle.tiltag.besparelseDriftOgVedligeholdelse.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Scrapværdi', $this->trans('appbundle.tiltag.scrapvaerdi.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Reinvestering', $this->trans('appbundle.tiltag.reinvestering.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['CO2-besparelse', $this->trans('appbundle.tiltag.samletCo2besparelse.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Faktisk Entreprisesum', $this->trans('appbundle.tiltag.anlaegsInvestering.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Entreprisesum', $this->trans('appbundle.tiltag.anlaegsInvestering.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Genopretning', $this->trans('appbundle.tiltag.genopretning.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Genopretning for implementeringsomkostninger', $this->trans('appbundle.tiltag.genopretningForImplementeringsomkostninger.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Modernisering', $this->trans('appbundle.tiltag.modernisering.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Aa+ investering eksl. øvrige omk.', $this->trans('appbundle.tiltag.aaplusInvestering.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Simpel tilbagebetalingstid', $this->trans('appbundle.tiltag.simpelTilbagebetalingstidAar.unit')]);
      $this->addFormatedStringCell('%s (%s)', ['Nutidsværdi set over 15 år', $this->trans('appbundle.tiltag.nutidsvaerdiSetOver15AarKr.unit')]);
    }
    $this->addRow($this->headerStyle);
  }

  private function writeBygning(Bygning $bygning, Tiltag $tiltag = null, $tiltagIndex = 0) {
    $rapport = $bygning->getRapport();

    $this->addCell($bygning->getId());
    $this->addCell($bygning->getEnhedsys());
    $this->addCell($bygning->getNavn());
    $this->addCell($bygning->getAdresse());
    $this->addCell($bygning->getPostnummer());
    $this->addCell($bygning->getPostBy());
    $this->addCell($this->getReadable($bygning->getStatus(), 'BygningStatusType'));
    $this->addCell($rapport ? $rapport->getVersion() : null);
    $this->addCell($rapport ? $rapport->getUpdatedAt() : null);

    if ($this->showAll || $this->groups['bygningsinformation']) {
      $this->addCell($bygning->getType());
      $this->addCell($bygning->getOpfoerselsAar());
      $this->addCell($bygning->getAfdelingsnavn());
      $this->addCell($bygning->getEjerA());
      $this->addCell($bygning->getAnvendelse());
      $this->addCell($bygning->getDivisionnavn());
      $this->addCell($bygning->getOmraadenavn());
      $this->addCell($bygning->getEjerforhold());
      if ($bygning->getSegment()) {
        $this->addCell($bygning->getSegment()->getNavn());
        $this->addCell($bygning->getSegment()->getForkortelse());
        $this->addCell($bygning->getSegment()->getMagistrat());
      } else {
        $this->fillCell(3);
      }
    }

    if ($this->showAll || $this->groups['baselineinformation']) {
      if ($tiltagIndex === 0) {
        $this->addCell($bygning->getBruttoetageareal());
        $this->addCell($bygning->getForsyningsvaerkVarme());
        $this->addCell($bygning->getForsyningsvaerkVarme() ? $bygning->getForsyningsvaerkVarme()->getKgCo2MWh(2009) : null);
        $this->addCell($rapport ? $rapport->getBaselineCO2Varme() : null);
        $this->addCell(($bygning->getForsyningsvaerkVarme() && $rapport) ? $bygning->getForsyningsvaerkVarme()->getKgCo2MWh($rapport->getDatering()->format('Y')) : null);
        $this->addCell($bygning->getForsyningsvaerkEl());
        $this->addCell($bygning->getForsyningsvaerkEl() ? $bygning->getForsyningsvaerkEl()->getKgCo2MWh(2009) : null);
        $this->addCell($rapport ? $rapport->getBaselineCO2El() : null);
        $this->addCell(($bygning->getForsyningsvaerkEl() && $rapport) ? $bygning->getForsyningsvaerkEl()->getKgCo2MWh($rapport->getDatering()->format('Y')) : null);
        $this->addCell($rapport ? $rapport->getBaselineVarmeGAF() : null);
        $this->addCell($rapport ? $rapport->getBaselineVarmeGUF() : null);
        $this->addCell($rapport ? $rapport->getBaselineEl() : null);
        $this->addCell($rapport ? $rapport->getBaselineStrafAfkoeling() : null);
        $this->addCell($rapport ? $rapport->getEnergibudgetVarme() : null);
        $this->addCell($rapport ? $rapport->getEnergibudgetEl() : null);
      } else {
        $this->fillCell(15);
      }
    }

    if ($this->showAll || $this->groups['aa_screeningsinformation']) {
      if ($tiltagIndex === 0) {
        $this->addCell($bygning->getAaplusAnsvarlig());
        $this->addCell($bygning->getEnergiRaadgiver());
        $this->addCell($bygning->getProjektleder());
        $this->addCell($bygning->getProjekterende());
        $this->addCell($rapport ? $rapport->getDatering() : null);
        $this->addCell(($rapport && $rapport->getDatoForDrift()) ? $rapport->getDatoForDrift()->format('Y-m-d') : null);
        $this->addCell(($rapport ? $rapport->getElena() : false) ? 1 : 0);
        $this->addCell(($rapport ? $rapport->getAva() : false) ? 1 : 0);
      } else {
        $this->fillCell(8);
      }
    }

    if ($this->showAll || $this->groups['besparelsesinformation']) {
      if ($tiltagIndex === 0 && $rapport) {
        $this->addCell($rapport->getBesparelseVarmeGAF());
        $this->addCell($rapport->getBesparelseVarmeGUF());
        $this->addCell($rapport->getBesparelseEl());
        $this->addCell($rapport->getSolcelleproduktion());
        $this->addCell($rapport->getSalgTilNettetAar1());
        $this->addCell($rapport->getCo2BesparelseVarme());
        $this->addCell($rapport->getCo2BesparelseEl());
        $this->addCell($rapport->getCo2BesparelseVarme() + $rapport->getCo2BesparelseEl());
        $this->addCell($rapport->getAnlaegsinvestering());
        $this->addCell($rapport->getGenopretning());
        $this->addCell($rapport->getModernisering());
        $this->addCell($rapport->getinvesteringEksFaellesomkostninger());
        $this->addCell($rapport->getMtmFaellesomkostninger());
        $this->addCell($rapport->getEnergiscreening());
        $this->addCell($rapport->getImplementering());
        $this->addCell($rapport->getinvesteringInklFaellesomkostninger());
        $this->addCell($rapport->getInternRenteInklFaellesomkostninger());
        $this->addCell($rapport->getNutidsvaerdiSetOver15AarKr());
        $this->addCell($rapport->getBesparelseAarEt());
      } else {
        $this->fillCell(19);
      }
    }

    if ($this->showAll || $this->groups['oekonomi']) {
      if ($tiltagIndex === 0 and $rapport) {
        for ($y = 1; $y <= 30; $y++) {
          $this->addCell($rapport->getCashFlow()['besparelse_varme'][$y]);
        }
        for ($y = 1; $y <= 30; $y++) {
          $this->addCell($rapport->getCashFlow()['besparelse_el'][$y]);
        }
      } else {
        $this->fillCell(60);
      }
    }

    if ($tiltag) {
      $type = $this->getTiltagType($tiltag);
      $this->addCell($tiltagIndex + 1);
      $this->addCell($tiltag->getId());
      $this->addCell($this->trans($type));
      $this->addCell($type === 'Special' && $tiltag->getTiltagskategori() ? $tiltag->getTiltagskategori()->getNavn() : '');
      $this->addCell($tiltag->getTitle());
      $this->addCell($this->nullableBoolToString($tiltag->getTilvalgtAfRaadgiver()));
      $this->addCell($this->nullableBoolToString($tiltag->getTilvalgtAfAaPlus()));
      $this->addCell($tiltag->getTilvalgtbegrundelse());
      $this->addCell($this->nullableBoolToString($tiltag->getTilvalgtAfMagistrat()));
      $this->addCell($tiltag->getTilvalgtBegrundelseMagistrat());
      $this->addCell($tiltag->getMaengde());
      $this->addCell($tiltag->getEnhed());
      $this->addCell($tiltag->getLevetid());
      $this->addCell($tiltag->getDatoForDrift() ? $tiltag->getDatoForDrift()->format('Y-m-d') : null);
      $this->addCell($tiltag->getVarmebesparelseGAF());
      $this->addCell($tiltag->getVarmebesparelseGUF());
      $this->addCell($tiltag->getElbesparelse());
      if($this->accessor->isReadable($tiltag, 'solcelleproduktion')) {
        $this->addCell($this->accessor->getValue($tiltag, 'solcelleproduktion'));
      } else {
        $this->fillCell(1);
      }
      if($this->accessor->isReadable($tiltag, 'salg_til_nettet_aar1')) {
        $this->addCell($this->accessor->getValue($tiltag, 'salg_til_nettet_aar1'));
      } else {
        $this->fillCell(1);
      }
      $this->addCell($tiltag->getSamletEnergibesparelse());
      $this->addCell($tiltag->getBesparelseStrafafkoelingsafgift());
      $this->addCell($tiltag->getBeskrivelseDriftOgVedligeholdelse());
      $this->addCell($tiltag->getScrapvaerdi());
      $this->addCell($tiltag->getReinvestering());
      $this->addCell($tiltag->getSamletCo2besparelse());
      $this->addCell($tiltag->getReelAnlaegsinvestering());
      $this->addCell($tiltag->getAnlaegsinvestering());
      $this->addCell($tiltag->getGenopretning());
      $this->addCell($tiltag->getGenopretningForImplementeringsomkostninger());
      $this->addCell($tiltag->getModernisering());
      $this->addCell($tiltag->getAaplusInvestering());
      $this->addCell($tiltag->getSimpelTilbagebetalingstidAar());
      $this->addCell($tiltag->getNutidsvaerdiSetOver15AarKr());
    }
    $this->addRow();
  }

  private function getTiltagType(Tiltag $object) {
    if (preg_match('/\\\\(?<type>[^\\\\]+)Tiltag$/', get_class($object), $matches)) {
      return $matches['type'];
    }

    return null;
  }

  private function getReadable($value, $type) {
    return $this->container->has('twig.extension.readable_enum_value')
      ? $this->container->get('twig.extension.readable_enum_value')->getReadableEnumValue($value, $type)
      : $value;
  }

  private function addCell($value, $colspan = 1) {
    if (is_array($value)) {
      foreach ($value as $v) {
        $this->addCell($v);
      }
    } else {
      if ($value instanceof \DateTime) {
        $value = $value->format('Y-m-d');
      } elseif (is_object($value)) {
        $value = (string)$value;
      } elseif (gettype($value) == 'string' && is_numeric($value)) {
        if((int)$value == $value) {
          $value = (int)$value;
        } else {
          $value = floatval($value);
        }
      }


      $this->data[$this->col] = $value;
      for ($i = 1; $i < $colspan; $i++) {
        $this->data[$this->col + $i] = null;
      }
      $this->col += $colspan;
    }
  }

  private function addDateCell($value) {
    die($value);
  }

  private function addIntegerCell($value) {
    $this->addCell(intval($value));
  }

  private function addNumberCell($value) {
    $this->addCell(floatval($value));
  }

  private function addFormatedStringCell($format, array $args = [], $width = 1) {
    $this->addCell(vsprintf($format, $args), $width);
  }

  private function fillCell($colspan, $value = '') {
    $this->addCell(array_fill(0, $colspan, $value));
  }

  private function addRow($style = null) {
    $row = array_slice($this->data, 0, $this->col);
    if($style) {
      $this->writer->addRowWithStyle($row, $style);
    } else {
      $this->writer->addRow($row);
    }
    $this->row += 1;
    $this->col = 0;
  }

  private function trans($text) {
    return $this->translator->trans($text);
  }

  private function nullableBoolToString($value) {
      $s = '';
      $s = $value === false ? 0 : $s;
      $s = $value === true ? 1 : $s;

      return $s;
  }
}
