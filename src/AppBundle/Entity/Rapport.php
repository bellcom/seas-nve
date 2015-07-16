<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

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
   * @var integer
   *
   * @ORM\Column(name="BaselineEl", type="integer", nullable=true)
   */
  protected $BaselineEl;

  /**
   * @var integer
   *
   * @ORM\Column(name="BaselineVarmeGUF", type="integer", nullable=true)
   */
  protected $BaselineVarmeGUF;

  /**
   * @var integer
   *
   * @ORM\Column(name="BaselineVarmeGAF", type="integer", nullable=true)
   */
  protected $BaselineVarmeGAF;

  /**
   * @var integer
   *
   * @ORM\Column(name="BaselineVand", type="integer", nullable=true)
   */
  protected $BaselineVand;

  /**
   * @var integer
   *
   * @ORM\Column(name="BaselineStrafAfkoeling", type="integer", nullable=true)
   */
  protected $BaselineStrafAfkoeling;

  /**
   * @var float
   *
   * @ORM\Column(name="faktorPaaVarmebesparelse", type="decimal", scale=4, nullable=true)
   */
  protected $faktorPaaVarmebesparelse;

  /**
   * @var integer
   *
   * @ORM\Column(name="Energiscreening", type="integer", nullable=true)
   */
  protected $Energiscreening;

  /**
   * Constructor
   */
  public function __construct() {
    $this->tiltag = new \Doctrine\Common\Collections\ArrayCollection();
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
   * Set Energiscreening
   *
   * @param integer $energiscreening
   * @return Rapport
   */
  public function setEnergiscreening($energiscreening)
  {
    $this->Energiscreening = $energiscreening;

    return $this;
  }

  /**
   * Get Energiscreening
   *
   * @return integer
   */
  public function getEnergiscreening()
  {
    return $this->Energiscreening;
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

  public function getKalkulationsrente()
  {
    return $this->configuration->getKalkulationsrente();
  }

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

  public function getInflation()
  {
    return $this->configuration->getInflation();
  }

  public function getLobetid()
  {
    return $this->configuration->getLobetid();
  }

  public function getElfaktor()
  {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkEl();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getFaktor($this->configuration);
  }

  public function getVarmefaktor()
  {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getFaktor($this->configuration);
  }

  public function getVandfaktor()
  {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVand();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getFaktor($this->configuration);
  }

  public function getVandKrKWh($yearNumber = 1)
  {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVand();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKrKWh(date('Y') - 1 + $yearNumber);
  }

  public function getVarmeKrKWh($yearNumber = 1)
  {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKrKWh(date('Y') - 1 + $yearNumber);
  }

  public function getElKrKWh($yearNumber = 1)
  {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkEl();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKrKWh(date('Y') - 1 + $yearNumber);
  }

  public function getVarmeKgCo2MWh($yearNumber = 1) {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKgCo2MWh(date('Y') - 1 + $yearNumber);
  }

  public function getElKgCo2MWh($yearNumber = 1) {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkEl();
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKgCo2MWh(date('Y') - 1 + $yearNumber);
  }

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

}
