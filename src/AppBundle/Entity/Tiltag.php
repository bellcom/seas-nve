<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\InheritanceType;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;

/**
 * Tiltag
 *
 * @ORM\Table()
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *    "pumpe" = "PumpeTiltag",
 *    "special" = "SpecialTiltag",
 *    "belysning" = "BelysningTiltag",
 *    "klimaskærm" = "KlimaskaermTiltag",
 *    "tekniskisolering" = "TekniskIsoleringTiltag",
 *    "solcelle" = "SolcelleTiltag",
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TiltagRepository")
 * @JMS\Discriminator(field = "_discr", map = {
 *    "pumpe": "AppBundle\Entity\PumpeTiltag",
 *    "special": "AppBundle\Entity\SpecialTiltag",
 *    "belysning": "AppBundle\Entity\BelysningTiltag",
 *    "klimaskærm" = "AppBundle\Entity\KlimaskaermTiltag",
 *    "tekniskisolering" = "AppBundle\Entity\TekniskIsoleringTiltag",
 *    "solcelle" = "AppBundle\Entity\SolcelleTiltag",
 * })
 */
abstract class Tiltag {
  use TimestampableEntity;

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="Title", type="string", length=255, nullable=true)
   */
  private $title;

  /**
   * @var float
   *
   * @ORM\Column(name="VarmebesparelseGUF", type="float", nullable=true)
   */
  private $varmebesparelseGUF;

  /**
   * @var float
   *
   * @ORM\Column(name="VarmebesparelseGAF", type="float", nullable=true)
   */
  private $varmebesparelseGAF;

  /**
   * @var float
   *
   * @ORM\Column(name="Elbesparelse", type="float", nullable=true)
   */
  private $elbesparelse;

  /**
   * @var float
   *
   * @ORM\Column(name="Vandbesparelse", type="float", nullable=true)
   */
  private $vandbesparelse;

  /**
   * @var float
   *
   * @ORM\Column(name="EnergibesparelseAarEt", type="float", nullable=true)
   */
  private $energibesparelseAarEt;

  /**
   * @var float
   *
   * @ORM\Column(name="CO2besparelseAarEt", type="float", nullable=true)
   */
  private $co2besparelseAarEt;

  /**
   * @var integer
   *
   * @ORM\Column(name="AntalReinvesteringer", type="integer", nullable=true)
   */
  private $antalReinvesteringer;

  /**
   * @var integer
   *
   * @ORM\Column(name="FaktorForReinvesteringer", type="integer", nullable=true)
   */
  private $faktorForReinvesteringer;

  /**
   * @var string
   *
   * @ORM\Column(name="PrimaerEnterprise", type="string", length=50, nullable=true)
   */
  private $primaerEnterprise;

  /**
   * @var string
   *
   * @ORM\Column(name="Tiltagskategori", type="string", length=50, nullable=true)
   */
  private $tiltagskategori;

  /**
   * @var string
   *
   * @ORM\Column(name="AnlaegsInvestering", type="decimal", nullable=true)
   */
  private $anlaegsInvestering;

  /**
   * @var string
   *
   * @ORM\Column(name="DVBesparelse", type="decimal", nullable=true)
   */
  private $dVBesparelse;

  /**
   * @var string
   *
   * @ORM\Column(name="Levetid", type="decimal", nullable=true)
   */
  private $levetid;

  /**
   * @var string
   *
   * @ORM\Column(name="ForsyningVarme", type="string", length=50, nullable=true)
   */
  private $forsyningVarme;

  /**
   * @var string
   *
   * @ORM\Column(name="ForsyningEl", type="string", length=50, nullable=true)
   */
  private $forsyningEl;

  /**
   * @var string
   *
   * @ORM\Column(name="BeskrivelseNuvaerende", type="text", nullable=true)
   */
  private $beskrivelseNuvaerende;

  /**
   * @var string
   *
   * @ORM\Column(name="BeskrivelseForslag", type="text", nullable=true)
   */
  private $beskrivelseForslag;

  /**
   * @var string
   *
   * @ORM\Column(name="BeskrivelseOevrige", type="text", nullable=true)
   */
  private $beskrivelseOevrige;

  /**
   * @var string
   *
   * @ORM\Column(name="Risikovurdering", type="string", length=10, nullable=true)
   */
  private $risikovurdering;

  /**
   * @var string
   *
   * @ORM\Column(name="Placering", type="string", length=255, nullable=true)
   */
  private $placering;

  /**
   * @var string
   *
   * @ORM\Column(name="BeskrivelseBV", type="text", nullable=true)
   */
  private $beskrivelseBV;

  /**
   * @var string
   *
   * @ORM\Column(name="Indeklima", type="text", nullable=true)
   */
  private $indeklima;

  /**
   * @var Rapport
   *
   * @ManyToOne(targetEntity="Rapport", inversedBy="tiltag")
   * @JoinColumn(name="rapport_id", referencedColumnName="id")
   **/
  private $rapport;

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    return $this->title;
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
   * Set title
   *
   * @param string $title
   * @return Tiltag
   */
  public function setTitle($title) {
    $this->title = $title;

    return $this;
  }

  /**
   * Get title
   *
   * @return string
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * Set vandbesparelse
   *
   * @param float $vandbesparelse
   * @return Tiltag
   */
  public function setVandbesparelse($vandbesparelse) {
    $this->vandbesparelse = $vandbesparelse;

    return $this;
  }

  /**
   * Get vandbesparelse
   *
   * @return float
   */
  public function getVandbesparelse() {
    return $this->vandbesparelse;
  }

  /**
   * Set faktorForReinvesteringer
   *
   * @param integer $faktorForReinvesteringer
   * @return Tiltag
   */
  public function setFaktorForReinvesteringer($faktorForReinvesteringer) {
    $this->faktorForReinvesteringer = $faktorForReinvesteringer;

    return $this;
  }

  /**
   * Get faktorForReinvesteringer
   *
   * @return integer
   */
  public function getFaktorForReinvesteringer() {
    return $this->faktorForReinvesteringer;
  }

  /**
   * Set primaerEnterprise
   *
   * @param string $primaerEnterprise
   * @return Tiltag
   */
  public function setPrimaerEnterprise($primaerEnterprise) {
    $this->primaerEnterprise = $primaerEnterprise;

    return $this;
  }

  /**
   * Get primaerEnterprise
   *
   * @return string
   */
  public function getPrimaerEnterprise() {
    return $this->primaerEnterprise;
  }

  /**
   * Set tiltagskategori
   *
   * @param string $tiltagskategori
   * @return Tiltag
   */
  public function setTiltagskategori($tiltagskategori) {
    $this->tiltagskategori = $tiltagskategori;

    return $this;
  }

  /**
   * Get tiltagskategori
   *
   * @return string
   */
  public function getTiltagskategori() {
    return $this->tiltagskategori;
  }

  /**
   * Set anlaegsInvestering
   *
   * @param string $anlaegsInvestering
   * @return Tiltag
   */
  public function setAnlaegsInvestering($anlaegsInvestering) {
    $this->anlaegsInvestering = $anlaegsInvestering;

    return $this;
  }

  /**
   * Get anlaegsInvestering
   *
   * @return string
   */
  public function getAnlaegsInvestering() {
    return $this->anlaegsInvestering;
  }

  /**
   * Set dVBesparelse
   *
   * @param string $dVBesparelse
   * @return Tiltag
   */
  public function setDVBesparelse($dVBesparelse) {
    $this->dVBesparelse = $dVBesparelse;

    return $this;
  }

  /**
   * Get dVBesparelse
   *
   * @return string
   */
  public function getDVBesparelse() {
    return $this->dVBesparelse;
  }

  /**
   * Set levetid
   *
   * @param string $levetid
   * @return Tiltag
   */
  public function setLevetid($levetid) {
    $this->levetid = $levetid;

    return $this;
  }

  /**
   * Get levetid
   *
   * @return string
   */
  public function getLevetid() {
    return $this->levetid;
  }

  /**
   * Set forsyningVarme
   *
   * @param string $forsyningVarme
   * @return Tiltag
   */
  public function setForsyningVarme($forsyningVarme) {
    $this->forsyningVarme = $forsyningVarme;

    return $this;
  }

  /**
   * Get forsyningVarme
   *
   * @return string
   */
  public function getForsyningVarme() {
    return $this->forsyningVarme;
  }

  /**
   * Set forsyningEl
   *
   * @param string $forsyningEl
   * @return Tiltag
   */
  public function setForsyningEl($forsyningEl) {
    $this->forsyningEl = $forsyningEl;

    return $this;
  }

  /**
   * Get forsyningEl
   *
   * @return string
   */
  public function getForsyningEl() {
    return $this->forsyningEl;
  }

  /**
   * Set beskrivelseNuvaerende
   *
   * @param string $beskrivelseNuvaerende
   * @return Tiltag
   */
  public function setBeskrivelseNuvaerende($beskrivelseNuvaerende) {
    $this->beskrivelseNuvaerende = $beskrivelseNuvaerende;

    return $this;
  }

  /**
   * Get beskrivelseNuvaerende
   *
   * @return string
   */
  public function getBeskrivelseNuvaerende() {
    return $this->beskrivelseNuvaerende;
  }

  /**
   * Set beskrivelseForslag
   *
   * @param string $beskrivelseForslag
   * @return Tiltag
   */
  public function setBeskrivelseForslag($beskrivelseForslag) {
    $this->beskrivelseForslag = $beskrivelseForslag;

    return $this;
  }

  /**
   * Get beskrivelseForslag
   *
   * @return string
   */
  public function getBeskrivelseForslag() {
    return $this->beskrivelseForslag;
  }

  /**
   * Set beskrivelseOevrige
   *
   * @param string $beskrivelseOevrige
   * @return Tiltag
   */
  public function setBeskrivelseOevrige($beskrivelseOevrige) {
    $this->beskrivelseOevrige = $beskrivelseOevrige;

    return $this;
  }

  /**
   * Get beskrivelseOevrige
   *
   * @return string
   */
  public function getBeskrivelseOevrige() {
    return $this->beskrivelseOevrige;
  }

  /**
   * Set risikovurdering
   *
   * @param string $risikovurdering
   * @return Tiltag
   */
  public function setRisikovurdering($risikovurdering) {
    $this->risikovurdering = $risikovurdering;

    return $this;
  }

  /**
   * Get risikovurdering
   *
   * @return string
   */
  public function getRisikovurdering() {
    return $this->risikovurdering;
  }

  /**
   * Set placering
   *
   * @param string $placering
   * @return Tiltag
   */
  public function setPlacering($placering) {
    $this->placering = $placering;

    return $this;
  }

  /**
   * Get placering
   *
   * @return string
   */
  public function getPlacering() {
    return $this->placering;
  }

  /**
   * Set beskrivelseBV
   *
   * @param string $beskrivelseBV
   * @return Tiltag
   */
  public function setBeskrivelseBV($beskrivelseBV) {
    $this->beskrivelseBV = $beskrivelseBV;

    return $this;
  }

  /**
   * Get beskrivelseBV
   *
   * @return string
   */
  public function getBeskrivelseBV() {
    return $this->beskrivelseBV;
  }

  /**
   * Set indeklima
   *
   * @param string $indeklima
   * @return Tiltag
   */
  public function setIndeklima($indeklima) {
    $this->indeklima = $indeklima;

    return $this;
  }

  /**
   * Get indeklima
   *
   * @return string
   */
  public function getIndeklima() {
    return $this->indeklima;
  }

  /**
   * Set rapport
   *
   * @param \AppBundle\Entity\Rapport $rapport
   * @return Tiltag
   */
  public function setRapport(Rapport $rapport = NULL) {
    $this->rapport = $rapport;

    return $this;
  }

  /**
   * Get rapport
   *
   * @return \AppBundle\Entity\Rapport
   */
  public function getRapport() {
    return $this->rapport;
  }

  /**
   * Set varmebesparelseGUF;
   *
   * @param float $varmebesparelseGUF;
   * @return Tiltag
   */
  public function setVarmebesparelseGUF($varmebesparelseGUF) {
    $this->varmebesparelseGUF = $varmebesparelseGUF;

    return $this;
  }

  /**
   * Get varmebesparelseGUF;
   *
   * @return float
   */
  public function getVarmebesparelseGUF() {
    return $this->varmebesparelseGUF;
  }

  /**
   * Set varmebesparelseGAF
   *
   * @param float $varmebesparelseGAF
   * @return Tiltag
   */
  public function setVarmebesparelseGAF($varmebesparelseGAF) {
    $this->varmebesparelseGAF = $varmebesparelseGAF;

    return $this;
  }

  /**
   * Get varmebesparelseGAF
   *
   * @return float
   */
  public function getVarmebesparelseGAF() {
    return $this->varmebesparelseGAF;
  }

  /**
   * Set elbesparelse
   *
   * @param float $elbesparelse
   * @return Tiltag
   */
  public function setElbesparelse($elbesparelse) {
    $this->elbesparelse = $elbesparelse;

    return $this;
  }

  /**
   * Get elbesparelse
   *
   * @return float
   */
  public function getElbesparelse() {
    return $this->elbesparelse;
  }

  /**
   * Set energibesparelseAarEt
   *
   * @param float $energibesparelseAarEt
   * @return Tiltag
   */
  public function setEnergibesparelseAarEt($energibesparelseAarEt) {
    $this->energibesparelseAarEt = $energibesparelseAarEt;

    return $this;
  }

  /**
   * Get energibesparelseAarEt
   *
   * @return float
   */
  public function getEnergibesparelseAarEt() {
    return $this->energibesparelseAarEt;
  }

  /**
   * Set co2besparelseAarEt
   *
   * @param float $co2besparelseAarEt
   * @return Tiltag
   */
  public function setCo2besparelseAarEt($co2besparelseAarEt) {
    $this->co2besparelseAarEt = $co2besparelseAarEt;

    return $this;
  }

  /**
   * Get co2besparelseAarEt
   *
   * @return float
   */
  public function getCo2besparelseAarEt() {
    return $this->co2besparelseAarEt;
  }

  /**
   * Set antalReinvesteringer
   *
   * @param integer $antalReinvesteringer
   * @return Tiltag
   */
  public function setAntalReinvesteringer($antalReinvesteringer) {
    $this->antalReinvesteringer = $antalReinvesteringer;

    return $this;
  }

  /**
   * Get antalReinvesteringer
   *
   * @return integer
   */
  public function getAntalReinvesteringer() {
    return $this->antalReinvesteringer;
  }

  /**
   * @var ArrayCollection
   *
   * @OneToMany(targetEntity="TiltagDetail", mappedBy="tiltag", cascade={"persist", "remove"})
   * @OrderBy({"createdAt" = "ASC"})
   * @JMS\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\TiltagDetail>")
   */
  private $details;

  /**
   * Add a TiltagDetail to this Tiltag
   *
   * @param TiltagDetail $detail
   * @return Tiltag
   */
  public function addDetail(TiltagDetail $detail) {
    if (!$this->details->contains($detail)) {
      $this->details->add($detail);
      $this->compute();
    }

    return $this;
  }

  /**
   * Remove a TiltagDetail from this Tiltag
   *
   * @param TiltagDetail $detail
   * @return Tiltag
   */
  public function removeDetail(TiltagDetail $detail) {
    if ($this->details->contains($detail)) {
      $this->details->removeElement($detail);
      $this->compute();
    }

    return $this;
  }

  /**
   * @param \Doctrine\Common\Collections\ArrayCollection $details
   * @return Tiltag
   */
  public function setDetails(ArrayCollection $details) {
    $this->details = $details;

    return $this;
  }

  /**
   * @return \Doctrine\Common\Collections\ArrayCollection
   */
  public function getDetails() {
    return $this->details;
  }

  /**
   * Compute values in this Tiltag
   *
   * @return bool
   */
  public function compute() {
    return false;
  }

  public function __construct() {
    $this->details = new \Doctrine\Common\Collections\ArrayCollection();
  }

}
