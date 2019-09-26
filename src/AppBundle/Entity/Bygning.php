<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\BygningStatusType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;
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
 * @ORM\HasLifecycleCallbacks()
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
     * @var string
     *
     * @ORM\Column(name="cvr_number", type="string", length=255, nullable=true)
     */
    private $cvrNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="ean_number", type="string", length=255, nullable=true)
     */
    private $eanNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="p_number", type="string", length=255, nullable=true)
     */
    private $pNumber;

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
   * @var integer
   *
   * @ORM\Column(name="erhvervsareal", type="integer", nullable=true)
   */
  protected $erhvervsareal;

  /**
   * @var integer
   *
   * @ORM\Column(name="opvarmetareal", type="integer", nullable=true)
   */
  protected $opvarmetareal;

  /**
   * @ORM\ManyToOne(targetEntity="Forsyningsvaerk")
   * @ORM\JoinColumn(name="vand_forsyningsvaerk_id", referencedColumnName="id")
   **/
  protected $forsyningsvaerkVand;

  /**
   * @ORM\ManyToOne(targetEntity="Forsyningsvaerk")
   * @ORM\JoinColumn(name="varme_forsyningsvaerk_id", referencedColumnName="id")
   **/
  protected $forsyningsvaerkVarme;

  /**
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
   * @var Baseline|null
   *
   * Baseline object from Virksomhed.
   **/
  protected $baseline = NULL;

  /**
   * @ManyToOne(targetEntity="Virksomhed", cascade={"persist"})
   * @JoinColumn(name="virksomhed_id", referencedColumnName="id", nullable=true)
   **/
  protected $virksomhed;

  /**
   * @Assert\NotBlank(groups={"TILKNYTTET_RAADGIVER"})
   *
   * @ManyToOne(targetEntity="User", inversedBy="ansvarlig")
   * @JoinColumn(name="aaplusansvarlig_id", referencedColumnName="id")
   **/
  protected $aaplusAnsvarlig;

  /**
   * @ManyToOne(targetEntity="User", inversedBy="projektleder")
   * @JoinColumn(name="projektleder_id", referencedColumnName="id")
   **/
  protected $projektleder;

  /**
   * @Assert\NotBlank(groups={"TILKNYTTET_RAADGIVER"})
   *
   * @ManyToMany(targetEntity="User", inversedBy="energiRaadgiver")
   * @JoinTable(name="energiraadgiver_user")
   **/
  protected $energiRaadgiver;

  /**
   * @ManyToOne(targetEntity="User", inversedBy="projekterende")
   * @JoinColumn(name="projekterende_id", referencedColumnName="id")
   **/
  protected $projekterende;

  /**
   * @ManyToMany(targetEntity="User", inversedBy="bygninger")
   * @JoinTable(name="bygning_user")
   * @JMS\Exclude
   **/
  protected $users;

  /**
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

  /**
   * Contact persons reference.
   *
   * NOTE!!! this reference is not handled by Doctrine ORM.
   *
   * @var ArrayCollection
   *
   * @Assert\NotBlank
   */
  private $contactPersons;

  public function __construct() {
    $this->users = new ArrayCollection();
    $this->contactPersons = new ArrayCollection();
    $this->energiRaadgiver = new ArrayCollection();
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
    if (!empty($this->adresse)) {
      return $this->adresse;
    }
    return strval($this->id);
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
     * Set cvrNumber
     *
     * @param string $cvrNumber
     *
     * @return Bygning
     */
    public function setCvrNumber($cvrNumber)
    {
        $this->cvrNumber = $cvrNumber;

        return $this;
    }

    /**
     * Get cvrNumber
     *
     * @return string
     */
    public function getCvrNumber()
    {
        return $this->cvrNumber;
    }

    /**
     * Set eanNumber
     *
     * @param string $eanNumber
     *
     * @return Bygning
     */
    public function setEanNumber($eanNumber)
    {
        $this->eanNumber = $eanNumber;

        return $this;
    }

    /**
     * Get eanNumber
     *
     * @return string
     */
    public function getEanNumber()
    {
        return $this->eanNumber;
    }

    /**
     * Set pNumber
     *
     * @param string $pNumber
     *
     * @return Bygning
     */
    public function setPNumber($pNumber)
    {
        $this->pNumber = $pNumber;

        return $this;
    }

    /**
     * Get pNumber
     *
     * @return string
     */
    public function getPNumber()
    {
        return $this->pNumber;
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
   * Set erhvervsareal
   *
   * @param integer $erhvervsareal
   * @return Bygning
   */
  public function setErhvervsareal($erhvervsareal) {
    $this->erhvervsareal = $erhvervsareal;

    return $this;
  }

  /**
   * Get $erhvervsareal
   *
   * @return integer
   */
  public function getErhvervsareal() {
    return $this->erhvervsareal;
  }

  /**
   * Set Opvarmetareal
   *
   * @param integer $opvarmetareal
   * @return Bygning
   */
  public function setOpvarmetareal($opvarmetareal) {
    $this->opvarmetareal = $opvarmetareal;

    return $this;
  }

  /**
   * Get opvarmetareal
   *
   * @return integer
   */
  public function getOpvarmetareal() {
    return $this->opvarmetareal;
  }

  /**
   * Get areal
   *
   * @return integer
   */
  public function getAreal() {
    return $this->getErhvervsareal();
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
   * Inherits Forsyningsvaerk reference from Virksomhed/Parent Virksomhed
   *
   * @return Forsyningsvaerk
   */
  public function getForsyningsvaerkVand($inherit = FALSE) {
    if (empty($this->forsyningsvaerkVand) && $inherit) {
      if ($this->getVirksomhed() && $this->getVirksomhed()->getForsyningsvaerkVand()) {
        return $this->getVirksomhed()->getForsyningsvaerkVand();
      }

      if ($this->getVirksomhed()
        && $this->getVirksomhed()->getParent()
        && $this->getVirksomhed()->getParent()->getForsyningsvaerkVand()
      ) {
        return $this->getVirksomhed()->getParent()->getForsyningsvaerkVand();
      }
    }

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
   * Inherits Forsyningsvaerk reference from Virksomhed/Parent Virksomhed
   *
   * @return Forsyningsvaerk
   */
  public function getForsyningsvaerkVarme($inherit = FALSE) {
    if (empty($this->forsyningsvaerkVarme) && $inherit) {
      if ($this->getVirksomhed() && $this->getVirksomhed()->getForsyningsvaerkVarme()) {
        return $this->getVirksomhed()->getForsyningsvaerkVarme();
      }

      if ($this->getVirksomhed()
        && $this->getVirksomhed()->getParent()
        && $this->getVirksomhed()->getParent()->getForsyningsvaerkVarme()
      ) {
        return $this->getVirksomhed()->getParent()->getForsyningsvaerkVarme();
      }
    }

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
   * Inherits Forsyningsvaerk reference from Virksomhed/Parent Virksomhed
   *
   * @return Forsyningsvaerk
   */
  public function getForsyningsvaerkEl($inherit = FALSE) {
    if (empty($this->forsyningsvaerkEl) && $inherit) {
      if ($this->getVirksomhed() && $this->getVirksomhed()->getForsyningsvaerkEl()) {
        return $this->getVirksomhed()->getForsyningsvaerkEl();
      }
      if ($this->getVirksomhed()
        && $this->getVirksomhed()->getParent()
        && $this->getVirksomhed()->getParent()->getForsyningsvaerkEl()
      ) {
        return $this->getVirksomhed()->getParent()->getForsyningsvaerkEl();
      }
    }

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
   * @param \AppBundle\DBAL\Types\BygningStatusType status
   *
   * @return Bygning
   */
  public function setStatus($status = NULL) {
    $this->status = $status;

    if ($status == BygningStatusType::DRIFT && $this->rapport) {
      $this->rapport->setDatoForDrift(new \DateTime());
    }

    return $this;
  }

  /**
   * Get status
   *
   * @return \AppBundle\DBAL\Types\BygningStatusType
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
   * Set Virksomhed.
   *
   * @param Virksomhed $virksomhed
   *
   * @return Bygning
   */
  public function setVirksomhed(Virksomhed $virksomhed = NULL) {
    $this->virksomhed = $virksomhed;

    return $this;
  }

  /**
   * Get bygning tilknytet Virksomhed
   *
   * @return Virksomhed
   */
  public function getVirksomhed() {
    return $this->virksomhed;
  }

  /**
   * Set Aa+ Ansvarlig
   *
   * @param \AppBundle\Entity\User user
   *
   * @return Bygning
   */
  public function setAaplusAnsvarlig(\AppBundle\Entity\User $user = NULL) {
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
   * Set Projektleder
   *
   * @param \AppBundle\Entity\User user
   *
   * @return Bygning
   */
  public function setProjektleder(\AppBundle\Entity\User $user = NULL) {
    $this->projektleder = $user;

    return $this;
  }

  /**
   * Get Projektleder
   *
   * @return \AppBundle\Entity\User
   */
  public function getProjektleder() {
    return $this->projektleder;
  }

  /**
   * Set Energirådgiver
   *
   * Collection $energiRaadgiver
   *
   * @return Bygning
   */
  public function setEnergiRaadgiver(Collection $energiRaadgiver = NULL) {
    $this->energiRaadgiver = new ArrayCollection();
    // Prevent adding duplicated references.
    foreach ($energiRaadgiver as $user) {
      if ($this->energiRaadgiver->contains($user)) {
          continue;
      }
      $this->energiRaadgiver->add($user);
    }

    return $this;
  }

  /**
   * Get Energirådgiver
   *
   * @return ArrayCollection
   */
  public function getEnergiRaadgiver() {
    return $this->energiRaadgiver;
  }

  /**
   * Get Energirådgiver
   *
   * @return string
   */
  public function getEnergiRaadgiverStr() {
    $users = array();
    foreach ($this->energiRaadgiver as $user) {
      $users[] = $user->__toString();
    }
    return implode(', ', $users);
  }

  /**
   * Set Projekterende
   *
   * @param \AppBundle\Entity\User user
   *
   * @return Bygning
   */
  public function setProjekterende(\AppBundle\Entity\User $user = NULL) {
    $this->projekterende = $user;

    return $this;
  }

  /**
   * Get Energirådgiver
   *
   * @return \AppBundle\Entity\User
   */
  public function getProjekterende() {
    return $this->projekterende;
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

  /**
   * Set contactPersons
   *
   * @param ArrayCollection $contactPersons
   *
   * @return Bygning
   */
  public function setContactPersons($contactPersons)
  {
    $this->contactPersons = $contactPersons;

    return $this;
  }

  /**
   * Get contactPersons
   *
   * @return ArrayCollection
   */
  public function getContactPersons()
  {
    return $this->contactPersons;
  }

  /**
   * Adds contact person to collection.
   *
   * @param ContactPerson $contactPerson
   */
  public function addContactPerson(ContactPerson $contactPerson)
  {
    $contactPerson->setReference($this);
    $this->contactPersons->add($contactPerson);
  }

  /**
   * Removes contact person from collection.
   *
   * @param ContactPerson $contactPerson
   */
  public function removeContactPerson(ContactPerson $contactPerson)
  {
    $this->contactPersons->removeElement($contactPerson);
  }

  /**
   * Note: This should really be done in BaseLine.postLoad, but apparently the
   * relation to Bygning is not loaded on postLoad. An issue with OneToOne
   * relations and owning side?
   *
   * @ORM\PostLoad()
   * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
   */
  public function postLoad(LifecycleEventArgs $event) {
    if ($this->getVirksomhed()) {
      $this->setBaseline($this->getVirksomhed()->getBaseline());
    }

    // Contact persons are not handled by Doctrine ORM.
    // We are loading it here.
    /** @var ContactPersonRepository $repository */
    $repository = $event->getEntityManager()
      ->getRepository(ContactPerson::class);
      $this->contactPersons = new ArrayCollection(array());
      foreach ($repository->findByEntity($this) as $contactPerson) {
        $this->contactPersons->add($contactPerson);
      }
    }

}
