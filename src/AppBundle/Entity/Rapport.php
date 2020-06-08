<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Annotations\Formula;
use AppBundle\Calculation\Calculation;
use AppBundle\DBAL\Types\Energiforsyning\NavnType;
use AppBundle\DBAL\Types\Energiforsyning\InternProduktion\PrisgrundlagType;
use AppBundle\DBAL\Types\SlutanvendelseType;
use AppBundle\Entity\Energiforsyning\InternProduktion;
use AppBundle\Entity\Energiforsyning;
use AppBundle\Entity\Traits\FormulableCalculationEntity;
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
 * Rapport
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RapportRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Rapport {

  use BlameableEntity;
  use TimestampableEntity;
  use FormulableCalculationEntity;

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var Bygning
   *
   * @OneToOne(targetEntity="Bygning", inversedBy="rapport", fetch="EAGER")
   **/
  protected $bygning;

  /**
   * @OneToMany(targetEntity="Energiforsyning", mappedBy="rapport", cascade={"persist", "remove"})
   * @OrderBy({"id" = "ASC"})
   * @JMS\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Energiforsyning>")
   */
  protected $energiforsyninger;

  /**
   * @OneToMany(targetEntity="Bilag", mappedBy="rapport")
   * @OrderBy({"id" = "ASC"})
   * @JMS\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Bilag>")
   */
  protected $bilag;

  /**
   * @OneToMany(targetEntity="Tiltag", mappedBy="rapport", cascade={"persist", "remove"})
   * @OrderBy({"id" = "ASC"})
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
   * @Formula("$this->co2BesparelseEl + $this->co2BesparelseVarme + $this->co2BesparelseBraendstofITon")
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
   * @ORM\Column(name="besparelseBraendstof", type="float", nullable=true)
   */
  protected $besparelseBraendstof;

  /**
   * @var array
   *
   * @ORM\Column(name="besparelseSlutanvendelser", type="array")
   */
  private $besparelseSlutanvendelser = array();

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="samletEnergibesparelse", type="float", nullable=true)
   * @Formula("$this->besparelseEl + $this->besparelseVarmeGAF + $this->besparelseVarmeGUF + $this->besparelseBraendstof")
   */
  protected $samletEnergibesparelse;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="samletEnergibesparelseKr", type="float", nullable=true)
   */
  protected $samletEnergibesparelseKr;

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
   * @ORM\Column(name="fravalgtBesparelseBraendstof", type="float", nullable=true)
   */
  protected $fravalgtBesparelseBraendstof;

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
   * @ORM\Column(name="BaselineCO2Braendstof", type="float", nullable=true)
   */
  protected $BaselineCO2Braendstof;

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
   * @ORM\Column(name="co2BesparelseBraendstofFaktor", type="float", nullable=true)
   */
  protected $co2BesparelseBraendstofFaktor;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="co2BesparelseBraendstofITon", type="float", nullable=true)
   */
  protected $co2BesparelseBraendstofITon;

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
   * @ORM\Column(name="BaselineBraendstof", type="decimal", precision=16, scale=4, nullable=true)
   */
  protected $BaselineBraendstof;

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
   * @var array
   *
   * @Calculated
   * @ORM\Column(name="nutidsvaerdiSet", type="array", nullable=true)
   */
  protected $nutidsvaerdiSet;

  /**
   * @var array
   *
   * @Calculated
   * @ORM\Column(name="akkumuleretNutidsvaerdiSet", type="array", nullable=true)
   */
  protected $akkumuleretNutidsvaerdiSet;

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
   * @ORM\Column(name="cashFlow", type="array")
   */
  protected $cashFlow;

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
   * @ORM\Column(name="energibudgetBraendstof", type="float", nullable=true)
   */
  protected $energibudgetBraendstof;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="fravalgtBesparelseDriftOgVedligeholdelse", type="float", nullable=true)
   */
  protected $fravalgtBesparelseDriftOgVedligeholdelse;

  /**
   * @var bool
   *
   * @ORM\Column(name="visGraphPDF", type="boolean")
   */
  protected $visGraphPDF = TRUE;

  /**
   * @return float
   */
  public function getfravalgtBesparelseDriftOgVedligeholdelse()
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
  public function getBaselineCO2Braendstof() {
    return $this->BaselineCO2Braendstof;
  }

  /**
   * @param float $BaselineCO2Braendstof
   */
  public function setBaselineCO2Braendstof($BaselineCO2Braendstof) {
    $this->BaselineCO2Braendstof = $BaselineCO2Braendstof;
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
  public function getCo2BesparelseBraendstofFaktor() {
    return $this->co2BesparelseBraendstofFaktor;
  }

  /**
   * @param float $co2BesparelseBraendstofFaktor
   */
  public function setCo2BesparelseBraendstofFaktor($co2BesparelseBraendstofFakrtor) {
    $this->co2BesparelseBraendstofFaktor = $co2BesparelseBraendstofFakrtor;
  }

  /**
   * @return float
   */
  public function getCo2BesparelseBraendstofITon() {
    return $this->co2BesparelseBraendstofITon;
  }

  /**
   * @param float $co2BesparelseBraendstofITon
   */
  public function setCo2BesparelseBraendstofITon($co2BesparelseBraendstofITon) {
    $this->co2BesparelseBraendstofITon = $co2BesparelseBraendstofITon;
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
   * Set energibudgetBraendstof
   *
   * @param float $energibudgetBraendstof
   * @return Rapport
   */
  public function setEnergibudgetBraendstof($energibudgetBraendstof)
  {
    $this->energibudgetBraendstof = $energibudgetBraendstof;
    return $this;
  }

  /**
   * Get energibudgetBraendstof
   *
   * @return float
   */
  public function getEnergibudgetBraendstof()
  {
    return $this->energibudgetBraendstof;
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
   * Set samletEnergibesparelse
   *
   * @param float $samletEnergibesparelse
   * @return Rapport
   */
  public function setSamletEnergibesparelse($samletEnergibesparelse)
  {
    $this->samletEnergibesparelse = $samletEnergibesparelse;
    return $this;
  }

  /**
   * Get samletEnergibesparelse
   *
   * @return float
   */
  public function getSamletEnergibesparelse()
  {
    return $this->samletEnergibesparelse;
  }

  /**
   * Set samletEnergibesparelseKr
   *
   * @param float $samletEnergibesparelseKr
   * @return Rapport
   */
  public function setSamletEnergibesparelseKr($samletEnergibesparelseKr)
  {
    $this->samletEnergibesparelseKr = $samletEnergibesparelseKr;
    return $this;
  }

  /**
   * Get samletEnergibesparelseKr
   *
   * @return float
   */
  public function getSamletEnergibesparelseKr()
  {
    return $this->samletEnergibesparelseKr;
  }

  /**
   * @param array $nutidsvaerdiSet
   */
  public function setNutidsvaerdiSet($nutidsvaerdiSet) {
    $this->nutidsvaerdiSet = $nutidsvaerdiSet;
  }

  /**
   * @return array
   */
  public function getNutidsvaerdiSet($value = FALSE) {
    return $value ? array_sum($this->nutidsvaerdiSet) : $this->nutidsvaerdiSet;
  }

  /**
   * @param array $akkumuleretNutidsvaerdiSet
   */
  public function setAkkumuleretNutidsvaerdiSet($akkumuleretNutidsvaerdiSet) {
    $this->akkumuleretNutidsvaerdiSet = $akkumuleretNutidsvaerdiSet;
  }

  /**
   * @return array
   */
  public function getAkkumuleretNutidsvaerdiSet() {
    return $this->akkumuleretNutidsvaerdiSet;
  }

  /**
   * Constructor
   */
  public function __construct() {
    $this->tiltag = new \Doctrine\Common\Collections\ArrayCollection();
    $this->energiforsyninger = new \Doctrine\Common\Collections\ArrayCollection();
    $this->bilag = new \Doctrine\Common\Collections\ArrayCollection();
    $this->datering = new \DateTime();
    $this->version = 1;
    $this->besparelseSlutanvendelser = array();
  }

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    $bygning = $this->getBygning();
    if ($bygning->getAdresse()) {
      return $bygning->getAdresse();
    }
    if ($bygning->getNavn()) {
      return $bygning->getNavn();
    }
    return strval($bygning->getId());
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
   * Get the "full" version with nummeric building status appended
   *
   * @return string
   */
  public function getFullVersion() {
    return 'Bygn. Status: '.$this->getBygning()->getNummericStatus().' / Itteration: '.$this->version;
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
   * Set datoForDrift
   *
   * @param \DateTime $datoForDrift
   * @return Rapport
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
   * Set bygning
   *
   * @param \AppBundle\Entity\Bygning $bygning
   * @return Rapport
   */
  public function setBygning(\AppBundle\Entity\Bygning $bygning = NULL) {
    $this->bygning = $bygning;

    if($bygning && $bygning->getBaseline()) {
      $this->updateBaselineValues($bygning->getBaseline());
    }

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
   * Add bilag
   *
   * @param \AppBundle\Entity\Bilag $bilag
   * @return Rapport
   */
  public function addBilag(\AppBundle\Entity\Bilag $bilag) {
    $this->bilag[] = $bilag;

    $bilag->setRapport($this);

    return $this;
  }

  /**
   * Remove bilag
   *
   * @param \AppBundle\Entity\Bilag $bilag
   */
  public function removeBilag(\AppBundle\Entity\Bilag $bilag) {
    $this->bilag->removeElement($bilag);
  }

  /**
   * Set bilag
   *
   * @return Rapport
   */
  public function setBilag($bilag) {
    $this->bilag = $bilag;

    return $this;
  }

  /**
   * Get bilag
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getBilag() {
    return $this->bilag;
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
   * Get all selected Tiltag.
   *
   * @return \Doctrine\Common\Collections\Collection
   *   The list of selected TiltagDetails.
   */
  public function getTilvalgteTiltag() {
    return $this->getTiltag()->filter(function ($tiltag) {
      return $tiltag->getTilvalgt();
    });
  }

  /**
   * Get all deselected Tiltag.
   *
   * @return \Doctrine\Common\Collections\Collection
   *   The list of selected TiltagDetails.
   */
  public function getFravalgteTiltag() {
    return $this->getTiltag()->filter(function ($tiltag) {
      return !$tiltag->getTilvalgt();
    });
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
   * Set besparelseSlutanvendelser
   *
   * @param array $besparelseSlutanvendelser
   *
   * @return Rapport
   */
  public function setBesparelseSlutanvendelser($besparelseSlutanvendelser)
  {
    $this->besparelseSlutanvendelser = $besparelseSlutanvendelser;

    return $this;
  }

  /**
   * Get besparelseSlutanvendelser
   *
   * @return array
   */
  public function getBesparelseSlutanvendelser()
  {
    return $this->besparelseSlutanvendelser;
  }

  /**
   * Get besparelseSlutanvendelser labels
   *
   * @return array
   */
  public function getBesparelseSlutanvendelserLabels()
  {
    return SlutanvendelseType::getChoices();
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
   * @return string
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
   * Get besparelseBraendstof
   *
   * @return float
   */
  public function getBesparelseBraendstof() {
    return $this->besparelseBraendstof;
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
   * @return Rapport
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
   * @return Rapport
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
   * @return Rapport
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
   * Set BaselineBraendstof
   *
   * @param integer $BaselineBraendstof
   * @return Rapport
   */
  public function setBaselineBraendstof($BaselineBraendstof) {
    $this->BaselineBraendstof = $BaselineBraendstof;

    return $this;
  }

  /**
   * Get BaselineBraendstof
   *
   * @return integer
   */
  public function getBaselineBraendstof() {
    return $this->BaselineBraendstof;
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
   * @return Rapport
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
   * @return Rapport
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
   * @return Rapport
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
   * @return Rapport
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
   * @return Rapport
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
  public function getTotalVarme() {
    return $this->getBaselineVarmeGAF() + $this->getBaselineVarmeGUF();
  }

  /**
   * Get Kalkulationsrente
   *
   * @return float
   */
  public function getKalkulationsrente() {
    // By default configuration settings will be used.
    $kalkulationrente = $this->configuration->getRapportKalkulationsrente();

    // Inherit Kalkulationsrente from Virksomhed.
    $virksomhed = $this->getBygning()->getVirksomhed();
    if (empty($virksomhed)) {
      return $kalkulationrente;
    }

    if (!empty($virksomhed->getKalkulationsrente(TRUE))) {
      $kalkulationrente = $virksomhed->getKalkulationsrente(TRUE);
    }

    return $kalkulationrente;
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
    return $this->getDriftomkostningerfaktor() + (25 * $this->getBygning()->getAreal());
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
   * Gets Inflation
   *
   * @return float
   */
  public function getInflation() {
    // By default configuration settings will be used.
    $inflation = $this->configuration->getRapportInflation();

    // Inherit Inflation from Virksomhed.
    $virksomhed = $this->getBygning()->getVirksomhed();
    if (empty($virksomhed)) {
        return $inflation;
    }

    if (!empty($virksomhed->getInflation(TRUE))) {
        $inflation = $virksomhed->getInflation(TRUE);
    }

    return $inflation;
  }

  /**
   * Gets Lobetid
   *
   * @return float
   */
  public function getLobetid() {
    // By default configuration settings will be used.
    $lobetid = $this->configuration->getRapportLobetid();

    // Inherit Lobetid from Virksomhed.
    $virksomhed = $this->getBygning()->getVirksomhed();
    if (empty($virksomhed)) {
      return $lobetid;
    }

    if (!empty($virksomhed->getLobetid(TRUE))) {
      $lobetid = $virksomhed->getLobetid(TRUE);
    }

    return $lobetid;
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
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkEl(TRUE);
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getFaktor($this, $this->getDatering()->format('Y'));
  }

  /**
   *
   * @return float
   */
  public function getVarmefaktor() {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme(TRUE);
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getFaktor($this, $this->getDatering()->format('Y'));
  }

  /**
   *
   * @return float
   */
  public function getVandfaktor() {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVand(TRUE);
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getFaktor($this, $this->getDatering()->format('Y'));
  }

  /**
   *
   * @return float
   */
  public function getVandKrKWh($yearNumber = 1) {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVand(TRUE);
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKrKWh($this->getDatering()->format('Y') - 1 + $yearNumber);
  }

  /**
   *
   * @return float
   */
  public function getVarmeKrKWh($yearNumber = 1) {
    $value = 0;
    $prisfaktor = 1;

    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme(TRUE);
    if ($forsyningsvaerk) {
      $value = $forsyningsvaerk->getKrKWh($this->getDatering()->format('Y') - 1 + $yearNumber);
    }
    // Get prisfaktor from energiforsyning associated with bygnings forsyningsvaerk.
    foreach ($this->getEnergiforsyninger() as $energiforsyning) {
      if ($energiforsyning->getForsyningsvaerk() == $this->bygning->getForsyningsvaerkVarme(TRUE)) {
        $prisfaktor = $energiforsyning->getPrisfaktor();
        break;
      }
    }

    return $value * $prisfaktor;
  }

  /**
   *
   * @return float
   */
  public function getElKrKWh($yearNumber = 1) {
    $value = 0;
    $prisfaktor = 1;

    $forsyningsvaerk = $this->bygning->getForsyningsvaerkEl(TRUE);
    if ($forsyningsvaerk) {
      $value = $forsyningsvaerk->getKrKWh($this->getDatering()->format('Y') - 1 + $yearNumber);
    }
    // Get prisfaktor from energiforsyning associated with bygnings forsyningsvaerk.
    foreach ($this->getEnergiforsyninger() as $energiforsyning) {
      if ($energiforsyning->getForsyningsvaerk() == $this->bygning->getForsyningsvaerkEl(TRUE)) {
        $prisfaktor = $energiforsyning->getPrisfaktor();
        break;
      }
    }

    return $value * $prisfaktor;
  }

  /**
   *
   * @return float
   */
  public function getVarmeKgCo2MWh($yearNumber = 1) {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme(TRUE);
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKgCo2MWh($this->getDatering()->format('Y') - 1 + $yearNumber);
  }

  /**
   *
   * @return float
   */
  public function getElKgCo2MWh($yearNumber = 1) {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkEl(TRUE);
    return !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKgCo2MWh($this->getDatering()->format('Y') - 1 + $yearNumber);
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
    if (!$this->energiforsyninger || $this->energiforsyninger->count() != 2) {
      return FALSE;
    }

    $energiforsyningEl = $this->getEnergiforsyningByNavn(NavnType::HOVEDFORSYNING_EL);
    $energiforsyningVarme = $this->getEnergiforsyningByNavn(NavnType::FJERNVARME);

    if (!$energiforsyningEl || !$energiforsyningVarme) {
      return FALSE;
    }

    $internProduktionEl = $energiforsyningEl->getInternProduktioner() ? $energiforsyningEl->getInternProduktioner()
      ->first() : NULL;
    $internProduktionVarme = $energiforsyningVarme->getInternProduktioner() ? $energiforsyningVarme->getInternProduktioner()
      ->first() : NULL;

    if ($internProduktionEl && $internProduktionVarme) {
      return $internProduktionEl->getPrisgrundlag() == PrisgrundlagType::EL && $internProduktionEl->getFordeling() == 1 && $internProduktionEl->getEffektivitet() == 1
      && $internProduktionVarme->getPrisgrundlag() == PrisgrundlagType::VARME && $internProduktionVarme->getFordeling() == 1 && $internProduktionVarme->getEffektivitet() == 1;
    }

    return FALSE;
  }

  private function getEnergiforsyningByNavn($navn) {
    if (!$this->energiforsyninger) {
      return NULL;
    }
    return $this->energiforsyninger->filter(function ($energiforsyning) use ($navn) {
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
    return $this->anlaegsinvestering;
  }

  /**
   * Get investering eksl. genopretning og modernisering
   *
   */
  public function getFravalgtInvesteringEkslGenopretningOgModernisering() {
    return $this->fravalgtAnlaegsinvestering;
  }

  /**
   * @Formula("$this->getAnlaegsinvestering()")
   */
  protected $investeringEksFaellesomkostninger;

  /**
   * Get investering eksl. genopretning og modernisering
   *
   * (Aa+ Investering eks. Øvrige omkostninger)
   */
  public function getinvesteringEksFaellesomkostninger() {
    return $this->calculateByFormula('investeringEksFaellesomkostninger');
  }

  /**
   * @Formula("$this->getInvesteringEksFaellesomkostninger() + ($this->getEnergiscreening() + $this->getMtmFaellesomkostninger() + $this->getImplementering())")
   */
  protected $investeringInklFaellesomkostninger;

  /**
   * Get investering inkl.  øvrige omkostninger
   *
   * (Aa+ Investering inkl. Øvrige omkostninger)
   */
  public function getinvesteringInklFaellesomkostninger() {
    return $this->calculateByFormula('investeringInklFaellesomkostninger');
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
   * Get bygning Virksomhed
   */
  public function getVirksomhed() {
    return $this->bygning->getVirksomhed();
  }

  /**
   * Get sum of solcelleproduktion from all SolcelleTiltag.
   */
  public function getSolcelleproduktion() {
    return $this->accumulate(function($tiltag, $value) {
      return $value + ($tiltag instanceof SolcelleTiltag ? $tiltag->getSolcelleproduktion() : 0);
    }, 0);
  }

  /**
   * Get sum of salgTilNettetAar1 from all SolcelleTiltag.
   */
  public function getSalgTilNettetAar1() {
    return $this->accumulate(function($tiltag, $value) {
      return $value + ($tiltag instanceof SolcelleTiltag ? $tiltag->getSalgTilNettetAar1() : 0);
    }, 0);
  }

  /**
   * @return boolean
   */
  public function getVisGraphPDF() {
    return $this->visGraphPDF;
  }

  /**
   * @param boolean $visGraphPDF
   */
  public function setVisGraphPDF($visGraphPDF) {
    $this->visGraphPDF = $visGraphPDF;
  }

  /**
   * Get all files on this Rapport plus any files from Tiltag.
   *
   * @return array
   */
  public function getAllFiles() {
    $files = [];

    if ($this->getBilag()) {
      foreach ($this->getBilag() as $bilag) {
        $files[] = $bilag->getFilepath();
      }
    }

    foreach ($this->getTiltag() as $tiltag) {
      $tiltagFiles = $tiltag->getAllFiles();
      if ($tiltagFiles) {
        $files += $tiltagFiles;
      }
    }

    return $files ? $files : null;
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
    $this->initFormulableCalculation();
    $this->tranlsationSuffix = 'appbundle.rapport.';
  }

  /**
   * Post persist handler.
   *
   * @ORM\PostPersist
   * @param LifecycleEventArgs $event
   */
  public function postPersist(LifecycleEventArgs $event) {
    // Init with preset energiforsyning El
    $forsyningEl = new Energiforsyning();
    $forsyningEl
      ->setNavn(NavnType::HOVEDFORSYNING_EL)
      ->setBeskrivelse("El");
    $internProduktionEl = new InternProduktion();
    $internProduktionEl
      ->setNavn("El")
      ->setFordeling(1.0)
      ->setEffektivitet(1.0)
      ->setPrisgrundlag(PrisgrundlagType::EL);
    $forsyningEl->addInternProduktion($internProduktionEl);
    $forsyningEl->calculate();
    $this->addEnergiforsyning($forsyningEl);

    // Init with preset energiforsyning Varme
    $forsyningVarme = new Energiforsyning();
    $forsyningVarme
      ->setNavn(NavnType::FJERNVARME)
      ->setBeskrivelse("Fjernvarme");
    $internProduktionVarme = new InternProduktion();
    $internProduktionVarme
      ->setNavn("Varme")
      ->setFordeling(1.0)
      ->setEffektivitet(1.0)
      ->setPrisgrundlag(PrisgrundlagType::VARME);
    $forsyningVarme->addInternProduktion($internProduktionVarme);
    $forsyningVarme->calculate();
    $this->addEnergiforsyning($forsyningVarme);

    // Init with preset energiforsyning Oliefyr
    $forsyningOliefyr = new Energiforsyning();
    $forsyningOliefyr
      ->setNavn(NavnType::OLIEFYR)
      ->setBeskrivelse("Oliefyr");
    $internProduktionOliefyr = new InternProduktion();
    $internProduktionOliefyr
      ->setNavn("Oliefyr")
      ->setFordeling(1.0)
      ->setEffektivitet(1.0)
      ->setPrisgrundlag(PrisgrundlagType::VARME);
    $forsyningOliefyr->addInternProduktion($internProduktionOliefyr);
    $forsyningOliefyr->calculate();
    $this->addEnergiforsyning($forsyningOliefyr);

    // Init with preset energiforsyning Træpillefyr
    $forsyningTraepillefyr = new Energiforsyning();
    $forsyningTraepillefyr
      ->setNavn(NavnType::TRAEPILLEFYR)
      ->setBeskrivelse("Træpillefyr");
    $internProduktionTraepillefyr= new InternProduktion();
    $internProduktionTraepillefyr
      ->setNavn("Træpillefyr")
      ->setFordeling(1.0)
      ->setEffektivitet(1.0)
      ->setPrisgrundlag(PrisgrundlagType::VARME);
    $forsyningTraepillefyr->addInternProduktion($internProduktionTraepillefyr);
    $forsyningTraepillefyr->calculate();
    $this->addEnergiforsyning($forsyningTraepillefyr);

    // Init with preset energiforsyning Varmepumpe
    $forsyningVarmepumpe = new Energiforsyning();
    $forsyningVarmepumpe
      ->setNavn(NavnType::VARMEPUMPE)
      ->setBeskrivelse("Varmepumpe");
    $internProduktionVarmepumpe = new InternProduktion();
    $internProduktionVarmepumpe
      ->setNavn("Varmepumpe El")
      ->setFordeling(1.0)
      ->setEffektivitet(1.0)
      ->setPrisgrundlag(PrisgrundlagType::EL);
    $forsyningVarmepumpe->addInternProduktion($internProduktionVarmepumpe);
    $forsyningVarmepumpe->calculate();
    $this->addEnergiforsyning($forsyningVarmepumpe);

    // Init with preset energiforsyning Gas
    $forsyningGas = new Energiforsyning();
    $forsyningGas
      ->setNavn(NavnType::GAS)
      ->setBeskrivelse("Gas");
    $internProduktionGas = new InternProduktion();
    $internProduktionGas
      ->setNavn("Gas")
      ->setFordeling(1.0)
      ->setEffektivitet(1.0)
      ->setPrisgrundlag(PrisgrundlagType::VARME);
    $forsyningGas->addInternProduktion($internProduktionGas);
    $forsyningGas->calculate();
    $this->addEnergiforsyning($forsyningGas);

    // Init with preset energiforsyning Flis
    $forsyningFlis = new Energiforsyning();
    $forsyningFlis
      ->setNavn(NavnType::FLIS)
      ->setBeskrivelse("Flis");
    $internProduktionFlis = new InternProduktion();
    $internProduktionFlis
      ->setNavn("Flis")
      ->setFordeling(1.0)
      ->setEffektivitet(1.0)
      ->setPrisgrundlag(PrisgrundlagType::VARME);
    $forsyningFlis->addInternProduktion($internProduktionFlis);
    $forsyningFlis->calculate();
    $this->addEnergiforsyning($forsyningFlis);

    $event->getEntityManager()->flush();
  }

  protected $propertiesRequiredForCalculation = [
    'BaselineEl',
    'BaselineStrafAfkoeling',
    'BaselineVarmeGAF',
    'BaselineVarmeGUF',
    'energiscreening',
    'faktorPaaVarmebesparelse',
  ];

  public function getPropertiesRequiredForCalculation() {
    return $this->propertiesRequiredForCalculation;
  }

  public function getNutidsvaerdiBeregnAar() {
    return $this->getConfiguration()->getNutidsvaerdiBeregnAar();
  }

  /**
   * Check if calculating this Rapport makes sense.
   * Some values may be required to make a meaningful calculation.
   */
  public function getCalculationWarnings($messages = []) {
    $properties = $this->getPropertiesRequiredForCalculation();
    $prefix = 'rapport';
    $tiltag = $this->getTiltag();
    return Calculation::getCalculationWarnings($this, $properties, $prefix, $this->getTiltag());
  }

  public function calculate() {
    $this->BaselineCO2El = $this->calculateBaselineCO2El();
    $this->BaselineCO2Varme = $this->calculateBaselineCO2Varme();
    $this->BaselineCO2Braendstof = $this->calculateBaselineCO2Braendstof();
    $this->BaselineCO2Samlet = $this->calculateBaselineCO2Samlet();

    $this->besparelseEl = $this->calculateBesparelseEl();
    $this->fravalgtBesparelseEl = $this->calculateFravalgtBesparelseEl();
    $this->besparelseVarmeGUF = $this->calculateBesparelseVarmeGUF();
    $this->fravalgtBesparelseVarmeGUF = $this->calculateFravalgtBesparelseVarmeGUF();
    $this->besparelseVarmeGAF = $this->calculateBesparelseVarmeGAF();
    $this->fravalgtBesparelseVarmeGAF = $this->calculateFravalgtBesparelseVarmeGAF();
    $this->besparelseBraendstof = $this->calculateBesparelseBraendstof();
    $this->fravalgtBesparelseBraendstof = $this->calculateFravalgtBesparelseBraendstof();

    $this->besparelseSlutanvendelser = $this->calculateBesparelseSlutanvendelser();

    $this->co2BesparelseEl = $this->calculateCo2BesparelseEl();
    $this->co2BesparelseVarme = $this->calculateCo2BesparelseVarme();
    $this->co2BesparelseBraendstofITon = $this->calculateCo2BesparelseBraendstofITon();
    $this->besparelseCO2 = $this->calculateByFormula('besparelseCO2');
    $this->fravalgtBesparelseCO2 = $this->calculateFravalgtBesparelseCO2();

    $this->co2BesparelseElFaktor = $this->calculateCo2BesparelseElFaktor();
    $this->co2BesparelseVarmeFaktor = $this->calculateCo2BesparelseVarmeFaktor();
    $this->co2BesparelseBraendstofFaktor = $this->calculateCo2BesparelseBraendstofFaktor();
    $this->co2BesparelseSamletFaktor = $this->calculateCo2BesparelseSamletFaktor();
    $this->fravalgtCo2BesparelseSamletFaktor = $this->calculateFravalgtCo2BesparelseSamletFaktor();

    $this->mtmFaellesomkostninger = $this->calculateMtmFaellesomkostninger();
    $this->implementering = $this->calculateImplementering();
    $this->fravalgtImplementering = $this->calculateFravalgtImplementering();
    $this->faellesomkostninger = $this->calculateFaellesomkostninger();
    $this->fravalgtBesparelseDriftOgVedligeholdelse = $this->calculateFravalgtBesparelseDriftOgVedligeholdelse();

    $this->cashFlow = $this->calculateCashFlow();
    $this->besparelseAarEt = $this->calculateBesparelseAarEt();
    $this->fravalgtBesparelseAarEt = $this->calculateFravalgteSavingsYearOne();
    $this->anlaegsinvestering = $this->calculateAnlaegsinvestering();
    $this->fravalgtAnlaegsinvestering = $this->calculateFravalgtAnlaegsinvestering();
    $this->nutidsvaerdiSetOver15AarKr = $this->calculateNutidsvaerdiSetOver15AarKr();
    $this->fravalgtNutidsvaerdiSetOver15AarKr = $this->calculateFravalgtNutidsvaerdiSetOver15AarKr();

    $this->cashFlow15 = $this->calculateCashFlow15();
    $this->cashFlow30 = $this->calculateCashFlow30();

    $this->nutidsvaerdiSet = $this->calculateNutidsvaerdiSet();
    $this->akkumuleretNutidsvaerdiSet = $this->calculateAkkumuleterNutidsvaerdiSet();

    $this->internRenteInklFaellesomkostninger = $this->calculateInternRenteInklFaellesomkostninger();

    $this->energibudgetVarme = $this->calculateEnergibudgetVarme();
    $this->energibudgetEl = $this->calculateEnergibudgetEl();
    $this->energibudgetBraendstof = $this->calculateEnergibudgetBraendstof();

    $this->samletEnergibesparelse = $this->calculateByFormula('samletEnergibesparelse');
    $this->samletEnergibesparelseKr = $this->calculateSamletEnergiBesparelseKr();
  }

  private function calculateCashFlow15() {
    $result = array_fill(1, 15, 0);
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      $cashflow = $tiltag->getCashFlow15();
      if(count($cashflow) == 15) {
        for($i = 1; $i <= 15; $i++) {
          $result[$i] += $cashflow[$i];
        }
      }
    }

    return $result;
  }

  private function calculateCashFlow30() {
    $result = array_fill(1, 30, 0);
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      $cashflow = $tiltag->getCashFlow15();
      if(count($cashflow) == 30) {
        for($i = 1; $i <= 30; $i++) {
          $result[$i] += $cashflow[$i];
        }
      }
    }

    return $result;
  }

  private function calculateCashFlowSet() {
    $nutidsvaerdiBeregnAar = $this->getNutidsvaerdiBeregnAar();
    $result = array_fill(1, $nutidsvaerdiBeregnAar, 0);
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      $cashflow = $tiltag->getCashFlowSet();
      for ($i = 1; $i <= $nutidsvaerdiBeregnAar; $i++) {
        $result[$i] += isset($cashflow[$i]) ? $cashflow[$i] : 0;
      }
    }

    return $result;
  }

  /**
   * Calculates expression for BesparelseVarmeGUF value
   */
  protected function calculateBesparelseVarmeGUFExp() {
    return $this->calculateBesparelseVarmeGUF(TRUE);
  }

  /**
   * @Formula("$this->calculateBesparelseVarmeGUFExp()")
   */
  private function calculateBesparelseVarmeGUF($expression = FALSE) {
    $values = array();
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      $values[] = $tiltag->getVarmebesparelseGUF();
    }
    return $expression ? $this->sumExpr($values) : array_sum($values);
  }

  private function calculateFravalgtBesparelseVarmeGUF() {
    $value = 0;
    foreach ($this->getFravalgteTiltag() as $tiltag) {
      $value += $tiltag->getVarmebesparelseGUF();
    }
    return $value;
  }

  /**
   * Calculates expression for BesparelseVarmeGAF value
   */
  protected function calculateBesparelseVarmeGAFExp() {
    return $this->calculateBesparelseVarmeGAF(TRUE);
  }

  /**
   * @Formula("$this->calculateBesparelseVarmeGAFExp()")
   */
  protected function calculateBesparelseVarmeGAF($expression = FALSE) {
    $values = array();
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      $values[] = $tiltag->getVarmebesparelseGAF();
    }
    return $expression ? $this->sumExpr($values) : array_sum($values);
  }

  private function calculateFravalgtBesparelseVarmeGAF() {
    $value = 0;
    foreach ($this->getFravalgteTiltag() as $tiltag) {
      $value += $tiltag->getVarmebesparelseGAF();
    }
    return $value;
  }

  /**
   * Calculates expression for FravalgtBesparelseBraendstof value
   */
  protected function calculateFravalgtBesparelseBraendstofExp() {
    return $this->calculateFravalgtBesparelseBraendstof(TRUE);
  }

  /**
   * @Formula("$this->calculateFravalgtBesparelseBraendstofExp()")
   */
  private function calculateFravalgtBesparelseBraendstof($expression = FALSE) {
    $values = array();
    foreach ($this->getFravalgteTiltag() as $tiltag) {
      if (method_exists($tiltag, 'getBesparelseCo2Braendstof')) {
        if ($value = $tiltag->getBesparelseCo2Braendstof()) {
          $values[] = (float) $value;
        }
      }
    }
    return $expression ? $this->sumExpr($values) : array_sum($values);
  }

  private function calculateFravalgtBesparelseCO2() {
    $value = 0;
    foreach ($this->getFravalgteTiltag() as $tiltag) {
      $value += $tiltag->getSamletCo2besparelse();
    }
    return $value;
  }

  /**
   * Calculates expression for besparelseEl value
   */
  protected function calculateBesparelseElExp() {
    return $this->calculateBesparelseEl(TRUE);
  }

  /**
   * @Formula("$this->calculateBesparelseElExp()")
   */
  private function calculateBesparelseEl($expression = FALSE) {
    $values = array();
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      $values[] = $tiltag->getElBesparelse();
    }
    return $expression ? $this->sumExpr($values) : array_sum($values);
  }

  /**
   * Calculates expression for besparelseBraendstof value
   */
  protected function calculateBesparelseBraendstofExp() {
    return $this->calculateBesparelseBraendstof(TRUE);
  }

  /**
   * @Formula("$this->calculateBesparelseBraendstofExp()")
   */
  private function calculateBesparelseBraendstof($expression = FALSE) {
    $values = array();

    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      if (method_exists($tiltag, 'getBesparelseBraendstof')) {
        $values[] = $tiltag->getBesparelseBraendstof();
      }
    }
    return $expression ? $this->sumExpr($values) : array_sum($values);
  }

  /**
   * Calculates besparelseSlutanvendelser by slutanvendelse type.
   */
  private function calculateBesparelseSlutanvendelser() {
    $values = array();
    /** @var Tiltag $tiltag */
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      if (empty($tiltag->getSlutanvendelse())) {
        continue;
      }

      $slutanvendelseType = (string) $tiltag->getSlutanvendelse();
      if (!isset($values[$slutanvendelseType])) {
        $values[$slutanvendelseType] = array(
          'el' => 0,
          'varmeGAF' => 0,
          'varmeGUF' => 0,
          'braendStof' => 0,
          'total' => 0,
        );
      }

      $values[$slutanvendelseType]['el'] += $tiltag->getElbesparelse();
      $values[$slutanvendelseType]['varmeGAF'] += $tiltag->getVarmebesparelseGAF();
      $values[$slutanvendelseType]['varmeGUF'] += $tiltag->getVarmebesparelseGUF();
      if (method_exists($tiltag, 'getBesparelseBraendstof')) {
        $values[$slutanvendelseType]['braendStof'] += $tiltag->getBesparelseBraendstof();
      }
      unset($values[$slutanvendelseType]['total']);
      $values[$slutanvendelseType]['total'] = array_sum($values[$slutanvendelseType]);
    }
    return $values;
  }

  private function calculateBaselineCO2El() {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkEl(TRUE);
    $kgCo2MWh = !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKgCo2MWh(2015);

    return ($this->BaselineEl / 1000) * ($kgCo2MWh / 1000);
  }

  private function calculateBaselineCO2Varme() {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme(TRUE);
    $kgCo2MWh = !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKgCo2MWh(2015);

    return (($this->BaselineVarmeGUF + $this->BaselineVarmeGAF) / 1000) * $kgCo2MWh / 1000;
  }

  private function calculateBaselineCO2Braendstof() {
    $forsyningsvaerk = $this->bygning->getForsyningsvaerkVarme(TRUE);
    $kgCo2MWh = !$forsyningsvaerk ? 0 : $forsyningsvaerk->getKgCo2MWh(2015);
    return ($this->BaselineBraendstof / 1000) * $kgCo2MWh / 1000;
  }

  private function calculateBaselineCO2Samlet() {
    return $this->BaselineCO2El + $this->BaselineCO2Varme;
  }

  /**
   * @Formula("$this->co2BesparelseEl / $this->BaselineCO2El")
   */
  private function calculateCo2BesparelseElFaktor() {
    if (!empty($this->BaselineCO2El)) {
      return $this->co2BesparelseEl / $this->BaselineCO2El;
    }
    return null;
  }

  /**
   * @Formula("$this->co2BesparelseVarme / $this->BaselineCO2Varme")
   */
  private function calculateCo2BesparelseVarmeFaktor() {
    if (!empty($this->BaselineCO2Varme)) {
      return $this->co2BesparelseVarme / $this->BaselineCO2Varme;
    }
    return null;
  }

  /**
   * @Formula("$this->besparelseCO2 / $this->BaselineCO2Samlet")
   */
  private function calculateCo2BesparelseSamletFaktor() {
    if (!empty($this->BaselineCO2Samlet)) {
      return $this->besparelseCO2 / $this->BaselineCO2Samlet;
    }
    return null;
  }

  private function calculateFravalgtCo2BesparelseSamletFaktor() {
    if ($this->BaselineCO2Samlet != 0) {
      return $this->fravalgtBesparelseCO2 / $this->BaselineCO2Samlet;
    }
    return null;
  }

  /**
   * Gets KgCo2MWh value from bygning ForsyningsvaerkEl.
   *
   * @return float|null
   */
  private function getBygningForsyningsvaerkElKgCo2MWh() {
    $vaerk = $this->getBygning()->getForsyningsvaerkEl(TRUE);
    if($vaerk) {
      return $vaerk->getKgCo2MWh(2015);
    }
    return null;
  }

  /**
   * @Formula("($this->besparelseEl + $this->getSolcelleproduktion() + $this->getSalgTilNettetAar1()) / 1000 * $this->getBygningForsyningsvaerkElKgCo2MWh() / 1000")
   */
  private function calculateCo2BesparelseEl() {
    $ElKgCo2MWh = $this->getBygningForsyningsvaerkElKgCo2MWh();
    if($ElKgCo2MWh) {
      return ($this->besparelseEl + $this->getSolcelleproduktion() + $this->getSalgTilNettetAar1()) / 1000 * $ElKgCo2MWh / 1000;
    } else {
      return 0;
    }
  }

  /**
   * Gets KgCo2MWh value from bygning ForsyningsvaerkVarme.
   *
   * @return float|null
   */
  private function getBygningForsyningsvaerkVarmeKgCo2MWh() {
    $vaerk = $this->getBygning()->getForsyningsvaerkVarme(TRUE);
    if($vaerk) {
      return $vaerk->getKgCo2MWh(2015);
    }
    return null;
  }

  /**
   * @Formula("($this->besparelseVarmeGAF + $this->besparelseVarmeGUF) / 1000 * $this->getBygningForsyningsvaerkVarmeKgCo2MWh() / 1000")
   */
  private function calculateCo2BesparelseVarme() {
    $VarmeKgCo2MWh = $this->getBygningForsyningsvaerkVarmeKgCo2MWh();
    if($VarmeKgCo2MWh) {
      return ($this->besparelseVarmeGAF + $this->besparelseVarmeGUF) / 1000 * $VarmeKgCo2MWh / 1000;
    } else {
      return 0;
    }
  }

  /**
   * Calculates expression for Co2BesparelseBraendstofFaktor value
   */
  protected function calculateCo2BesparelseBraendstofFaktorExp() {
    return $this->calculateCo2BesparelseBraendstofFaktor(TRUE);
  }

  /**
   * The Co2BesparelseBraendstofFaktor calculated based on Tiltag without using
   * Baseline data.
   *
   * @Formula("$this->calculateCo2BesparelseBraendstofFaktorExp()")
   */
  private function calculateCo2BesparelseBraendstofFaktor($expression = FALSE) {
    $amount = array();

    foreach ($this->getTilvalgteTiltag() as $tiltag) {

      if (method_exists($tiltag, 'getBesparelseCo2Braendstof')) {

        if ($value = $tiltag->getBesparelseCo2Braendstof()) {
          $amount[] = (float) $value;
        }
      }
    }

    if ($expression) {
      return $this->sumExpr($amount) . '/' .  count($amount);
    }

    return Calculation::divide(array_sum($amount), count($amount));
  }

  /**
   * Calculates expression for Co2BesparelseBraendstofITon value
   */
  protected function calculateCo2BesparelseBraendstofITonExp() {
    return $this->calculateCo2BesparelseBraendstofITon(TRUE);
  }

  /**
   * @Formula("$this->calculateCo2BesparelseBraendstofITonExp()")
   */
  private function calculateCo2BesparelseBraendstofITon($expression = FALSE) {
    $amount = array();

    foreach ($this->getTilvalgteTiltag() as $tiltag) {

      if (method_exists($tiltag, 'getBesparelseCo2BraendstofITon')) {

        if ($value = $tiltag->getBesparelseCo2BraendstofITon()) {
          $amount[] = (float) $value;
        }
      }
    }

    if ($expression) {
      return $this->sumExpr($amount);
    }

    return array_sum($amount);
  }

  private function calculateFravalgtBesparelseEl() {
    $value = 0;
    foreach ($this->getFravalgteTiltag() as $tiltag) {
      $value += $tiltag->getElBesparelse();
    }
    return $value;
  }

  private function calculateMtmFaellesomkostninger() {
    $areal = $this->bygning->getErhvervsareal();
    if ($areal < $this->configuration->getMtmFaellesomkostningerNulHvisArealMindreEnd()
        || $this->anlaegsinvestering < $this->configuration->getMtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd()) {
      return 0;
    }
    $offset = $this->configuration->getMtmFaellesomkostningerGrundpris();
    $scale = $this->configuration->getMtmFaellesomkostningerPrisPrM2();

    return $offset + $scale * $areal;
  }

  private function calculateImplementering() {
    $sum = 0;
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      $sum += $tiltag->getAaplusInvestering();
    }

    return $sum * $this->getProcentAfInvestering();
  }

  private function calculateFravalgtImplementering() {
    $sum = 0;
    foreach ($this->getFravalgteTiltag() as $tiltag) {
      $sum += $tiltag->getAaplusInvestering();
    }

    return $sum * $this->getProcentAfInvestering();
  }

  private function calculateFaellesomkostninger() {
    return $this->energiscreening + $this->mtmFaellesomkostninger + $this->implementering;
  }

  /**
   * Calculates expression for BesparelseAarEt value
   */
  protected function calculateBesparelseAarEtExp() {
    return $this->calculateBesparelseAarEt(TRUE);
  }

  /**
   * @Formula("$this->calculateBesparelseAarEtExp()")
   */
  private function calculateBesparelseAarEt($expression = FALSE) {
    $result = array();

    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      $result[] = $tiltag->getBesparelseAarEt();
    }

    return $expression ? $this->sumExpr($result) : array_sum($result);
  }

  private function calculateFravalgteSavingsYearOne() {
    $result = 0;

    foreach ($this->getFravalgteTiltag() as $tiltag) {
      $result += $tiltag->getBesparelseAarEt();
    }

    return $result;
  }

  /**
   * Calculates expression for Anlaegsinvestering value
   */
  protected function calculateAnlaegsinvesteringExp() {
    return $this->calculateAnlaegsinvestering(TRUE);
  }

  /**
   * @Formula("$this->calculateAnlaegsinvesteringExp()")
   */
  protected function calculateAnlaegsinvestering($expression = FALSE) {
    $result = array();
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      $result[] = $tiltag->getAnlaegsinvestering();
    }

    return $expression ? $this->sumExpr($result) : array_sum($result);
  }

  protected function calculateFravalgtAnlaegsinvestering() {
    $result = 0;
    foreach ($this->getFravalgteTiltag() as $tiltag) {
      $result += $tiltag->getAnlaegsinvestering();
    }

    return $result;
  }

  /**
   * Calculates expression for nutidsvaerdiSetOver15AarKr value
   */
  protected function calculateNutidsvaerdiSetOver15AarKrExp() {
    return $this->sumExpr($this->calculateNutidsvaerdiSetOver15AarKr(TRUE));
  }

  /**
   * Calculate using sum of cash flows from Tiltag with "Øvrige omkostninger"
   * added in year 1.
   *
   * @Formula("$this->calculateNutidsvaerdiSetOver15AarKrExp()")
   */
  protected function calculateNutidsvaerdiSetOver15AarKr($array = FALSE) {
    $numberOfYears = 15;
    $cashFlow = array_fill(1, $numberOfYears, 0);
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      foreach ($tiltag->getCashFlow15() as $index => $value) {
        $cashFlow[$index] += $value;
      }
    }

    $cashFlow[1] -= $this->getEnergiscreening() + $this->getMtmFaellesomkostninger() + $this->getImplementering();

    return Calculation::npv($this->getKalkulationsrente(), $cashFlow, $array);
  }

  /**
   * @Formula("$this->calculateNutidsvaerdiSet")
   */
  protected function calculateNutidsvaerdiSet() {
    $years = $this->getNutidsvaerdiBeregnAar();
    $cashFlow = $this->calculateCashFlow($years);
    return Calculation::npv($this->getKalkulationsrente(), $cashFlow['cash flow'], TRUE);
  }

  /**
   * @Formula("$this->calculateNutidsvaerdiSetOver15AarKrExpr()")
   */
  protected function calculateAkkumuleterNutidsvaerdiSet() {
    $years = $this->getNutidsvaerdiBeregnAar();
    $nutidsvaerdiSet = $this->getNutidsvaerdiSet();
    $result = array_fill(0, $years, 0);
    $value = - ($this->getEnergiscreening() + $this->getMtmFaellesomkostninger() + $this->getImplementering());
    $result[0] = $value;
    for ($i = 1; $i <= $years; $i++) {
      $value += isset($nutidsvaerdiSet[$i]) ? $nutidsvaerdiSet[$i] : 0;
      $result[$i] = $value;
    }

    return $result;
  }

  protected function calculateFravalgtNutidsvaerdiSetOver15AarKr() {
    $result = 0;
    foreach ($this->getFravalgteTiltag() as $tiltag) {
      $result += $tiltag->getNutidsvaerdiSetOver15AarKr();
    }

    return $result;
  }

  /**
   * Calculates expression for InternRenteInklFaellesomkostninger value
   */
  protected function calculateInternRenteInklFaellesomkostningerExp() {
    return $this->calculateInternRenteInklFaellesomkostninger(TRUE);
  }

  /**
   * @Formula("$this->calculateInternRenteInklFaellesomkostningerExp()")
   */
  private function calculateInternRenteInklFaellesomkostninger($expression = FALSE) {
    $numberOfYears = 15;
    $cashFlow = array_fill(1, $numberOfYears, 0);
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      foreach ($tiltag->getCashFlow15() as $index => $value) {
        $cashFlow[$index] += $value;
      }
    }

    $cashFlow[1] -= $this->getEnergiscreening() + $this->getMtmFaellesomkostninger() + $this->getImplementering();

    if ($expression) {
      return $this->mathArrayExpr($cashFlow, '; ', 'IRR(',  ')');
    }

    $irr = Excel::IRR($cashFlow);

    if(ExcelError::IS_ERR($irr)) {
      return NULL;
    }

    return $irr;
  }

  private function calculateEnergibudgetVarme() {
    return ($this->BaselineVarmeGAF + $this->BaselineVarmeGUF) - ($this->besparelseVarmeGAF + $this->besparelseVarmeGUF);
  }

  private function calculateEnergibudgetEl() {
    return $this->BaselineEl - $this->besparelseEl;
  }

  private function calculateEnergibudgetBraendstof() {
    return $this->BaselineBraendstof - $this->besparelseBraendstof;
  }

  private function calculateCashFlow($numberOfYears = 30) {
    $maxTiltagLevetid = $this->accumulate(function($tiltag, $value) {
      return $tiltag->getLevetid() > $value ? $tiltag->getLevetid() : $value;
    }, 0);

    $flow = array(
      'ydelse laan' => array_fill(0, $numberOfYears + 1, 0),
      'laan til faellesomkostninger' => array_fill(0, $numberOfYears + 1, 0),
      'ydelse laan inkl. faellesomkostninger' => array_fill(0, $numberOfYears + 1, 0),
      'besparelse' => array_fill(0, $numberOfYears + 1, 0),
      'cash flow' => array_fill(0, $numberOfYears + 1, 0),
      'akkumuleret' => array_fill(0, $numberOfYears + 1, 0),
      'besparelse_varme' => array_fill(0, $numberOfYears + 1, NULL),
      'besparelse_el' => array_fill(0, $numberOfYears + 1, NULL),
    );

    $tilvalgteTiltag = $this->getTilvalgteTiltag();
    $rente = $this->getKalkulationsrente();
    $loebetid = $this->getLaanLoebetid();
    $samletAarligYdelseTilLaan = 0;

    foreach ($tilvalgteTiltag as $index => $tiltag) {
      $samletAarligYdelseTilLaan += Calculation::pmt($rente, $loebetid, $tiltag->getAaplusInvestering());
    }

    for ($year = 1; $year <= $numberOfYears; $year++) {
      $flow['ydelse laan'][$year] = ($year <= $loebetid) ? -$samletAarligYdelseTilLaan : NULL;
      $flow['laan til faellesomkostninger'][$year] = ($year <= $loebetid) ? -Calculation::pmt($rente, $loebetid, $this->faellesomkostninger) : NULL;
      $flow['ydelse laan inkl. faellesomkostninger'][$year] = $flow['ydelse laan'][$year] + $flow['laan til faellesomkostninger'][$year];
      $besparelse = $this->accumulate(function($tiltag, $value) use ($year) {
        return $value + $tiltag->calculateSavingsForYear($year);
      }, 0);

      $flow['besparelse'][$year] = $besparelse;
      $flow['cash flow'][$year] = -$flow['ydelse laan inkl. faellesomkostninger'][$year] + $flow['besparelse'][$year];
      $flow['akkumuleret'][$year] = $flow['akkumuleret'][$year - 1] + $flow['cash flow'][$year];

      if ($year <= $maxTiltagLevetid) {
        $flow['besparelse_varme'][$year] = $this->accumulate(function($tiltag, $value) use ($year) {
          return $value + $tiltag->calculateBesparelseVarmeForYear($year);
        }, 0);
        $flow['besparelse_el'][$year] = $this->accumulate(function($tiltag, $value) use ($year) {
          return $value + $tiltag->calculateBesparelseElForYear($year);
        }, 0);
      }
    }

    // Remove year 0.
    foreach ($flow as &$row) {
      unset($row[0]);
    }

    return $flow;
  }

  protected function calculateFravalgtBesparelseDriftOgVedligeholdelse() {
    $result = 0;
    foreach ($this->getFravalgteTiltag() as $tiltag) {
      $result += $tiltag->getBesparelseDriftOgVedligeholdelse();
    }

    return $result;
  }

  /**
   * Calculates expression for SamletEnergiBesparelse value
   */
  protected function calculateSamletEnergiBesparelseKrExp() {
    return $this->calculateSamletEnergiBesparelseKr(TRUE);
  }

  /**
   * @Formula("$this->calculateSamletEnergiBesparelseKrExp()")
   */
  protected function calculateSamletEnergiBesparelseKr($expression = FALSE) {
    $result = array();

    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      $result[] = $tiltag->getSamletEnergibesparelse();
    }

    return $expression ? $this->sumExpr($result) : array_sum($result);
  }

  /**
   * Accumulate over all tilvalgte Tiltag in this Rapport.
   *
   * @param callable $accumulator
   *   The accumulator.
   * @param mixed $start
   *   The start value.
   *
   * @return mixed
   *   The accumulated value.
   */
  protected function accumulate(callable $accumulator, $start = 0) {
    $value = $start;
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      $value = $accumulator($tiltag, $value);
    }
    return $value;
  }

  /**
   * Array variant of accumulate function.
   * See $this->accumulate().
   *
   * @param callable $accumulator
   *   The accumulator.
   * @param mixed $start
   *   The start value.
   *
   * @return mixed
   *   The accumulated value.
   */
  protected function accumulateArray(callable $accumulator, $start = array()) {
    $values = $start;
    foreach ($this->getTilvalgteTiltag() as $tiltag) {
      $values = $accumulator($tiltag, $values);
    }
    return $values;
  }

  /**
   * Updates baseline values;
   *
   * @param Baseline $baseline
   * @return Rapport
   */
  public function updateBaselineValues(Baseline $baseline) {
    $this->setBaselineEl($baseline->getElBaselineFastsatForEjendomKorrigeret());
    $this->setBaselineVarmeGAF($baseline->getVarmeGAFForbrugKorrigeret());
    $this->setBaselineVarmeGUF($baseline->getVarmeGUFForbrugKorrigeret());
    $this->setBaselineBraendstof($baseline->getBraendstofForbrugKorrigeret());
    $this->setBaselineStrafAfkoeling($baseline->getVarmeStrafafkoelingsafgiftKorrigeret());
    return $this;
  }

  /**
   * Updates baseline values from virksomhed rapport;
   *
   * @param VirksomhedRapport $virksomhedRapport
   * @return Rapport
   */
  public function updateBaselineValuesFromVirksomherRapport(VirksomhedRapport $virksomhedRapport) {
    $this->setBaselineEl($virksomhedRapport->getBaselineEl());
    $this->setBaselineVarmeGAF($virksomhedRapport->getBaselineVarmeGAF());
    $this->setBaselineVarmeGUF($virksomhedRapport->getBaselineVarmeGUF());
    $this->setBaselineBraendstof($virksomhedRapport->getBaselineBraendstof());
    $this->setBaselineStrafAfkoeling($virksomhedRapport->getBaselineStrafAfkoeling());
    return $this;
  }

}
