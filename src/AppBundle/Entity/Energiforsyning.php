<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Energiforsyning\InternProduktion;
use AppBundle\Annotations\Calculated;
use AppBundle\Calculation\Calculation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OrderBy;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\DBAL\Types\Energiforsyning\NavnType;
use AppBundle\DBAL\Types\Energiforsyning\InternProduktion\PrisgrundlagType;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * Energiforsyning
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\EnergiforsyningRepository")
 */
class Energiforsyning {
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ManyToOne(targetEntity="Rapport", inversedBy="energiforsyninger", fetch="EAGER")
   * @JoinColumn(name="rapport_id", referencedColumnName="id")
   **/
  protected $rapport;

  /**
   * @var string
   *
   * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\Energiforsyning\NavnType")
   * @ORM\Column(name="navn", type="NavnType", nullable=true)
   */
  protected $navn;

  /**
   * @var string
   *
   * @ORM\Column(name="beskrivelse", type="text")
   */
  protected $beskrivelse;

  /**
   * @var float
   *
   * @ORM\Column(name="prisfaktor", type="decimal", scale=4, nullable=true)
   */
  protected $prisfaktor;

  /**
   * @OneToMany(targetEntity="AppBundle\Entity\Energiforsyning\InternProduktion", mappedBy="energiforsyning", cascade={"persist", "remove"})
   * @OrderBy({"id" = "ASC"})
   * @JMS\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Energiforsyning\InternProduktion>")
   */
  protected $internProduktioner;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="samletVarmeeffektivitet", type="float", nullable=true)
   */
  protected $samletVarmeeffektivitet;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="samletEleffektivitet", type="float", nullable=true)
   */
  protected $samletEleffektivitet;

  public function getId() {
    return $this->id;
  }

  /**
   * Constructor
   */
  public function __construct() {
    $this->internProduktioner = new ArrayCollection();
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

  public function getRapport() {
    return $this->rapport;
  }

  public function setNavn($navn) {
    $this->navn = $navn;

    return $this;
  }

  public function getNavn() {
    return $this->navn;
  }

  public function setBeskrivelse($beskrivelse) {
    $this->beskrivelse = $beskrivelse;

    return $this;
  }

  public function getBeskrivelse() {
    return $this->beskrivelse;
  }

  public function getForsyningsvaerk() {
    if (!$this->getRapport() || !$this->getRapport()->getBygning()) {
      return NULL;
    }

    switch ($this->getNavn()) {
      case NavnType::FJERNVARME:
        return $this->getRapport()->getBygning()->getForsyningsvaerkVarme();
      case NavnType::OLIEFYR:
        return $this->getRapport()->getOlie();
      case NavnType::TRAEPILLEFYR:
        return $this->getRapport()->getTraepillefyr();
      case NavnType::HOVEDFORSYNING_EL:
      case NavnType::VARMEPUMPE:
        return $this->getRapport()->getBygning()->getForsyningsvaerkEl();
    }

    return NULL;
  }

  public function getEnhedspris() {
    $forsyningsvaerk = $this->getForsyningsvaerk();
    return $forsyningsvaerk ? $forsyningsvaerk->getKrKWh($this->getRapport()->getDatering()->format('Y')) : NULL;
  }

  public function setPrisfaktor($prisfaktor) {
    $this->prisfaktor = $prisfaktor;

    return $this;
  }

  public function getPrisfaktor() {
    return $this->prisfaktor ? $this->prisfaktor : 1;
  }

  public function getNyEnhedspris() {
    return $this->getEnhedspris() * $this->getPrisfaktor();
  }

  public function setInternProduktioner($internProduktioner) {
    $this->internProduktioner = $internProduktioner;

    return $this;
  }

  public function addInternProduktion(InternProduktion $internProduktion) {
    $this->internProduktioner[] = $internProduktion;

    $internProduktion->setEnergiforsyning($this);
    $this->calculate();

    return $this;
  }

  public function removeInternProduktion(InternProduktion $internProduktion) {
    $this->internProduktioner->removeElement($internProduktion);
    $this->calculate();
  }

  public function getInternProduktioner() {
    return $this->internProduktioner;
  }

  public function getSamletVarmeeffektivitet() {
    return $this->samletVarmeeffektivitet;
  }

  public function getSamletEleffektivitet() {
    return $this->samletEleffektivitet;
  }

  public function calculate() {
    $this->samletVarmeeffektivitet = $this->calculateSamletVarmeeffektivitet();
    $this->samletEleffektivitet = $this->calculateSamletEleffektivitet();
  }

  private function calculateSamletVarmeeffektivitet() {
    return array_reduce($this->internProduktioner->filter(function($item) {
      return $item->getPrisgrundlag() == PrisgrundlagType::VARME;
    })->toArray(), function($carry, $item) {
      return $carry + (1 + (1 - $item->getEffektivitet())) * $item->getFordeling();
    }, 0);
  }

  private function calculateSamletEleffektivitet() {
    return array_reduce($this->internProduktioner->filter(function($item) {
      return $item->getPrisgrundlag() == PrisgrundlagType::EL;
    })->toArray(), function($carry, $item) {
      return $carry + (1 + (1 - $item->getEffektivitet())) * $item->getFordeling();
    }, 0);
  }

  public function __toString() {
    return NavnType::getReadableValue($this->navn);
  }


  /*
   * Additional setter and getter to make automatic English singularization behave.
   * Symfony can thus get from internProduktions to internProduktion.
   */
  public function setInternProduktions($internProduktioner) {
    return $this->setInternProduktioner($internProduktioner);
  }

  public function getInternProduktions() {
    return $this->getInternProduktioner();
  }

}
