<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\BygningStatusType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Mapping\Index;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Bygning
 *
 * @ORM\Table(name="Bygning",
 *    indexes={
 *      @Index(name="bygning_idx_enhedssys", columns={"Enhedsys"}),
 *      @Index(name="bygning_idx_bygid", columns={"BygId"}),
 *      @Index(name="bygning_idx_navn", columns={"Navn"}),
 *      @Index(name="bygning_idx_adresse", columns={"Adresse"}),
 *      @Index(name="bygning_idx_postnummer", columns={"Postnummer"}),
 *      @Index(name="bygning_idx_postby", columns={"PostBy"}),
 *    }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BygningRepository")
 */
class Bygning {

  use BlameableEntity;
  use TimestampableEntity;

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer", nullable=true)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var integer
   *
   * @ORM\Column(name="BygId", type="integer", nullable=true)
   */
  protected $bygId;

  /**
   * @var integer
   *
   * @ORM\Column(name="OpfoerselsAar", type="integer", nullable=true)
   */
  protected $OpfoerselsAar;

  /**
   * @var integer
   *
   * @ORM\Column(name="Enhedsys", type="integer", nullable=true)
   */
  protected $enhedsys;

  /**
   * @var string
   *
   * @ORM\Column(name="Type", type="string", length=255, nullable=true)
   */
  protected $type;

  /**
   * @var string
   *
   * @ORM\Column(name="Kommentarer", type="text", nullable=true)
   */
  protected $kommentarer;

  /**
   * @var string
   *
   * @ORM\Column(name="Adresse", type="string", length=255, nullable=true)
   */
  protected $adresse;

  /**
   * @var string
   *
   * @ORM\Column(name="Postnummer", type="string", length=4, nullable=true)
   */
  protected $postnummer;

  /**
   * @var string
   *
   * @ORM\Column(name="PostBy", type="string", length=255, nullable=true)
   */
  protected $postBy;

  /**
   * @var string
   *
   * @ORM\Column(name="Navn", type="string", length=255, nullable=true)
   */
  protected $navn;

  /**
   * @var string
   *
   * @ORM\Column(name="Afdelingsnavn", type="string", length=255, nullable=true)
   */
  protected $afdelingsnavn;

  /**
   * @var string
   *
   * @ORM\Column(name="Ejer_A", type="string", length=255, nullable=true)
   */
  protected $ejerA;

  /**
   * @var string
   *
   * @ORM\Column(name="Anvendelse", type="string", length=255, nullable=true)
   */
  protected $anvendelse;

  /**
   * @var integer
   *
   * @ORM\Column(name="Bruttoetageareal", type="integer", nullable=true)
   */
  protected $bruttoetageareal;

  /**
   * @ORM\ManyToOne(targetEntity="Forsyningsvaerk")
   * @ORM\JoinColumn(name="vand_forsyningsvaerk_id", referencedColumnName="id")
   **/
  protected $forsyningsvaerkVand;

  /**
   * @Assert\NotBlank(groups={"DATA_VERIFICERET"})
   *
   * @ORM\ManyToOne(targetEntity="Forsyningsvaerk")
   * @ORM\JoinColumn(name="varme_forsyningsvaerk_id", referencedColumnName="id")
   **/
  protected $forsyningsvaerkVarme;

  /**
   * @Assert\NotBlank(groups={"DATA_VERIFICERET"})
   *
   * @ORM\ManyToOne(targetEntity="Forsyningsvaerk")
   * @ORM\JoinColumn(name="el_forsyningsvaerk_id", referencedColumnName="id")
   **/
  protected $forsyningsvaerkEl;

  /**
   * @var string
   *
   * @ORM\Column(name="Divisionnavn", type="string", length=255, nullable=true)
   */
  protected $divisionnavn;

  /**
   * @var string
   *
   * @ORM\Column(name="Omraadenavn", type="string", length=255, nullable=true)
   */
  protected $omraadenavn;

  /**
   * @var integer
   *
   * @ORM\Column(name="Ejerforhold", type="integer", nullable=true)
   */
  protected $ejerforhold;

  /**
   * @OneToOne(targetEntity="Rapport", mappedBy="bygning", cascade={"persist"})
   * @JMS\Exclude
   **/
  protected $rapport;

  /**
   * @OneToOne(targetEntity="Baseline", mappedBy="bygning", cascade={"persist"})
   * @JMS\Exclude
   **/
  protected $baseline;

  /**
   * @Assert\NotBlank(groups={"TILKNYTTET_RAADGIVER"})
   *
   * @ManyToOne(targetEntity="User", inversedBy="ansvarlig")
   * @JoinColumn(name="aaplusansvarlig_id", referencedColumnName="id")
   **/
  protected $aaplusAnsvarlig;

  /**
   * @Assert\NotBlank(groups={"TILKNYTTET_RAADGIVER"})
   *
   * @ManyToOne(targetEntity="User", inversedBy="energiRaadgiver")
   * @JoinColumn(name="energiraadgiver_id", referencedColumnName="id")
   **/
  protected $energiRaadgiver;

  /**
   * @ManyToMany(targetEntity="User", inversedBy="bygninger")
   * @JoinTable(name="bygning_user")
   * @JMS\Exclude
   **/
  protected $users;

  /**
   * @Assert\NotBlank(groups={"DATA_VERIFICERET"})
   *
   * @ManyToOne(targetEntity="Segment", inversedBy="bygninger")
   * @JoinColumn(name="segment_id", referencedColumnName="id", nullable=true)
   **/
  protected $segment;

  /**
   * @var string
   *
   * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\BygningStatusType")
   * @ORM\Column(name="status", type="BygningStatusType")
   **/
  protected $status = BygningStatusType::IKKE_STARTET;


  public function __construct() {
    $this->users = new ArrayCollection();
  }

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    if (!empty($this->navn)) {
      return $this->navn;
    }
    else {
      return $this->adresse;
    }

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
   * Set bygId
   *
   * @param integer $bygId
   * @return Bygning
   */
  public function setBygId($bygId) {
    $this->bygId = $bygId;

    return $this;
  }

  /**
   * Get bygId
   *
   * @return integer
   */
  public function getBygId() {
    return $this->bygId;
  }

  /**
   * Set OpfoerselsAar
   *
   * @param integer OpfoerselsAar
   * @return Bygning
   */
  public function setOpfoerselsAar($OpfoerselsAar) {
    $this->OpfoerselsAar = $OpfoerselsAar;

    return $this;
  }

  /**
   * Get OpfoerselsAar
   *
   * @return integer
   */
  public function getOpfoerselsAar() {
    return $this->OpfoerselsAar;
  }

  /**
   * Set enhedsys
   *
   * @param integer $enhedsys
   * @return Bygning
   */
  public function setEnhedsys($enhedsys) {
    $this->enhedsys = $enhedsys;

    return $this;
  }

  /**
   * Get enhedsys
   *
   * @return integer
   */
  public function getEnhedsys() {
    return $this->enhedsys;
  }

  /**
   * Set type
   *
   * @param string $type
   * @return Bygning
   */
  public function setType($type) {
    $this->type = $type;

    return $this;
  }

  /**
   * Get type
   *
   * @return string
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Set adresse
   *
   * @param string $adresse
   * @return Bygning
   */
  public function setAdresse($adresse) {
    $this->adresse = $adresse;

    return $this;
  }

  /**
   * Get adresse
   *
   * @return string
   */
  public function getAdresse() {
    return $this->adresse;
  }

  /**
   * Set postnummer
   *
   * @param string $postnummer
   * @return Bygning
   */
  public function setPostnummer($postnummer) {
    $this->postnummer = $postnummer;

    return $this;
  }

  /**
   * Get postnummer
   *
   * @return string
   */
  public function getPostnummer() {
    return $this->postnummer;
  }

  /**
   * Set postBy
   *
   * @param string $postBy
   * @return Bygning
   */
  public function setPostBy($postBy) {
    $this->postBy = $postBy;

    return $this;
  }

  /**
   * Get postBy
   *
   * @return string
   */
  public function getPostBy() {
    return $this->postBy;
  }

  /**
   * Set navn
   *
   * @param string $navn
   * @return Bygning
   */
  public function setNavn($navn) {
    $this->navn = $navn;

    return $this;
  }

  /**
   * Get navn
   *
   * @return string
   */
  public function getNavn() {
    return $this->navn;
  }

  /**
   * Set afdelingsnavn
   *
   * @param string $afdelingsnavn
   * @return Bygning
   */
  public function setAfdelingsnavn($afdelingsnavn) {
    $this->afdelingsnavn = $afdelingsnavn;

    return $this;
  }

  /**
   * Get afdelingsnavn
   *
   * @return string
   */
  public function getAfdelingsnavn() {
    return $this->afdelingsnavn;
  }

  /**
   * Set ejerA
   *
   * @param string $ejerA
   * @return Bygning
   */
  public function setEjerA($ejerA) {
    $this->ejerA = $ejerA;

    return $this;
  }

  /**
   * Get ejerA
   *
   * @return string
   */
  public function getEjerA() {
    return $this->ejerA;
  }

  /**
   * Set anvendelse
   *
   * @param string $anvendelse
   * @return Bygning
   */
  public function setAnvendelse($anvendelse) {
    $this->anvendelse = $anvendelse;

    return $this;
  }

  /**
   * Get anvendelse
   *
   * @return string
   */
  public function getAnvendelse() {
    return $this->anvendelse;
  }

  /**
   * Set bruttoetageareal
   *
   * @param integer $bruttoetageareal
   * @return Bygning
   */
  public function setBruttoetageareal($bruttoetageareal) {
    $this->bruttoetageareal = $bruttoetageareal;

    return $this;
  }

  /**
   * Get bruttoetageareal
   *
   * @return integer
   */
  public function getBruttoetageareal() {
    return $this->bruttoetageareal;
  }

  /**
   * Set forsyningsvaerkVand
   *
   * @param Forsyningsvaerk $forsyningsvaerkVand
   * @return Bygning
   */
  public function setForsyningsvaerkVand($forsyningsvaerkVand) {
    $this->forsyningsvaerkVand = $forsyningsvaerkVand;

    return $this;
  }

  /**
   * Get forsyningsvaerkVand
   *
   * @return Forsyningsvaerk
   */
  public function getForsyningsvaerkVand() {
    return $this->forsyningsvaerkVand;
  }

  /**
   * Set forsyningsvaerkVarme
   *
   * @param Forsyningsvaerk $forsyningsvaerkVarme
   * @return Bygning
   */
  public function setForsyningsvaerkVarme($forsyningsvaerkVarme) {
    $this->forsyningsvaerkVarme = $forsyningsvaerkVarme;

    return $this;
  }

  /**
   * Get forsyningsvaerkVarme
   *
   * @return Forsyningsvaerk
   */
  public function getForsyningsvaerkVarme() {
    return $this->forsyningsvaerkVarme;
  }

  /**
   * Set forsyningsvaerkEl
   *
   * @param Forsyningsvaerk $forsyningsvaerkEl
   * @return Bygning
   */
  public function setForsyningsvaerkEl($forsyningsvaerkEl) {
    $this->forsyningsvaerkEl = $forsyningsvaerkEl;

    return $this;
  }

  /**
   * Get forsyningsvaerkEl
   *
   * @return Forsyningsvaerk
   */
  public function getForsyningsvaerkEl() {
    return $this->forsyningsvaerkEl;
  }

  /**
   * Set divisionnavn
   *
   * @param string $divisionnavn
   * @return Bygning
   */
  public function setDivisionnavn($divisionnavn) {
    $this->divisionnavn = $divisionnavn;

    return $this;
  }

  /**
   * Get divisionnavn
   *
   * @return string
   */
  public function getDivisionnavn() {
    return $this->divisionnavn;
  }

  /**
   * Set omraadenavn
   *
   * @param string $omraadenavn
   * @return Bygning
   */
  public function setOmraadenavn($omraadenavn) {
    $this->omraadenavn = $omraadenavn;

    return $this;
  }

  /**
   * Get omraadenavn
   *
   * @return string
   */
  public function getOmraadenavn() {
    return $this->omraadenavn;
  }

  /**
   * Set ejerforhold
   *
   * @param integer $ejerforhold
   * @return Bygning
   */
  public function setEjerforhold($ejerforhold) {
    $this->ejerforhold = $ejerforhold;

    return $this;
  }

  /**
   * Get ejerforhold
   *
   * @return integer
   */
  public function getEjerforhold() {
    return $this->ejerforhold;
  }

  /**
   * Set users
   */
  public function setUsers(\Doctrine\Common\Collections\Collection $users) {
    $this->users = $users;

    return $this;
  }

  /**
   * Get users
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getUsers() {
    return $this->users;
  }

  /**
   * Add user
   *
   * @param \AppBundle\Entity\User $user
   *
   * @return Bygning
   */
  public function addUser(\AppBundle\Entity\User $user) {
    $this->users[] = $user;

    return $this;
  }

  /**
   * Remove user
   *
   * @param \AppBundle\Entity\User $user
   */
  public function removeUser(\AppBundle\Entity\User $user) {
    $this->users->removeElement($user);
  }

  /**
   * Set segment
   *
   * @param \AppBundle\Entity\Segment $segment
   *
   * @return Bygning
   */
  public function setSegment(\AppBundle\Entity\Segment $segment = NULL) {
    $this->segment = $segment;

    return $this;
  }

  /**
   * Get segment
   *
   * @return \AppBundle\Entity\Segment
   */
  public function getSegment() {
    return $this->segment;
  }

  /**
   * Set status
   *
   * @param \AppBundle\Entity\BygningStatus status
   *
   * @return Bygning
   */
  public function setStatus($status = NULL) {
    $this->status = $status;

    return $this;
  }

  /**
   * Get status
   *
   * @return \AppBundle\Entity\BygningStatus
   */
  public function getStatus() {
    return $this->status;
  }

  /**
   * Get nummeric status i.e. the first char from the status
   *
   * @return string
   */
  public function getNummericStatus() {
    return substr($this->status, 0, 1);
  }

  /**
   * Set Aa+ Ansvarlig
   *
   * @param \AppBundle\Entity\User user
   *
   * @return Bygning
   */
  public function setAaplusAnsvarlig(\AppBundle\Entity\User $user = NULL) {
    if ($this->aaplusAnsvarlig !== NULL) {
      $this->removeUser($this->aaplusAnsvarlig);
    }

    if ($user && !$this->getUsers()->contains($user)) {
      $this->addUser($user);
    }

    $this->aaplusAnsvarlig = $user;

    return $this;
  }

  /**
   * Get Aa+ Ansvarlig
   *
   * @return \AppBundle\Entity\User
   */
  public function getAaplusAnsvarlig() {
    return $this->aaplusAnsvarlig;
  }

  /**
   * Set Energirådgiver
   *
   * @param \AppBundle\Entity\User user
   *
   * @return Bygning
   */
  public function setEnergiRaadgiver(\AppBundle\Entity\User $user = NULL) {
    if ($this->energiRaadgiver) {
      $this->removeUser($this->energiRaadgiver);
    }

    if ($user && !$this->getUsers()->contains($user)) {
      $this->addUser($user);
    }

    $this->energiRaadgiver = $user;

    return $this;
  }

  /**
   * Get Energirådgiver
   *
   * @return \AppBundle\Entity\User
   */
  public function getEnergiRaadgiver() {
    return $this->energiRaadgiver;
  }

  /**
   * Set rapport
   *
   * @param \AppBundle\Entity\Rapport $rapport
   *
   * @return Bygning
   */
  public function setRapport(\AppBundle\Entity\Rapport $rapport = NULL) {
    $this->rapport = $rapport;
    if($rapport !== null) {
      $rapport->setBygning($this);
    }

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
   * @return string
   */
  public function getKommentarer() {
    return $this->kommentarer;
  }

  /**
   * @param string $kommentarer
   */
  public function setKommentarer($kommentarer) {
    $this->kommentarer = $kommentarer;
  }

  /**
   * @return mixed
   */
  public function getBaseline() {
    return $this->baseline;
  }

  /**
   * @param mixed $baseline
   */
  public function setBaseline($baseline) {
    $this->baseline = $baseline;
  }
}
