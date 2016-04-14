<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;

/**
 * BaselineKorrektion
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class BaselineKorrektion {
  use BlameableEntity;
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
   * @ORM\ManyToOne(targetEntity="Baseline", inversedBy="korrektioner")
   * @ORM\JoinColumn(name="baseline_id", referencedColumnName="id")
   **/
  protected $baseline;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="datoForImplementering", type="date", nullable=true)
   */
  private $datoForImplementering;

  /**
   * @var string
   *
   * @ORM\Column(name="beskrivelse", type="text", nullable=true)
   */
  private $beskrivelse;

  /**
   * @var string
   *
   * @ORM\Column(name="korrektionEl", type="decimal", nullable=true)
   */
  private $korrektionEl;

  /**
   * @var string
   *
   * @ORM\Column(name="korrektionGAF", type="decimal", nullable=true)
   */
  private $korrektionGAF;

  /**
   * @var string
   *
   * @ORM\Column(name="korrektionGUF", type="decimal", nullable=true)
   */
  private $korrektionGUF;

  /**
   * @var string
   *
   * @ORM\Column(name="kilde", type="string", length=255, nullable=true)
   */
  private $kilde;

  /**
   * @var boolean
   *
   * @ORM\Column(name="indvirkning", type="boolean", nullable=true)
   */
  private $indvirkning;


  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
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
    if($baseline) {
      $baseline->addKorrektioner($this);
    }
  }

  /**
   * Set datoForImplementering
   *
   * @param \DateTime $datoForImplementering
   *
   * @return BaselineKorrektion
   */
  public function setDatoForImplementering($datoForImplementering) {
    $this->datoForImplementering = $datoForImplementering;

    return $this;
  }

  /**
   * Get datoForImplementering
   *
   * @return \DateTime
   */
  public function getDatoForImplementering() {
    return $this->datoForImplementering;
  }

  /**
   * Set beskrivelse
   *
   * @param string $beskrivelse
   *
   * @return BaselineKorrektion
   */
  public function setBeskrivelse($beskrivelse) {
    $this->beskrivelse = $beskrivelse;

    return $this;
  }

  /**
   * Get beskrivelse
   *
   * @return string
   */
  public function getBeskrivelse() {
    return $this->beskrivelse;
  }

  /**
   * Set korrektionEl
   *
   * @param string $korrektionEl
   *
   * @return BaselineKorrektion
   */
  public function setKorrektionEl($korrektionEl) {
    $this->korrektionEl = $korrektionEl;

    return $this;
  }

  /**
   * Get korrektionEl
   *
   * @return string
   */
  public function getKorrektionEl() {
    return $this->korrektionEl;
  }

  /**
   * Set korrektionGAF
   *
   * @param string $korrektionGAF
   *
   * @return BaselineKorrektion
   */
  public function setKorrektionGAF($korrektionGAF) {
    $this->korrektionGAF = $korrektionGAF;

    return $this;
  }

  /**
   * Get korrektionGAF
   *
   * @return string
   */
  public function getKorrektionGAF() {
    return $this->korrektionGAF;
  }

  /**
   * Set korrektionGUF
   *
   * @param string $korrektionGUF
   *
   * @return BaselineKorrektion
   */
  public function setKorrektionGUF($korrektionGUF) {
    $this->korrektionGUF = $korrektionGUF;

    return $this;
  }

  /**
   * Get korrektionGUF
   *
   * @return string
   */
  public function getKorrektionGUF() {
    return $this->korrektionGUF;
  }

  /**
   * Set kilde
   *
   * @param string $kilde
   *
   * @return BaselineKorrektion
   */
  public function setKilde($kilde) {
    $this->kilde = $kilde;

    return $this;
  }

  /**
   * Get kilde
   *
   * @return string
   */
  public function getKilde() {
    return $this->kilde;
  }

  /**
   * Set indvirkning
   *
   * @param boolean $indvirkning
   *
   * @return BaselineKorrektion
   */
  public function setIndvirkning($indvirkning) {
    $this->indvirkning = $indvirkning;

    return $this;
  }

  /**
   * Get indvirkning
   *
   * @return boolean
   */
  public function getIndvirkning() {
    return $this->indvirkning;
  }
}

