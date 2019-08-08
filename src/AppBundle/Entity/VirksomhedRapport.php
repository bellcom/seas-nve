<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Calculation\Calculation;
use AppBundle\DBAL\Types\Energiforsyning\NavnType;
use AppBundle\DBAL\Types\Energiforsyning\InternProduktion\PrisgrundlagType;
use AppBundle\Entity\Energiforsyning\InternProduktion;
use AppBundle\Entity\Energiforsyning;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Event\LifecycleEventArgs;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use PHPExcel_Calculation_Financial as Excel;
use PHPExcel_Calculation_Functions as ExcelError;

/**
 * VirksomhedRapport
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\VirksomhedRapportRepository")
 * @ORM\HasLifecycleCallbacks
 */
class VirksomhedRapport {

  use BlameableEntity;
  use TimestampableEntity;

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @OneToOne(targetEntity="Virksomhed", inversedBy="rapport", fetch="EAGER")
   **/
  protected $virksomhed;

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
   * @var \DateTime
   *
   * @ORM\Column(name="datoForDrift", type="date", nullable=true)
   */
  protected $datoForDrift;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="besparelseAarEt", type="float", scale=4, nullable=true)
   */
  protected $besparelseAarEt;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="fravalgtbesparelseAarEt", type="float", scale=4, nullable=true)
   */
  protected $fravalgtBesparelseAarEt;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="besparelseVarmeGUF", type="float", scale=4, nullable=true)
   */
  protected $besparelseVarmeGUF;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="fravalgtBesparelseVarmeGUF", type="float", scale=4, nullable=true)
   */
  protected $fravalgtBesparelseVarmeGUF;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="besparelseVarmeGAF", type="float", nullable=true)
   */
  protected $besparelseVarmeGAF;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="fravalgtBesparelseVarmeGAF", type="float", nullable=true)
   */
  protected $fravalgtBesparelseVarmeGAF;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="besparelseCO2", type="float", nullable=true)
   */
  protected $besparelseCO2;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="fravalgtBesparelseCO2", type="float", nullable=true)
   */
  protected $fravalgtBesparelseCO2;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="besparelseEl", type="float", nullable=true)
   */
  protected $besparelseEl;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="fravalgtBesparelseEl", type="float", nullable=true)
   */
  protected $fravalgtBesparelseEl;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="co2BesparelseEl", type="float", nullable=true)
   */
  protected $co2BesparelseEl;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="co2BesparelseVarme", type="float", nullable=true)
   */
  protected $co2BesparelseVarme;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="BaselineCO2El", type="float", nullable=true)
   */
  protected $BaselineCO2El;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="BaselineCO2Varme", type="float", nullable=true)
   */
  protected $BaselineCO2Varme;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="BaselineCO2Samlet", type="float", nullable=true)
   */
  protected $BaselineCO2Samlet;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="fravalgtBaselineCO2Samlet", type="float", nullable=true)
   */
  protected $fravalgtBaselineCO2Samlet;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="co2BesparelseElFaktor", type="float", nullable=true)
   */
  protected $co2BesparelseElFaktor;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="co2BesparelseVarmeFaktor", type="float", nullable=true)
   */
  protected $co2BesparelseVarmeFaktor;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="co2BesparelseSamletFaktor", type="float", nullable=true)
   */
  protected $co2BesparelseSamletFaktor;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="fravalgtCo2BesparelseSamletFaktor", type="float", nullable=true)
   */
  protected $fravalgtCo2BesparelseSamletFaktor;

  /**
   * @var float
   *
   * @ORM\Column(name="BaselineEl", type="decimal", precision=16, scale=4, nullable=true)
   */
  protected $BaselineEl;

  /**
   * @var float
   *
   * @ORM\Column(name="BaselineVarmeGUF", type="decimal", precision=16, scale=4, nullable=true)
   */
  protected $BaselineVarmeGUF;

  /**
   * @var float
   *
   * @ORM\Column(name="BaselineVarmeGAF", type="decimal", precision=16, scale=4, nullable=true)
   */
  protected $BaselineVarmeGAF;

  /**
   * @var float
   *
   * @ORM\Column(name="BaselineVand", type="decimal", precision=16, scale=4, nullable=true)
   */
  protected $BaselineVand;

  /**
   * @var float
   *
   * @ORM\Column(name="BaselineStrafAfkoeling", type="decimal", precision=16, scale=4, nullable=true)
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
   * @ORM\Column(name="energiscreening", type="decimal", precision=16, scale=4, nullable=true)
   */
  protected $energiscreening;

  /**
   * Tilvalgt TotalInvestering = sum af alle tiltags anlægsinvesteringer
   *
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="anlaegsinvestering", type="float", nullable=true)
   */
  protected $anlaegsinvestering;

  /**
   * Fravlgt TotalInvestering = sum af alle tiltags anlægsinvesteringer
   *
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="fravalgtAnlaegsinvestering", type="float", nullable=true)
   */
  protected $fravalgtAnlaegsinvestering;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="nutidsvaerdiSetOver15AarKr", type="float", nullable=true)
   */
  protected $nutidsvaerdiSetOver15AarKr;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="fravalgtNutidsvaerdiSetOver15AarKr", type="float", nullable=true)
   */
  protected $fravalgtNutidsvaerdiSetOver15AarKr;

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
   * @ORM\Column(name="fravalgtimplementering", type="float", nullable=true)
   */
  protected $fravalgtImplementering;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="faellesomkostninger", type="float", nullable=true)
   */
  protected $faellesomkostninger;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="internRenteInklFaellesomkostninger", type="float", nullable=true)
   */
  protected $internRenteInklFaellesomkostninger;

  /**
   * @var integer
   *
   * @ORM\Column(name="laanLoebetid", type="integer", nullable=true)
   */
  protected $laanLoebetid = 15;

  /**
   * @var boolean
   *
   * @ORM\Column(name="elena", type="boolean", nullable=true)
   */
  protected $elena = FALSE;

  /**
   * @var boolean
   *
   * @ORM\Column(name="ava", type="boolean", nullable=true)
   */
  protected $ava = FALSE;

  /**
   * @var array of float
   *
   * @Calculated
   * @ORM\Column(name="cashFlow15", type="array")
   */
  protected $cashFlow15;

  /**
   * @var array of float
   *
   * @Calculated
   * @ORM\Column(name="cashFlow30", type="array")
   */
  protected $cashFlow30;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="energibudgetVarme", type="float", nullable=true)
   */
  protected $energibudgetVarme;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="energibudgetEl", type="float", nullable=true)
   */
  protected $energibudgetEl;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="fravalgtBesparelseDriftOgVedligeholdelse", type="float", nullable=true)
   */
  protected $fravalgtBesparelseDriftOgVedligeholdelse;

  /**
   * @return float
   */
  public function getFravalgtBesparelseDriftOgVedligeholdelse()
  {
    return $this->fravalgtBesparelseDriftOgVedligeholdelse;
  }

  /**
   * @param float $fravalgtBesparelseDriftOgVedligeholdelse
   */
  public function setFravalgtBesparelseDriftOgVedligeholdelse($fravalgtBesparelseDriftOgVedligeholdelse)
  {
    $this->fravalgtBesparelseDriftOgVedligeholdelse = $fravalgtBesparelseDriftOgVedligeholdelse;
  }

  /**
   * @return float
   */
  public function getBaselineCO2El() {
    return $this->BaselineCO2El;
  }

  /**
   * @param float $BaselineCO2El
   */
  public function setBaselineCO2El($BaselineCO2El) {
    $this->BaselineCO2El = $BaselineCO2El;
  }

  /**
   * @return float
   */
  public function getBaselineCO2Varme() {
    return $this->BaselineCO2Varme;
  }

  /**
   * @param float $BaselineCO2Varme
   */
  public function setBaselineCO2Varme($BaselineCO2Varme) {
    $this->BaselineCO2Varme = $BaselineCO2Varme;
  }

  /**
   * @return float
   */
  public function getBaselineCO2Samlet() {
    return $this->BaselineCO2Samlet;
  }

  /**
   * @param float $BaselineCO2Samlet
   */
  public function setBaselineCO2Samlet($BaselineCO2Samlet) {
    $this->BaselineCO2Samlet = $BaselineCO2Samlet;
  }

  /**
   * @return float
   */
  public function getCo2BesparelseElFaktor() {
    return $this->co2BesparelseElFaktor;
  }

  /**
   * @param float $co2BesparelseElFaktor
   */
  public function setCo2BesparelseElFaktor($co2BesparelseElFaktor) {
    $this->co2BesparelseElFaktor = $co2BesparelseElFaktor;
  }

  /**
   * @return float
   */
  public function getCo2BesparelseVarmeFaktor() {
    return $this->co2BesparelseVarmeFaktor;
  }

  /**
   * @param float $co2BesparelseVarmeFaktor
   */
  public function setCo2BesparelseVarmeFaktor($co2BesparelseVarmeFaktor) {
    $this->co2BesparelseVarmeFaktor = $co2BesparelseVarmeFaktor;
  }

  /**
   * @return float
   */
  public function getCo2BesparelseSamletFaktor() {
    return $this->co2BesparelseSamletFaktor;
  }

  /**
   * @param float $co2BesparelseSamletFaktor
   */
  public function setCo2BesparelseSamletFaktor($co2BesparelseSamletFaktor) {
    $this->co2BesparelseSamletFaktor = $co2BesparelseSamletFaktor;
  }

  /**
   * @return float
   */
  public function getFravalgtCo2BesparelseSamletFaktor() {
    return $this->fravalgtCo2BesparelseSamletFaktor;
  }

  /**
   * @param float $fravalgtCo2BesparelseSamletFaktor
   */
  public function setFravalgtCo2BesparelseSamletFaktor($fravalgtCo2BesparelseSamletFaktor) {
    $this->fravalgtCo2BesparelseSamletFaktor = $fravalgtCo2BesparelseSamletFaktor;
  }

  /**
   * Get cashFlow15
   *
   * @return array of float
   */
  public function getCashFlow15() {
    return $this->cashFlow15;
  }

  /**
   * Get cashFlow30
   *
   * @return array of float
   */
  public function getCashFlow30() {
    return $this->cashFlow30;
  }

  /**
   * Get energibudgetVarme
   *
   * @return float
   */
  public function getEnergibudgetVarme() {
    return $this->energibudgetVarme;
  }

  /**
   * Get energibudgetEl
   *
   * @return float
   */
  public function getEnergibudgetEl() {
    return $this->energibudgetEl;
  }

  /**
   * @var Forsyningsvaerk
   */
  protected $traepillefyr;

  public function setTraepillefyr(Forsyningsvaerk $traepillefyr = NULL) {
    $this->traepillefyr = $traepillefyr;

    return $this;
  }

  public function getTraepillefyr() {
    return $this->traepillefyr;
  }

  /**
   * @var Forsyningsvaerk
   */
  protected $olie;

  public function setOlie(Forsyningsvaerk $olie = NULL) {
    $this->olie = $olie;

    return $this;
  }

  public function getOlie() {
    return $this->olie;
  }

  /**
   * @var array
   *
   * @Calculated
   * @ORM\Column(name="cashFlow", type="array")
   */
  protected $cashFlow;

  /**
   * Constructor
   */
  public function __construct() {
    $this->datering = new \DateTime();
    $this->version = 1;
  }

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
      /** @var Virksomhed $virksomhed */
      $virksomhed = $this->getVirksomhed();
    if ($virksomhed->getAddress()) {
      return $virksomhed->getAddress();
    }
    if ($virksomhed->getName()) {
      return $virksomhed->getName();
    }
    return strval($virksomhed->getId());
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
   * @return VirksomhedRapport
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
   * Get the "full" version with nummeric building status appended
   *
   * @return string
   */
  public function getFullVersion() {
    return 'Virksomhed '.$this->getVirksomhed() . ' / Itteration: '.$this->version;
  }

  /**
   * Set datering
   *
   * @param \DateTime $datering
   * @return VirksomhedRapport
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
   * Set datoForDrift
   *
   * @param \DateTime $datoForDrift
   * @return VirksomhedRapport
   */
  public function setDatoForDrift($datoForDrift) {
    $this->datoForDrift = $datoForDrift;

    return $this;
  }

  /**
   * Get datoForDrift
   *
   * @return \DateTime
   */
  public function getDatoForDrift() {
    return $this->datoForDrift;
  }

  /**
   * Set virksomhed
   *
   * @param Virksomhed $virksomhed
   * @return VirksomhedRapport
   */
  public function setVirksomhed(Virksomhed $virksomhed = NULL) {
    $this->virksomhed = $virksomhed;

    return $this;
  }

  /**
   * Get virksomhed
   *
   * @return Virksomhed
   */
  public function getVirksomhed() {
    return $this->virksomhed;
  }

  /**
   * Get total besparelseVarme
   *
   * @return float
   */
  public function getBesparelseAarEt() {
    return $this->besparelseAarEt;
  }

  /**
   * Get total besparelseVarme for fravalgte tiltag
   *
   * @return float
   */
  public function getFravalgtBesparelseAarEt() {
    return $this->fravalgtBesparelseAarEt;
  }

  /**
   * Get total besparelseVarme
   *
   * @return float
   */
  public function getBesparelseVarme() {
    return $this->besparelseVarmeGUF + $this->besparelseVarmeGAF;
  }

  /**
   * Get total besparelseVarme for fravalgte tiltag
   *
   * @return float
   */
  public function getFravalgtBesparelseVarme() {
    return $this->fravalgtBesparelseVarmeGUF + $this->fravalgtBesparelseVarmeGAF;
  }

  /**
   * Get besparelseVarmeGUF
   *
   * @return float
   */
  public function getBesparelseVarmeGUF() {
    return $this->besparelseVarmeGUF;
  }

  /**
   * Get besparelseVarmeGUF for fravalgte tiltag
   *
   * @return float
   */
  public function getFravalgtBesparelseVarmeGUF() {
    return $this->fravalgtBesparelseVarmeGUF;
  }

  /**
   * Get besparelseVarmeGAF
   *
   * @return float
   */
  public function getBesparelseVarmeGAF() {
    return $this->besparelseVarmeGAF;
  }

  /**
   * Get besparelseVarmeGAF for fravalgte tiltag
   *
   * @return float
   */
  public function getFravalgtBesparelseVarmeGAF() {
    return $this->fravalgtBesparelseVarmeGAF;
  }

  /**
   * Get besparelseCO2
   *
   * @return float
   */
  public function getBesparelseCO2() {
    return $this->besparelseCO2;
  }

  /**
   * Get besparelseCO2 for fravalgte tiltag
   *
   * @return float
   */
  public function getFravalgtBesparelseCO2() {
    return $this->fravalgtBesparelseCO2;
  }

  /**
   * Get anlaegsinvestering
   *
   * @return float
   */
  public function getAnlaegsinvestering() {
    return $this->anlaegsinvestering;
  }

  /**
   * Get anlaegsinvestering
   *
   * @return string
   */
  public function getFravalgtAnlaegsinvestering() {
    return $this->fravalgtAnlaegsinvestering;
  }

  /**
   * Get Sum af økonomi for tilvalgte tiltag
   */
  public function getTilvalgtSum() {
    return $this->getInvesteringEkslGenopretningOgModernisering() + $this->energiscreening + $this->mtmFaellesomkostninger + $this->implementering;
  }

  /**
   * Get Sum af økonomi for fravalgte tiltag
   */
  public function getFravalgtSum() {
    return $this->getFravalgtInvesteringEkslGenopretningOgModernisering() + $this->getFravalgtImplementering();
  }

  /**
   * Get besparelseEl
   *
   * @return float
   */
  public function getBesparelseEl() {
    return $this->besparelseEl;
  }

  /**
   * Get co2besparelseEl
   *
   * @return float
   */
  public function getCo2BesparelseEl() {
    return $this->co2BesparelseEl;
  }

  /**
   * Get co2besparelseVarme
   *
   * @return float
   */
  public function getCo2BesparelseVarme() {
    return $this->co2BesparelseVarme;
  }

  /**
   * Get besparelseEl for fravalgte tiltag
   *
   * @return float
   */
  public function getFravalgtBesparelseEl() {
    return $this->fravalgtBesparelseEl;
  }

  /**
   * Set BaselineEl
   *
   * @param integer $baselineEl
   * @return VirksomhedRapport
   */
  public function setBaselineEl($baselineEl) {
    $this->BaselineEl = $baselineEl;

    return $this;
  }

  /**
   * Get BaselineEl
   *
   * @return integer
   */
  public function getBaselineEl() {
    return $this->BaselineEl;
  }

  /**
   * Set BaselineVarmeGUF
   *
   * @param integer $baselineVarmeGUF
   * @return VirksomhedRapport
   */
  public function setBaselineVarmeGUF($baselineVarmeGUF) {
    $this->BaselineVarmeGUF = $baselineVarmeGUF;

    return $this;
  }

  /**
   * Get BaselineVarmeGUF
   *
   * @return integer
   */
  public function getBaselineVarmeGUF() {
    return $this->BaselineVarmeGUF;
  }

  /**
   * Set BaselineVarmeGAF
   *
   * @param integer $baselineVarmeGAF
   * @return VirksomhedRapport
   */
  public function setBaselineVarmeGAF($baselineVarmeGAF) {
    $this->BaselineVarmeGAF = $baselineVarmeGAF;

    return $this;
  }

  /**
   * Get BaselineVarmeGAF
   *
   * @return integer
   */
  public function getBaselineVarmeGAF() {
    return $this->BaselineVarmeGAF;
  }

  /**
   * Get BaselineVarme
   *
   * @return integer
   */
  public function getBaselineVarme() {
    return $this->BaselineVarmeGAF + $this->BaselineVarmeGUF;
  }

  /**
   * Set BaselineVand
   *
   * @param integer $baselineVand
   * @return VirksomhedRapport
   */
  public function setBaselineVand($baselineVand) {
    $this->BaselineVand = $baselineVand;

    return $this;
  }

  /**
   * Get BaselineVand
   *
   * @return integer
   */
  public function getBaselineVand() {
    return $this->BaselineVand;
  }

  /**
   * Set BaselineStrafAfkoeling
   *
   * @param integer $baselineStrafAfkoeling
   * @return VirksomhedRapport
   */
  public function setBaselineStrafAfkoeling($baselineStrafAfkoeling) {
    $this->BaselineStrafAfkoeling = $baselineStrafAfkoeling;

    return $this;
  }

  /**
   * Get BaselineStrafAfkoeling
   *
   * @return integer
   */
  public function getBaselineStrafAfkoeling() {
    return $this->BaselineStrafAfkoeling;
  }

  /**
   * Set faktorPaaVarmebesparelse
   *
   * @param float $faktorPaaVarmebesparelse
   * @return VirksomhedRapport
   */
  public function setFaktorPaaVarmebesparelse($faktorPaaVarmebesparelse) {
    $this->faktorPaaVarmebesparelse = $faktorPaaVarmebesparelse;

    return $this;
  }

  /**
   * Get faktorPaaVarmebesparelse
   *
   * @return float
   */
  public function getFaktorPaaVarmebesparelse() {
    return $this->faktorPaaVarmebesparelse;
  }

  /**
   * Set energiscreening
   *
   * @param integer $energiscreening
   * @return VirksomhedRapport
   */
  public function setEnergiscreening($energiscreening) {
    $this->energiscreening = $energiscreening;

    return $this;
  }

  /**
   * Get Energiscreening
   *
   * @return integer
   */
  public function getEnergiscreening() {
    return $this->energiscreening;
  }

  /**
   * Set laanLoebetid
   *
   * @param integer $laanLoebetid
   * @return VirksomhedRapport
   */
  public function setLaanLoebetid($laanLoebetid) {
    $this->laanLoebetid = $laanLoebetid;

    return $this;
  }

  /**
   * Get LaanLoebetid
   *
   * @return integer
   */
  public function getLaanLoebetid() {
    return $this->laanLoebetid;
  }

  /**
   * Get nutidsvaerdiSetOver15AarKr.
   *
   * @return float
   */
  public function getNutidsvaerdiSetOver15AarKr() {
    return $this->nutidsvaerdiSetOver15AarKr;
  }

  /**
   * Get nutidsvaerdiSetOver15AarKr for fravlgte tiltag
   *
   * @return float
   */
  public function getFravalgtNutidsvaerdiSetOver15AarKr() {
    return $this->fravalgtNutidsvaerdiSetOver15AarKr;
  }

  /**
   * Set elena
   *
   * @param string $elena
   * @return VirksomhedRapport
   */
  public function setElena($elena) {
    $this->elena = $elena;

    return $this;
  }

  /**
   * @var float
   *
   * @ORM\Column(name="Genopretning", type="decimal", nullable=true)
   */
  protected $genopretning;

  /**
   * @var float
   *
   * @ORM\Column(name="genopretningForImplementeringsomkostninger", type="decimal", nullable=true)
   */
  protected $genopretningForImplementeringsomkostninger;

  /**
   * @var float
   *
   * @ORM\Column(name="Modernisering", type="decimal", nullable=true)
   */
  protected $modernisering;

  /**
   * @var float
   *
   * @ORM\Column(name="FravalgtGenopretning", type="decimal", nullable=true)
   */
  protected $fravalgtGenopretning;

  /**
   * @var float
   *
   * @ORM\Column(name="FravalgtModernisering", type="decimal", nullable=true)
   */
  protected $fravalgtModernisering;

  /**
   * Get genopretning
   *
   * @return float
   */
  public function getGenopretning() {
    return $this->genopretning;
  }

  public function getGenopretningForImplementeringsomkostninger() {
    return $this->genopretningForImplementeringsomkostninger;
  }

  /**
   * Get modernisering
   *
   * @return float
   */
  public function getModernisering() {
    return $this->modernisering;
  }

  /**
   * Get genopretning for fravalgte tiltag
   *
   * @return float
   */
  public function getFravalgtGenopretning() {
    return $this->fravalgtGenopretning;
  }

  /**
   * Get moderniseringfor fravalgte tiltag
   *
   * @return float
   */
  public function getFravalgtModernisering() {
    return $this->fravalgtModernisering;
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
  public function getTotalVarme() {
    return $this->getBaselineVarmeGAF() + $this->getBaselineVarmeGUF();
  }

  /**
   *
   * @return float
   */
  public function getKalkulationsrente() {
    return $this->configuration->getRapportKalkulationsrente();
  }

  /**
   *
   * @return float
   */
  public function getDriftomkostningerfaktor() {
    return $this->configuration->getRapportDriftomkostningerfaktor();
  }

  /**
   * Get interne driftomkostninger
   * (Forventet timeforbrug for lokalpersonalet)
   *
   * @return float
   */
  public function getInterneDriftomkostninger() {
    return $this->getDriftomkostningerfaktor() + (25 * $this->getVirksomhed()->getBygningsAreal());
  }

  /**
   *
   * @return float
   */
  public function getInflationsfaktor() {
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
  public function getInflation() {
    return $this->configuration->getRapportInflation();
  }

  /**
   *
   * @return float
   */
  public function getLobetid() {
    return $this->configuration->getRapportLobetid();
  }

  /**
   *
   * @return float
   */
  public function getProcentAfInvestering() {
    return $this->configuration->getRapportProcentAfInvestering();
  }

  /**
   *
   * @return float
   */
  public function getElfaktor() {
      // @TODO Implement function.
//    $forsyningsvaerk = $this->bygning->getForsyningsvaerkEl();
//    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getFaktor($this->configuration, $this->getDatering()->format('Y'));
      return 0;
  }

  /**
   *
   * @return float
   */
  public function getVarmefaktor() {
      // @TODO Implement function.
      return 0;
//    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme();
//    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getFaktor($this->configuration, $this->getDatering()->format('Y'));
  }

  /**
   *
   * @return float
   */
  public function getVandfaktor() {
      // @TODO Implement function.
      return 0;
//    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVand();
//    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getFaktor($this->configuration, $this->getDatering()->format('Y'));
  }

  /**
   *
   * @return float
   */
  public function getVandKrKWh($yearNumber = 1) {
      // @TODO Implement function.
      return 0;
//    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVand();
//    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKrKWh($this->getDatering()->format('Y') - 1 + $yearNumber);
  }

  /**
   *
   * @return float
   */
  public function getVarmeKrKWh($yearNumber = 1) {
      // @TODO Implement function.
      return 0;
//    $value = 0;
//    $prisfaktor = 1;
//
//    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme();
//    if ($forsyningsvaerk) {
//      $value = $forsyningsvaerk->getKrKWh($this->getDatering()->format('Y') - 1 + $yearNumber);
//    }
//    // Get prisfaktor from energiforsyning associated with bygnings forsyningsvaerk.
//    foreach ($this->getEnergiforsyninger() as $energiforsyning) {
//      if ($energiforsyning->getForsyningsvaerk() == $this->bygning->getForsyningsvaerkVarme()) {
//        $prisfaktor = $energiforsyning->getPrisfaktor();
//        break;
//      }
//    }
//
//    return $value * $prisfaktor;
  }

  /**
   *
   * @return float
   */
  public function getElKrKWh($yearNumber = 1) {
      // @TODO Implement function.
      return 0;
//    $value = 0;
//    $prisfaktor = 1;
//
//    $forsyningsvaerk = $this->bygning->getForsyningsvaerkEl();
//    if ($forsyningsvaerk) {
//      $value = $forsyningsvaerk->getKrKWh($this->getDatering()->format('Y') - 1 + $yearNumber);
//    }
//    // Get prisfaktor from energiforsyning associated with bygnings forsyningsvaerk.
//    foreach ($this->getEnergiforsyninger() as $energiforsyning) {
//      if ($energiforsyning->getForsyningsvaerk() == $this->bygning->getForsyningsvaerkEl()) {
//        $prisfaktor = $energiforsyning->getPrisfaktor();
//        break;
//      }
//    }
//
//    return $value * $prisfaktor;
  }

  /**
   *
   * @return float
   */
  public function getVarmeKgCo2MWh($yearNumber = 1) {
      // @TODO Implement function.
      return 0;
//    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme();
//    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKgCo2MWh($this->getDatering()->format('Y') - 1 + $yearNumber);
  }

  /**
   *
   * @return float
   */
  public function getElKgCo2MWh($yearNumber = 1) {
      // @TODO Implement function.
      return 0;
//    $forsyningsvaerk = $this->bygning->getForsyningsvaerkEl();
//    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKgCo2MWh($this->getDatering()->format('Y') - 1 + $yearNumber);
  }

  /**
   * @return boolean
   */
  public function getAva() {
    return $this->ava;
  }

  /**
   * @param boolean $ava
   */
  public function setAva($ava) {
    $this->ava = $ava;
  }

  /**
   *
   * @return boolean
   */
  public function getStandardforsyning() {
      // @TODO Implement function.
      return FALSE;
//    if (!$this->energiforsyninger || $this->energiforsyninger->count() != 2) {
//      return FALSE;
//    }
//
//    $energiforsyningEl = $this->getEnergiforsyningByNavn(NavnType::HOVEDFORSYNING_EL);
//    $energiforsyningVarme = $this->getEnergiforsyningByNavn(NavnType::FJERNVARME);
//
//    if (!$energiforsyningEl || !$energiforsyningVarme) {
//      return FALSE;
//    }
//
//    $internProduktionEl = $energiforsyningEl->getInternProduktioner() ? $energiforsyningEl->getInternProduktioner()
//      ->first() : NULL;
//    $internProduktionVarme = $energiforsyningVarme->getInternProduktioner() ? $energiforsyningVarme->getInternProduktioner()
//      ->first() : NULL;
//
//    if ($internProduktionEl && $internProduktionVarme) {
//      return $internProduktionEl->getPrisgrundlag() == PrisgrundlagType::EL && $internProduktionEl->getFordeling() == 1 && $internProduktionEl->getEffektivitet() == 1
//      && $internProduktionVarme->getPrisgrundlag() == PrisgrundlagType::VARME && $internProduktionVarme->getFordeling() == 1 && $internProduktionVarme->getEffektivitet() == 1;
//    }
//
//    return FALSE;
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
  public function getFravalgtImplementering() {
    return $this->fravalgtImplementering;
  }

  /**
   *
   * @return float
   */
  public function getInternRenteInklFaellesomkostninger() {
    return $this->internRenteInklFaellesomkostninger;
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
   * Get investering eksl. genopretning og modernisering
   */
  public function getInvesteringEkslGenopretningOgModernisering() {
    return $this->anlaegsinvestering - ($this->genopretning + $this->modernisering);
  }

  /**
   * Get investering eksl. genopretning og modernisering
   */
  public function getFravalgtInvesteringEkslGenopretningOgModernisering() {
    return $this->fravalgtAnlaegsinvestering - ($this->fravalgtGenopretning + $this->fravalgtModernisering);
  }

  /**
   * Get investering eksl. genopretning og modernisering
   *
   * (Aa+ Investering eks. Øvrige omkostninger)
   */
  public function getinvesteringEksFaellesomkostninger() {
    return $this->getAnlaegsinvestering() - ($this->getModernisering() + $this->getGenopretning());
  }

  /**
   * Get investering inkl.  øvrige omkostninger
   *
   * (Aa+ Investering inkl. Øvrige omkostninger)
   */
  public function getinvesteringInklFaellesomkostninger() {
    return $this->getInvesteringEksFaellesomkostninger() + ($this->getEnergiscreening() + $this->getMtmFaellesomkostninger() + $this->getImplementering());
  }

  /**
   * Get investering eksl. genopretning og modernisering for fravalgte tiltag
   */
  public function getFravalgtInvesteringEksFaellesomkostninger() {
    return $this->getFravalgtAnlaegsinvestering();
  }

  /**
   * Get sum fællesomkostninger
   */
  public function getSumFaellesOmkostninger() {
    return $this->mtmFaellesomkostninger + $this->implementering;
  }

  /**
   * Get sum of solcelleproduktion from all SolcelleTiltag.
   */
  public function getSolcelleproduktion() {
      // @TODO Implement function.
      return 0;
//    return $this->accumulate(function($tiltag, $value) {
//      return $value + ($tiltag instanceof SolcelleTiltag ? $tiltag->getSolcelleproduktion() : 0);
//    }, 0);
  }

  /**
   * Get sum of salgTilNettetAar1 from all SolcelleTiltag.
   */
  public function getSalgTilNettetAar1() {
      // @TODO Implement function.
      return 0;
//    return $this->accumulate(function($tiltag, $value) {
//      return $value + ($tiltag instanceof SolcelleTiltag ? $tiltag->getSalgTilNettetAar1() : 0);
//    }, 0);
  }

  /**
   * Post load handler.
   *
   * @ORM\PostLoad
   * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
   */
  public function postLoad(LifecycleEventArgs $event) {
    $repository = $event->getEntityManager()
      ->getRepository('AppBundle:Configuration');
    $this->setConfiguration($repository->getConfiguration());
  }

  public function calculate() {
  }

  protected function calculateAnlaegsinvestering() {
      // @TODO Implement function.
      return 0;
//    $result = 0;
//    foreach ($this->getTilvalgteTiltag() as $tiltag) {
//      $result += $tiltag->getAnlaegsinvestering();
//    }
//
//    return $result;
  }

  protected function calculateFravalgtAnlaegsinvestering() {
      // @TODO Implement function.
      return 0;
//    $result = 0;
//    foreach ($this->getFravalgteTiltag() as $tiltag) {
//      $result += $tiltag->getAnlaegsinvestering();
//    }
//
//    return $result;
  }

}
