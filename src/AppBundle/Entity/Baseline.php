<?php
/**
 * @file
 * Baseline Entity.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use AppBundle\Entity\ELOKategori;
use AppBundle\DBAL\Types\Baseline\ArealKildePrimaerType;
use AppBundle\DBAL\Types\Baseline\ArealKildeSekundaerType;

/**
 * Baseline.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BaselineRepository")
 */
class Baseline {
  use BlameableEntity;
  use TimestampableEntity;

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
   * @ORM\OneToOne(targetEntity="Bygning", mappedBy="baseline")
   **/
  protected $bygning;

  /**
   * @ORM\ManyToOne(targetEntity="ELOKategori", inversedBy="baselines")
   * @ORM\JoinColumn(name="elo_kategori_id", referencedColumnName="id")
   **/
  protected $eloKategori;

  /**
   * @var string
   *
   * @ORM\Column(name="arealdataPrimaerKilde", type="ArealKildePrimaerType", nullable=true)
   */
  protected $arealdataPrimaerKilde;

  /**
   * @var float
   *
   * @ORM\Column(name="arealdataPrimaerAreal", type="float", nullable=true)
   */
  protected $arealdataPrimaerAreal;

  /**
   * @var string
   *
   * @ORM\Column(name="arealdataPrimaerNoter", type="text", nullable=true)
   */
  protected $arealdataPrimaerNoter;

  /**
   * @var string
   *
   * @ORM\Column(name="arealdataSekundaerKilde", type="ArealKildeSekundaerType", nullable=true)
   */
  protected $arealdataSekundaerKilde;

  /**
   * @var float
   *
   * @ORM\Column(name="arealdataSekundaerAreal", type="float", nullable=true)
   */
  protected $arealdataSekundaerAreal;

  /**
   * @var float
   *
   * @ORM\Column(name="arealdataSekundaerNoter", type="text", nullable=true)
   */
  protected $arealdataSekundaerNoter;

  /**
   * @var float
   *
   * @ORM\Column(name="arealTilNoegletalsanalyse", type="float", nullable=true)
   */
  protected $arealTilNoegletalsanalyse;

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
  public function getBygning() {
    return $this->bygning;
  }

  /**
   * @param mixed $bygning
   */
  public function setBygning($bygning) {
    $this->bygning = $bygning;
  }

  /**
   * @return mixed
   */
  public function getEloKategori() {
    return $this->eloKategori;
  }

  /**
   * @param mixed $eloKategori
   */
  public function setEloKategori($eloKategori) {
    $this->eloKategori = $eloKategori;
  }

  /**
   * @return string
   */
  public function getArealdataPrimaerKilde() {
    return $this->arealdataPrimaerKilde;
  }

  /**
   * @param string $arealdataPrimaerKilde
   */
  public function setArealdataPrimaerKilde($arealdataPrimaerKilde) {
    $this->arealdataPrimaerKilde = $arealdataPrimaerKilde;
  }

  /**
   * @return float
   */
  public function getArealdataPrimaerAreal() {
    return $this->arealdataPrimaerAreal;
  }

  /**
   * @param float $arealdataPrimaerAreal
   */
  public function setArealdataPrimaerAreal($arealdataPrimaerAreal) {
    $this->arealdataPrimaerAreal = $arealdataPrimaerAreal;
  }

  /**
   * @return string
   */
  public function getArealdataPrimaerNoter() {
    return $this->arealdataPrimaerNoter;
  }

  /**
   * @param string $arealdataPrimaerNoter
   */
  public function setArealdataPrimaerNoter($arealdataPrimaerNoter) {
    $this->arealdataPrimaerNoter = $arealdataPrimaerNoter;
  }

  /**
   * @return string
   */
  public function getArealdataSekundaerKilde() {
    return $this->arealdataSekundaerKilde;
  }

  /**
   * @param string $arealdataSekundaerKilde
   */
  public function setArealdataSekundaerKilde($arealdataSekundaerKilde) {
    $this->arealdataSekundaerKilde = $arealdataSekundaerKilde;
  }

  /**
   * @return float
   */
  public function getArealdataSekundaerAreal() {
    return $this->arealdataSekundaerAreal;
  }

  /**
   * @param float $arealdataSekundaerAreal
   */
  public function setArealdataSekundaerAreal($arealdataSekundaerAreal) {
    $this->arealdataSekundaerAreal = $arealdataSekundaerAreal;
  }

  /**
   * @return float
   */
  public function getArealdataSekundaerNoter() {
    return $this->arealdataSekundaerNoter;
  }

  /**
   * @param float $arealdataSekundaerNoter
   */
  public function setArealdataSekundaerNoter($arealdataSekundaerNoter) {
    $this->arealdataSekundaerNoter = $arealdataSekundaerNoter;
  }

  /**
   * @return float
   */
  public function getArealTilNoegletalsanalyse() {
    return $this->arealTilNoegletalsanalyse;
  }

  /**
   * @param float $arealTilNoegletalsanalyse
   */
  public function setArealTilNoegletalsanalyse($arealTilNoegletalsanalyse) {
    $this->arealTilNoegletalsanalyse = $arealTilNoegletalsanalyse;
  }
}
