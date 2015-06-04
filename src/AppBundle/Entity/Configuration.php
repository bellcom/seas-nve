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
  private $id;

  /**
   * @var double
   * @ORM\Column(name="rapport_kalkulationsrente", type="decimal", scale=4, nullable=true)
   */
  private $rapport_kalkulationsrente;

  /**
   * @var double
   * @ORM\Column(name="rapport_inflationsfaktor", type="decimal", scale=4, nullable=true)
   */
  private $rapport_inflationsfaktor;

  /**
   * @var double
   * @ORM\Column(name="rapport_inflation", type="decimal", scale=4, nullable=true)
   */
  private $rapport_inflation;

  /**
   * @var double
   * @ORM\Column(name="rapport_lobetid", type="decimal", scale=4, nullable=true)
   */
  private $rapport_lobetid;

  /**
   * @var double
   * @ORM\Column(name="rapport_elfaktor", type="decimal", scale=4, nullable=true)
   */
  private $rapport_elfaktor;

  /**
   * @var double
   * @ORM\Column(name="rapport_varmefaktor", type="decimal", scale=4, nullable=true)
   */
  private $rapport_varmefaktor;

  /**
   * @var double
   * @ORM\Column(name="rapport_vandfaktor", type="decimal", scale=4, nullable=true)
   */
  private $rapport_vandfaktor;

  /**
   * @var double
   * @ORM\Column(name="rapport_varmeKrKWh", type="decimal", scale=4, nullable=true)
   */
  private $rapport_varmeKrKWh;

  /**
   * @var double
   * @ORM\Column(name="rapport_elKrKWh", type="decimal", scale=4, nullable=true)
   */
  private $rapport_elKrKWh;

  /**
   * @var double
   * @ORM\Column(name="tekniskisolering_varmeledningsevneEksistLamelmaatter", type="decimal", scale=4, nullable=true)
   */
  private $tekniskisolering_varmeledningsevneEksistLamelmaatter;

  /**
   * @var double
   * @ORM\Column(name="tekniskisolering_varmeledningsevneNyIsolering", type="decimal", scale=4, nullable=true)
   */
  private $tekniskisolering_varmeledningsevneNyIsolering;

  public function setId($id) {
    $this->id = $id;
  }

  public function setKalkulationsrente($kalkulationsrente) {
    $this->rapport_kalkulationsrente = $kalkulationsrente;

    return $this;
  }

  public function getKalkulationsrente() {
    return $this->rapport_kalkulationsrente;
  }

  public function setInflationsfaktor($inflationsfaktor) {
    $this->rapport_inflationsfaktor = $inflationsfaktor;

    return $this;
  }

  public function getInflationsfaktor() {
    return $this->rapport_inflationsfaktor;
  }

  public function setInflation($inflation) {
    $this->rapport_inflation = $inflation;

    return $this;
  }

  public function getInflation() {
    return $this->rapport_inflation;
  }

  public function setLobetid($lobetid) {
    $this->rapport_lobetid = $lobetid;

    return $this;
  }

  public function getLobetid() {
    return $this->rapport_lobetid;
  }

  public function setElfaktor($elfaktor) {
    $this->rapport_elfaktor = $elfaktor;

    return $this;
  }

  public function getElfaktor() {
    return $this->rapport_elfaktor;
  }

  public function setVarmefaktor($varmefaktor) {
    $this->rapport_varmefaktor = $varmefaktor;

    return $this;
  }

  public function getVarmefaktor() {
    return $this->rapport_varmefaktor;
  }

  public function setVandfaktor($vandfaktor) {
    $this->rapport_vandfaktor = $vandfaktor;

    return $this;
  }

  public function getVandfaktor() {
    return $this->rapport_vandfaktor;
  }

  public function setVarmeKrKWh($varmeKrKWh) {
    $this->rapport_varmeKrKWh = $varmeKrKWh;

    return $this;
  }

  public function getVarmeKrKWh() {
    return $this->rapport_varmeKrKWh;
  }

  public function setElKrKWh($elKrKWh) {
    $this->rapport_elKrKWh = $elKrKWh;

    return $this;
  }

  public function getElKrKWh() {
    return $this->rapport_elKrKWh;
  }

  public function setVarmeledningsevneEksistLamelmaatter($varmeledningsevneEksistLamelmaatter) {
    $this->tekniskisolering_varmeledningsevneEksistLamelmaatter = $varmeledningsevneEksistLamelmaatter;

    return $this;
  }

  public function getVarmeledningsevneEksistLamelmaatter() {
    return $this->tekniskisolering_varmeledningsevneEksistLamelmaatter;
  }

  public function setVarmeledningsevneNyIsolering($varmeledningsevneNyIsolering) {
    $this->tekniskisolering_varmeledningsevneNyIsolering = $varmeledningsevneNyIsolering;

    return $this;
  }

  public function getVarmeledningsevneNyIsolering() {
    return $this->tekniskisolering_varmeledningsevneNyIsolering;
  }

}
