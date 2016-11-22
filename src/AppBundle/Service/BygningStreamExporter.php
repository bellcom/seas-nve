<?php

namespace AppBundle\Service;

use AppBundle\Entity\Bygning;
use AppBundle\Entity\Tiltag;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class BygningStreamExporter {
  /**
   * @var ContainerInterface
   */
  protected $container;

  /**
   * @var TranslatorInterface
   */
  protected $translator;

  public function __construct(ContainerInterface $container, TranslatorInterface $translator) {
    $this->container = $container;
    $this->translator = $translator;
  }

  public function setConfig(array $config) {
    $this->type = isset($config['type']) ? $config['type'] : null;
    $this->groups = isset($config['columns']['groups']) ? $config['columns']['groups'] : [];
    $this->showAll = isset($this->groups['alt']) ? $this->groups['alt'] : false;
  }

  private $handle = null;

  public function start($handle) {
    $this->handle = $handle;
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

  public function end() {}

  private $showAll = false;
  private $type = null;
  private $groups = [];

  private function writeHeader() {
    $this->write('Standardinformation', 9);
    if ($this->showAll || $this->groups['bygningsinformation']) {
      $this->write('Bygningsinformation', 11);
    }
    if ($this->showAll || $this->groups['baselineinformation']) {
      $this->write('Baselineinformation', 15);
    }
    if ($this->showAll || $this->groups['aa_screeningsinformation']) {
      $this->write('Aa+/Screeningsinformation', 7);
    }
    if ($this->showAll || $this->groups['besparelsesinformation']) {
      $this->write('Besparelsesinformation (Energi og økonomi)', 17);
    }
    if ($this->showAll || $this->groups['oekonomi']) {
      $this->write('Økonomiinformation (Set over 30 år)', 60);
    }
    if ($this->type === 'tiltag') {
      $this->write('Tiltag', 29);
    }
    $this->endRow();

    $this->write('ID');
    $this->write('Enhedsys');
    $this->write('Navn');
    $this->write('Adresse');
    $this->write('Postnummer');
    $this->write('By');
    $this->write('Status');
    $this->write('Version');
    $this->write('Opdateret');

    if ($this->showAll || $this->groups['bygningsinformation']) {
      $this->write('Type');
      $this->write('Opførelsesår');
      $this->write('Afdelingsnavn');
      $this->write('Ejer/Lejer');
      $this->write('Anvendelse');
      $this->write('Divisionnavn');
      $this->write('Områdenavn');
      $this->write('Ejerforhold');
      $this->write('Segment Navn');
      $this->write('Magistrat Forkortelse');
      $this->write('Segment Magistrat');
    }

    if ($this->showAll || $this->groups['baselineinformation']) {
      $this->writef('%s (%s)', [$this->trans('Bruttoetageareal'), $this->trans('appbundle.bygning.bruttoetageareal.unit')]);
      $this->writef('Varmeværk');
      $this->writef('%s (%s)', ['CO2-faktor Varme 2009', 'Kg CO2/mWh']);
      $this->writef('%s (%s)', [$this->trans('CO2 Varme 2009'), $this->trans('appbundle.rapport.BaselineCO2Varme.unit')]);
      $this->writef('%s (%s)', ['CO2-faktor Varme screeningsdato', 'Kg CO2/mWh']);
      $this->writef('Elværk');
      $this->writef('%s (%s)', ['CO2-faktor El 2009', 'Kg CO2/mWh']);
      $this->writef('%s (%s)', ['CO2 El 2009', $this->trans('appbundle.rapport.BaselineCO2El.unit')]);
      $this->writef('%s (%s)', ['CO2-faktor El screeningsdato', 'Kg CO2/mWh']);
      $this->writef('%s (%s)', ['Varmeforbrug GAF (Baseline)', $this->trans('appbundle.rapport.BaselineVarmeGAF.unit')]);
      $this->writef('%s (%s)', ['Varmeforbrug GUF (Baseline)', $this->trans('appbundle.rapport.BaselineVarmeGUF.unit')]);
      $this->writef('%s (%s)', ['Elforbrug (Baseline)', $this->trans('appbundle.rapport.BaselineEl.unit')]);
      $this->writef('%s (%s)', ['Straffeafkøling', $this->trans('appbundle.rapport.BaselineStrafAfkoeling.unit')]);
      $this->writef('%s (%s)', ['Energibudget, varme', $this->trans('appbundle.rapport.energibudgetVarme.unit')]);
      $this->writef('%s (%s)', ['Energibudget, el', $this->trans('appbundle.rapport.energibudgetEl.unit')]);
    }

    if ($this->showAll || $this->groups['aa_screeningsinformation']) {
      $this->write('Aa+ Ansvarlig');
      $this->write('Rådgiver');
      $this->write('Projektleder');
      $this->write('Screeningsdato');
      $this->write('Dato f. drift (Bygn.)');
      $this->write('Elena');
      $this->write('AVA-støtte');
    }

    if ($this->showAll || $this->groups['besparelsesinformation']) {
      $this->writef('%s (%s)', ['Varmebesparelse GAF', $this->trans('appbundle.rapport.besparelseVarmeGAF.unit')]);
      $this->writef('%s (%s)', ['Varmebesparelse GUF', $this->trans('appbundle.rapport.besparelseVarmeGUF.unit')]);
      $this->writef('%s (%s)', ['Elbesparelse', $this->trans('appbundle.rapport.besparelseEl.unit')]);
      $this->writef('%s (%s)', ['CO2-besparelse Varme', $this->trans('appbundle.rapport.besparelseCO2varme.unit')]);
      $this->writef('%s (%s)', ['CO2-besparelse El', $this->trans('appbundle.rapport.besparelseCO2el.unit')]);
      $this->writef('%s (%s)', ['Samlet CO2-besparelse', $this->trans('appbundle.rapport.besparelseCO2.unit')]);
      $this->writef('%s (%s)', ['Total Entreprisesum', $this->trans('appbundle.rapport.anlaegsinvestering.unit')]);
      $this->writef('%s (%s)', ['Genopretning', $this->trans('appbundle.rapport.genopretning.unit')]);
      $this->writef('%s (%s)', ['Modernisering', $this->trans('appbundle.rapport.modernisering.unit')]);
      $this->writef('%s (%s)', ['Aa+ Investering eksl. øvrige omkostninger', $this->trans('appbundle.rapport.investeringEksFaellesomkostninger.unit')]);
      $this->writef('%s (%s)', ['MTM fællesomkostninger', $this->trans('appbundle.rapport.mtmFaellesomkostninger.unit')]);
      $this->writef('%s (%s)', ['Energiscreeningspris', $this->trans('appbundle.rapport.energiscreening.unit')]);
      $this->writef('%s (%s)', ['Implementeringsomkostninger', $this->trans('appbundle.rapport.implementering.unit')]);
      $this->writef('%s (%s)', ['Aa+ Investering inkl. øvrige omkostninger', $this->trans('appbundle.rapport.investeringInklFaellesomkostninger.unit')]);
      $this->writef('%s (%s)', ['Intern rente inkl. øvrige omkostninger', $this->trans('appbundle.rapport.internRenteInklFaellesomkostninger.unit')]);
      $this->writef('%s (%s)', ['Nutidsværdi inkl. øvrige omkostninger', $this->trans('appbundle.rapport.nutidsvaerdiInklFaellesomkostninger.unit')]);
      $this->writef('%s (%s)', ['Økonomisk besparelse i år 1', $this->trans('appbundle.rapport.besparelseAarEt.unit')]);
    }

    if ($this->showAll || $this->groups['oekonomi']) {
      for ($y = 1; $y <= 30; $y++) {
        $this->write('Varmebesparelse år ' . $y . ' (kWh/år)');
      }
      for ($y = 1; $y <= 30; $y++) {
        $this->write('Elbesparelse år ' . $y . ' (kWh/år)');
      }
    }

    if ($this->type === 'tiltag') {
      $this->write('Tiltagsnr.');
      $this->write('Type');
      $this->write('Kategori');
      $this->write('Title');
      $this->write('Tilvalgt (Aa+)');
      $this->write('Begrundelse (Aa+)');
      $this->write('Tilvalgt/fravalgt (Mag)');
      $this->write('Begrundelse (mag)');
      $this->write('Mængde');
      $this->write('Enheder');
      $this->write('Funktionsdygtig levetid');
      $this->write('Dato f. drift (Tiltag)');
      $this->writef('%s (%s)', ['Varmebesparelse GAF', $this->trans('appbundle.tiltag.varmebesparelseGAF.unit')]);
      $this->writef('%s (%s)', ['Varmebesparelse GUF', $this->trans('appbundle.tiltag.varmebesparelseGUF.unit')]);
      $this->writef('%s (%s)', ['Elbesparelse', $this->trans('appbundle.tiltag.elbesparelse.unit')]);
      $this->writef('%s (%s)', ['samlet energibesparelse', $this->trans('appbundle.tiltag.samletEnergibesparelse.unit')]);
      $this->writef('%s (%s)', ['Besparelse på straffeafkøling', $this->trans('appbundle.tiltag.besparelseStrafafkoelingsafgift.unit')]);
      $this->writef('%s (%s)', ['Besparelse D & V', $this->trans('appbundle.tiltag.besparelseDriftOgVedligeholdelse.unit')]);
      $this->writef('%s (%s)', ['Scrapværdi', $this->trans('appbundle.tiltag.scrapvaerdi.unit')]);
      $this->writef('%s (%s)', ['Reinvestering', $this->trans('appbundle.tiltag.reinvestering.unit')]);
      $this->writef('%s (%s)', ['CO2-besparelse', $this->trans('appbundle.tiltag.samletCo2besparelse.unit')]);
      $this->writef('%s (%s)', ['Faktisk Entreprisesum', $this->trans('appbundle.tiltag.anlaegsInvestering.unit')]);
      $this->writef('%s (%s)', ['Entreprisesum', $this->trans('appbundle.tiltag.anlaegsInvestering.unit')]);
      $this->writef('%s (%s)', ['Genopretning', $this->trans('appbundle.tiltag.genopretning.unit')]);
      $this->writef('%s (%s)', ['Genopretning for implementeringsomkostninger', $this->trans('appbundle.tiltag.genopretningForImplementeringsomkostninger.unit')]);
      $this->writef('%s (%s)', ['Modernisering', $this->trans('appbundle.tiltag.modernisering.unit')]);
      $this->writef('%s (%s)', ['Aa+ investering eksl. øvrige omk.', $this->trans('appbundle.tiltag.aaplusInvestering.unit')]);
      $this->writef('%s (%s)', ['Simpel tilbagebetalingstid', $this->trans('appbundle.tiltag.simpelTilbagebetalingstidAar.unit')]);
      $this->writef('%s (%s)', ['Nutidsværdi set over 15 år', $this->trans('appbundle.tiltag.nutidsvaerdiSetOver15AarKr.unit')]);
    }
    $this->endRow();
  }

  private function writeBygning(Bygning $bygning, Tiltag $tiltag = null, $tiltagIndex = 0) {
    $rapport = $bygning->getRapport();

    $this->write($bygning->getId());
    $this->write($bygning->getEnhedsys());
    $this->write($bygning->getNavn());
    $this->write($bygning->getAdresse());
    $this->write($bygning->getPostnummer());
    $this->write($bygning->getPostBy());
    $this->write($this->getReadable($bygning->getStatus(), 'BygningStatusType'));
    $this->write($rapport ? $rapport->getVersion() : null);
    $this->write($rapport ? $rapport->getUpdatedAt() : null);

    if ($this->showAll || $this->groups['bygningsinformation']) {
      $this->write($bygning->getType());
      $this->write($bygning->getOpfoerselsAar());
      $this->write($bygning->getAfdelingsnavn());
      $this->write($bygning->getEjerA());
      $this->write($bygning->getAnvendelse());
      $this->write($bygning->getDivisionnavn());
      $this->write($bygning->getOmraadenavn());
      $this->write($bygning->getEjerforhold());
      if ($bygning->getSegment()) {
        $this->write($bygning->getSegment()->getNavn());
        $this->write($bygning->getSegment()->getForkortelse());
        $this->write($bygning->getSegment()->getMagistrat());
      } else {
        $this->fill(3);
      }
    }

    if ($this->showAll || $this->groups['baselineinformation']) {
      if ($tiltagIndex === 0) {
        $this->write($bygning->getBruttoetageareal());
        $this->write($bygning->getForsyningsvaerkVarme());
        $this->write($bygning->getForsyningsvaerkVarme() ? $bygning->getForsyningsvaerkVarme()->getKgCo2MWh(2009) : null);
        $this->write($rapport ? $rapport->getBaselineCO2Varme() : null);
        $this->write(($bygning->getForsyningsvaerkVarme() && $rapport) ? $bygning->getForsyningsvaerkVarme()->getKgCo2MWh($rapport->getDatering()->format('Y')) : null);
        $this->write($bygning->getForsyningsvaerkEl());
        $this->write($bygning->getForsyningsvaerkEl() ? $bygning->getForsyningsvaerkEl()->getKgCo2MWh(2009) : null);
        $this->write($rapport ? $rapport->getBaselineCO2El() : null);
        $this->write(($bygning->getForsyningsvaerkEl() && $rapport) ? $bygning->getForsyningsvaerkEl()->getKgCo2MWh($rapport->getDatering()->format('Y')) : null);
        $this->write($rapport ? $rapport->getBaselineVarmeGAF() : null);
        $this->write($rapport ? $rapport->getBaselineVarmeGUF() : null);
        $this->write($rapport ? $rapport->getBaselineEl() : null);
        $this->write($rapport ? $rapport->getBaselineStrafAfkoeling() : null);
        $this->write($rapport ? $rapport->getEnergibudgetVarme() : null);
        $this->write($rapport ? $rapport->getEnergibudgetEl() : null);
      } else {
        $this->fill(15);
      }
    }

    if ($this->showAll || $this->groups['aa_screeningsinformation']) {
      if ($tiltagIndex === 0) {
        $this->write($bygning->getAaplusAnsvarlig());
        $this->write($bygning->getEnergiRaadgiver());
        $this->write(null /*$bygning->getProjektleder()*/);
        $this->write($rapport ? $rapport->getDatering() : null);
        $this->write(($rapport && $rapport->getDatoForDrift()) ? $rapport->getDatoForDrift()->format('Y-m-d') : null);
        $this->write(($rapport ? $rapport->getElena() : false) ? 1 : 0);
        $this->write(($rapport ? $rapport->getAva() : false) ? 1 : 0);
      } else {
        $this->fill(7);
      }
    }

    if ($this->showAll || $this->groups['besparelsesinformation']) {
      if ($tiltagIndex === 0 && $rapport) {
        $this->write($rapport->getBesparelseVarmeGAF());
        $this->write($rapport->getBesparelseVarmeGUF());
        $this->write($rapport->getBesparelseEl());
        $this->write($rapport->getCo2BesparelseVarme());
        $this->write($rapport->getCo2BesparelseEl());
        $this->write($rapport->getCo2BesparelseVarme() + $rapport->getCo2BesparelseEl());
        $this->write($rapport->getAnlaegsinvestering());
        $this->write($rapport->getGenopretning());
        $this->write($rapport->getModernisering());
        $this->write($rapport->getFravalgtInvesteringEksFaellesomkostninger());
        $this->write($rapport->getMtmFaellesomkostninger());
        $this->write($rapport->getEnergiscreening());
        $this->write($rapport->getImplementering());
        $this->write($rapport->getinvesteringInklFaellesomkostninger());
        $this->write($rapport->getInternRenteInklFaellesomkostninger());
        $this->write($rapport->getNutidsvaerdiSetOver15AarKr());
        $this->write($rapport->getBesparelseAarEt());
      } else {
        $this->fill(17);
      }
    }

    if ($this->showAll || $this->groups['oekonomi']) {
      if ($tiltagIndex === 0 and $rapport) {
        for ($y = 1; $y <= 30; $y++) {
          $this->write($rapport->getCashFlow()['besparelse_varme'][$y]);
        }
        for ($y = 1; $y <= 30; $y++) {
          $this->write($rapport->getCashFlow()['besparelse_el'][$y]);
        }
      } else {
        $this->fill(60);
      }
    }

    if ($tiltag) {
      $type = $this->getTiltagType($tiltag);
      $this->write($tiltagIndex + 1);
      $this->write($this->trans($type));
      $this->write($type === 'Special' && $tiltag->getTiltagskategori() ? $tiltag->getTiltagskategori()->getNavn() : '');
      $this->write($tiltag->getTitle());
      $this->write($tiltag->getTilvalgtAfAaPlus() ? 1 : 0);
      $this->write($tiltag->getTilvalgtbegrundelse());
      $this->write($tiltag->getTilvalgtBegrundelseMagistrat());
      $this->write($tiltag->getMaengde());
      $this->write($tiltag->getEnhed());
      $this->write($tiltag->getLevetid());
      $this->write($tiltag->getDatoForDrift() ? $tiltag->getDatoForDrift()->format('Y-m-d') : null);
      $this->write($tiltag->getVarmebesparelseGAF());
      $this->write($tiltag->getVarmebesparelseGUF());
      $this->write($tiltag->getElbesparelse());
      $this->write($tiltag->getSamletEnergibesparelse());
      $this->write($tiltag->getBesparelseStrafafkoelingsafgift());
      $this->write($tiltag->getBeskrivelseDriftOgVedligeholdelse());
      $this->write($tiltag->getScrapvaerdi());
      $this->write($tiltag->getReinvestering());
      $this->write($tiltag->getSamletCo2besparelse());
      $this->write($tiltag->getReelAnlaegsinvestering());
      $this->write($tiltag->getAnlaegsinvestering());
      $this->write($tiltag->getGenopretning());
      $this->write($tiltag->getGenopretningForImplementeringsomkostninger());
      $this->write($tiltag->getModernisering());
      $this->write($tiltag->getAaplusInvestering());
      $this->write($tiltag->getSimpelTilbagebetalingstidAar());
      $this->write($tiltag->getNutidsvaerdiSetOver15AarKr());
    }
    $this->endRow();
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

  private $data = [ '' ];
  private $row = 1;
  private $col = 0;

  private function write($value, $width = 1) {
    if (is_array($value)) {
      foreach ($value as $v) {
        $this->write($v);
      }
    } else {
      if ($value instanceof \DateTime) {
        $value = $value->format('Y-m-d');
      } elseif (is_object($value)) {
        $value = (string)$value;
      }
      $this->data[$this->col] = $value;
      for ($i = 1; $i < $width; $i++) {
        $this->data[$this->col + $i] = null;
      }
      $this->col += $width;
    }
  }

  private function writeDate($value) {
    die($value);
  }

  private function writeInteger($value) {
    $this->write(intval($value));
  }

  private function writeNumber($value) {
    $this->write(floatval($value));
  }

  private function writef($format, array $args = [], $width = 1) {
    $this->write(vsprintf($format, $args), $width);
  }

  private function fill($cols, $value = '') {
    $this->write(array_fill(0, $cols, $value));
  }

  private function freeze() {
    $this->sheet->freezePaneByColumnAndRow($this->col, $this->row);
  }

  private function endRow() {
    $fields = array_slice($this->data, 0, $this->col);
    fputcsv($this->handle, $fields);
    fflush($this->handle);
    $this->row += 1;
    $this->col = 0;
  }

  private function trans($text) {
    return $this->translator->trans($text);
  }
}
