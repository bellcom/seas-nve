<?php
/**
 * @file
 * ELOFordeling Entity.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ELOFordeling.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ELOFordeling {
  /**
   * Constructor
   */
  public function __construct() {}

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer", nullable=true)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\OneToOne(targetEntity="ELOKategori", inversedBy="fordelingVarmeGUF", fetch="EAGER")
   **/
  protected $eloKategoriFordelingVarmeGUF;

  /**
   * @ORM\OneToOne(targetEntity="ELOKategori", inversedBy="fordelingVarmeGAF", fetch="EAGER")
   **/
  protected $eloKategoriFordelingVarmeGAF;

  /**
   * @ORM\OneToOne(targetEntity="ELOKategori", inversedBy="fordelingEl", fetch="EAGER")
   **/
  protected $eloKategoriFordelingEl;

  /**
   * @var float
   *
   * @ORM\Column(name="januar", type="float", nullable=false)
   */
  protected $januar;

  /**
   * @var float
   *
   * @ORM\Column(name="februar", type="float", nullable=false)
   */
  protected $februar;

  /**
   * @var float
   *
   * @ORM\Column(name="marts", type="float", nullable=false)
   */
  protected $marts;

  /**
   * @var float
   *
   * @ORM\Column(name="april", type="float", nullable=false)
   */
  protected $april;

  /**
   * @var float
   *
   * @ORM\Column(name="maj", type="float", nullable=false)
   */
  protected $maj;

  /**
   * @var float
   *
   * @ORM\Column(name="juni", type="float", nullable=false)
   */
  protected $juni;

  /**
   * @var float
   *
   * @ORM\Column(name="juli", type="float", nullable=false)
   */
  protected $juli;

  /**
   * @var float
   *
   * @ORM\Column(name="august", type="float", nullable=false)
   */
  protected $august;

  /**
   * @var float
   *
   * @ORM\Column(name="september", type="float", nullable=false)
   */
  protected $september;

  /**
   * @var float
   *
   * @ORM\Column(name="oktober", type="float", nullable=false)
   */
  protected $oktober;

  /**
   * @var float
   *
   * @ORM\Column(name="november", type="float", nullable=false)
   */
  protected $november;

  /**
   * @var float
   *
   * @ORM\Column(name="december", type="float", nullable=false)
   */
  protected $december;

  /**
   * Get month value by month number 1-12
   *
   * @param $month
   * @return mixed
   */
  public function getMonth($month) {
    switch($month) {
      case 1: return $this->januar;
      case 2: return $this->februar;
      case 3: return $this->marts;
      case 4: return $this->april;
      case 5: return $this->maj;
      case 6: return $this->juni;
      case 7: return $this->juli;
      case 8: return $this->august;
      case 9: return $this->september;
      case 10: return $this->oktober;
      case 11: return $this->november;
      case 12: return $this->december;
    }
  }

  /**
   * Set month value by month number 1-12
   *
   * @param $month
   * @param $value
   * @return mixed
   */
  public function setMonth($month, $value) {
    switch($month) {
      case 1:
        $this->januar = $value;
        break;
      case 2:
        $this->februar = $value;
        break;
      case 3:
        $this->marts = $value;
        break;
      case 4:
        $this->april = $value;
        break;
      case 5:
        $this->maj = $value;
        break;
      case 6:
        $this->juni = $value;
        break;
      case 7:
        $this->juli = $value;
        break;
      case 8:
        $this->august = $value;
        break;
      case 9:
        $this->september = $value;
        break;
      case 10:
        $this->oktober = $value;
        break;
      case 11:
        $this->november = $value;
        break;
      case 12:
        $this->december = $value;
        break;
    }
  }

  /**
   * @return float
   */
  public function getJanuar() {
    return $this->januar;
  }

  /**
   * @param float $januar
   */
  public function setJanuar($januar) {
    $this->januar = $januar;
  }

  /**
   * @return float
   */
  public function getFebruar() {
    return $this->februar;
  }

  /**
   * @param float $februar
   */
  public function setFebruar($februar) {
    $this->februar = $februar;
  }

  /**
   * @return float
   */
  public function getMarts() {
    return $this->marts;
  }

  /**
   * @param float $marts
   */
  public function setMarts($marts) {
    $this->marts = $marts;
  }

  /**
   * @return float
   */
  public function getApril() {
    return $this->april;
  }

  /**
   * @param float $april
   */
  public function setApril($april) {
    $this->april = $april;
  }

  /**
   * @return float
   */
  public function getMaj() {
    return $this->maj;
  }

  /**
   * @param float $maj
   */
  public function setMaj($maj) {
    $this->maj = $maj;
  }

  /**
   * @return float
   */
  public function getJuni() {
    return $this->juni;
  }

  /**
   * @param float $juni
   */
  public function setJuni($juni) {
    $this->juni = $juni;
  }

  /**
   * @return float
   */
  public function getJuli() {
    return $this->juli;
  }

  /**
   * @param float $juli
   */
  public function setJuli($juli) {
    $this->juli = $juli;
  }

  /**
   * @return float
   */
  public function getAugust() {
    return $this->august;
  }

  /**
   * @param float $august
   */
  public function setAugust($august) {
    $this->august = $august;
  }

  /**
   * @return float
   */
  public function getSeptember() {
    return $this->september;
  }

  /**
   * @param float $september
   */
  public function setSeptember($september) {
    $this->september = $september;
  }

  /**
   * @return float
   */
  public function getOktober() {
    return $this->oktober;
  }

  /**
   * @param float $oktober
   */
  public function setOktober($oktober) {
    $this->oktober = $oktober;
  }

  /**
   * @return float
   */
  public function getNovember() {
    return $this->november;
  }

  /**
   * @param float $november
   */
  public function setNovember($november) {
    $this->november = $november;
  }

  /**
   * @return float
   */
  public function getDecember() {
    return $this->december;
  }

  /**
   * @param float $december
   */
  public function setDecember($december) {
    $this->december = $december;
  }

  /**
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return mixed
   */
  public function getEloKategoriFordelingVarmeGUF() {
    return $this->eloKategoriFordelingVarmeGUF;
  }

  /**
   * @param mixed $eloKategoriFordelingVarmeGUF
   */
  public function setEloKategoriFordelingVarmeGUF($eloKategoriFordelingVarmeGUF) {
    $this->eloKategoriFordelingVarmeGUF = $eloKategoriFordelingVarmeGUF;
  }

  /**
   * @return mixed
   */
  public function getEloKategoriFordelingVarmeGAF() {
    return $this->eloKategoriFordelingVarmeGAF;
  }

  /**
   * @param mixed $eloKategoriFordelingVarmeGAF
   */
  public function setEloKategoriFordelingVarmeGAF($eloKategoriFordelingVarmeGAF) {
    $this->eloKategoriFordelingVarmeGAF = $eloKategoriFordelingVarmeGAF;
  }

  /**
   * @return mixed
   */
  public function getEloKategoriFordelingEl() {
    return $this->eloKategoriFordelingEl;
  }

  /**
   * @param mixed $eloKategoriFordelingEl
   */
  public function setEloKategoriFordelingEl($eloKategoriFordelingEl) {
    $this->eloKategoriFordelingEl = $eloKategoriFordelingEl;
  }
}
