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
use AppBundle\DBAL\Types\Baseline\ElKildePrimaerType;
use AppBundle\DBAL\Types\Baseline\ElKildeSekundaerType;
use AppBundle\Annotations\Calculated;

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
   * @var string
   *
   * @ORM\Column(name="elForbrugsdataPrimaerKilde", type="ElKildePrimaerType", nullable=true)
   */
  protected $elForbrugsdataPrimaerKilde;

  /**
   * @var string
   *
   * @ORM\Column(name="elForbrugsdataPrimaer1Aarstal", type="text", nullable=true)
   */
  protected $elForbrugsdataPrimaer1Aarstal;

  /**
   * @var float
   *
   * @ORM\Column(name="elForbrugsdataPrimaer1Forbrug", type="float", nullable=true)
   */
  protected $elForbrugsdataPrimaer1Forbrug;

  /**
   * @var string
   *
   * @ORM\Column(name="elForbrugsdataPrimaer2Aarstal", type="text", nullable=true)
   */
  protected $elForbrugsdataPrimaer2Aarstal;

  /**
   * @var float
   *
   * @ORM\Column(name="elForbrugsdataPrimaer2Forbrug", type="float", nullable=true)
   */
  protected $elForbrugsdataPrimaer2Forbrug;

  /**
   * @var string
   *
   * @ORM\Column(name="elForbrugsdataPrimaer3Aarstal", type="text", nullable=true)
   */
  protected $elForbrugsdataPrimaer3Aarstal;

  /**
   * @var float
   *
   * @ORM\Column(name="elForbrugsdataPrimaer3Forbrug", type="float", nullable=true)
   */
  protected $elForbrugsdataPrimaer3Forbrug;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="elForbrugsdataPrimaerGennemsnit", type="float", nullable=true)
   */
  protected $elForbrugsdataPrimaerGennemsnit;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="elForbrugsdataPrimaerNoegetal", type="float", nullable=true)
   */
  protected $elForbrugsdataPrimaerNoegetal;

  /**
   * @var string
   *
   * @ORM\Column(name="elForbrugsdataPrimaerNoter", type="text", nullable=true)
   */
  protected $elForbrugsdataPrimaerNoter;

  /**
   * @var string
   *
   * @ORM\Column(name="elForbrugsdataSekundaerKilde", type="ElKildeSekundaerType", nullable=true)
   */
  protected $elForbrugsdataSekundaerKilde;

  /**
   * @var string
   *
   * @ORM\Column(name="elForbrugsdataSekundaer1Aarstal", type="text", nullable=true)
   */
  protected $elForbrugsdataSekundaer1Aarstal;

  /**
   * @var float
   *
   * @ORM\Column(name="elForbrugsdataSekundaer1Forbrug", type="float", nullable=true)
   */
  protected $elForbrugsdataSekundaer1Forbrug;

  /**
   * @var string
   *
   * @ORM\Column(name="elForbrugsdataSekundaer2Aarstal", type="text", nullable=true)
   */
  protected $elForbrugsdataSekundaer2Aarstal;

  /**
   * @var float
   *
   * @ORM\Column(name="elForbrugsdataSekundaer2Forbrug", type="float", nullable=true)
   */
  protected $elForbrugsdataSekundaer2Forbrug;

  /**
   * @var string
   *
   * @ORM\Column(name="elForbrugsdataSekundaer3Aarstal", type="text", nullable=true)
   */
  protected $elForbrugsdataSekundaer3Aarstal;

  /**
   * @var float
   *
   * @ORM\Column(name="elForbrugsdataSekundaer3Forbrug", type="float", nullable=true)
   */
  protected $elForbrugsdataSekundaer3Forbrug;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="elForbrugsdataSekundaerGennemsnit", type="float", nullable=true)
   */
  protected $elForbrugsdataSekundaerGennemsnit;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="elForbrugsdataSekundaerNoegetal", type="float", nullable=true)
   */
  protected $elForbrugsdataSekundaerNoegetal;

  /**
   * @var string
   *
   * @ORM\Column(name="elForbrugsdataSekundaerNoter", type="text", nullable=true)
   */
  protected $elForbrugsdataSekundaerNoter;

  /**
   * @var float
   *
   * @ORM\Column(name="elBaselineFastsatForEjendom", type="float", nullable=true)
   */
  protected $elBaselineFastsatForEjendom;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="elBaselineNoegletalForEjendom", type="float", nullable=true)
   */
  protected $elBaselineNoegletalForEjendom;

  /**
   * @var float
   *
   * @ORM\Column(name="elBaselineNoter", type="float", nullable=true)
   */
  protected $elBaselineNoter;

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

  /**
   * @return string
   */
  public function getElForbrugsdataPrimaerKilde() {
    return $this->elForbrugsdataPrimaerKilde;
  }

  /**
   * @param string $elForbrugsdataPrimaerKilde
   */
  public function setElForbrugsdataPrimaerKilde($elForbrugsdataPrimaerKilde) {
    $this->elForbrugsdataPrimaerKilde = $elForbrugsdataPrimaerKilde;
  }

  /**
   * @return string
   */
  public function getElForbrugsdataPrimaer1Aarstal() {
    return $this->elForbrugsdataPrimaer1Aarstal;
  }

  /**
   * @param string $elForbrugsdataPrimaer1Aarstal
   */
  public function setElForbrugsdataPrimaer1Aarstal($elForbrugsdataPrimaer1Aarstal) {
    $this->elForbrugsdataPrimaer1Aarstal = $elForbrugsdataPrimaer1Aarstal;
  }

  /**
   * @return float
   */
  public function getElForbrugsdataPrimaer1Forbrug() {
    return $this->elForbrugsdataPrimaer1Forbrug;
  }

  /**
   * @param float $elForbrugsdataPrimaer1Forbrug
   */
  public function setElForbrugsdataPrimaer1Forbrug($elForbrugsdataPrimaer1Forbrug) {
    $this->elForbrugsdataPrimaer1Forbrug = $elForbrugsdataPrimaer1Forbrug;
  }

  /**
   * @return string
   */
  public function getElForbrugsdataPrimaer2Aarstal() {
    return $this->elForbrugsdataPrimaer2Aarstal;
  }

  /**
   * @param string $elForbrugsdataPrimaer2Aarstal
   */
  public function setElForbrugsdataPrimaer2Aarstal($elForbrugsdataPrimaer2Aarstal) {
    $this->elForbrugsdataPrimaer2Aarstal = $elForbrugsdataPrimaer2Aarstal;
  }

  /**
   * @return float
   */
  public function getElForbrugsdataPrimaer2Forbrug() {
    return $this->elForbrugsdataPrimaer2Forbrug;
  }

  /**
   * @param float $elForbrugsdataPrimaer2Forbrug
   */
  public function setElForbrugsdataPrimaer2Forbrug($elForbrugsdataPrimaer2Forbrug) {
    $this->elForbrugsdataPrimaer2Forbrug = $elForbrugsdataPrimaer2Forbrug;
  }

  /**
   * @return string
   */
  public function getElForbrugsdataPrimaer3Aarstal() {
    return $this->elForbrugsdataPrimaer3Aarstal;
  }

  /**
   * @param string $elForbrugsdataPrimaer3Aarstal
   */
  public function setElForbrugsdataPrimaer3Aarstal($elForbrugsdataPrimaer3Aarstal) {
    $this->elForbrugsdataPrimaer3Aarstal = $elForbrugsdataPrimaer3Aarstal;
  }

  /**
   * @return float
   */
  public function getElForbrugsdataPrimaer3Forbrug() {
    return $this->elForbrugsdataPrimaer3Forbrug;
  }

  /**
   * @param float $elForbrugsdataPrimaer3Forbrug
   */
  public function setElForbrugsdataPrimaer3Forbrug($elForbrugsdataPrimaer3Forbrug) {
    $this->elForbrugsdataPrimaer3Forbrug = $elForbrugsdataPrimaer3Forbrug;
  }

  /**
   * @return float
   */
  public function getElForbrugsdataPrimaerGennemsnit() {
    return $this->elForbrugsdataPrimaerGennemsnit;
  }

  /**
   * @param float $elForbrugsdataPrimaerGennemsnit
   */
  public function setElForbrugsdataPrimaerGennemsnit($elForbrugsdataPrimaerGennemsnit) {
    $this->elForbrugsdataPrimaerGennemsnit = $elForbrugsdataPrimaerGennemsnit;
  }

  /**
   * @return float
   */
  public function getElForbrugsdataPrimaerNoegetal() {
    return $this->elForbrugsdataPrimaerNoegetal;
  }

  /**
   * @param float $elForbrugsdataPrimaerNoegetal
   */
  public function setElForbrugsdataPrimaerNoegetal($elForbrugsdataPrimaerNoegetal) {
    $this->elForbrugsdataPrimaerNoegetal = $elForbrugsdataPrimaerNoegetal;
  }

  /**
   * @return string
   */
  public function getElForbrugsdataPrimaerNoter() {
    return $this->elForbrugsdataPrimaerNoter;
  }

  /**
   * @param string $elForbrugsdataPrimaerNoter
   */
  public function setElForbrugsdataPrimaerNoter($elForbrugsdataPrimaerNoter) {
    $this->elForbrugsdataPrimaerNoter = $elForbrugsdataPrimaerNoter;
  }

  /**
   * @return string
   */
  public function getElForbrugsdataSekundaerKilde() {
    return $this->elForbrugsdataSekundaerKilde;
  }

  /**
   * @param string $elForbrugsdataSekundaerKilde
   */
  public function setElForbrugsdataSekundaerKilde($elForbrugsdataSekundaerKilde) {
    $this->elForbrugsdataSekundaerKilde = $elForbrugsdataSekundaerKilde;
  }

  /**
   * @return string
   */
  public function getElForbrugsdataSekundaer1Aarstal() {
    return $this->elForbrugsdataSekundaer1Aarstal;
  }

  /**
   * @param string $elForbrugsdataSekundaer1Aarstal
   */
  public function setElForbrugsdataSekundaer1Aarstal($elForbrugsdataSekundaer1Aarstal) {
    $this->elForbrugsdataSekundaer1Aarstal = $elForbrugsdataSekundaer1Aarstal;
  }

  /**
   * @return float
   */
  public function getElForbrugsdataSekundaer1Forbrug() {
    return $this->elForbrugsdataSekundaer1Forbrug;
  }

  /**
   * @param float $elForbrugsdataSekundaer1Forbrug
   */
  public function setElForbrugsdataSekundaer1Forbrug($elForbrugsdataSekundaer1Forbrug) {
    $this->elForbrugsdataSekundaer1Forbrug = $elForbrugsdataSekundaer1Forbrug;
  }

  /**
   * @return string
   */
  public function getElForbrugsdataSekundaer2Aarstal() {
    return $this->elForbrugsdataSekundaer2Aarstal;
  }

  /**
   * @param string $elForbrugsdataSekundaer2Aarstal
   */
  public function setElForbrugsdataSekundaer2Aarstal($elForbrugsdataSekundaer2Aarstal) {
    $this->elForbrugsdataSekundaer2Aarstal = $elForbrugsdataSekundaer2Aarstal;
  }

  /**
   * @return float
   */
  public function getElForbrugsdataSekundaer2Forbrug() {
    return $this->elForbrugsdataSekundaer2Forbrug;
  }

  /**
   * @param float $elForbrugsdataSekundaer2Forbrug
   */
  public function setElForbrugsdataSekundaer2Forbrug($elForbrugsdataSekundaer2Forbrug) {
    $this->elForbrugsdataSekundaer2Forbrug = $elForbrugsdataSekundaer2Forbrug;
  }

  /**
   * @return string
   */
  public function getElForbrugsdataSekundaer3Aarstal() {
    return $this->elForbrugsdataSekundaer3Aarstal;
  }

  /**
   * @param string $elForbrugsdataSekundaer3Aarstal
   */
  public function setElForbrugsdataSekundaer3Aarstal($elForbrugsdataSekundaer3Aarstal) {
    $this->elForbrugsdataSekundaer3Aarstal = $elForbrugsdataSekundaer3Aarstal;
  }

  /**
   * @return float
   */
  public function getElForbrugsdataSekundaer3Forbrug() {
    return $this->elForbrugsdataSekundaer3Forbrug;
  }

  /**
   * @param float $elForbrugsdataSekundaer3Forbrug
   */
  public function setElForbrugsdataSekundaer3Forbrug($elForbrugsdataSekundaer3Forbrug) {
    $this->elForbrugsdataSekundaer3Forbrug = $elForbrugsdataSekundaer3Forbrug;
  }

  /**
   * @return float
   */
  public function getElForbrugsdataSekundaerGennemsnit() {
    return $this->elForbrugsdataSekundaerGennemsnit;
  }

  /**
   * @param float $elForbrugsdataSekundaerGennemsnit
   */
  public function setElForbrugsdataSekundaerGennemsnit($elForbrugsdataSekundaerGennemsnit) {
    $this->elForbrugsdataSekundaerGennemsnit = $elForbrugsdataSekundaerGennemsnit;
  }

  /**
   * @return float
   */
  public function getElForbrugsdataSekundaerNoegetal() {
    return $this->elForbrugsdataSekundaerNoegetal;
  }

  /**
   * @param float $elForbrugsdataSekundaerNoegetal
   */
  public function setElForbrugsdataSekundaerNoegetal($elForbrugsdataSekundaerNoegetal) {
    $this->elForbrugsdataSekundaerNoegetal = $elForbrugsdataSekundaerNoegetal;
  }

  /**
   * @return string
   */
  public function getElForbrugsdataSekundaerNoter() {
    return $this->elForbrugsdataSekundaerNoter;
  }

  /**
   * @param string $elForbrugsdataSekundaerNoter
   */
  public function setElForbrugsdataSekundaerNoter($elForbrugsdataSekundaerNoter) {
    $this->elForbrugsdataSekundaerNoter = $elForbrugsdataSekundaerNoter;
  }

  /**
   * @return float
   */
  public function getElBaselineFastsatForEjendom() {
    return $this->elBaselineFastsatForEjendom;
  }

  /**
   * @param float $elBaselineFastsatForEjendom
   */
  public function setElBaselineFastsatForEjendom($elBaselineFastsatForEjendom) {
    $this->elBaselineFastsatForEjendom = $elBaselineFastsatForEjendom;
  }

  /**
   * @return float
   */
  public function getElBaselineNoegletalForEjendom() {
    return $this->elBaselineNoegletalForEjendom;
  }

  /**
   * @param float $elBaselineNoegletalForEjendom
   */
  public function setElBaselineNoegletalForEjendom($elBaselineNoegletalForEjendom) {
    $this->elBaselineNoegletalForEjendom = $elBaselineNoegletalForEjendom;
  }

  /**
   * @return float
   */
  public function getElBaselineNoter() {
    return $this->elBaselineNoter;
  }

  /**
   * @param float $elBaselineNoter
   */
  public function setElBaselineNoter($elBaselineNoter) {
    $this->elBaselineNoter = $elBaselineNoter;
  }
}
