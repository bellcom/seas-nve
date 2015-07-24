<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Calculation\Calculation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Event\LifecycleEventArgs;
use JMS\Serializer\Annotation as JMS;

/**
 * Rapport
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RapportRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Rapport {
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ManyToOne(targetEntity="Bygning", inversedBy="rapporter", fetch="EAGER")
   * @JoinColumn(name="bygning_id", referencedColumnName="id")
   **/
  protected $bygning;

  /**
   * @OneToMany(targetEntity="Energiforsyning", mappedBy="rapport", cascade={"persist", "remove"})
   * @OrderBy({"id" = "ASC"})
   * @JMS\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Energiforsyning>")
   */
  protected $energiforsyninger;

  /**
   * @OneToMany(targetEntity="Tiltag", mappedBy="rapport", cascade={"persist", "remove"})
   * @OrderBy({"title" = "ASC"})
   * @JMS\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Tiltag>")
   */
  protected $tiltag;

  /**
   * @var string
   *
   * @ORM\Column(name="version", type="string", length=255)
   */
  protected $version;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="Datering", type="date")
   */
  protected $datering;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="BaselineEl", type="decimal", scale=4, nullable=true)
   */
  protected $BaselineEl;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="BaselineVarmeGUF", type="decimal", scale=4, nullable=true)
   */
  protected $BaselineVarmeGUF;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="BaselineVarmeGAF", type="decimal", scale=4, nullable=true)
   */
  protected $BaselineVarmeGAF;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="BaselineVand", type="decimal", scale=4, nullable=true)
   */
  protected $BaselineVand;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="BaselineStrafAfkoeling", type="decimal", scale=4, nullable=true)
   */
  protected $BaselineStrafAfkoeling;

  /**
   * @var float
   *
   * @ORM\Column(name="faktorPaaVarmebesparelse", type="decimal", scale=4, nullable=true)
   */
  protected $faktorPaaVarmebesparelse;

  /**
   * @var float
   *
   * @ORM\Column(name="energiscreening", type="decimal", scale=4, nullable=true)
   */
  protected $energiscreening;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="mtmFaellesomkostninger", type="float", nullable=true)
   */
  protected $mtmFaellesomkostninger;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="implementering", type="float", nullable=true)
   */
  protected $implementering;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="faellesomkostninger", type="float", nullable=true)
   */
  protected $faellesomkostninger;

  /**
   * @var integer
   *
   * @ORM\Column(name="laanLoebetid", type="integer", nullable=true)
   */
  protected $laanLoebetid;

  /**
   * @var float
   *
   * @ORM\Column(name="laanRente", type="decimal", scale=4, nullable=true)
   */
  protected $laanRente;

  /**
   * @var boolean
   *
   * @ORM\Column(name="elena", type="boolean", nullable=true)
   */
  protected $elena = false;

  /**
   * @var array
   */
  protected $cashFlow;

  /**
   * Constructor
   */
  public function __construct() {
    $this->tiltag = new \Doctrine\Common\Collections\ArrayCollection();
    $this->energiforsyninger = new \Doctrine\Common\Collections\ArrayCollection();
    $this->datering = new \DateTime();
  }

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    return $this->getBygning()->getAdresse() . ", " . $this->version;
  }

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set version
   *
   * @param string $version
   * @return Rapport
   */
  public function setVersion($version) {
    $this->version = $version;

    return $this;
  }

  /**
   * Get version
   *
   * @return string
   */
  public function getVersion() {
    return $this->version;
  }

  /**
   * Set datering
   *
   * @param \DateTime $datering
   * @return Rapport
   */
  public function setDatering($datering) {
    $this->datering = $datering;

    return $this;
  }

  /**
   * Get datering
   *
   * @return \DateTime
   */
  public function getDatering() {
    return $this->datering;
  }


  /**
   * Set bygning
   *
   * @param \AppBundle\Entity\Bygning $bygning
   * @return Rapport
   */
  public function setBygning(\AppBundle\Entity\Bygning $bygning = NULL) {
    $this->bygning = $bygning;

    return $this;
  }

  /**
   * Get bygning
   *
   * @return \AppBundle\Entity\Bygning
   */
  public function getBygning() {
    return $this->bygning;
  }

  /**
   * Add energiforsyning
   *
   * @param \AppBundle\Entity\Energiforsyning $energiforsyning
   * @return Rapport
   */
  public function addEnergiforsyning(\AppBundle\Entity\Energiforsyning $energiforsyning) {
    $this->energiforsyninger[] = $energiforsyning;

    $energiforsyning->setRapport($this);

    return $this;
  }

  /**
   * Remove energiforsyning
   *
   * @param \AppBundle\Entity\Energiforsyning $energiforsyning
   */
  public function removeEnergiforsyning(\AppBundle\Entity\Energiforsyning $energiforsyning) {
    $this->energiforsyninger->removeElement($energiforsyning);
  }

  /**
   * Set energiforsyninger
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function setEnergiforsyninger($energiforsyninger) {
    $this->energiforsyninger = $energiforsyninger;

    return $this;
  }

  /**
   * Get energiforsyninger
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getEnergiforsyninger() {
    return $this->energiforsyninger;
  }

  /**
   * Add tiltag
   *
   * @param \AppBundle\Entity\Tiltag $tiltag
   * @return Rapport
   */
  public function addTiltag(\AppBundle\Entity\Tiltag $tiltag) {
    $this->tiltag[] = $tiltag;

    $tiltag->setRapport($this);

    return $this;
  }

  /**
   * Remove tiltag
   *
   * @param \AppBundle\Entity\Tiltag $tiltag
   */
  public function removeTiltag(\AppBundle\Entity\Tiltag $tiltag) {
    $this->tiltag->removeElement($tiltag);
  }

  /**
   * Get tiltag
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getTiltag() {
    return $this->tiltag;
  }

  /**
   * Get all selected TiltagDetails.
   *
   * @return \Doctrine\Common\Collections\Collection
   *   The list of selected TiltagDetails.
   */
  public function getTilvalgteTiltag() {
    return $this->getTiltag()->filter(function($tiltag) {
      return $tiltag->getTilvalgt();
    });
  }

  /**
   * Set BaselineEl
   *
   * @param integer $baselineEl
   * @return Rapport
   */
  public function setBaselineEl($baselineEl)
  {
    $this->BaselineEl = $baselineEl;

    return $this;
  }

  /**
   * Get BaselineEl
   *
   * @return integer
   */
  public function getBaselineEl()
  {
    return $this->BaselineEl;
  }

  /**
   * Set BaselineVarmeGUF
   *
   * @param integer $baselineVarmeGUF
   * @return Rapport
   */
  public function setBaselineVarmeGUF($baselineVarmeGUF)
  {
    $this->BaselineVarmeGUF = $baselineVarmeGUF;

    return $this;
  }

  /**
   * Get BaselineVarmeGUF
   *
   * @return integer
   */
  public function getBaselineVarmeGUF()
  {
    return $this->BaselineVarmeGUF;
  }

  /**
   * Set BaselineVarmeGAF
   *
   * @param integer $baselineVarmeGAF
   * @return Rapport
   */
  public function setBaselineVarmeGAF($baselineVarmeGAF)
  {
    $this->BaselineVarmeGAF = $baselineVarmeGAF;

    return $this;
  }

  /**
   * Get BaselineVarmeGAF
   *
   * @return integer
   */
  public function getBaselineVarmeGAF()
  {
    return $this->BaselineVarmeGAF;
  }

  /**
   * Set BaselineVand
   *
   * @param integer $baselineVand
   * @return Rapport
   */
  public function setBaselineVand($baselineVand)
  {
    $this->BaselineVand = $baselineVand;

    return $this;
  }

  /**
   * Get BaselineVand
   *
   * @return integer
   */
  public function getBaselineVand()
  {
    return $this->BaselineVand;
  }

  /**
   * Set BaselineStrafAfkoeling
   *
   * @param integer $baselineStrafAfkoeling
   * @return Rapport
   */
  public function setBaselineStrafAfkoeling($baselineStrafAfkoeling)
  {
    $this->BaselineStrafAfkoeling = $baselineStrafAfkoeling;

    return $this;
  }

  /**
   * Get BaselineStrafAfkoeling
   *
   * @return integer
   */
  public function getBaselineStrafAfkoeling()
  {
    return $this->BaselineStrafAfkoeling;
  }

  /**
   * Set faktorPaaVarmebesparelse
   *
   * @param float $faktorPaaVarmebesparelse
   * @return Rapport
   */
  public function setFaktorPaaVarmebesparelse($faktorPaaVarmebesparelse)
  {
    $this->faktorPaaVarmebesparelse = $faktorPaaVarmebesparelse;

    return $this;
  }

  /**
   * Get faktorPaaVarmebesparelse
   *
   * @return float
   */
  public function getFaktorPaaVarmebesparelse()
  {
    return $this->faktorPaaVarmebesparelse;
  }

  /**
   * Set energiscreening
   *
   * @param integer $energiscreening
   * @return Rapport
   */
  public function setEnergiscreening($energiscreening)
  {
    $this->energiscreening = $energiscreening;

    return $this;
  }

  /**
   * Get Energiscreening
   *
   * @return integer
   */
  public function getEnergiscreening()
  {
    return $this->energiscreening;
  }

  /**
   * Set laanLoebetid
   *
   * @param integer $laanLoebetid
   * @return Rapport
   */
  public function setLaanLoebetid($laanLoebetid)
  {
    $this->laanLoebetid = $laanLoebetid;

    return $this;
  }

  /**
   * Get LaanLoebetid
   *
   * @return integer
   */
  public function getLaanLoebetid()
  {
    return $this->laanLoebetid;
  }

  /**
   * Set laanRente
   *
   * @param integer $laanRente
   * @return Rapport
   */
  public function setLaanRente($laanRente)
  {
    $this->laanRente = $laanRente;

    return $this;
  }

  /**
   * Get LaanRente
   *
   * @return integer
   */
  public function getLaanRente()
  {
    return $this->laanRente;
  }

  /**
   * Set elena
   *
   * @param string $elena
   * @return Bygning
   */
  public function setElena($elena) {
    $this->elena = $elena;

    return $this;
  }

  /**
   * Get elena
   *
   * @return boolean
   */
  public function getElena() {
    return $this->elena;
  }

  /**
   * Get Energiscreening
   *
   * @return integer
   */
  public function getTotalVarme()
  {
    return $this->getBaselineVarmeGAF() + $this->getBaselineVarmeGUF();
  }

  /**
   *
   * @return float
   */
  public function getKalkulationsrente()
  {
    return $this->configuration->getKalkulationsrente();
  }

  /**
   *
   * @return float
   */
  public function getInflationsfaktor()
  {
    $kalkulationsrente = $this->getKalkulationsrente();
    $inflation = $this->getInflation();

    $inflationsfaktor = 0;
    for ($year = 1; $year <= 15; $year++) {
      $inflationsfaktor += pow(1 + $inflation, $year) / pow(1 + $kalkulationsrente, $year);
    }

    return $inflationsfaktor;
  }

  /**
   *
   * @return float
   */
  public function getInflation()
  {
    return $this->configuration->getInflation();
  }

  /**
   *
   * @return float
   */
  public function getLobetid()
  {
    return $this->configuration->getLobetid();
  }

  /**
   *
   * @return float
   */
  public function getProcentAfInvestering()
  {
    return $this->configuration->getProcentAfInvestering();
  }

  /**
   *
   * @return float
   */
  public function getElfaktor()
  {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkEl();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getFaktor($this->configuration);
  }

  /**
   *
   * @return float
   */
  public function getVarmefaktor()
  {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getFaktor($this->configuration);
  }

  /**
   *
   * @return float
   */
  public function getVandfaktor()
  {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVand();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getFaktor($this->configuration);
  }

  /**
   *
   * @return float
   */
  public function getVandKrKWh($yearNumber = 1)
  {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVand();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKrKWh(date('Y') - 1 + $yearNumber);
  }

  /**
   *
   * @return float
   */
  public function getVarmeKrKWh($yearNumber = 1)
  {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKrKWh(date('Y') - 1 + $yearNumber);
  }

  /**
   *
   * @return float
   */
  public function getElKrKWh($yearNumber = 1)
  {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkEl();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKrKWh(date('Y') - 1 + $yearNumber);
  }

  /**
   *
   * @return float
   */
  public function getVarmeKgCo2MWh($yearNumber = 1) {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKgCo2MWh(date('Y') - 1 + $yearNumber);
  }

  /**
   *
   * @return float
   */
  public function getElKgCo2MWh($yearNumber = 1) {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkEl();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKgCo2MWh(date('Y') - 1 + $yearNumber);
  }

  /**
   *
   * @return boolean
   */
  public function getStandardforsyning() {
    if (!$this->energiforsyninger || $this->energiforsyninger->count() != 2) {
      return false;
    }

    $energiforsyningEl = $this->getEnergiforsyningByNavn('Hovedforsyning El');
    $energiforsyningVarme = $this->getEnergiforsyningByNavn('Fjernvarme');

    if (!$energiforsyningEl || !$energiforsyningVarme) {
      return false;
    }

    $internProduktionEl = $energiforsyningEl->getInternProduktioner() ? $energiforsyningEl->getInternProduktioner()->first() : NULL;
    $internProduktionVarme = $energiforsyningVarme->getInternProduktioner() ? $energiforsyningVarme->getInternProduktioner()->first() : NULL;

    if ($internProduktionEl && $internProduktionVarme) {
      return $internProduktionEl->getPrisgrundlag() == 'EL' && $internProduktionEl->getFordeling() == 1 && $internProduktionEl->getEffektivitet() == 1
                                                    && $internProduktionVarme->getPrisgrundlag() == 'VARME' && $internProduktionVarme->getFordeling() == 1 && $internProduktionVarme->getEffektivitet() == 1;
    }

    return false;
  }

  public function getEnergiforsyningByNavn($navn) {
    if (!$this->energiforsyninger) {
      return NULL;
    }
    return $this->energiforsyninger->filter(function($energiforsyning) use ($navn) {
        return $energiforsyning->getNavn() == $navn;
      })->first();
  }

  /**
   * @var Configuration
   */
  protected $configuration;

  public function setConfiguration(Configuration $configuration) {
    $this->configuration = $configuration;

    return $this;
  }

  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   *
   * @return float
   */
  public function getMtmFaellesomkostninger() {
    return $this->mtmFaellesomkostninger;
  }

  /**
   *
   * @return float
   */
  public function getImplementering() {
    return $this->implementering;
  }

  /**
   *
   * @return float
   */
  public function getFaellesomkostninger() {
    return $this->faellesomkostninger;
  }

  /**
   *
   * @return array
   */
  public function getCashFlow() {
    return $this->cashFlow;
  }

  /**
   * Post load handler.
   *
   * @ORM\PostLoad
   * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
   */
  public function postLoad(LifecycleEventArgs $event) {
    $repository = $event->getEntityManager()->getRepository('AppBundle:Configuration');
    $this->setConfiguration($repository->getConfiguration());
  }

  public function calculate() {
    $this->BaselineVarmeGUF = $this->calculateBaselineVarmeGUF();
    $this->BaselineVarmeGAF = $this->calculateBaselineVarmeGAF();

    $this->mtmFaellesomkostninger = $this->calculateMtmFaellesomkostninger();
    $this->implementering = $this->calculateImplementering();
    $this->faellesomkostninger = $this->calculateFaellesomkostninger();

    $this->cashFlow = $this->calculateCashFlow();
  }

  private function calculateBaselineVarmeGUF() {
    $value = 0;
    foreach ($this->tiltag as $tiltag) {
      $value += $tiltag->getVarmebesparelseGUF();
    }
    return $value;
  }

  private function calculateBaselineVarmeGAF() {
    $value = 0;
    foreach ($this->tiltag as $tiltag) {
      $value += $tiltag->getVarmebesparelseGAF();
    }
    return $value;
  }

  private function calculateMtmFaellesomkostninger() {
    return 10000 + 10 * $this->bygning->getBruttoetageareal();
  }

  private function calculateImplementering() {
    $sum = 0;
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      $sum += $tiltag->getAnlaegsinvestering();
    }

    return $sum * $this->getProcentAfInvestering();
  }

  private function calculateFaellesomkostninger() {
    return $this->energiscreening + $this->mtmFaellesomkostninger + $this->implementering;
  }

  private function calculateCashFlow() {
    $numberOfYears = 30;

    $flow = array(
      'ydelse laan' => array_fill(0, $numberOfYears + 1, 0),
      'laan til faellesomkostninger' => array_fill(0, $numberOfYears + 1, 0),
      'ydelse laan inkl. faellesomkostninger' => array_fill(0, $numberOfYears + 1, 0),
      'besparelse' => array_fill(0, $numberOfYears + 1, 0),
      'cash flow' => array_fill(0, $numberOfYears + 1, 0),
      'akkumuleret' => array_fill(0, $numberOfYears + 1, 0),
    );

    $tilvalgteTiltag = $this->getTilvalgteTiltag();
    $rente = $this->getLaanRente();
    $loebetid = $this->getLaanLoebetid();
    $samletAarligYdelseTilLaan = 0;
    $inflation = $this->getInflation();
    foreach ($tilvalgteTiltag as $index => $tiltag) {
      $samletAarligYdelseTilLaan += Calculation::pmt($rente, $loebetid, $tiltag->getAnlaegsinvestering());
    }

    for ($year = 1; $year <= $numberOfYears; $year++) {
      $flow['ydelse laan'][$year] = ($year <= $loebetid) ? -$samletAarligYdelseTilLaan : NULL;
      $flow['laan til faellesomkostninger'][$year] = ($year <= $loebetid) ? -Calculation::pmt($rente, $loebetid, $this->faellesomkostninger) : NULL;
      $flow['ydelse laan inkl. faellesomkostninger'][$year] = $flow['ydelse laan'][$year] + $flow['laan til faellesomkostninger'][$year];
      $besparelse = 0;
      foreach ($tilvalgteTiltag as $tiltag) {
        if (true || $tiltag instanceof \AppBundle\Entity\SolcelleTiltag) {
          $besparelse += // $tiltag->getIndtaegtSalgAfEnergibesparelse()
                       + ($tiltag->getVarmebesparelseGUF() + $tiltag->getVarmebesparelseGAF()) * $this->getVarmeKrKWh($year)
                       + $tiltag->getElbesparelse() * $this->getElKrKWh($year)
                       + $tiltag->getVandbesparelse() * $this->getVandKrKWh($year)
                       + ($tiltag->getBesparelseStrafafkoelingsafgift() + $tiltag->getBesparelseDriftOgVedligeholdelse()) * pow(1 + $inflation, $year);
        }
      }

      $flow['besparelse'][$year] = $besparelse;
      $flow['cash flow'][$year] = -$flow['ydelse laan'][$year] + $flow['besparelse'][$year];
      $flow['akkumuleret'][$year] = $flow['akkumuleret'][$year - 1] + $flow['cash flow'][$year];
    }

    // Remove year 0.
    foreach ($flow as &$row) {
      unset($row[0]);
    }

    return $flow;
  }

}
