<?php
/**
 * @file
 * ELOKategori Entity.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * ELOKategori.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ELOKategori {
  use BlameableEntity;
  use TimestampableEntity;

  /**
   * Constructor
   */
  public function __construct() {
    $this->baselines = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer", nullable=true)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   *
   * @ORM\Column(name="navn", type="string", length=255, nullable=true)
   */
  protected $navn;

  /**
   * @ORM\OneToMany(targetEntity="Baseline", mappedBy="eloKategori")
   * @JMS\Type("Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Baseline>")
   */
  protected $baselines;

  /**
   * @ORM\OneToOne(targetEntity="ELOFordeling", mappedBy="eloKategoriFordelingVarmeGUF", fetch="EAGER")
   **/
  protected $fordelingVarmeGUF;

  /**
   * @ORM\OneToOne(targetEntity="ELOFordeling", mappedBy="eloKategoriFordelingVarmeGAF", fetch="EAGER")
   **/
  protected $fordelingVarmeGAF;

  /**
   * @ORM\OneToOne(targetEntity="ELOFordeling", mappedBy="eloKategoriFordelingEl", fetch="EAGER")
   **/
  protected $fordelingEl;

  /**
   * @var float
   *
   * Total varmeforbrug incl. varmt vand, klimakorrigeret
   *
   * @ORM\Column(name="totalVarmeforbrug", type="float", nullable=false)
   */
  protected $totalVarmeforbrug;

  /**
   * @var float
   *
   * Elforbrug
   *
   * @ORM\Column(name="totalElforbrug", type="float", nullable=false)
   */
  protected $totalElforbrug;

  /**
   * @var float
   *
   * GUF-andel [% af total varmeforbrug]
   *
   * @ORM\Column(name="andelVarmeGUFFaktor", type="float", nullable=false)
   */
  protected $andelVarmeGUFFaktor;

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
  public function getBaselines() {
    return $this->baselines;
  }

  /**
   * @param mixed $baselines
   */
  public function setBaselines($baselines) {
    $this->baselines = $baselines;
  }

  /**
   * @return mixed
   */
  public function getFordelingVarmeGUF() {
    return $this->fordelingVarmeGUF;
  }

  /**
   * @param mixed $fordelingVarmeGUF
   */
  public function setFordelingVarmeGUF($fordelingVarmeGUF) {
    $this->fordelingVarmeGUF = $fordelingVarmeGUF;
  }

  /**
   * @return mixed
   */
  public function getFordelingVarmeGAF() {
    return $this->fordelingVarmeGAF;
  }

  /**
   * @param mixed $fordelingVarmeGAF
   */
  public function setFordelingVarmeGAF($fordelingVarmeGAF) {
    $this->fordelingVarmeGAF = $fordelingVarmeGAF;
  }

  /**
   * @return mixed
   */
  public function getFordelingEl() {
    return $this->fordelingEl;
  }

  /**
   * @param mixed $fordelingEl
   */
  public function setFordelingEl($fordelingEl) {
    $this->fordelingEl = $fordelingEl;
  }

  /**
   * Add baseline
   *
   * @param \AppBundle\Entity\Baseline $baseline
   *
   * @return ELOKategori
   */
  public function addBaseline(\AppBundle\Entity\Baseline $baseline) {
    $this->baselines[] = $baseline;

    return $this;
  }

  /**
   * Remove baseline
   *
   * @param \AppBundle\Entity\Baseline $baseline
   */
  public function removeBaseline(\AppBundle\Entity\Baseline $baseline) {
    $this->baselines->removeElement($baseline);
  }

  /**
   * @return string
   */
  public function getNavn() {
    return $this->navn;
  }

  /**
   * @param string $navn
   */
  public function setNavn($navn) {
    $this->navn = $navn;
  }

  /**
   * @return float
   */
  public function getTotalVarmeforbrug() {
    return $this->totalVarmeforbrug;
  }

  /**
   * @param float $totalVarmeforbrug
   */
  public function setTotalVarmeforbrug($totalVarmeforbrug) {
    $this->totalVarmeforbrug = $totalVarmeforbrug;
  }

  /**
   * @return float
   */
  public function getTotalElforbrug() {
    return $this->totalElforbrug;
  }

  /**
   * @param float $totalElforbrug
   */
  public function setTotalElforbrug($totalElforbrug) {
    $this->totalElforbrug = $totalElforbrug;
  }

  /**
   * @return float
   */
  public function getAndelVarmeGUFFaktor() {
    return $this->andelVarmeGUFFaktor;
  }

  /**
   * @param float $andelVarmeGUFFaktor
   */
  public function setAndelVarmeGUFFaktor($andelVarmeGUFFaktor) {
    $this->andelVarmeGUFFaktor = $andelVarmeGUFFaktor;
  }
}
