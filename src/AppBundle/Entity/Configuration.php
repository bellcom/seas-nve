<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Configuration
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ConfigurationRepository")
 */
class Configuration {
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   */
  protected $id;

  /**
   * @var float
   * @ORM\Column(name="rapport_kalkulationsrente", type="decimal", scale=4, nullable=true)
   */
  protected $rapportKalkulationsrente;

  /**
   * @var float
   * @ORM\Column(name="rapport_inflation", type="decimal", scale=4, nullable=true)
   */
  protected $rapportInflation;

  /**
   * @var float
   * @ORM\Column(name="rapport_lobetid", type="decimal", scale=4, nullable=true)
   */
  protected $rapportLobetid;

  /**
   * @var float
   * @ORM\Column(name="rapport_driftomkosningerfaktor", type="decimal", scale=4, nullable=true)
   */
  protected $rapportDriftomkostningerfaktor;

  /**
   * @var float
   * @ORM\Column(name="rapport_nominelEnergiprisstigning", type="decimal", scale=4, nullable=true)
   */
  protected $rapportNominelEnergiprisstigning;

  /**
   * @var float
   * @ORM\Column(name="rapport_procentAfInvestering", type="decimal", scale=4, nullable=true)
   */
  protected $rapportProcentAfInvestering = 0.1;

  /**
   * @var float
   * @ORM\Column(name="tekniskisolering_varmeledningsevneEksistLamelmaatter", type="decimal", scale=4, nullable=true)
   */
  protected $tekniskisoleringVarmeledningsevneEksistLamelmaatter;

  /**
   * @var float
   * @ORM\Column(name="tekniskisolering_varmeledningsevneNyIsolering", type="decimal", scale=4, nullable=true)
   */
  protected $tekniskisoleringVarmeledningsevneNyIsolering;

  /**
   * @var float
   * @ORM\Column(name="solcelletiltagdetail_energiprisstigningPctPrAar", type="decimal", scale=4, nullable=true)
   */
  protected $solcelletiltagdetailEnergiprisstigningPctPrAar;

	/**
   * @var float
   * @ORM\Column(name="solcelletiltagdetail_salgsprisFoerste10AarKrKWh", type="decimal", scale=4, nullable=true)
   */
  protected $solcelletiltagdetailSalgsprisFoerste10AarKrKWh;

	/**
   * @var float
   * @ORM\Column(name="solcelletiltagdetail_salgsprisEfter10AarKrKWh", type="decimal", scale=4, nullable=true)
   */
  protected $solcelletiltagdetailSalgsprisEfter10AarKrKWh;

	/**
   * @var float
   * @ORM\Column(type="decimal", scale=4, nullable=true)
   */
  protected $mtmFaellesomkostningerGrundpris = 5000;

  /**
   * @var float
   * @ORM\Column(type="decimal", scale=4, nullable=true)
   */
  protected $mtmFaellesomkostningerPrisPrM2 = 5.0000;

  /**
   * @var float
   * @ORM\Column(type="float")
   */
  protected $mtmFaellesomkostningerNulHvisArealMindreEnd;

  /**
   * @var float
   * @ORM\Column(type="float")
   */
  protected $mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd;

  public function setId($id) {
    $this->id = $id;
  }

  public function setRapportKalkulationsrente($kalkulationsrente) {
    $this->rapportKalkulationsrente = $kalkulationsrente;

    return $this;
  }

  public function getRapportKalkulationsrente() {
    return $this->rapportKalkulationsrente;
  }

  public function setRapportInflation($inflation) {
    $this->rapportInflation = $inflation;

    return $this;
  }

  public function getRapportInflation() {
    return $this->rapportInflation;
  }

  public function setRapportLobetid($lobetid) {
    $this->rapportLobetid = $lobetid;

    return $this;
  }

  public function getRapportLobetid() {
    return $this->rapportLobetid;
  }

  public function setRapportDriftomkostningerfaktor($faktor) {
    $this->rapportDriftomkostningerfaktor = $faktor;

    return $this;
  }

  public function getRapportDriftomkostningerfaktor() {
    return $this->rapportDriftomkostningerfaktor;
  }

  public function setRapportNominelEnergiprisstigning($rapport_nominelEnergiprisstigning) {
    $this->rapportNominelEnergiprisstigning = $rapport_nominelEnergiprisstigning;

    return $this;
  }

  public function getRapportNominelEnergiprisstigning() {
    return $this->rapportNominelEnergiprisstigning;
  }

  public function setRapportProcentAfInvestering($rapport_procentAfInvestering) {
    $this->rapportProcentAfInvestering = $rapport_procentAfInvestering;

    return $this;
  }

  public function getRapportProcentAfInvestering() {
    return $this->rapportProcentAfInvestering;
  }

  public function setTekniskIsoleringVarmeledningsevneEksistLamelmaatter($varmeledningsevneEksistLamelmaatter) {
    $this->tekniskisoleringVarmeledningsevneEksistLamelmaatter = $varmeledningsevneEksistLamelmaatter;

    return $this;
  }

  public function getTekniskIsoleringVarmeledningsevneEksistLamelmaatter() {
    return $this->tekniskisoleringVarmeledningsevneEksistLamelmaatter;
  }

  public function setTekniskIsoleringVarmeledningsevneNyIsolering($varmeledningsevneNyIsolering) {
    $this->tekniskisoleringVarmeledningsevneNyIsolering = $varmeledningsevneNyIsolering;

    return $this;
  }

  public function getTekniskIsoleringVarmeledningsevneNyIsolering() {
    return $this->tekniskisoleringVarmeledningsevneNyIsolering;
  }

  public function setSolcelletiltagdetailEnergiprisstigningPctPrAar($solcelletiltagdetailEnergiprisstigningPctPrAar) {
    $this->solcelletiltagdetailEnergiprisstigningPctPrAar = $solcelletiltagdetailEnergiprisstigningPctPrAar;

    return $this;
  }

  public function getSolcelletiltagdetailEnergiprisstigningPctPrAar() {
    return $this->solcelletiltagdetailEnergiprisstigningPctPrAar;
  }

  public function setSolcelletiltagdetailSalgsprisFoerste10AarKrKWh($solcelletiltagdetailSalgsprisFoerste10AarKrKWh) {
    $this->solcelletiltagdetailSalgsprisFoerste10AarKrKWh = $solcelletiltagdetailSalgsprisFoerste10AarKrKWh;

    return $this;
  }

  public function getSolcelletiltagdetailSalgsprisFoerste10AarKrKWh() {
    return $this->solcelletiltagdetailSalgsprisFoerste10AarKrKWh;
  }

  public function setSolcelletiltagdetailSalgsprisEfter10AarKrKWh($solcelletiltagdetailSalgsprisEfter10AarKrKWh) {
    $this->solcelletiltagdetailSalgsprisEfter10AarKrKWh = $solcelletiltagdetailSalgsprisEfter10AarKrKWh;

    return $this;
  }

  public function getSolcelletiltagdetailSalgsprisEfter10AarKrKWh() {
    return $this->solcelletiltagdetailSalgsprisEfter10AarKrKWh;
  }

  public function setMtmFaellesomkostningerGrundpris($mtmFaellesomkostningerGrundpris) {
    $this->mtmFaellesomkostningerGrundpris = $mtmFaellesomkostningerGrundpris;

    return $this;
  }

  public function getMtmFaellesomkostningerGrundpris() {
    return $this->mtmFaellesomkostningerGrundpris;
  }

  public function setMtmFaellesomkostningerPrisPrM2($mtmFaellesomkostningerPrisPrM2) {
    $this->mtmFaellesomkostningerPrisPrM2 = $mtmFaellesomkostningerPrisPrM2;

    return $this;
  }

  public function getMtmFaellesomkostningerPrisPrM2() {
    return $this->mtmFaellesomkostningerPrisPrM2;
  }

  public function setMtmFaellesomkostningerNulHvisArealMindreEnd($mtmFaellesomkostningerNulHvisArealMindreEnd) {
      $this->mtmFaellesomkostningerNulHvisArealMindreEnd = $mtmFaellesomkostningerNulHvisArealMindreEnd;

      return $this;
  }

  public function getMtmFaellesomkostningerNulHvisArealMindreEnd() {
      return $this->mtmFaellesomkostningerNulHvisArealMindreEnd;
  }

  public function setMtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd($mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd) {
      $this->mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd = $mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd;

      return $this;
  }

  public function getMtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd() {
      return $this->mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd;
  }
}
