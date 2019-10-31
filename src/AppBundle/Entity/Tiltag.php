<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Annotations\Formula;
use AppBundle\Calculation\Calculation;
use AppBundle\DBAL\Types\PrimaerEnterpriseType;
use AppBundle\DBAL\Types\SlutanvendelseType;
use AppBundle\Entity\Traits\FormulableCalculationEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OrderBy;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

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
 *    "vindue" = "VindueTiltag",
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
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Tiltag {
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
   * @var SlutanvendelseType
   *
   * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\SlutanvendelseType")
   * @ORM\Column(name="slutanvendelse", type="SlutanvendelseType", nullable=true)
   **/
  protected $slutanvendelse;

  /**
   * @var boolean
   *
   * @ORM\Column(name="tilvalgtAfRaadgiver", type="boolean")
   */
  protected $tilvalgtAfRaadgiver = TRUE;

  /**
   * @var boolean
   *
   * @ORM\Column(name="tilvalgtAfAaPlus", type="boolean", nullable=true)
   */
  protected $tilvalgtAfAaPlus = TRUE;

  /**
   * @var boolean
   *
   * @ORM\Column(name="tilvalgtAfMagistrat", type="boolean", nullable=true)
   */
  protected $tilvalgtAfMagistrat = TRUE;

  /**
   * @var string
   *
   * This is: Begrundelse Aa+
   *
   * @ORM\Column(name="tilvalgtbegrundelse", type="text", nullable=true)
   */
  protected $tilvalgtbegrundelse;

  /**
   * @var string
   *
   * @ORM\Column(name="tilvalgtBegrundelseMagistrat", type="text", nullable=true)
   */
  protected $tilvalgtBegrundelseMagistrat;

  /**
   * @var string
   *
   * @ORM\Column(name="title", type="string", length=255, nullable=true)
   */
  protected $title;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmebesparelseGUF", type="float", nullable=true)
   */
  protected $varmebesparelseGUF;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmebesparelseGAF", type="float", nullable=true)
   */
  protected $varmebesparelseGAF;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="elbesparelse", type="float", nullable=true)
   */
  protected $elbesparelse;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="vandbesparelse", type="float", nullable=true)
   */
  protected $vandbesparelse;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="samletEnergibesparelse", type="float", nullable=true)
   */
  protected $samletEnergibesparelse;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="samletCo2besparelse", type="float", nullable=true)
   */
  protected $samletCo2besparelse;

  /**
   * @var float
   *
   * @Calculated
   * @Formula("($this->varmebesparelseGAF + $this->varmebesparelseGUF + $this->elbesparelse) * $this->getPrioriteringsfaktor() * $this->getTilskudsstoerrelse()")
   * @ORM\Column(name="samletTilskud", type="float", nullable=true)
   */
  protected $samletTilskud;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="besparelseAarEt", type="float", scale=4, nullable=true)
   */
  protected $besparelseAarEt;

  /**
   * @var integer
   *
   * @Calculated
   * @ORM\Column(name="antalReinvesteringer", type="integer", nullable=true)
   */
  protected $antalReinvesteringer;

  /**
   * @var integer
   *
   * @ORM\Column(name="faktorForReinvesteringer", type="integer", nullable=true)
   */
  protected $faktorForReinvesteringer = 1;

  /**
   * @var float
   *
   * @ORM\Column(name="prioriteringsfaktor", type="float")
   */
  protected $prioriteringsfaktor = 1;

  /**
   * @var float
   *
   * @ORM\Column(name="konverteringsfaktorFoer", type="float")
   */
  protected $konverteringsfaktorFoer = 1;

  /**
   * @var float
   *
   * @ORM\Column(name="konverteringsfaktorEfter", type="float")
   */
  protected $konverteringsfaktorEfter = 1;

  /**
   * @var float
   *
   * @ORM\Column(name="forbrugFoer", type="integer", nullable=true)
   */
  protected $forbrugFoer = 0;

  /**
   * @var float
   *
   * @ORM\Column(name="forbrugEfter", type="integer", nullable=true)
   */
  protected $forbrugEfter = 0;

  /**
   * Enterprisesum
   *
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="anlaegsinvestering", type="float", nullable=true)
   */
  protected $anlaegsinvestering;

  /**
   * Enterprisesum (beregnet)
   *
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="anlaegsinvestering_beregnet", type="float", nullable=true)
   */
  protected $anlaegsinvestering_beregnet;

  /**
   * Enterprisesum ex. risiko
   *
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="anlaegsinvesteringExRisiko", type="float", nullable=true)
   */
  protected $anlaegsinvesteringExRisiko = 0;

  /**
   * @var float
   *
   * @ORM\Column(name="opstartsomkostninger", type="decimal", nullable=true)
   */
  protected $opstartsomkostninger = 0;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="reelAnlaegsinvestering", type="float", nullable=true)
   */
  protected $reelAnlaegsinvestering = 0;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="besparelseDriftOgVedligeholdelse", type="float", nullable=true)
   */
  protected $besparelseDriftOgVedligeholdelse = 0;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="besparelseStrafafkoelingsafgift", type="float", nullable=true)
   */
  protected $besparelseStrafafkoelingsafgift = 0;

  /**
   * @var float
   *
   * @ORM\Column(name="levetid", type="decimal")
   */
  protected $levetid = 10;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="simpelTilbagebetalingstidAar", type="float", nullable=true)
   */
  protected $simpelTilbagebetalingstidAar;

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
   * @ORM\Column(name="scrapvaerdi", type="float", nullable=true)
   */
  protected $scrapvaerdi;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="aaplusInvestering", type="float", nullable=true)
   */
  protected $aaplusInvestering;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="reinvestering", type="float", nullable=true)
   */
  protected $reinvestering;

  /**
   * @var string
   *
   * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\PrimaerEnterpriseType")
   * @ORM\Column(name="primaerEnterprise", type="PrimaerEnterpriseType")
   */
  protected $primaerEnterprise = PrimaerEnterpriseType::NONE;

  /**
   * @ManyToOne(targetEntity="TiltagsKategori")
   * @JoinColumn(name="kategori_id", referencedColumnName="id")
   **/
  protected $tiltagskategori;

  /**
   * @var Energiforsyning
   *
   * @ManyToOne(targetEntity="Energiforsyning")
   * @JoinColumn(name="varme_energiforsyning_id", referencedColumnName="id")
   */
  protected $forsyningVarme;

  /**
   * @var Energiforsyning
   *
   * @ManyToOne(targetEntity="Energiforsyning")
   * @JoinColumn(name="el_energiforsyning_id", referencedColumnName="id")
   */
  protected $forsyningEl;

  /**
   * @var string
   *
   * @ORM\Column(name="beskrivelseNuvaerende", type="text", nullable=true)
   *
   * @Assert\Length(
   *  max = 10000,
   *  maxMessage = "maxLength"
   * )
   */
  protected $beskrivelseNuvaerende;

  /**
   * @var string
   *
   * @ORM\Column(name="beskrivelseForslag", type="text", nullable=true)
   *
   * @Assert\Length(
   *  max = 10000,
   *  maxMessage = "maxLength"
   * )
   */
  protected $beskrivelseForslag;

  /**
   * @var string
   *
   * @ORM\Column(name="beskrivelseOevrige", type="text", nullable=true)
   *
   * @Assert\Length(
   *  max = 10000,
   *  maxMessage = "maxLength"
   * )
   */
  protected $beskrivelseOevrige;

  /**
   * @var string
   *
   * @ORM\Column(name="risikovurdering", type="text", nullable=true)
   *
   * @Assert\Length(
   *  max = 10000,
   *  maxMessage = "maxLength"
   * )
   */
  protected $risikovurdering;

  /**
   * @var string
   *
   * Tekniske forhold / kompleksitet
   *
   * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\RisikovurderingType")
   * @ORM\Column(name="risikovurderingTeknisk", type="RisikovurderingType", nullable=true)
   */
  protected $risikovurderingTeknisk;

  /**
   * @var string
   *
   * Brugsmønster
   *
   * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\RisikovurderingType")
   * @ORM\Column(name="risikovurderingBrugsmoenster", type="RisikovurderingType", nullable=true)
   */
  protected $risikovurderingBrugsmoenster;

  /**
   * @var string
   *
   * Datagrundlag
   *
   * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\RisikovurderingType")
   * @ORM\Column(name="risikovurderingDatagrundlag", type="RisikovurderingType", nullable=true)
   */
  protected $risikovurderingDatagrundlag;

  /**
   * @var string
   *
   * Div. (Beskrives i noter.)
   *
   * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\RisikovurderingType")
   * @ORM\Column(name="risikovurderingDiverse", type="RisikovurderingType", nullable=true)
   */
  protected $risikovurderingDiverse;

  /**
   * @var float
   *
   * Ændring i besparelse i forhold til risikovurdering
   *
   * @ORM\Column(name="risikovurderingAendringIBesparelseFaktor", type="float", nullable=true)
   */
  protected $risikovurderingAendringIBesparelseFaktor;

  /**
   * @var float
   *
   * Økonomisk kompensering ift. investering
   *
   * @ORM\Column(name="risikovurderingOekonomiskKompenseringIftInvesteringFaktor", type="float", nullable=true)
   */
  protected $risikovurderingOekonomiskKompenseringIftInvesteringFaktor;

  /**
   * @var float
   *
   * Ændring i besparelse ift. energiledelse
   *
   * @ORM\Column(name="energiledelseAendringIBesparelseFaktor", type="float", nullable=true)
   */
  protected $energiledelseAendringIBesparelseFaktor;

  /**
   * @var string
   *
   * @ORM\Column(name="energiledelseNoter", type="text", nullable=true)
   *
   * @Assert\Length(
   *  max = 360,
   *  maxMessage = "maxLength"
   * )
   */
  protected $energiledelseNoter;

  /**
   * @var string
   *
   * @ORM\Column(name="placering", type="string", length=10000, nullable=true)
   */
  protected $placering;

  /**
   * @var string
   *
   * @ORM\Column(name="beskrivelseDriftOgVedligeholdelse", type="text", nullable=true)
   *
   * @Assert\Length(
   *  max = 10000,
   *  maxMessage = "maxLength"
   * )
   */
  protected $beskrivelseDriftOgVedligeholdelse;

  /**
   * @var string
   *
   * @ORM\Column(name="indeklima", type="text", nullable=true)
   *
   * @Assert\Length(
   *  max = 10000,
   *  maxMessage = "maxLength"
   * )
   */
  protected $indeklima;

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
   * @var Rapport
   *
   * @ManyToOne(targetEntity="Rapport", inversedBy="tiltag")
   * @JoinColumn(name="rapport_id", referencedColumnName="id")
   **/
  protected $rapport;

  /**
   * @var ArrayCollection
   *
   * @OneToMany(targetEntity="TiltagDetail", mappedBy="tiltag", cascade={"persist", "remove"})
   * @OrderBy({"createdAt" = "ASC"})
   * @JMS\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\TiltagDetail>")
   */
  protected $details;

  /**
   * @var boolean
   *
   * @ORM\Column(name="elena", type="boolean", nullable=true)
   */
  protected $elena = FALSE;

  //----- Økonomi ----- //

  /**
   * @var ArrayCollection
   *
   * @OneToMany(targetEntity="Regning", mappedBy="tiltag", cascade={"persist", "remove"})
   * @OrderBy({"createdAt" = "ASC"})
   * @JMS\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Regning>")
   */
  protected $regning;

  /**
   * @var string
   *
   * @ORM\Column(name="EstimeredeUdgifter", type="decimal", nullable=true)
   */
  protected $estimeredeUdgifter;

  /**
   * @var string
   *
   * @ORM\Column(name="BudgetteredeUdgifter", type="decimal", nullable=true)
   */
  protected $budgetteredeUdgifter;

  /**
   * @var string
   *
   * @ORM\Column(name="Genopretning", type="decimal", nullable=true)
   */
  protected $genopretning = 0;

  /**
   * @var float
   *
   * @ORM\Column(name="genopretningForImplementeringsomkostninger", type="decimal", nullable=true)
   */
  protected $genopretningForImplementeringsomkostninger = 0;

  /**
   * @var string
   *
   * @ORM\Column(name="Modernisering", type="decimal", nullable=true)
   */
  protected $modernisering = 0;

  /**
   * @OneToMany(targetEntity="Bilag", mappedBy="tiltag", cascade={"remove"})
   * @OrderBy({"id" = "ASC"})
   * @JMS\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Bilag>")
   */
  protected $bilag;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="maengde", type="float", nullable=true)
   */
  protected $maengde;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="tilskudsstoerrelse", type="float", nullable=true)
   */
  protected $tilskudsstoerrelse;

  /**
   * @var string
   *
   * @Calculated
   * @ORM\Column(name="enhed", type="string", nullable=true)
   */
  protected $enhed;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="DatoForDrift", type="date", nullable=true)
   */
  protected $datoForDrift;

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
   * Get index
   *
   * @return integer
   */
  public function getIndexNumber() {
    $tiltag = $this->getRapport()->getTiltag();
    $index = 1;
    foreach ($tiltag as $t) {
      if($t->getId() === $this->getId()) {
        return $index;
      }
      $index++;
    }

    return 0;
  }

  /**
   * Set slutanvendelse
   *
   * @param SlutanvendelseType $slutanvendelse
   *
   * @return Slutanvendelse
   */
  public function setSlutanvendelse($slutanvendelse = NULL) {
    $this->slutanvendelse = $slutanvendelse;

    return $this;
  }

  /**
   * Get slutanvendelse
   *
   * @return \AppBundle\DBAL\Types\SlutanvendelseType
   */
  public function getSlutanvendelse() {
    if (isset(SlutanvendelseType::$detaultValues[get_class($this)])) {
      $this->slutanvendelse = SlutanvendelseType::$detaultValues[get_class($this)];
    }
    return $this->slutanvendelse;
  }

  /**
   * @return string
   */
  public function getRisikovurderingTeknisk() {
    return $this->risikovurderingTeknisk;
  }

  /**
   * @param string $risikovurderingTeknisk
   */
  public function setRisikovurderingTeknisk($risikovurderingTeknisk) {
    $this->risikovurderingTeknisk = $risikovurderingTeknisk;
  }

  /**
   * @return string
   */
  public function getRisikovurderingBrugsmoenster() {
    return $this->risikovurderingBrugsmoenster;
  }

  /**
   * @param string $risikovurderingBrugsmoenster
   */
  public function setRisikovurderingBrugsmoenster($risikovurderingBrugsmoenster) {
    $this->risikovurderingBrugsmoenster = $risikovurderingBrugsmoenster;
  }

  /**
   * @return string
   */
  public function getRisikovurderingDatagrundlag() {
    return $this->risikovurderingDatagrundlag;
  }

  /**
   * @param string $risikovurderingDatagrundlag
   */
  public function setRisikovurderingDatagrundlag($risikovurderingDatagrundlag) {
    $this->risikovurderingDatagrundlag = $risikovurderingDatagrundlag;
  }

  /**
   * @return string
   */
  public function getRisikovurderingDiverse() {
    return $this->risikovurderingDiverse;
  }

  /**
   * @param string $risikovurderingDiverse
   */
  public function setRisikovurderingDiverse($risikovurderingDiverse) {
    $this->risikovurderingDiverse = $risikovurderingDiverse;
  }

  /**
   * @return float
   */
  public function getRisikovurderingAendringIBesparelseFaktor() {
    return $this->risikovurderingAendringIBesparelseFaktor;
  }

  /**
   * @param float $risikovurderingAendringIBesparelseFaktor
   */
  public function setRisikovurderingAendringIBesparelseFaktor($risikovurderingAendringIBesparelseFaktor) {
    $this->risikovurderingAendringIBesparelseFaktor = $risikovurderingAendringIBesparelseFaktor;
  }

  /**
   * @return float
   */
  public function getRisikovurderingOekonomiskKompenseringIftInvesteringFaktor() {
    return $this->risikovurderingOekonomiskKompenseringIftInvesteringFaktor;
  }

  /**
   * @param float $risikovurderingOekonomiskKompenseringIftInvesteringFaktor
   */
  public function setRisikovurderingOekonomiskKompenseringIftInvesteringFaktor($risikovurderingOekonomiskKompenseringIftInvesteringFaktor) {
    $this->risikovurderingOekonomiskKompenseringIftInvesteringFaktor = $risikovurderingOekonomiskKompenseringIftInvesteringFaktor;
  }

  /**
   * @return float
   */
  public function getEnergiledelseAendringIBesparelseFaktor()
  {
    return $this->energiledelseAendringIBesparelseFaktor;
  }

  /**
   * @param float $energiledelseAendringIBesparelseFaktor
   */
  public function setEnergiledelseAendringIBesparelseFaktor($energiledelseAendringIBesparelseFaktor)
  {
    $this->energiledelseAendringIBesparelseFaktor = $energiledelseAendringIBesparelseFaktor;
  }

  /**
   * @return string
   */
  public function getEnergiledelseNoter()
  {
    return $this->energiledelseNoter;
  }

  /**
   * @param string $energiledelseNoter
   */
  public function setEnergiledelseNoter($energiledelseNoter)
  {
    $this->energiledelseNoter = $energiledelseNoter;
  }

  /**
   * @return string
   */
  public function getTilvalgtBegrundelseMagistrat() {
    return $this->tilvalgtBegrundelseMagistrat;
  }

  /**
   * @param string $tilvalgtBegrundelseMagistrat
   */
  public function setTilvalgtBegrundelseMagistrat($tilvalgtBegrundelseMagistrat) {
    $this->tilvalgtBegrundelseMagistrat = $tilvalgtBegrundelseMagistrat;
  }

  /**
   * Get "Tilvalgt"
   *
   * Magistrat takes presedence over AaPlus which takes presedence over Rådgiver.
   *
   * @return bool
   */
  public function getTilvalgt() {
    if ($this->tilvalgtAfMagistrat !== NULL) {
      return $this->tilvalgtAfMagistrat;
    }

    if ($this->tilvalgtAfAaPlus !== NULL) {
      return $this->tilvalgtAfAaPlus;
    }

    if ($this->tilvalgtAfRaadgiver !== NULL) {
      return $this->tilvalgtAfRaadgiver;
    }

    return FALSE;
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
   * Set prioriteringsfaktor
   *
   * @param integer $prioriteringsfaktor
   * @return Tiltag
   */
  public function setPrioriteringsfaktor($prioriteringsfaktor) {
    $this->prioriteringsfaktor = $prioriteringsfaktor;

    return $this;
  }

  /**
   * Get prioriteringsfaktor
   *
   * @return integer
   */
  public function getPrioriteringsfaktor() {
    return $this->prioriteringsfaktor;
  }

  /**
   * Set konverteringsfaktorFoer
   *
   * @param integer $konverteringsfaktorFoer
   * @return Tiltag
   */
  public function setKonverteringsfaktorFoer($konverteringsfaktorFoer) {
    $this->konverteringsfaktorFoer = $konverteringsfaktorFoer;

    return $this;
  }

  /**
   * Get konverteringsfaktorFoer
   *
   * @return integer
   */
  public function getKonverteringsfaktorFoer() {
    return $this->konverteringsfaktorFoer;
  }

  /**
   * Set konverteringsfaktorEfter
   *
   * @param integer $konverteringsfaktorEfter
   * @return Tiltag
   */
  public function setKonverteringsfaktorEfter($konverteringsfaktorEfter) {
    $this->konverteringsfaktorEfter = $konverteringsfaktorEfter;

    return $this;
  }

  /**
   * Get konverteringsfaktorEfter
   *
   * @return integer
   */
  public function getKonverteringsfaktorEfter() {
    return $this->konverteringsfaktorEfter;
  }

  /**
   * Set forbrugFoer
   *
   * @param integer $forbrugFoer
   * @return Tiltag
   */
  public function setForbrugFoer($forbrugFoer) {
    $this->forbrugFoer = $forbrugFoer;

    return $this;
  }

  /**
   * Get forbrugFoer
   *
   * @return integer
   */
  public function getForbrugFoer() {
    return $this->forbrugFoer;
  }

  /**
   * Set forbrugEfter
   *
   * @param integer $forbrugEfter
   * @return Tiltag
   */
  public function setForbrugEfter($forbrugEfter) {
    $this->forbrugEfter = $forbrugEfter;

    return $this;
  }

  /**
   * Get forbrugEfter
   *
   * @return integer
   */
  public function getForbrugEfter() {
    return $this->forbrugEfter;
  }

  /**
   * Set primaerEnterprise
   *
   * @param \AppBundle\DBAL\Types\PrimaerenterpriseType $primaerEnterprise
   *
   * @return Tiltag
   */
  public function setPrimaerEnterprise($primaerEnterprise) {
    $this->primaerEnterprise = $primaerEnterprise;

    return $this;
  }

  /**
   * Get primaerEnterprise
   *
   * @return \AppBundle\DBAL\Types\PrimaerenterpriseType
   */
  public function getPrimaerEnterprise() {
    return $this->primaerEnterprise;
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
   * Set tiltagskategori
   *
   * @param \AppBundle\Entity\TiltagsKategori tiltagskategori
   * @return Tiltag
   */
  public function setTiltagskategori($tiltagskategori) {
    $this->tiltagskategori = $tiltagskategori;

    return $this;
  }

  /**
   * Get tiltagskategori
   *
   * @return \AppBundle\Entity\TiltagsKategori
   */
  public function getTiltagskategori() {
    return $this->tiltagskategori;
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
   * Get anlaegsinvestering (beregnet)
   *
   * @return string
   */
  public function getAnlaegsinvesteringBeregnet() {
    return $this->anlaegsinvestering_beregnet;
  }

  /**
   * @return float
   */
  public function getAnlaegsinvesteringExRisiko() {
    return $this->anlaegsinvesteringExRisiko;
  }

  /**
   * Set opstartsomkostninger
   *
   * @param float $opstartsomkostninger
   *
   * @return Tiltag
   */
  public function setOpstartsomkostninger($opstartsomkostninger) {
    $this->opstartsomkostninger = $opstartsomkostninger;

    return $this;
  }

  /**
   * Get opstartsomkostninger
   *
   * @return float
   */
  public function getOpstartsomkostninger() {
    return $this->opstartsomkostninger;
  }

  /**
   * Set reelAnlaegsinvestering
   *
   * @param float $reelAnlaegsinvestering
   *
   * @return Tiltag
   */
  public function setReelAnlaegsinvestering($reelAnlaegsinvestering) {
    $this->reelAnlaegsinvestering = $reelAnlaegsinvestering;

    return $this;
  }

  /**
   * Get reelAnlaegsinvestering
   *
   * @return float
   */
  public function getReelAnlaegsinvestering() {
    return $this->reelAnlaegsinvestering;
  }

  public function setBesparelseDriftOgVedligeholdelse($besparelseDriftOgVedligeholdelse) {
    $this->besparelseDriftOgVedligeholdelse = $besparelseDriftOgVedligeholdelse;

    return $this;
  }

  /**
   * Get besparelseDriftOgVedligeholdelse
   *
   * @return string
   */
  public function getBesparelseDriftOgVedligeholdelse() {
    return $this->besparelseDriftOgVedligeholdelse;
  }

  public function setBesparelseStrafafkoelingsafgift($besparelseStrafafkoelingsafgift) {
    $this->besparelseStrafafkoelingsafgift = $besparelseStrafafkoelingsafgift;

    return $this;
  }

  /**
   * Get besparelseStrafafkoelingsafgift
   *
   * @return string
   */
  public function getBesparelseStrafafkoelingsafgift() {
    return $this->besparelseStrafafkoelingsafgift;
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
   * @param \AppBundle\Entity\Energiforsyning $forsyningVarme
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
   * Set beskrivelseDriftOgVedligeholdelse
   *
   * @param string $beskrivelseDriftOgVedligeholdelse
   * @return Tiltag
   */
  public function setBeskrivelseDriftOgVedligeholdelse($beskrivelseDriftOgVedligeholdelse) {
    $this->beskrivelseDriftOgVedligeholdelse = $beskrivelseDriftOgVedligeholdelse;

    return $this;
  }

  /**
   * Get beskrivelseDriftOgVedligeholdelse
   *
   * @return string
   */
  public function getBeskrivelseDriftOgVedligeholdelse() {
    return $this->beskrivelseDriftOgVedligeholdelse;
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
   * Get varmebesparelseGUF;
   *
   * @return float
   */
  public function getVarmebesparelseGUF() {
    return $this->varmebesparelseGUF;
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
   * Get elbesparelse
   *
   * @return float
   */
  public function getElbesparelse() {
    return $this->elbesparelse;
  }

  /**
   * Get samletEnergibesparelse
   *
   * @return float
   */
  public function getSamletEnergibesparelse() {
    return $this->samletEnergibesparelse;
  }

  /**
   * Get samletCo2besparelse
   *
   * @return float
   */
  public function getSamletCo2besparelse() {
    return $this->samletCo2besparelse;
  }

  /**
   * Get samletTilskud
   *
   * @return float
   */
  public function getSamletTilskud() {
    return $this->samletTilskud;
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
   * Get simpelTilbagebetalingstidAar.
   *
   * @return float
   */
  public function getSimpelTilbagebetalingstidAar() {
    return $this->simpelTilbagebetalingstidAar;
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
   * Get scrapvaerdi.
   *
   * @return float
   */
  public function getScrapvaerdi() {
    return $this->scrapvaerdi;
  }

  /**
   * Get reinvestering.
   *
   * @return float
   */
  public function getReinvestering() {
    return $this->reinvestering;
  }

  /**
   * Add a TiltagDetail to this Tiltag
   *
   * @param TiltagDetail $detail
   * @return Tiltag
   */
  public function addDetail(TiltagDetail $detail) {
    if (!$this->details->contains($detail)) {
      $this->details->add($detail);
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
   * Add regning
   *
   * @param \AppBundle\Entity\Regning $regning
   *
   * @return Tiltag
   */
  public function addRegning(\AppBundle\Entity\Regning $regning) {
    $this->regning[] = $regning;

    return $this;
  }

  /**
   * Remove regning
   *
   * @param \AppBundle\Entity\Regning $regning
   */
  public function removeRegning(\AppBundle\Entity\Regning $regning) {
    $this->regning->removeElement($regning);
  }

  /**
   * Get regning
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getRegning() {
    return $this->regning;
  }

  /**
   * Set estimeredeUdgifter
   *
   * @param string $estimeredeUdgifter
   *
   * @return Tiltag
   */
  public function setEstimeredeUdgifter($estimeredeUdgifter) {
    $this->estimeredeUdgifter = $estimeredeUdgifter;

    return $this;
  }

  /**
   * Get estimeredeUdgifter
   *
   * @return string
   */
  public function getEstimeredeUdgifter() {
    return $this->estimeredeUdgifter;
  }

  /**
   * Set budgetteredeUdgifter
   *
   * @param string $budgetteredeUdgifter
   *
   * @return Tiltag
   */
  public function setBudgetteredeUdgifter($budgetteredeUdgifter) {
    $this->budgetteredeUdgifter = $budgetteredeUdgifter;

    return $this;
  }

  /**
   * Get budgetteredeUdgifter
   *
   * @return string
   */
  public function getBudgetteredeUdgifter() {
    return $this->budgetteredeUdgifter;
  }

  /**
   * Set genopretning
   *
   * @param string $genopretning
   *
   * @return Tiltag
   */
  public function setGenopretning($genopretning) {
    $this->genopretning = $genopretning;

    return $this;
  }

  /**
   * Get genopretning
   *
   * @return float
   */
  public function getGenopretning() {
    return $this->genopretning;
  }

  /**
   * Set genopretningForImplementeringsomkostninger
   *
   * @param string $genopretningForImplementeringsomkostninger
   *
   * @return Tiltag
   */
  public function setGenopretningForImplementeringsomkostninger($genopretningForImplementeringsomkostninger) {
    $this->genopretningForImplementeringsomkostninger = $genopretningForImplementeringsomkostninger;

    return $this;
  }

  /**
   * Get genopretningForImplementeringsomkostninger
   *
   * @return string
   */
  public function getGenopretningForImplementeringsomkostninger() {
    return $this->genopretningForImplementeringsomkostninger;
  }

  /**
   * Set modernisering
   *
   * @param string $modernisering
   *
   * @return Tiltag
   */
  public function setModernisering($modernisering) {
    $this->modernisering = $modernisering;

    return $this;
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
   * Get all selected TiltagDetails.
   *
   * @return ArrayCollection
   *   The list of selected TiltagDetails.
   */
  protected function getTilvalgteDetails() {
    return $this->getDetails()->filter(function ($detail) {
      return $detail->getTilvalgt();
    });
  }

  /**
   * @return float
   */
  public function getAaplusInvestering() {
    return $this->aaplusInvestering;
  }

  /**
   * @param float $aaplusInvestering
   */
  public function setAaplusInvestering($aaplusInvestering) {
    $this->aaplusInvestering = $aaplusInvestering;
  }

  /**
   * Set dato for drift
   *
   * @param \DateTime $datoForDrift
   * @return Tiltag
   */
  public function setDatoForDrift($datoForDrift) {
    $this->datoForDrift = $datoForDrift;

    return $this;
  }

  /**
   * Get dato for drift
   *
   * @return \DateTime
   */
  public function getDatoForDrift() {
    return $this->datoForDrift;
  }

  protected $propertiesRequiredForCalculation = [
    'forsyningVarme',
    'forsyningEl',
    'levetid',
    'faktorForReinvesteringer',
    'slutanvendelse',
  ];

  public function getPropertiesRequiredForCalculation() {
    return $this->propertiesRequiredForCalculation;
  }

  /**
   * Check if calculating this Tiltag makes sense.
   * Some values may be required to make a meaningful calculation.
   */
  public function getCalculationWarnings($messages = [])
  {
    $properties = $this->getPropertiesRequiredForCalculation();
    $prefix = 'tiltag';
    return Calculation::getCalculationWarnings($this, $properties, $prefix, $this->getDetails());
  }

  /**
   * Get all files on this Tiltag plus any files from TiltagDetails.
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

    foreach ($this->getDetails() as $detail) {
      $detailFiles = $detail->getAllFiles();
      if ($detailFiles) {
        $files[] = $detailFiles;
      }
    }

    return $files ? [ $this->getIndexNumber().'-'.$this->getTitle() => $files ] : null;
  }

  /**
   * Calculate values in this Tiltag
   */
  public function calculate() {
    $this->varmebesparelseGUF = $this->calculateVarmebesparelseGUF();
    $this->varmebesparelseGAF = $this->calculateVarmebesparelseGAF();
    $this->elbesparelse = $this->calculateElbesparelse();
    $this->vandbesparelse = $this->calculateVandbesparelse();

    // Calculating values by formulas from annotation.
    $this->samletEnergibesparelse = $this->calculateByFormula('samletEnergibesparelse');
    $this->samletCo2besparelse = $this->calculateByFormula('samletCo2besparelse');
    $this->samletTilskud = $this->calculateByFormula('samletTilskud');

    // This may be computed, may be an input
    if (($value = $this->calculateBesparelseDriftOgVedligeholdelse()) !== NULL) {
      $this->besparelseDriftOgVedligeholdelse = $value;
    }
    // This may be computed, may be an input
    if (($value = $this->calculateLevetid()) !== NULL) {
      $this->levetid = $value;
    }
    $this->antalReinvesteringer = $this->calculateAntalReinvesteringer();
    $this->anlaegsinvestering_beregnet = $this->calculateAnlaegsinvestering();
    $this->anlaegsinvestering = $this->anlaegsinvestering_beregnet;
    if ($this->reelAnlaegsinvestering > 0) {
      $this->anlaegsinvestering = $this->reelAnlaegsinvestering;
    }
    if ($this->opstartsomkostninger > 0) {
      $this->anlaegsinvestering += $this->opstartsomkostninger;
    }
    $this->aaplusInvestering = $this->calculateAaplusInvestering();
    $this->reinvestering = $this->calculateReinvestering();
    $this->scrapvaerdi = $this->calculateScrapvaerdi();
    $this->cashFlow15 = $this->calculateCashFlow(15);
    $this->cashFlow30 = $this->calculateCashFlow(30);
    $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
    $this->nutidsvaerdiSetOver15AarKr = $this->calculateNutidsvaerdiSetOver15AarKr();
    $this->besparelseAarEt = $this->calculateSavingsForYear(1);
    $this->maengde = $this->calculateMaengde();
    $this->tilskudsstoerrelse = $this->getTilskudsstoerrelse();
    $this->enhed = $this->calculateEnhed();
  }

  /**
   * @inheritDoc
   * @Formula("$this->getAnlaegsinvestering() - ($this->getGenopretning() + $this->getModernisering())")
   */
  protected function calculateAaplusInvestering() {
    return $this->getAnlaegsinvestering() - ($this->getGenopretning() + $this->getModernisering());
  }

  protected function calculateCashFlow($numberOfYears, $yderligereBesparelseKrAar = 0) {
    $inflation = $this->getRapport()->getInflation();

    $aaplusinvestering = floatval($this->aaplusInvestering);
    $varmebesparelseGUF = floatval($this->varmebesparelseGUF);
    $varmebesparelseGAF = floatval($this->varmebesparelseGAF);
    $elbesparelse = floatval($this->elbesparelse);
    $vandbesparelse = floatval($this->vandbesparelse);
    $besparelseStrafafkoelingsafgift = floatval($this->besparelseStrafafkoelingsafgift);
    $besparelseDriftOgVedligeholdelse = floatval($this->besparelseDriftOgVedligeholdelse);
    $scrapvaerdi = floatval($this->scrapvaerdi);

    $cashFlow = array_fill(1, $numberOfYears, 0);

    for ($year = 1; $year <= $numberOfYears; $year++) {
      $varmepris = $this->calculateVarmepris($year);
      $value = ($varmebesparelseGUF + $varmebesparelseGAF) * $varmepris
        + $elbesparelse * $this->getRapport()->getElKrKWh($year)
        + $vandbesparelse * $this->getRapport()->getVandKrKWh($year)
        + ($besparelseStrafafkoelingsafgift + $besparelseDriftOgVedligeholdelse) * pow(1 + $inflation, $year);

      if ($this instanceof SolcelleTiltag) {
        $value += $this->getSolcelleproduktion() * $this->getRapport()->getElKrKWh($year)
          + $this->getSalgTilNettetAar1() * ($year <= 10
                                             ? $this->getRapport()->getConfiguration()->getSolcelletiltagdetailSalgsprisFoerste10AarKrKWh()
                                             : $this->getRapport()->getConfiguration()->getSolcelletiltagdetailSalgsprisEfter10AarKrKWh());
      }

      if ($year == 1) {
        $value -= $aaplusinvestering;
      }
      else {
        if ($this->levetid + 1 == $year) {
          $value -= $this->aaplusInvestering * $this->faktorForReinvesteringer * pow(1 + $inflation, $year);
        }
        if ($numberOfYears == 15 && $year == $numberOfYears) {
          $value += $scrapvaerdi;
        }
      }
      $cashFlow[$year] = $value + $yderligereBesparelseKrAar;
    }

    return $cashFlow;
  }

  public function calculateSavingsForYear($year) {
    if ($year > $this->levetid) {
      return 0;
    }

    $varmepris = $this->calculateVarmepris($year);
    $besparelse = // $this->getIndtaegtSalgAfEnergibesparelse()
                +($this->getVarmebesparelseGUF() + $this->getVarmebesparelseGAF()) * $varmepris
                + $this->getElbesparelse() * $this->rapport->getElKrKWh($year)
                + $this->getVandbesparelse() * $this->rapport->getVandKrKWh($year)
                + ($this->getBesparelseStrafafkoelingsafgift() + $this->getBesparelseDriftOgVedligeholdelse()) * pow(1 + $this->rapport->getInflation(), $year)
                ;

    return $besparelse;
  }

  public function calculateBesparelseVarmeForYear($year) {
    if ($year > $this->levetid) {
      return 0;
    }

    return $this->getVarmebesparelseGUF() + $this->getVarmebesparelseGAF();
  }

  public function calculateBesparelseElForYear($year) {
    if ($year > $this->levetid) {
      return 0;
    }

    return $this->getElbesparelse();
  }

  protected function calculateVarmepris($year = 1) {
    if ($this->forsyningVarme) {
      $forsyningsvaerk = $this->forsyningVarme->getForsyningsvaerk();
      if ($forsyningsvaerk) {
        return $forsyningsvaerk->getKrKWh($this->rapport->getDatering()->format('Y') - 1 + $year);
      }
    }

    return 0;
  }

  protected function calculateVandbesparelse() {
    return NULL;
  }

  protected function calculateBesparelseDriftOgVedligeholdelse() {
    return NULL;
  }

  protected function calculateAntalReinvesteringer() {
    if ($this->getRapport()->getLobetid() == 0 || $this->levetid == 0) {
      return 0;
    }
    if ($this->levetid / $this->getRapport()->getLobetid() > 1) {
      return 0;
    }
    elseif ($this->levetid / $this->getRapport()->getLobetid() < 1) {
      return floor($this->getRapport()->getLobetid() / $this->levetid);
    }
    return 0;
  }

  /**
   * Calculates Anlaegsinvestering faktor.
   *
   * @return float
   */
  protected function calculateAnlaegsinvesteringFaktor() {
    return $this->getRisikovurderingOekonomiskKompenseringIftInvesteringFaktor() ? ($this->getRisikovurderingOekonomiskKompenseringIftInvesteringFaktor() + 1) : 1;
  }

  protected function calculateAnlaegsinvestering($value = NULL) {
    if($value === NULL) {
      return NULL;
    } else {
      return $value * $this->calculateAnlaegsinvesteringFaktor();
    }
  }

  protected function calculateVarmebesparelseGUF($value = NULL) {
    return $this->calculateBesparelseFromAendringIBesparelseFaktor($value);
  }

  protected function calculateVarmebesparelseGAF($value = null) {
    return $this->calculateBesparelseFromAendringIBesparelseFaktor($value);
  }

  /**
   * @Formula("$value * $this->calculateRisikoFaktor() * $this->calculateEnergiledelseFaktor()")
   */
  protected function calculateElbesparelse($value = null) {
    return $this->calculateBesparelseFromAendringIBesparelseFaktor($value);
  }

  protected function calculateBesparelseFromAendringIBesparelseFaktor($value) {
    if($value === NULL) {
      return NULL;
    } else {
      return $value * $this->calculateRisikoFaktor() * $this->calculateEnergiledelseFaktor();
    }
  }

  /**
   * Helper function to simplify calculation.
   *
   * @return float|int
   */
  protected function calculateRisikoFaktor() {
    return $this->getRisikovurderingAendringIBesparelseFaktor() ? (1 - $this->getRisikovurderingAendringIBesparelseFaktor()) : 1;
  }

  /**
   * Helper function to simplify calculation.
   *
   * @return float|int
   */
  protected function calculateEnergiledelseFaktor() {
    return $this->getEnergiledelseAendringIBesparelseFaktor() ? (1 - $this->getEnergiledelseAendringIBesparelseFaktor()) : 1;
  }

  protected function calculateLevetid() {
    return NULL;
  }

  /**
   * @Formula("($this->aaplusInvestering - $this->samletTilskud) / ($this->samletEnergibesparelse + $this->besparelseDriftOgVedligeholdelse + $this->besparelseStrafafkoelingsafgift)")
   */
  protected function calculateSimpelTilbagebetalingstidAar() {
    return $this->divide(($this->aaplusInvestering - $this->samletTilskud),
      $this->samletEnergibesparelse + $this->besparelseDriftOgVedligeholdelse + $this->besparelseStrafafkoelingsafgift);
  }

  /**
   * Calculates expression for nutidsvaerdiSetOver15AarKr value
   */
  protected function calculateNutidsvaerdiSetOver15AarKrExpr() {
    return $this->sumExpr($this->calculateNutidsvaerdiSetOver15AarKr(TRUE));
  }

  /**
   * @Formula("$this->calculateNutidsvaerdiSetOver15AarKrExpr()")
   */
  protected function calculateNutidsvaerdiSetOver15AarKr($array = FALSE) {
    return Calculation::npv($this->getRapport()
      ->getKalkulationsrente(), $this->cashFlow15, $array);
  }

  protected function calculateScrapvaerdi() {
    $cutoff = 15;
    if ($this->levetid > $cutoff) {
      return (1 - ($cutoff / $this->levetid)) * pow(1 + $this->getRapport()
          ->getInflation(), $cutoff) * $this->aaplusInvestering;
    }
    elseif ($cutoff - $this->antalReinvesteringer * $this->levetid == 0) {
      return 0;
    }
    else {
      return (1 - ($this->levetid == 0 ? 0 : ($cutoff - $this->antalReinvesteringer * $this->levetid) / $this->levetid)) * $this->reinvestering * pow(1 + $this->getRapport()
          ->getInflation(), $cutoff);
    }
  }

  protected function calculateReinvestering() {
    if ($this->levetid >= 15) {
      return 0;
    }
    else {
      return $this->faktorForReinvesteringer * $this->aaplusInvestering;
    }
  }

  protected function calculateMaengde() {
    return NULL;
  }

  protected function calculateTilskudsstoerrelse() {
    return $this->getTilskudsstoerrelse();
  }

  protected function calculateEnhed() {
    return NULL;
  }

  public function getRapportElKrKWh() {
    return $this->getRapport()->getElKrKWh();
  }

  public function getRapportVarmeKrKWh() {
    return $this->getRapport()->getVarmeKrKWh();
  }

  public function getRapportElKgCo2MWh() {
    return $this->getRapport()->getElKgCo2MWh();
  }

  public function getRapportVarmeKgCo2MWh() {
    return $this->getRapport()->getVarmeKgCo2MWh();
  }

  public function getRapportSolcelletiltagdetailSalgsprisFoerste10AarKrKWh() {
    return $this->getRapport()->getConfiguration()->getSolcelletiltagdetailSalgsprisFoerste10AarKrKWh();
  }

  protected function accumulate(callable $accumulator, $start = 0) {
    $value = $start;
    foreach ($this->getTilvalgteDetails() as $detail) {
      $value = $accumulator($detail, $value);
    }
    return $value;
  }

  protected function accumulateArray(callable $accumulator, $start = array()) {
    $result = $start;
    foreach ($this->getTilvalgteDetails() as $detail) {
      $result = $accumulator($detail, $result);
    }
    return $result;
  }

  /**
   * Calculate the sum of something from each tilvalgt detail.
   *
   * @param string|callable $f
   *   A callable or a property name.
   *
   * @return integer
   *   The sum af results from calling $f on each tilvalgt detail.
   */
  protected function sum($f, $expression = FALSE) {
    $result = $this->accumulateArray(function ($detail, $result) use ($f) {
      $result[] = (is_callable($f) ? $f($detail) : $detail->{'get' . $f}());
      return $result;
    });

    if ($expression) {
      return $this->sumExpr($result);
    }
    return array_sum($result);
  }

  public function __construct() {
    $this->details = new \Doctrine\Common\Collections\ArrayCollection();
    $this->bilag = new \Doctrine\Common\Collections\ArrayCollection();
    if (isset(SlutanvendelseType::$detaultValues[get_class($this)])) {
      $this->slutanvendelse = SlutanvendelseType::$detaultValues[get_class($this)];
    }
  }

  /**
   * Safe division.
   *
   * @param float $numerator
   *   The numerator.
   *
   * @param float $denominator
   *   The denominator.
   *
   * @return float
   *   .
   */
  protected function divide($numerator, $denominator) {
    return Calculation::divide($numerator, $denominator);
  }

  protected function fordelbesparelse($BesparKwh, $kilde, $type) {
    return Calculation::fordelbesparelse($BesparKwh, $kilde, $type);
  }


  /**
   * Set tilvalgtbegrundelse
   *
   * @param string $tilvalgtbegrundelse
   *
   * @return Tiltag
   */
  public function setTilvalgtbegrundelse($tilvalgtbegrundelse) {
    $this->tilvalgtbegrundelse = $tilvalgtbegrundelse;

    return $this;
  }

  /**
   * Get tilvalgtbegrundelse
   *
   * @return string
   */
  public function getTilvalgtbegrundelse() {
    return $this->tilvalgtbegrundelse;
  }

  /**
   * Set tilvalgtAfMagistrat
   *
   * @param boolean $tilvalgtAfMagistrat
   *
   * @return Tiltag
   */
  public function setTilvalgtAfMagistrat($tilvalgtAfMagistrat) {
    $this->tilvalgtAfMagistrat = $tilvalgtAfMagistrat;

    return $this;
  }

  /**
   * Get tilvalgtAfMagistrat
   *
   * @return boolean
   */
  public function getTilvalgtAfMagistrat() {
    return $this->tilvalgtAfMagistrat;
  }


  /**
   * Set tilvalgtAfRaadgiver
   *
   * @param boolean $tilvalgtAfRaadgiver
   *
   * @return Tiltag
   */
  public function setTilvalgtAfRaadgiver($tilvalgtAfRaadgiver) {
    $this->tilvalgtAfRaadgiver = $tilvalgtAfRaadgiver;

    return $this;
  }

  /**
   * Get tilvalgtAfRaadgiver
   *
   * @return boolean
   */
  public function getTilvalgtAfRaadgiver() {
    return $this->tilvalgtAfRaadgiver;
  }

  /**
   * Set tilvalgtAfAaPlus
   *
   * @param boolean $tilvalgtAfAaPlus
   *
   * @return Tiltag
   */
  public function setTilvalgtAfAaPlus($tilvalgtAfAaPlus) {
    $this->tilvalgtAfAaPlus = $tilvalgtAfAaPlus;

    return $this;
  }

  /**
   * Get tilvalgtAfAaPlus
   *
   * @return boolean
   */
  public function getTilvalgtAfAaPlus() {
    return $this->tilvalgtAfAaPlus;
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
   * Add bilag
   *
   * @param \AppBundle\Entity\Bilag $bilag
   * @return Tiltag
   */
  public function addBilag(\AppBundle\Entity\Bilag $bilag) {
    $this->bilag[] = $bilag;

    $bilag->setTiltag($this);

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
   * @return Tiltag
   */
  public function setBilag($bilag) {
    $this->bilag = $bilag;

    return $this;
  }

  /**
   * Get bilag
   *
   * @return Tiltag
   */
  public function getBilag() {
    return $this->bilag;
  }

  /**
   * Get maengde
   *
   * @return float
   */
  public function getMaengde() {
    return $this->maengde;
  }

  /**
   * @param float $tilskudsstoerrelse
   */
  public function setTilskudsstoerrelse($tilskudsstoerrelse) {
    $this->tilskudsstoerrelse = $tilskudsstoerrelse;
  }

  /**
   * Get tilskudsstoerrelse
   *
   * @return float
   */
  public function getTilskudsstoerrelse() {
    if ($this->tilskudsstoerrelse) {
      return $this->tilskudsstoerrelse;
    }

    $virksomhed = $this->getRapport()->getBygning()->getVirksomhed();

    if ($virksomhed) {
      if ($virksomhed->getTilskudstorelse(TRUE)) {
        return $virksomhed->getTilskudstorelse(TRUE);
      }
    }

    return 0;
  }

  /**
   * Get enhed
   *
   * @return string
   */
  public function getEnhed() {
    return $this->enhed;
  }

  /**
   * @ORM\PostLoad()
   */
  public function postLoad() {
    $this->initFormulableCalculation();
  }

}
