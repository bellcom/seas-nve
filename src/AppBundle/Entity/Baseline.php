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
use AppBundle\DBAL\Types\Baseline\VarmeKildePrimaerType;
use AppBundle\DBAL\Types\Baseline\VarmeKildeSekundaerType;
use AppBundle\DBAL\Types\Baseline\GUFFastsaettesEfterType;
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
   * Areal, der skal benyttes til nøgletalsanalyse
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
   * @var string
   *
   * @ORM\Column(name="elBaselineNoter", type="text", nullable=true)
   */
  protected $elBaselineNoter;


  /**
   * @var string
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaerKilde", type="VarmeKildePrimaerType", nullable=true)
   */
  protected $varmeForbrugsdataPrimaerKilde;

  /**
   * @var string
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaer1Aarstal", type="text", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer1Aarstal;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaer1Forbrug", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer1Forbrug;

  /**
   * @var string
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaer2Aarstal", type="text", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer2Aarstal;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaer2Forbrug", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer2Forbrug;

  /**
   * @var string
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaer3Aarstal", type="text", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer3Aarstal;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaer3Forbrug", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer3Forbrug;

  /**
   * @var string
   *
   * @ORM\Column(name="varmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter", type="GUFFastsaettesEfterType", nullable=true)
   */
  protected $varmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaer1SamletVarmeforbrugJuniJuliAugust", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer1SamletVarmeforbrugJuniJuliAugust;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaer2SamletVarmeforbrugJuniJuliAugust", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer2SamletVarmeforbrugJuniJuliAugust;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaer3SamletVarmeforbrugJuniJuliAugust", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer3SamletVarmeforbrugJuniJuliAugust;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaer1GUFRegAar", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer1GUFRegAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaer2GUFRegAar", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer2GUFRegAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaer3GUFRegAar", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer3GUFRegAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaer1GAFRegAar", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer1GAFRegAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaer2GAFRegAar", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer2GAFRegAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaer3GAFRegAar", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer3GAFRegAar;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaer1GDPeriode", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer1GDPeriode;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaer2GDPeriode", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer2GDPeriode;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaer3GDPeriode", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer3GDPeriode;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaer1GAFnormal", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer1GAFnormal;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaer2GAFnormal", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer2GAFnormal;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaer3GAFnormal", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer3GAFnormal;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaer1ForbrugKlimakorrigeret", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer1ForbrugKlimakorrigeret;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaer2ForbrugKlimakorrigeret", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer2ForbrugKlimakorrigeret;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaer3ForbrugKlimakorrigeret", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaer3ForbrugKlimakorrigeret;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaerGAFGennemsnit", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaerGAFGennemsnit;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaerGUFGennemsnit", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaerGUFGennemsnit;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaerGennemsnitKlimakorrigeret", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaerGennemsnitKlimakorrigeret;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataPrimaerNoegletal", type="float", nullable=true)
   */
  protected $varmeForbrugsdataPrimaerNoegletal;

  /**
   * @var string
   *
   * @ORM\Column(name="varmeForbrugsdataPrimaerNoter", type="text", nullable=true)
   */
  protected $varmeForbrugsdataPrimaerNoter;

  /**
   * @var string
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaerKilde", type="VarmeKildeSekundaerType", nullable=true)
   */
  protected $varmeForbrugsdataSekundaerKilde;

  /**
   * @var string
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaer1Aarstal", type="text", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer1Aarstal;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaer1Forbrug", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer1Forbrug;

  /**
   * @var string
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaer2Aarstal", type="text", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer2Aarstal;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaer2Forbrug", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer2Forbrug;

  /**
   * @var string
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaer3Aarstal", type="text", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer3Aarstal;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaer3Forbrug", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer3Forbrug;

  /**
   * @var string
   *
   * @ORM\Column(name="varmeForbrudsdataSekundaerGUFForbrugFastsaettesEfter", type="GUFFastsaettesEfterType", nullable=true)
   */
  protected $varmeForbrudsdataSekundaerGUFForbrugFastsaettesEfter;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaer1SamletVarmeforbrugJuniJuliAugust", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer1SamletVarmeforbrugJuniJuliAugust;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaer2SamletVarmeforbrugJuniJuliAugust", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer2SamletVarmeforbrugJuniJuliAugust;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaer3SamletVarmeforbrugJuniJuliAugust", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer3SamletVarmeforbrugJuniJuliAugust;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaer1GUFRegAar", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer1GUFRegAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaer2GUFRegAar", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer2GUFRegAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaer3GUFRegAar", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer3GUFRegAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaer1GAFRegAar", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer1GAFRegAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaer2GAFRegAar", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer2GAFRegAar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaer3GAFRegAar", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer3GAFRegAar;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaer1GDPeriode", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer1GDPeriode;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaer2GDPeriode", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer2GDPeriode;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaer3GDPeriode", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer3GDPeriode;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaer1GAFnormal", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer1GAFnormal;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaer2GAFnormal", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer2GAFnormal;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaer3GAFnormal", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer3GAFnormal;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaer1ForbrugKlimakorrigeret", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer1ForbrugKlimakorrigeret;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaer2ForbrugKlimakorrigeret", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer2ForbrugKlimakorrigeret;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaer3ForbrugKlimakorrigeret", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaer3ForbrugKlimakorrigeret;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaerGAFGennemsnit", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaerGAFGennemsnit;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaerGUFGennemsnit", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaerGUFGennemsnit;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaerGennemsnitKlimakorrigeret", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaerGennemsnitKlimakorrigeret;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeForbrugsdataSekundaerNoegletal", type="float", nullable=true)
   */
  protected $varmeForbrugsdataSekundaerNoegletal;

  /**
   * @var string
   *
   * @ORM\Column(name="varmeForbrugsdataSekundaerNoter", type="text", nullable=true)
   */
  protected $varmeForbrugsdataSekundaerNoter;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeGAFForbrug", type="float", nullable=true)
   */
  protected $varmeGAFForbrug;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeGUFForbrug", type="float", nullable=true)
   */
  protected $varmeGUFForbrug;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeBaselineFastsatForEjendom", type="float", nullable=true)
   */
  protected $varmeBaselineFastsatForEjendom;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="varmeBaselineNoegletalForEjendom", type="float", nullable=true)
   */
  protected $varmeBaselineNoegletalForEjendom;

  /**
   * @var float
   *
   * @ORM\Column(name="varmeStrafafkoelingsafgift", type="float", nullable=true)
   */
  protected $varmeStrafafkoelingsafgift;

  /**
   * @var string
   *
   * @ORM\Column(name="varmeBaselineNoter", type="text", nullable=true)
   */
  protected $varmeBaselineNoter;

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

  /**
   * @return string
   */
  public function getVarmeForbrugsdataPrimaerKilde() {
    return $this->varmeForbrugsdataPrimaerKilde;
  }

  /**
   * @param string $varmeForbrugsdataPrimaerKilde
   */
  public function setVarmeForbrugsdataPrimaerKilde($varmeForbrugsdataPrimaerKilde) {
    $this->varmeForbrugsdataPrimaerKilde = $varmeForbrugsdataPrimaerKilde;
  }

  /**
   * @return string
   */
  public function getVarmeForbrugsdataPrimaer1Aarstal() {
    return $this->varmeForbrugsdataPrimaer1Aarstal;
  }

  /**
   * @param string $varmeForbrugsdataPrimaer1Aarstal
   */
  public function setVarmeForbrugsdataPrimaer1Aarstal($varmeForbrugsdataPrimaer1Aarstal) {
    $this->varmeForbrugsdataPrimaer1Aarstal = $varmeForbrugsdataPrimaer1Aarstal;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer1Forbrug() {
    return $this->varmeForbrugsdataPrimaer1Forbrug;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer1Forbrug
   */
  public function setVarmeForbrugsdataPrimaer1Forbrug($varmeForbrugsdataPrimaer1Forbrug) {
    $this->varmeForbrugsdataPrimaer1Forbrug = $varmeForbrugsdataPrimaer1Forbrug;
  }

  /**
   * @return string
   */
  public function getVarmeForbrugsdataPrimaer2Aarstal() {
    return $this->varmeForbrugsdataPrimaer2Aarstal;
  }

  /**
   * @param string $varmeForbrugsdataPrimaer2Aarstal
   */
  public function setVarmeForbrugsdataPrimaer2Aarstal($varmeForbrugsdataPrimaer2Aarstal) {
    $this->varmeForbrugsdataPrimaer2Aarstal = $varmeForbrugsdataPrimaer2Aarstal;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer2Forbrug() {
    return $this->varmeForbrugsdataPrimaer2Forbrug;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer2Forbrug
   */
  public function setVarmeForbrugsdataPrimaer2Forbrug($varmeForbrugsdataPrimaer2Forbrug) {
    $this->varmeForbrugsdataPrimaer2Forbrug = $varmeForbrugsdataPrimaer2Forbrug;
  }

  /**
   * @return string
   */
  public function getVarmeForbrugsdataPrimaer3Aarstal() {
    return $this->varmeForbrugsdataPrimaer3Aarstal;
  }

  /**
   * @param string $varmeForbrugsdataPrimaer3Aarstal
   */
  public function setVarmeForbrugsdataPrimaer3Aarstal($varmeForbrugsdataPrimaer3Aarstal) {
    $this->varmeForbrugsdataPrimaer3Aarstal = $varmeForbrugsdataPrimaer3Aarstal;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer3Forbrug() {
    return $this->varmeForbrugsdataPrimaer3Forbrug;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer3Forbrug
   */
  public function setVarmeForbrugsdataPrimaer3Forbrug($varmeForbrugsdataPrimaer3Forbrug) {
    $this->varmeForbrugsdataPrimaer3Forbrug = $varmeForbrugsdataPrimaer3Forbrug;
  }

  /**
   * @return string
   */
  public function getVarmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter() {
    return $this->varmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter;
  }

  /**
   * @param string $varmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter
   */
  public function setVarmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter($varmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter) {
    $this->varmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter = $varmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer1SamletVarmeforbrugJuniJuliAugust() {
    return $this->varmeForbrugsdataPrimaer1SamletVarmeforbrugJuniJuliAugust;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer1SamletVarmeforbrugJuniJuliAugust
   */
  public function setVarmeForbrugsdataPrimaer1SamletVarmeforbrugJuniJuliAugust($varmeForbrugsdataPrimaer1SamletVarmeforbrugJuniJuliAugust) {
    $this->varmeForbrugsdataPrimaer1SamletVarmeforbrugJuniJuliAugust = $varmeForbrugsdataPrimaer1SamletVarmeforbrugJuniJuliAugust;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer2SamletVarmeforbrugJuniJuliAugust() {
    return $this->varmeForbrugsdataPrimaer2SamletVarmeforbrugJuniJuliAugust;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer2SamletVarmeforbrugJuniJuliAugust
   */
  public function setVarmeForbrugsdataPrimaer2SamletVarmeforbrugJuniJuliAugust($varmeForbrugsdataPrimaer2SamletVarmeforbrugJuniJuliAugust) {
    $this->varmeForbrugsdataPrimaer2SamletVarmeforbrugJuniJuliAugust = $varmeForbrugsdataPrimaer2SamletVarmeforbrugJuniJuliAugust;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer3SamletVarmeforbrugJuniJuliAugust() {
    return $this->varmeForbrugsdataPrimaer3SamletVarmeforbrugJuniJuliAugust;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer3SamletVarmeforbrugJuniJuliAugust
   */
  public function setVarmeForbrugsdataPrimaer3SamletVarmeforbrugJuniJuliAugust($varmeForbrugsdataPrimaer3SamletVarmeforbrugJuniJuliAugust) {
    $this->varmeForbrugsdataPrimaer3SamletVarmeforbrugJuniJuliAugust = $varmeForbrugsdataPrimaer3SamletVarmeforbrugJuniJuliAugust;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer1GUFRegAar() {
    return $this->varmeForbrugsdataPrimaer1GUFRegAar;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer1GUFRegAar
   */
  public function setVarmeForbrugsdataPrimaer1GUFRegAar($varmeForbrugsdataPrimaer1GUFRegAar) {
    $this->varmeForbrugsdataPrimaer1GUFRegAar = $varmeForbrugsdataPrimaer1GUFRegAar;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer2GUFRegAar() {
    return $this->varmeForbrugsdataPrimaer2GUFRegAar;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer2GUFRegAar
   */
  public function setVarmeForbrugsdataPrimaer2GUFRegAar($varmeForbrugsdataPrimaer2GUFRegAar) {
    $this->varmeForbrugsdataPrimaer2GUFRegAar = $varmeForbrugsdataPrimaer2GUFRegAar;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer3GUFRegAar() {
    return $this->varmeForbrugsdataPrimaer3GUFRegAar;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer3GUFRegAar
   */
  public function setVarmeForbrugsdataPrimaer3GUFRegAar($varmeForbrugsdataPrimaer3GUFRegAar) {
    $this->varmeForbrugsdataPrimaer3GUFRegAar = $varmeForbrugsdataPrimaer3GUFRegAar;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer1GAFRegAar() {
    return $this->varmeForbrugsdataPrimaer1GAFRegAar;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer1GAFRegAar
   */
  public function setVarmeForbrugsdataPrimaer1GAFRegAar($varmeForbrugsdataPrimaer1GAFRegAar) {
    $this->varmeForbrugsdataPrimaer1GAFRegAar = $varmeForbrugsdataPrimaer1GAFRegAar;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer2GAFRegAar() {
    return $this->varmeForbrugsdataPrimaer2GAFRegAar;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer2GAFRegAar
   */
  public function setVarmeForbrugsdataPrimaer2GAFRegAar($varmeForbrugsdataPrimaer2GAFRegAar) {
    $this->varmeForbrugsdataPrimaer2GAFRegAar = $varmeForbrugsdataPrimaer2GAFRegAar;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer3GAFRegAar() {
    return $this->varmeForbrugsdataPrimaer3GAFRegAar;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer3GAFRegAar
   */
  public function setVarmeForbrugsdataPrimaer3GAFRegAar($varmeForbrugsdataPrimaer3GAFRegAar) {
    $this->varmeForbrugsdataPrimaer3GAFRegAar = $varmeForbrugsdataPrimaer3GAFRegAar;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer1GDPeriode() {
    return $this->varmeForbrugsdataPrimaer1GDPeriode;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer1GDPeriode
   */
  public function setVarmeForbrugsdataPrimaer1GDPeriode($varmeForbrugsdataPrimaer1GDPeriode) {
    $this->varmeForbrugsdataPrimaer1GDPeriode = $varmeForbrugsdataPrimaer1GDPeriode;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer2GDPeriode() {
    return $this->varmeForbrugsdataPrimaer2GDPeriode;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer2GDPeriode
   */
  public function setVarmeForbrugsdataPrimaer2GDPeriode($varmeForbrugsdataPrimaer2GDPeriode) {
    $this->varmeForbrugsdataPrimaer2GDPeriode = $varmeForbrugsdataPrimaer2GDPeriode;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer3GDPeriode() {
    return $this->varmeForbrugsdataPrimaer3GDPeriode;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer3GDPeriode
   */
  public function setVarmeForbrugsdataPrimaer3GDPeriode($varmeForbrugsdataPrimaer3GDPeriode) {
    $this->varmeForbrugsdataPrimaer3GDPeriode = $varmeForbrugsdataPrimaer3GDPeriode;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer1GAFnormal() {
    return $this->varmeForbrugsdataPrimaer1GAFnormal;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer1GAFnormal
   */
  public function setVarmeForbrugsdataPrimaer1GAFnormal($varmeForbrugsdataPrimaer1GAFnormal) {
    $this->varmeForbrugsdataPrimaer1GAFnormal = $varmeForbrugsdataPrimaer1GAFnormal;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer2GAFnormal() {
    return $this->varmeForbrugsdataPrimaer2GAFnormal;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer2GAFnormal
   */
  public function setVarmeForbrugsdataPrimaer2GAFnormal($varmeForbrugsdataPrimaer2GAFnormal) {
    $this->varmeForbrugsdataPrimaer2GAFnormal = $varmeForbrugsdataPrimaer2GAFnormal;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer3GAFnormal() {
    return $this->varmeForbrugsdataPrimaer3GAFnormal;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer3GAFnormal
   */
  public function setVarmeForbrugsdataPrimaer3GAFnormal($varmeForbrugsdataPrimaer3GAFnormal) {
    $this->varmeForbrugsdataPrimaer3GAFnormal = $varmeForbrugsdataPrimaer3GAFnormal;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer1ForbrugKlimakorrigeret() {
    return $this->varmeForbrugsdataPrimaer1ForbrugKlimakorrigeret;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer1ForbrugKlimakorrigeret
   */
  public function setVarmeForbrugsdataPrimaer1ForbrugKlimakorrigeret($varmeForbrugsdataPrimaer1ForbrugKlimakorrigeret) {
    $this->varmeForbrugsdataPrimaer1ForbrugKlimakorrigeret = $varmeForbrugsdataPrimaer1ForbrugKlimakorrigeret;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer2ForbrugKlimakorrigeret() {
    return $this->varmeForbrugsdataPrimaer2ForbrugKlimakorrigeret;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer2ForbrugKlimakorrigeret
   */
  public function setVarmeForbrugsdataPrimaer2ForbrugKlimakorrigeret($varmeForbrugsdataPrimaer2ForbrugKlimakorrigeret) {
    $this->varmeForbrugsdataPrimaer2ForbrugKlimakorrigeret = $varmeForbrugsdataPrimaer2ForbrugKlimakorrigeret;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaer3ForbrugKlimakorrigeret() {
    return $this->varmeForbrugsdataPrimaer3ForbrugKlimakorrigeret;
  }

  /**
   * @param float $varmeForbrugsdataPrimaer3ForbrugKlimakorrigeret
   */
  public function setVarmeForbrugsdataPrimaer3ForbrugKlimakorrigeret($varmeForbrugsdataPrimaer3ForbrugKlimakorrigeret) {
    $this->varmeForbrugsdataPrimaer3ForbrugKlimakorrigeret = $varmeForbrugsdataPrimaer3ForbrugKlimakorrigeret;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaerGAFGennemsnit() {
    return $this->varmeForbrugsdataPrimaerGAFGennemsnit;
  }

  /**
   * @param float $varmeForbrugsdataPrimaerGAFGennemsnit
   */
  public function setVarmeForbrugsdataPrimaerGAFGennemsnit($varmeForbrugsdataPrimaerGAFGennemsnit) {
    $this->varmeForbrugsdataPrimaerGAFGennemsnit = $varmeForbrugsdataPrimaerGAFGennemsnit;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaerGUFGennemsnit() {
    return $this->varmeForbrugsdataPrimaerGUFGennemsnit;
  }

  /**
   * @param float $varmeForbrugsdataPrimaerGUFGennemsnit
   */
  public function setVarmeForbrugsdataPrimaerGUFGennemsnit($varmeForbrugsdataPrimaerGUFGennemsnit) {
    $this->varmeForbrugsdataPrimaerGUFGennemsnit = $varmeForbrugsdataPrimaerGUFGennemsnit;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaerGennemsnitKlimakorrigeret() {
    return $this->varmeForbrugsdataPrimaerGennemsnitKlimakorrigeret;
  }

  /**
   * @param float $varmeForbrugsdataPrimaerGennemsnitKlimakorrigeret
   */
  public function setVarmeForbrugsdataPrimaerGennemsnitKlimakorrigeret($varmeForbrugsdataPrimaerGennemsnitKlimakorrigeret) {
    $this->varmeForbrugsdataPrimaerGennemsnitKlimakorrigeret = $varmeForbrugsdataPrimaerGennemsnitKlimakorrigeret;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataPrimaerNoegletal() {
    return $this->varmeForbrugsdataPrimaerNoegletal;
  }

  /**
   * @param float $varmeForbrugsdataPrimaerNoegletal
   */
  public function setVarmeForbrugsdataPrimaerNoegletal($varmeForbrugsdataPrimaerNoegletal) {
    $this->varmeForbrugsdataPrimaerNoegletal = $varmeForbrugsdataPrimaerNoegletal;
  }

  /**
   * @return string
   */
  public function getVarmeForbrugsdataPrimaerNoter() {
    return $this->varmeForbrugsdataPrimaerNoter;
  }

  /**
   * @param string $varmeForbrugsdataPrimaerNoter
   */
  public function setVarmeForbrugsdataPrimaerNoter($varmeForbrugsdataPrimaerNoter) {
    $this->varmeForbrugsdataPrimaerNoter = $varmeForbrugsdataPrimaerNoter;
  }

  /**
   * @return string
   */
  public function getVarmeForbrugsdataSekundaerKilde() {
    return $this->varmeForbrugsdataSekundaerKilde;
  }

  /**
   * @param string $varmeForbrugsdataSekundaerKilde
   */
  public function setVarmeForbrugsdataSekundaerKilde($varmeForbrugsdataSekundaerKilde) {
    $this->varmeForbrugsdataSekundaerKilde = $varmeForbrugsdataSekundaerKilde;
  }

  /**
   * @return string
   */
  public function getVarmeForbrugsdataSekundaer1Aarstal() {
    return $this->varmeForbrugsdataSekundaer1Aarstal;
  }

  /**
   * @param string $varmeForbrugsdataSekundaer1Aarstal
   */
  public function setVarmeForbrugsdataSekundaer1Aarstal($varmeForbrugsdataSekundaer1Aarstal) {
    $this->varmeForbrugsdataSekundaer1Aarstal = $varmeForbrugsdataSekundaer1Aarstal;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer1Forbrug() {
    return $this->varmeForbrugsdataSekundaer1Forbrug;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer1Forbrug
   */
  public function setVarmeForbrugsdataSekundaer1Forbrug($varmeForbrugsdataSekundaer1Forbrug) {
    $this->varmeForbrugsdataSekundaer1Forbrug = $varmeForbrugsdataSekundaer1Forbrug;
  }

  /**
   * @return string
   */
  public function getVarmeForbrugsdataSekundaer2Aarstal() {
    return $this->varmeForbrugsdataSekundaer2Aarstal;
  }

  /**
   * @param string $varmeForbrugsdataSekundaer2Aarstal
   */
  public function setVarmeForbrugsdataSekundaer2Aarstal($varmeForbrugsdataSekundaer2Aarstal) {
    $this->varmeForbrugsdataSekundaer2Aarstal = $varmeForbrugsdataSekundaer2Aarstal;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer2Forbrug() {
    return $this->varmeForbrugsdataSekundaer2Forbrug;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer2Forbrug
   */
  public function setVarmeForbrugsdataSekundaer2Forbrug($varmeForbrugsdataSekundaer2Forbrug) {
    $this->varmeForbrugsdataSekundaer2Forbrug = $varmeForbrugsdataSekundaer2Forbrug;
  }

  /**
   * @return string
   */
  public function getVarmeForbrugsdataSekundaer3Aarstal() {
    return $this->varmeForbrugsdataSekundaer3Aarstal;
  }

  /**
   * @param string $varmeForbrugsdataSekundaer3Aarstal
   */
  public function setVarmeForbrugsdataSekundaer3Aarstal($varmeForbrugsdataSekundaer3Aarstal) {
    $this->varmeForbrugsdataSekundaer3Aarstal = $varmeForbrugsdataSekundaer3Aarstal;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer3Forbrug() {
    return $this->varmeForbrugsdataSekundaer3Forbrug;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer3Forbrug
   */
  public function setVarmeForbrugsdataSekundaer3Forbrug($varmeForbrugsdataSekundaer3Forbrug) {
    $this->varmeForbrugsdataSekundaer3Forbrug = $varmeForbrugsdataSekundaer3Forbrug;
  }

  /**
   * @return string
   */
  public function getVarmeForbrudsdataSekundaerGUFForbrugFastsaettesEfter() {
    return $this->varmeForbrudsdataSekundaerGUFForbrugFastsaettesEfter;
  }

  /**
   * @param string $varmeForbrudsdataSekundaerGUFForbrugFastsaettesEfter
   */
  public function setVarmeForbrudsdataSekundaerGUFForbrugFastsaettesEfter($varmeForbrudsdataSekundaerGUFForbrugFastsaettesEfter) {
    $this->varmeForbrudsdataSekundaerGUFForbrugFastsaettesEfter = $varmeForbrudsdataSekundaerGUFForbrugFastsaettesEfter;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer1SamletVarmeforbrugJuniJuliAugust() {
    return $this->varmeForbrugsdataSekundaer1SamletVarmeforbrugJuniJuliAugust;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer1SamletVarmeforbrugJuniJuliAugust
   */
  public function setVarmeForbrugsdataSekundaer1SamletVarmeforbrugJuniJuliAugust($varmeForbrugsdataSekundaer1SamletVarmeforbrugJuniJuliAugust) {
    $this->varmeForbrugsdataSekundaer1SamletVarmeforbrugJuniJuliAugust = $varmeForbrugsdataSekundaer1SamletVarmeforbrugJuniJuliAugust;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer2SamletVarmeforbrugJuniJuliAugust() {
    return $this->varmeForbrugsdataSekundaer2SamletVarmeforbrugJuniJuliAugust;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer2SamletVarmeforbrugJuniJuliAugust
   */
  public function setVarmeForbrugsdataSekundaer2SamletVarmeforbrugJuniJuliAugust($varmeForbrugsdataSekundaer2SamletVarmeforbrugJuniJuliAugust) {
    $this->varmeForbrugsdataSekundaer2SamletVarmeforbrugJuniJuliAugust = $varmeForbrugsdataSekundaer2SamletVarmeforbrugJuniJuliAugust;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer3SamletVarmeforbrugJuniJuliAugust() {
    return $this->varmeForbrugsdataSekundaer3SamletVarmeforbrugJuniJuliAugust;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer3SamletVarmeforbrugJuniJuliAugust
   */
  public function setVarmeForbrugsdataSekundaer3SamletVarmeforbrugJuniJuliAugust($varmeForbrugsdataSekundaer3SamletVarmeforbrugJuniJuliAugust) {
    $this->varmeForbrugsdataSekundaer3SamletVarmeforbrugJuniJuliAugust = $varmeForbrugsdataSekundaer3SamletVarmeforbrugJuniJuliAugust;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer1GUFRegAar() {
    return $this->varmeForbrugsdataSekundaer1GUFRegAar;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer1GUFRegAar
   */
  public function setVarmeForbrugsdataSekundaer1GUFRegAar($varmeForbrugsdataSekundaer1GUFRegAar) {
    $this->varmeForbrugsdataSekundaer1GUFRegAar = $varmeForbrugsdataSekundaer1GUFRegAar;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer2GUFRegAar() {
    return $this->varmeForbrugsdataSekundaer2GUFRegAar;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer2GUFRegAar
   */
  public function setVarmeForbrugsdataSekundaer2GUFRegAar($varmeForbrugsdataSekundaer2GUFRegAar) {
    $this->varmeForbrugsdataSekundaer2GUFRegAar = $varmeForbrugsdataSekundaer2GUFRegAar;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer3GUFRegAar() {
    return $this->varmeForbrugsdataSekundaer3GUFRegAar;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer3GUFRegAar
   */
  public function setVarmeForbrugsdataSekundaer3GUFRegAar($varmeForbrugsdataSekundaer3GUFRegAar) {
    $this->varmeForbrugsdataSekundaer3GUFRegAar = $varmeForbrugsdataSekundaer3GUFRegAar;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer1GAFRegAar() {
    return $this->varmeForbrugsdataSekundaer1GAFRegAar;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer1GAFRegAar
   */
  public function setVarmeForbrugsdataSekundaer1GAFRegAar($varmeForbrugsdataSekundaer1GAFRegAar) {
    $this->varmeForbrugsdataSekundaer1GAFRegAar = $varmeForbrugsdataSekundaer1GAFRegAar;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer2GAFRegAar() {
    return $this->varmeForbrugsdataSekundaer2GAFRegAar;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer2GAFRegAar
   */
  public function setVarmeForbrugsdataSekundaer2GAFRegAar($varmeForbrugsdataSekundaer2GAFRegAar) {
    $this->varmeForbrugsdataSekundaer2GAFRegAar = $varmeForbrugsdataSekundaer2GAFRegAar;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer3GAFRegAar() {
    return $this->varmeForbrugsdataSekundaer3GAFRegAar;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer3GAFRegAar
   */
  public function setVarmeForbrugsdataSekundaer3GAFRegAar($varmeForbrugsdataSekundaer3GAFRegAar) {
    $this->varmeForbrugsdataSekundaer3GAFRegAar = $varmeForbrugsdataSekundaer3GAFRegAar;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer1GDPeriode() {
    return $this->varmeForbrugsdataSekundaer1GDPeriode;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer1GDPeriode
   */
  public function setVarmeForbrugsdataSekundaer1GDPeriode($varmeForbrugsdataSekundaer1GDPeriode) {
    $this->varmeForbrugsdataSekundaer1GDPeriode = $varmeForbrugsdataSekundaer1GDPeriode;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer2GDPeriode() {
    return $this->varmeForbrugsdataSekundaer2GDPeriode;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer2GDPeriode
   */
  public function setVarmeForbrugsdataSekundaer2GDPeriode($varmeForbrugsdataSekundaer2GDPeriode) {
    $this->varmeForbrugsdataSekundaer2GDPeriode = $varmeForbrugsdataSekundaer2GDPeriode;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer3GDPeriode() {
    return $this->varmeForbrugsdataSekundaer3GDPeriode;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer3GDPeriode
   */
  public function setVarmeForbrugsdataSekundaer3GDPeriode($varmeForbrugsdataSekundaer3GDPeriode) {
    $this->varmeForbrugsdataSekundaer3GDPeriode = $varmeForbrugsdataSekundaer3GDPeriode;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer1GAFnormal() {
    return $this->varmeForbrugsdataSekundaer1GAFnormal;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer1GAFnormal
   */
  public function setVarmeForbrugsdataSekundaer1GAFnormal($varmeForbrugsdataSekundaer1GAFnormal) {
    $this->varmeForbrugsdataSekundaer1GAFnormal = $varmeForbrugsdataSekundaer1GAFnormal;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer2GAFnormal() {
    return $this->varmeForbrugsdataSekundaer2GAFnormal;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer2GAFnormal
   */
  public function setVarmeForbrugsdataSekundaer2GAFnormal($varmeForbrugsdataSekundaer2GAFnormal) {
    $this->varmeForbrugsdataSekundaer2GAFnormal = $varmeForbrugsdataSekundaer2GAFnormal;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer3GAFnormal() {
    return $this->varmeForbrugsdataSekundaer3GAFnormal;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer3GAFnormal
   */
  public function setVarmeForbrugsdataSekundaer3GAFnormal($varmeForbrugsdataSekundaer3GAFnormal) {
    $this->varmeForbrugsdataSekundaer3GAFnormal = $varmeForbrugsdataSekundaer3GAFnormal;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer1ForbrugKlimakorrigeret() {
    return $this->varmeForbrugsdataSekundaer1ForbrugKlimakorrigeret;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer1ForbrugKlimakorrigeret
   */
  public function setVarmeForbrugsdataSekundaer1ForbrugKlimakorrigeret($varmeForbrugsdataSekundaer1ForbrugKlimakorrigeret) {
    $this->varmeForbrugsdataSekundaer1ForbrugKlimakorrigeret = $varmeForbrugsdataSekundaer1ForbrugKlimakorrigeret;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer2ForbrugKlimakorrigeret() {
    return $this->varmeForbrugsdataSekundaer2ForbrugKlimakorrigeret;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer2ForbrugKlimakorrigeret
   */
  public function setVarmeForbrugsdataSekundaer2ForbrugKlimakorrigeret($varmeForbrugsdataSekundaer2ForbrugKlimakorrigeret) {
    $this->varmeForbrugsdataSekundaer2ForbrugKlimakorrigeret = $varmeForbrugsdataSekundaer2ForbrugKlimakorrigeret;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaer3ForbrugKlimakorrigeret() {
    return $this->varmeForbrugsdataSekundaer3ForbrugKlimakorrigeret;
  }

  /**
   * @param float $varmeForbrugsdataSekundaer3ForbrugKlimakorrigeret
   */
  public function setVarmeForbrugsdataSekundaer3ForbrugKlimakorrigeret($varmeForbrugsdataSekundaer3ForbrugKlimakorrigeret) {
    $this->varmeForbrugsdataSekundaer3ForbrugKlimakorrigeret = $varmeForbrugsdataSekundaer3ForbrugKlimakorrigeret;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaerGAFGennemsnit() {
    return $this->varmeForbrugsdataSekundaerGAFGennemsnit;
  }

  /**
   * @param float $varmeForbrugsdataSekundaerGAFGennemsnit
   */
  public function setVarmeForbrugsdataSekundaerGAFGennemsnit($varmeForbrugsdataSekundaerGAFGennemsnit) {
    $this->varmeForbrugsdataSekundaerGAFGennemsnit = $varmeForbrugsdataSekundaerGAFGennemsnit;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaerGUFGennemsnit() {
    return $this->varmeForbrugsdataSekundaerGUFGennemsnit;
  }

  /**
   * @param float $varmeForbrugsdataSekundaerGUFGennemsnit
   */
  public function setVarmeForbrugsdataSekundaerGUFGennemsnit($varmeForbrugsdataSekundaerGUFGennemsnit) {
    $this->varmeForbrugsdataSekundaerGUFGennemsnit = $varmeForbrugsdataSekundaerGUFGennemsnit;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaerGennemsnitKlimakorrigeret() {
    return $this->varmeForbrugsdataSekundaerGennemsnitKlimakorrigeret;
  }

  /**
   * @param float $varmeForbrugsdataSekundaerGennemsnitKlimakorrigeret
   */
  public function setVarmeForbrugsdataSekundaerGennemsnitKlimakorrigeret($varmeForbrugsdataSekundaerGennemsnitKlimakorrigeret) {
    $this->varmeForbrugsdataSekundaerGennemsnitKlimakorrigeret = $varmeForbrugsdataSekundaerGennemsnitKlimakorrigeret;
  }

  /**
   * @return float
   */
  public function getVarmeForbrugsdataSekundaerNoegletal() {
    return $this->varmeForbrugsdataSekundaerNoegletal;
  }

  /**
   * @param float $varmeForbrugsdataSekundaerNoegletal
   */
  public function setVarmeForbrugsdataSekundaerNoegletal($varmeForbrugsdataSekundaerNoegletal) {
    $this->varmeForbrugsdataSekundaerNoegletal = $varmeForbrugsdataSekundaerNoegletal;
  }

  /**
   * @return string
   */
  public function getVarmeForbrugsdataSekundaerNoter() {
    return $this->varmeForbrugsdataSekundaerNoter;
  }

  /**
   * @param string $varmeForbrugsdataSekundaerNoter
   */
  public function setVarmeForbrugsdataSekundaerNoter($varmeForbrugsdataSekundaerNoter) {
    $this->varmeForbrugsdataSekundaerNoter = $varmeForbrugsdataSekundaerNoter;
  }

  /**
   * @return float
   */
  public function getVarmeGAFForbrug() {
    return $this->varmeGAFForbrug;
  }

  /**
   * @param float $varmeGAFForbrug
   */
  public function setVarmeGAFForbrug($varmeGAFForbrug) {
    $this->varmeGAFForbrug = $varmeGAFForbrug;
  }

  /**
   * @return float
   */
  public function getVarmeGUFForbrug() {
    return $this->varmeGUFForbrug;
  }

  /**
   * @param float $varmeGUFForbrug
   */
  public function setVarmeGUFForbrug($varmeGUFForbrug) {
    $this->varmeGUFForbrug = $varmeGUFForbrug;
  }

  /**
   * @return float
   */
  public function getVarmeBaselineFastsatForEjendom() {
    return $this->varmeBaselineFastsatForEjendom;
  }

  /**
   * @param float $varmeBaselineFastsatForEjendom
   */
  public function setVarmeBaselineFastsatForEjendom($varmeBaselineFastsatForEjendom) {
    $this->varmeBaselineFastsatForEjendom = $varmeBaselineFastsatForEjendom;
  }

  /**
   * @return float
   */
  public function getVarmeBaselineNoegletalForEjendom() {
    return $this->varmeBaselineNoegletalForEjendom;
  }

  /**
   * @param float $varmeBaselineNoegletalForEjendom
   */
  public function setVarmeBaselineNoegletalForEjendom($varmeBaselineNoegletalForEjendom) {
    $this->varmeBaselineNoegletalForEjendom = $varmeBaselineNoegletalForEjendom;
  }

  /**
   * @return float
   */
  public function getVarmeStrafafkoelingsafgift() {
    return $this->varmeStrafafkoelingsafgift;
  }

  /**
   * @param float $varmeStrafafkoelingsafgift
   */
  public function setVarmeStrafafkoelingsafgift($varmeStrafafkoelingsafgift) {
    $this->varmeStrafafkoelingsafgift = $varmeStrafafkoelingsafgift;
  }

  /**
   * @return string
   */
  public function getVarmeBaselineNoter() {
    return $this->varmeBaselineNoter;
  }

  /**
   * @param string $varmeBaselineNoter
   */
  public function setVarmeBaselineNoter($varmeBaselineNoter) {
    $this->varmeBaselineNoter = $varmeBaselineNoter;
  }

  ///
  // Calculations
  ///

  /**
   * Calculate the entity.
   *
   * @param float|NULL $GDNormalAar
   */
  public function calculate($GDNormalAar = NULL) {
    // El
    $this->elForbrugsdataPrimaerGennemsnit = $this->calculateAverageOfThree($this->elForbrugsdataPrimaer1Forbrug, $this->elForbrugsdataPrimaer2Forbrug, $this->elForbrugsdataPrimaer3Forbrug);
    $this->elForbrugsdataPrimaerNoegetal = $this->calculateElForbrugsdataPrimaerNoegetal();
    $this->elForbrugsdataSekundaerGennemsnit = $this->calculateAverageOfThree($this->elForbrugsdataSekundaer1Forbrug, $this->elForbrugsdataSekundaer2Forbrug, $this->elForbrugsdataSekundaer3Forbrug);
    $this->elForbrugsdataSekundaerNoegetal = $this->calculateElForbrugsdataSekundaerNoegetal();
    $this->elBaselineNoegletalForEjendom = $this->calculateElBaselineNoegletalForEjendom();

    // Varme
    $this->varmeForbrugsdataPrimaer1GUFRegAar = $this->calculateVarmeForbrugsdataGUFRegAar($this->varmeForbrugsdataPrimaer1Forbrug, $this->varmeForbrugsdataPrimaer1SamletVarmeforbrugJuniJuliAugust, $this->varmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter);
    $this->varmeForbrugsdataPrimaer2GUFRegAar = $this->calculateVarmeForbrugsdataGUFRegAar($this->varmeForbrugsdataPrimaer2Forbrug, $this->varmeForbrugsdataPrimaer2SamletVarmeforbrugJuniJuliAugust, $this->varmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter);
    $this->varmeForbrugsdataPrimaer3GUFRegAar = $this->calculateVarmeForbrugsdataGUFRegAar($this->varmeForbrugsdataPrimaer3Forbrug, $this->varmeForbrugsdataPrimaer3SamletVarmeforbrugJuniJuliAugust, $this->varmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter);
    $this->varmeForbrugsdataPrimaer1GAFRegAar = $this->calculateVarmeForbrugsdataGAFRegAar($this->varmeForbrugsdataPrimaer1Forbrug, $this->varmeForbrugsdataPrimaer1GUFRegAar);
    $this->varmeForbrugsdataPrimaer2GAFRegAar = $this->calculateVarmeForbrugsdataGAFRegAar($this->varmeForbrugsdataPrimaer2Forbrug, $this->varmeForbrugsdataPrimaer2GUFRegAar);
    $this->varmeForbrugsdataPrimaer3GAFRegAar = $this->calculateVarmeForbrugsdataGAFRegAar($this->varmeForbrugsdataPrimaer3Forbrug, $this->varmeForbrugsdataPrimaer3GUFRegAar);
    $this->varmeForbrugsdataPrimaer1GAFnormal = $this->calculateVarmeForbrugsdataGAFNormal($this->varmeForbrugsdataPrimaer1GAFRegAar, $GDNormalAar, $this->varmeForbrugsdataPrimaer1GDPeriode);
    $this->varmeForbrugsdataPrimaer2GAFnormal = $this->calculateVarmeForbrugsdataGAFNormal($this->varmeForbrugsdataPrimaer2GAFRegAar, $GDNormalAar, $this->varmeForbrugsdataPrimaer2GDPeriode);
    $this->varmeForbrugsdataPrimaer3GAFnormal = $this->calculateVarmeForbrugsdataGAFNormal($this->varmeForbrugsdataPrimaer3GAFRegAar, $GDNormalAar, $this->varmeForbrugsdataPrimaer3GDPeriode);
    $this->varmeForbrugsdataPrimaer1ForbrugKlimakorrigeret = $this->calculateVarmeForbrugsdataForbrugKlimakorrigeret($this->varmeForbrugsdataPrimaer1GUFRegAar, $this->varmeForbrugsdataPrimaer1GAFnormal);
    $this->varmeForbrugsdataPrimaer2ForbrugKlimakorrigeret = $this->calculateVarmeForbrugsdataForbrugKlimakorrigeret($this->varmeForbrugsdataPrimaer2GUFRegAar, $this->varmeForbrugsdataPrimaer2GAFnormal);
    $this->varmeForbrugsdataPrimaer3ForbrugKlimakorrigeret = $this->calculateVarmeForbrugsdataForbrugKlimakorrigeret($this->varmeForbrugsdataPrimaer3GUFRegAar, $this->varmeForbrugsdataPrimaer3GAFnormal);
    $this->varmeForbrugsdataPrimaerGAFGennemsnit = $this->calculateAverageOfThree($this->varmeForbrugsdataPrimaer1GAFnormal, $this->varmeForbrugsdataPrimaer2GAFnormal, $this->varmeForbrugsdataPrimaer3GAFnormal);
    $this->varmeForbrugsdataPrimaerGUFGennemsnit = $this->calculateAverageOfThree($this->varmeForbrugsdataPrimaer1GUFRegAar, $this->varmeForbrugsdataPrimaer2GUFRegAar, $this->varmeForbrugsdataPrimaer3GUFRegAar);
    $this->varmeForbrugsdataPrimaerGennemsnitKlimakorrigeret = $this->calculateAverageOfThree($this->varmeForbrugsdataPrimaer1ForbrugKlimakorrigeret, $this->varmeForbrugsdataPrimaer2ForbrugKlimakorrigeret, $this->varmeForbrugsdataPrimaer3ForbrugKlimakorrigeret);
    $this->varmeForbrugsdataPrimaerNoegletal = $this->calculateVarmeForbrugsdataNoegletal($this->getVarmeForbrugsdataPrimaerGennemsnitKlimakorrigeret());

    $this->varmeForbrugsdataSekundaer1GUFRegAar = $this->calculateVarmeForbrugsdataGUFRegAar($this->varmeForbrugsdataSekundaer1Forbrug, $this->varmeForbrugsdataSekundaer1SamletVarmeforbrugJuniJuliAugust, $this->varmeForbrudsdataSekundaerGUFForbrugFastsaettesEfter);
    $this->varmeForbrugsdataSekundaer2GUFRegAar = $this->calculateVarmeForbrugsdataGUFRegAar($this->varmeForbrugsdataSekundaer2Forbrug, $this->varmeForbrugsdataSekundaer2SamletVarmeforbrugJuniJuliAugust, $this->varmeForbrudsdataSekundaerGUFForbrugFastsaettesEfter);
    $this->varmeForbrugsdataSekundaer3GUFRegAar = $this->calculateVarmeForbrugsdataGUFRegAar($this->varmeForbrugsdataSekundaer3Forbrug, $this->varmeForbrugsdataSekundaer3SamletVarmeforbrugJuniJuliAugust, $this->varmeForbrudsdataSekundaerGUFForbrugFastsaettesEfter);
    $this->varmeForbrugsdataSekundaer1GAFRegAar = $this->calculateVarmeForbrugsdataGAFRegAar($this->varmeForbrugsdataSekundaer1Forbrug, $this->varmeForbrugsdataSekundaer1GUFRegAar);
    $this->varmeForbrugsdataSekundaer2GAFRegAar = $this->calculateVarmeForbrugsdataGAFRegAar($this->varmeForbrugsdataSekundaer2Forbrug, $this->varmeForbrugsdataSekundaer2GUFRegAar);
    $this->varmeForbrugsdataSekundaer3GAFRegAar = $this->calculateVarmeForbrugsdataGAFRegAar($this->varmeForbrugsdataSekundaer3Forbrug, $this->varmeForbrugsdataSekundaer3GUFRegAar);
    $this->varmeForbrugsdataSekundaer1GAFnormal = $this->calculateVarmeForbrugsdataGAFNormal($this->varmeForbrugsdataSekundaer1GAFRegAar, $GDNormalAar, $this->varmeForbrugsdataSekundaer1GDPeriode);
    $this->varmeForbrugsdataSekundaer2GAFnormal = $this->calculateVarmeForbrugsdataGAFNormal($this->varmeForbrugsdataSekundaer2GAFRegAar, $GDNormalAar, $this->varmeForbrugsdataSekundaer2GDPeriode);
    $this->varmeForbrugsdataSekundaer3GAFnormal = $this->calculateVarmeForbrugsdataGAFNormal($this->varmeForbrugsdataSekundaer3GAFRegAar, $GDNormalAar, $this->varmeForbrugsdataSekundaer3GDPeriode);
    $this->varmeForbrugsdataSekundaer1ForbrugKlimakorrigeret = $this->calculateVarmeForbrugsdataForbrugKlimakorrigeret($this->varmeForbrugsdataSekundaer1GUFRegAar, $this->varmeForbrugsdataSekundaer1GAFnormal);
    $this->varmeForbrugsdataSekundaer2ForbrugKlimakorrigeret = $this->calculateVarmeForbrugsdataForbrugKlimakorrigeret($this->varmeForbrugsdataSekundaer2GUFRegAar, $this->varmeForbrugsdataSekundaer2GAFnormal);
    $this->varmeForbrugsdataSekundaer3ForbrugKlimakorrigeret = $this->calculateVarmeForbrugsdataForbrugKlimakorrigeret($this->varmeForbrugsdataSekundaer3GUFRegAar, $this->varmeForbrugsdataSekundaer3GAFnormal);
    $this->varmeForbrugsdataSekundaerGAFGennemsnit = $this->calculateAverageOfThree($this->varmeForbrugsdataSekundaer1GAFnormal, $this->varmeForbrugsdataSekundaer2GAFnormal, $this->varmeForbrugsdataSekundaer3GAFnormal);
    $this->varmeForbrugsdataSekundaerGUFGennemsnit = $this->calculateAverageOfThree($this->varmeForbrugsdataSekundaer1GUFRegAar, $this->varmeForbrugsdataSekundaer2GUFRegAar, $this->varmeForbrugsdataSekundaer3GUFRegAar);
    $this->varmeForbrugsdataSekundaerGennemsnitKlimakorrigeret = $this->calculateAverageOfThree($this->varmeForbrugsdataSekundaer1ForbrugKlimakorrigeret, $this->varmeForbrugsdataSekundaer2ForbrugKlimakorrigeret, $this->varmeForbrugsdataSekundaer3ForbrugKlimakorrigeret);
    $this->varmeForbrugsdataSekundaerNoegletal = $this->calculateVarmeForbrugsdataNoegletal($this->getVarmeForbrugsdataSekundaerGennemsnitKlimakorrigeret());

    $this->varmeBaselineFastsatForEjendom = $this->calculateVarmeBaselineFastsatForEjendom();
    $this->varmeBaselineNoegletalForEjendom = $this->calculateVarmeBaselineNoegletalForEjendom();
  }

  /**
   * Calculate ElForbrugsdataPrimaerNoegetal
   *
   * =IF('1. Areal'!D18="";"Indtast areal";IF(AND(C21="";D21="";E21="");"";C23/'1. Areal'!D18))
   *
   * @return float|null
   */
  public function calculateElForbrugsdataPrimaerNoegetal() {
    if (isset($this->elForbrugsdataPrimaerGennemsnit) && !empty($this->arealTilNoegletalsanalyse)) {
      return $this->elForbrugsdataPrimaerGennemsnit / $this->arealTilNoegletalsanalyse;
    }
    return null;
  }

  /**
   * Calculate ElForbrugsdataSekundaerNoegetal
   *
   * =IF('1. Areal'!D18="";"Indtast areal";IF(AND(C31="";D31="";E31="");"";C33/'1. Areal'!D18))
   *
   * @return float|null
   */
  public function calculateElForbrugsdataSekundaerNoegetal() {
    if (isset($this->elForbrugsdataSekundaerGennemsnit) && !empty($this->arealTilNoegletalsanalyse)) {
      return $this->elForbrugsdataSekundaerGennemsnit / $this->arealTilNoegletalsanalyse;
    }
    return null;
  }

  /**
   * Calculate ElBaselineNoegletalForEjendom
   *
   * =IF('1. Areal'!D18="";
   *    "Indtast areal";
   *    IF(C39="";
   *      "";
   *      C39/'1. Areal'!D18
   *    )
   *  )
   *
   * @return float|null
   */
  public function calculateElBaselineNoegletalForEjendom() {
    if (isset($this->elBaselineFastsatForEjendom) && !empty($this->arealTilNoegletalsanalyse)) {
      return $this->elBaselineFastsatForEjendom / $this->arealTilNoegletalsanalyse;
    }
    return null;
  }

  /**
   * Calculate VarmeForbrugsdataGUFRegAar
   *
   * =IF(C22="";                                                         // If !$forbrugUkorrigeret
   *    "";                                                              //   return null
   *                                                                     // Else
   *    IF(C24="";                                                       //   If !$samletVarmeforbrugJuniJuliAugust
   *      VLOOKUP(C13;'Nøgletal og GUF-andel'!$A$2:$E$19;5;FALSE)*C22;   //     return EloKategori->getGUFAndel() * $forbrugUkorrigeret
   *                                                                     //   Else
   *      IF(C23=Lopslag!M2;                                             //     If $GUFFastsaettesEfterType === "GUF-andel i procent pba ELO-nøgletal"
   *        VLOOKUP(C13;'Nøgletal og GUF-andel'!$A$2:$E$19;5;FALSE)*C22; //       return EloKategori->getGUFAndel() * $forbrugUkorrigeret
   *                                                                     //     Else
   *        ('3. Baseline til udbud, VARME'!C24/3)*12                    //       return $samletVarmeforbrugJuniJuliAugust / 3 * 12
   *      )
   *    )
   *  )
   *
   * @param $forbrugUkorrigeret
   * @param $samletVarmeforbrugJuniJuliAugust
   * @param $GUFFastsaettesEfterType
   *
   * @return float|null
   */
  public function calculateVarmeForbrugsdataGUFRegAar($forbrugUkorrigeret, $samletVarmeforbrugJuniJuliAugust, $GUFFastsaettesEfterType) {
    if (!isset($forbrugUkorrigeret)) {
      return null;
    }
    else {
      if (!isset($samletVarmeforbrugJuniJuliAugust) || $GUFFastsaettesEfterType == GUFFastsaettesEfterType::GUF_ANDEL_I_PROCENT_PBA_ELO_NOEGLETAL) {
        return $this->getEloKategori()->getAndelVarmeGUFFaktor() * $forbrugUkorrigeret;
      }
      else {
        return $samletVarmeforbrugJuniJuliAugust / 3 * 12;
      }
    }
  }

  /**
   * Calculate VarmeForbrugsdataGAFRegAar
   *
   * =IF(C22="";"";C22-C25)                  // Forbrug, (kWh/år), ukorrigeret - GUFreg.år
   *
   * @return float|null
   */
  public function calculateVarmeForbrugsdataGAFRegAar($forbrugUkorrigeret, $GUFRegAar) {
    if (isset($forbrugUkorrigeret) && isset($GUFRegAar)) {
      return $forbrugUkorrigeret - $GUFRegAar;
    }
    return null;
  }

  /**
   * Calculate VarmeForbrugsdataGAFNormal
   *
   * =IF(C22="";"";C26*(C27/C28))           // GAFreg.år * (GDnormal.år / GDperiode)
   *
   * @return float|null
   */
  public function calculateVarmeForbrugsdataGAFNormal($GAFRegAar, $GDNormalAar, $GDPeriode) {
    if (!empty($GDPeriode) && isset($GAFRegAar) && isset($GDNormalAar)) {
      return $GAFRegAar * ($GDNormalAar / $GDPeriode);
    }
    return null;
  }

  /**
   * Calculate VarmeForbrugsdataForbrugKlimakorrigeret
   *
   * =IF(C22="";"";C25+C26*(C27/C28))       // If !Forbrug,(kWh/år),ukorrigeret   return NULL
   *                                        // Else return  GUFreg.år + GAFreg.år * (GDnormal.år / GDperiode)
   *
   * @return float|null
   */
  public function calculateVarmeForbrugsdataForbrugKlimakorrigeret($GUFRegAar, $varmeForbrugsdataGAFNormal) {
    if (isset($GUFRegAar) && isset($varmeForbrugsdataGAFNormal)) {
      return $GUFRegAar + $varmeForbrugsdataGAFNormal;
    }
    return null;
  }

  /**
   * Calculate VarmeForbrugsdataNoegletal
   *
   * =IF('1. Areal'!D18="";"Indtast areal";IF(C35="";"";C35/'1. Areal'!D18))
   *
   * @return float|null
   */
  public function calculateVarmeForbrugsdataNoegletal($varmeForbrugsdataGennemsnitKlimakorrigeret) {
    if (isset($varmeForbrugsdataGennemsnitKlimakorrigeret) && !empty($this->arealTilNoegletalsanalyse)) {
      return $varmeForbrugsdataGennemsnitKlimakorrigeret / $this->arealTilNoegletalsanalyse;
    }
    return null;
  }

  /**
   * Calculate VarmeBaselineFastsatForEjendom
   *
   * =IF(OR(C62="";C63="");"[C62] eller [C63] mangler";C62+C63)
   *
   * @return float|null
   */
  public function calculateVarmeBaselineFastsatForEjendom() {
    if (isset($this->varmeGAFForbrug) && isset($this->varmeGUFForbrug)) {
      return $this->varmeGAFForbrug + $this->varmeGUFForbrug;
    }
    return null;
  }

  /**
   * Calculate VarmeBaselineNoegletalForEjendom
   *
   * =IF('1. Areal'!D18="";"Indtast areal";+C64/'1. Areal'!D18)
   *
   * @return float|null
   */
  public function calculateVarmeBaselineNoegletalForEjendom() {
    if (isset($this->varmeBaselineFastsatForEjendom) && !empty($this->arealTilNoegletalsanalyse)) {
      return $this->varmeBaselineFastsatForEjendom / $this->arealTilNoegletalsanalyse;
    }
    return null;
  }

  /**
   * Calculates the average of three values if set.
   *
   * @param float $value1
   * @param float $value2
   * @param float $value3
   * @return float|null
   */
  public function calculateAverageOfThree($value1, $value2, $value3) {
    $sum = 0.0;
    $number = 0;

    if (isset($value1)) {
      $number++;
      $sum += $value1;
    }
    if (isset($value2)) {
      $number++;
      $sum += $value2;
    }
    if (isset($value3)) {
      $number++;
      $sum += $value3;
    }

    if ($number == 0) {
      return null;
    }
    return $sum / $number;
  }
}
