<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Mapping\Index;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;

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
   * @ORM\Column(name="Ident", type="integer", nullable=true)
   */
  protected $ident;

  /**
   * @var integer
   *
   * @ORM\Column(name="Enhedsys", type="integer", nullable=true)
   */
  protected $enhedsys;

  /**
   * @var string
   *
   * @ORM\Column(name="Enhedskode", type="string", length=255, nullable=true)
   */
  protected $enhedskode;

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
   * @ORM\Column(name="Ejer", type="string", length=255, nullable=true)
   */
  protected $ejer;

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
   * @var string
   *
   * @ORM\Column(name="Maalertype", type="string", length=255, nullable=true)
   */
  protected $maalertype;

  /**
   * @ORM\ManyToOne(targetEntity="Forsyningsvaerk")
   * @ORM\JoinColumn(name="vand_forsyningsvaerk_id", referencedColumnName="id")
   **/
  protected $forsyningsvaerkVand;

  /**
   * @var string
   *
   * @ORM\Column(name="Kundenummer", type="string", length=255, nullable=true)
   */
  protected $kundenummer;

  /**
   * @var string
   *
   * @ORM\Column(name="Kode", type="string", length=255, nullable=true)
   */
  protected $kode;

  /**
   * @ORM\ManyToOne(targetEntity="Forsyningsvaerk")
   * @ORM\JoinColumn(name="varme_forsyningsvaerk_id", referencedColumnName="id")
   **/
  protected $forsyningsvaerkVarme;

  /**
   * @var string
   *
   * @ORM\Column(name="Kundenr_1", type="string", length=255, nullable=true)
   */
  protected $kundenr1;

  /**
   * @var string
   *
   * @ORM\Column(name="Kode_1", type="string", length=255, nullable=true)
   */
  protected $kode1;

  /**
   * @var string
   *
   * @ORM\Column(name="MaalerskifteAFV", type="string", length=255, nullable=true)
   */
  protected $maalerskifteAFV;

  /**
   * @var string
   *
   * @ORM\Column(name="AFVInstnr_1", type="string", length=255, nullable=true)
   */
  protected $aFVInstnr1;

  /**
   * @ORM\ManyToOne(targetEntity="Forsyningsvaerk")
   * @ORM\JoinColumn(name="el_forsyningsvaerk_id", referencedColumnName="id")
   **/
  protected $forsyningsvaerkEl;

  /**
   * @var string
   *
   * @ORM\Column(name="Instnr", type="string", length=255, nullable=true)
   */
  protected $instnr;

  /**
   * @var string
   *
   * @ORM\Column(name="Kundenr_NRGI", type="string", length=255, nullable=true)
   */
  protected $kundenrNRGI;

  /**
   * @var string
   *
   * @ORM\Column(name="internetkode", type="string", length=255, nullable=true)
   */
  protected $internetkode;

  /**
   * @var string
   *
   * @ORM\Column(name="Aftagenr", type="string", length=255, nullable=true)
   */
  protected $aftagenr;

  /**
   * @var integer
   *
   * @ORM\Column(name="Telefon", type="integer", nullable=true)
   */
  protected $telefon;

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
   * @ORM\Column(name="Kommune", type="integer", nullable=true)
   */
  protected $kommune;

  /**
   * @var integer
   *
   * @ORM\Column(name="Ejerforhold", type="integer", nullable=true)
   */
  protected $ejerforhold;

  /**
   * @var string
   *
   * @ORM\Column(name="Ansvarlig", type="string", length=255, nullable=true)
   */
  protected $ansvarlig;

  /**
   * @var string
   *
   * @ORM\Column(name="Magistrat", type="string", length=255, nullable=true)
   */
  protected $magistrat;

  /**
   * @var string
   *
   * @ORM\Column(name="Lokation", type="string", length=255, nullable=true)
   */
  protected $lokation;

  /**
   * @var string
   *
   * @ORM\Column(name="Lokationsnavn", type="string", length=255, nullable=true)
   */
  protected $lokationsnavn;

  /**
   * @var string
   *
   * @ORM\Column(name="Lederbetegnelse", type="string", length=255, nullable=true)
   */
  protected $lederbetegnelse;

  /**
   * @var string
   *
   * @ORM\Column(name="Ledersnavn", type="string", length=255, nullable=true)
   */
  protected $ledersnavn;

  /**
   * @var string
   *
   * @ORM\Column(name="Ledersmail", type="string", length=255, nullable=true)
   */
  protected $ledersmail;

  /**
   * @var string
   *
   * @ORM\Column(name="Kontakt_Notat", type="string", length=255, nullable=true)
   */
  protected $kontaktNotat;

  /**
   * @var string
   *
   * @ORM\Column(name="Stamdata_Notat", type="string", length=255, nullable=true)
   */
  protected $stamdataNotat;

  /**
   * @var string
   *
   * @ORM\Column(name="Vand_Notat", type="string", length=255, nullable=true)
   */
  protected $vandNotat;

  /**
   * @var string
   *
   * @ORM\Column(name="El_Notat", type="string", length=255, nullable=true)
   */
  protected $elNotat;

  /**
   * @var string
   *
   * @ORM\Column(name="Varme_Notat", type="string", length=255, nullable=true)
   */
  protected $varmeNotat;

  /**
   * @OneToMany(targetEntity="Rapport", mappedBy="bygning")
   * @OrderBy({"datering" = "ASC"})
   * @JMS\Exclude
   **/
  protected $rapporter;

  /**
   * @ManyToMany(targetEntity="User", inversedBy="bygninger")
   * @JoinTable(name="bygning_user")
   * @JMS\Exclude
   **/
  protected $users;

  /**
   * @ManyToOne(targetEntity="Segment", inversedBy="bygninger", fetch="EAGER")
   * @JoinColumn(name="segment_id", referencedColumnName="id")
   **/
  protected $segment;

  /**
   * @ManyToOne(targetEntity="BygningStatus", fetch="EAGER")
   * @JoinColumn(name="status_id", referencedColumnName="id")
   **/
  protected $status;


  public function __construct() {
    $this->rapporter = new ArrayCollection();
    $this->users = new ArrayCollection();
  }

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    return $this->adresse;
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
   * Set ident
   *
   * @param integer $ident
   * @return Bygning
   */
  public function setIdent($ident) {
    $this->ident = $ident;

    return $this;
  }

  /**
   * Get ident
   *
   * @return integer
   */
  public function getIdent() {
    return $this->ident;
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
   * Set enhedskode
   *
   * @param string $enhedskode
   * @return Bygning
   */
  public function setEnhedskode($enhedskode) {
    $this->enhedskode = $enhedskode;

    return $this;
  }

  /**
   * Get enhedskode
   *
   * @return string
   */
  public function getEnhedskode() {
    return $this->enhedskode;
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
   * Set kommentarer
   *
   * @param string $kommentarer
   * @return Bygning
   */
  public function setKommentarer($kommentarer) {
    $this->kommentarer = $kommentarer;

    return $this;
  }

  /**
   * Get kommentarer
   *
   * @return string
   */
  public function getKommentarer() {
    return $this->kommentarer;
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
   * Set ejer
   *
   * @param string $ejer
   * @return Bygning
   */
  public function setEjer($ejer) {
    $this->ejer = $ejer;

    return $this;
  }

  /**
   * Get ejer
   *
   * @return string
   */
  public function getEjer() {
    return $this->ejer;
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
   * Set maalertype
   *
   * @param string $maalertype
   * @return Bygning
   */
  public function setMaalertype($maalertype) {
    $this->maalertype = $maalertype;

    return $this;
  }

  /**
   * Get maalertype
   *
   * @return string
   */
  public function getMaalertype() {
    return $this->maalertype;
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
   * Set kundenummer
   *
   * @param string $kundenummer
   * @return Bygning
   */
  public function setKundenummer($kundenummer) {
    $this->kundenummer = $kundenummer;

    return $this;
  }

  /**
   * Get kundenummer
   *
   * @return string
   */
  public function getKundenummer() {
    return $this->kundenummer;
  }

  /**
   * Set kode
   *
   * @param string $kode
   * @return Bygning
   */
  public function setKode($kode) {
    $this->kode = $kode;

    return $this;
  }

  /**
   * Get kode
   *
   * @return string
   */
  public function getKode() {
    return $this->kode;
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
   * Set kundenr1
   *
   * @param string $kundenr1
   * @return Bygning
   */
  public function setKundenr1($kundenr1) {
    $this->kundenr1 = $kundenr1;

    return $this;
  }

  /**
   * Get kundenr1
   *
   * @return string
   */
  public function getKundenr1() {
    return $this->kundenr1;
  }

  /**
   * Set kode1
   *
   * @param string $kode1
   * @return Bygning
   */
  public function setKode1($kode1) {
    $this->kode1 = $kode1;

    return $this;
  }

  /**
   * Get kode1
   *
   * @return string
   */
  public function getKode1() {
    return $this->kode1;
  }

  /**
   * Set maalerskifteAFV
   *
   * @param string $maalerskifteAFV
   * @return Bygning
   */
  public function setMaalerskifteAFV($maalerskifteAFV) {
    $this->maalerskifteAFV = $maalerskifteAFV;

    return $this;
  }

  /**
   * Get maalerskifteAFV
   *
   * @return string
   */
  public function getMaalerskifteAFV() {
    return $this->maalerskifteAFV;
  }

  /**
   * Set aFVInstnr1
   *
   * @param string $aFVInstnr1
   * @return Bygning
   */
  public function setAFVInstnr1($aFVInstnr1) {
    $this->aFVInstnr1 = $aFVInstnr1;

    return $this;
  }

  /**
   * Get aFVInstnr1
   *
   * @return string
   */
  public function getAFVInstnr1() {
    return $this->aFVInstnr1;
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
   * Set instnr
   *
   * @param string $instnr
   * @return Bygning
   */
  public function setInstnr($instnr) {
    $this->instnr = $instnr;

    return $this;
  }

  /**
   * Get instnr
   *
   * @return string
   */
  public function getInstnr() {
    return $this->instnr;
  }

  /**
   * Set kundenrNRGI
   *
   * @param string $kundenrNRGI
   * @return Bygning
   */
  public function setKundenrNRGI($kundenrNRGI) {
    $this->kundenrNRGI = $kundenrNRGI;

    return $this;
  }

  /**
   * Get kundenrNRGI
   *
   * @return string
   */
  public function getKundenrNRGI() {
    return $this->kundenrNRGI;
  }

  /**
   * Set internetkode
   *
   * @param string $internetkode
   * @return Bygning
   */
  public function setInternetkode($internetkode) {
    $this->internetkode = $internetkode;

    return $this;
  }

  /**
   * Get internetkode
   *
   * @return string
   */
  public function getInternetkode() {
    return $this->internetkode;
  }

  /**
   * Set aftagenr
   *
   * @param string $aftagenr
   * @return Bygning
   */
  public function setAftagenr($aftagenr) {
    $this->aftagenr = $aftagenr;

    return $this;
  }

  /**
   * Get aftagenr
   *
   * @return string
   */
  public function getAftagenr() {
    return $this->aftagenr;
  }

  /**
   * Set telefon
   *
   * @param integer $telefon
   * @return Bygning
   */
  public function setTelefon($telefon) {
    $this->telefon = $telefon;

    return $this;
  }

  /**
   * Get telefon
   *
   * @return integer
   */
  public function getTelefon() {
    return $this->telefon;
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
   * Set kommune
   *
   * @param integer $kommune
   * @return Bygning
   */
  public function setKommune($kommune) {
    $this->kommune = $kommune;

    return $this;
  }

  /**
   * Get kommune
   *
   * @return integer
   */
  public function getKommune() {
    return $this->kommune;
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
   * Set ansvarlig
   *
   * @param string $ansvarlig
   * @return Bygning
   */
  public function setAnsvarlig($ansvarlig) {
    $this->ansvarlig = $ansvarlig;

    return $this;
  }

  /**
   * Get ansvarlig
   *
   * @return string
   */
  public function getAnsvarlig() {
    return $this->ansvarlig;
  }

  /**
   * Set magistrat
   *
   * @param string $magistrat
   * @return Bygning
   */
  public function setMagistrat($magistrat) {
    $this->magistrat = $magistrat;

    return $this;
  }

  /**
   * Get magistrat
   *
   * @return string
   */
  public function getMagistrat() {
    return $this->magistrat;
  }

  /**
   * Set lokation
   *
   * @param string $lokation
   * @return Bygning
   */
  public function setLokation($lokation) {
    $this->lokation = $lokation;

    return $this;
  }

  /**
   * Get lokation
   *
   * @return string
   */
  public function getLokation() {
    return $this->lokation;
  }

  /**
   * Set lokationsnavn
   *
   * @param string $lokationsnavn
   * @return Bygning
   */
  public function setLokationsnavn($lokationsnavn) {
    $this->lokationsnavn = $lokationsnavn;

    return $this;
  }

  /**
   * Get lokationsnavn
   *
   * @return string
   */
  public function getLokationsnavn() {
    return $this->lokationsnavn;
  }

  /**
   * Set lederbetegnelse
   *
   * @param string $lederbetegnelse
   * @return Bygning
   */
  public function setLederbetegnelse($lederbetegnelse) {
    $this->lederbetegnelse = $lederbetegnelse;

    return $this;
  }

  /**
   * Get lederbetegnelse
   *
   * @return string
   */
  public function getLederbetegnelse() {
    return $this->lederbetegnelse;
  }

  /**
   * Set ledersnavn
   *
   * @param string $ledersnavn
   * @return Bygning
   */
  public function setLedersnavn($ledersnavn) {
    $this->ledersnavn = $ledersnavn;

    return $this;
  }

  /**
   * Get ledersnavn
   *
   * @return string
   */
  public function getLedersnavn() {
    return $this->ledersnavn;
  }

  /**
   * Set ledersmail
   *
   * @param string $ledersmail
   * @return Bygning
   */
  public function setLedersmail($ledersmail) {
    $this->ledersmail = $ledersmail;

    return $this;
  }

  /**
   * Get ledersmail
   *
   * @return string
   */
  public function getLedersmail() {
    return $this->ledersmail;
  }

  /**
   * Set kontaktNotat
   *
   * @param string $kontaktNotat
   * @return Bygning
   */
  public function setKontaktNotat($kontaktNotat) {
    $this->kontaktNotat = $kontaktNotat;

    return $this;
  }

  /**
   * Get kontaktNotat
   *
   * @return string
   */
  public function getKontaktNotat() {
    return $this->kontaktNotat;
  }

  /**
   * Set stamdataNotat
   *
   * @param string $stamdataNotat
   * @return Bygning
   */
  public function setStamdataNotat($stamdataNotat) {
    $this->stamdataNotat = $stamdataNotat;

    return $this;
  }

  /**
   * Get stamdataNotat
   *
   * @return string
   */
  public function getStamdataNotat() {
    return $this->stamdataNotat;
  }

  /**
   * Set vandNotat
   *
   * @param string $vandNotat
   * @return Bygning
   */
  public function setVandNotat($vandNotat) {
    $this->vandNotat = $vandNotat;

    return $this;
  }

  /**
   * Get vandNotat
   *
   * @return string
   */
  public function getVandNotat() {
    return $this->vandNotat;
  }

  /**
   * Set elNotat
   *
   * @param string $elNotat
   * @return Bygning
   */
  public function setElNotat($elNotat) {
    $this->elNotat = $elNotat;

    return $this;
  }

  /**
   * Get elNotat
   *
   * @return string
   */
  public function getElNotat() {
    return $this->elNotat;
  }

  /**
   * Set varmeNotat
   *
   * @param string $varmeNotat
   * @return Bygning
   */
  public function setVarmeNotat($varmeNotat) {
    $this->varmeNotat = $varmeNotat;

    return $this;
  }

  /**
   * Get varmeNotat
   *
   * @return string
   */
  public function getVarmeNotat() {
    return $this->varmeNotat;
  }

  /**
   * Add rapporter
   *
   * @param \AppBundle\Entity\Rapport $rapporter
   * @return Bygning
   */
  public function addRapporter(\AppBundle\Entity\Rapport $rapporter) {
    $this->rapporter[] = $rapporter;

    return $this;
  }

  /**
   * Remove rapporter
   *
   * @param \AppBundle\Entity\Rapport $rapporter
   */
  public function removeRapporter(\AppBundle\Entity\Rapport $rapporter) {
    $this->rapporter->removeElement($rapporter);
  }

  /**
   * Get rapporter
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getRapporter() {
    return $this->rapporter;
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
  public function addUser(\AppBundle\Entity\User $user)
  {
    $this->users[] = $user;

    return $this;
  }

  /**
   * Remove user
   *
   * @param \AppBundle\Entity\User $user
   */
  public function removeUser(\AppBundle\Entity\User $user)
  {
    $this->users->removeElement($user);
  }

  /**
   * Set segment
   *
   * @param \AppBundle\Entity\Segment $segment
   *
   * @return Bygning
   */
  public function setSegment(\AppBundle\Entity\Segment $segment = null)
  {
    $this->segment = $segment;

    return $this;
  }

  /**
   * Get segment
   *
   * @return \AppBundle\Entity\Segment
   */
  public function getSegment()
  {
    return $this->segment;
  }

  /**
   * Set status
   *
   * @param \AppBundle\Entity\BygningStatus status
   *
   * @return Bygning
   */
  public function setStatus(\AppBundle\Entity\BygningStatus $status = null)
  {
    $this->status = $status;

    return $this;
  }

  /**
   * Get segment
   *
   * @return \AppBundle\Entity\BygningStatus
   */
  public function getStatus()
  {
    return $this->status;
  }
}
