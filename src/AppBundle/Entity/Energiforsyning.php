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
   * @ORM\Column(name="navn", type="string", length=255)
   */
  protected $navn;

  /**
   * @var string
   *
   * @ORM\Column(name="beskrivelse", type="text")
   */
  protected $beskrivelse;

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

  public function setInternProduktioner($internProduktioner) {
    $this->internProduktioner = $internProduktioner;

    return $this;
  }

  public function addInternProduktion(InternProduktion $internProduktion) {
    $this->internProduktioner[] = $internProduktion;

    $internProduktion->setEnergiforsyning($this);

    return $this;
  }

  public function removeInternProduktion(InternProduktion $internProduktion) {
    $this->internProduktioner->removeElement($internProduktion);
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
      return $item->getPrisgrundlag() == 'VARME';
    })->toArray(), function($carry, $item) {
      return $carry + (1 + (1 - $item->getEffektivitet())) * $item->getFordeling();
    }, 0);
  }

  private function calculateSamletEleffektivitet() {
    return array_reduce($this->internProduktioner->filter(function($item) {
      return $item->getPrisgrundlag() == 'EL';
    })->toArray(), function($carry, $item) {
      return $carry + (1 + (1 - $item->getEffektivitet())) * $item->getFordeling();
    }, 0);
  }

  public function __toString() {
    return $this->navn;
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
