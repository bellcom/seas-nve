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
  protected $rapport_kalkulationsrente;

  /**
   * @var float
   * @ORM\Column(name="rapport_inflation", type="decimal", scale=4, nullable=true)
   */
  protected $rapport_inflation;

  /**
   * @var float
   * @ORM\Column(name="rapport_lobetid", type="decimal", scale=4, nullable=true)
   */
  protected $rapport_lobetid;

  /**
   * @var float
   * @ORM\Column(name="rapport_nominelEnergiprisstigning", type="decimal", scale=4, nullable=true)
   */
  protected $rapport_nominelEnergiprisstigning;

  /**
   * @var float
   * @ORM\Column(name="tekniskisolering_varmeledningsevneEksistLamelmaatter", type="decimal", scale=4, nullable=true)
   */
  protected $tekniskisolering_varmeledningsevneEksistLamelmaatter;

  /**
   * @var float
   * @ORM\Column(name="tekniskisolering_varmeledningsevneNyIsolering", type="decimal", scale=4, nullable=true)
   */
  protected $tekniskisolering_varmeledningsevneNyIsolering;

  /**
   * @var float
   * @ORM\Column(name="solcelle_forringetYdeevnePrAar", type="decimal", scale=4, nullable=true)
   */
  protected $solcelle_forringetYdeevnePrAar;

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

  public function setNominelEnergiprisstigning($rapport_nominelEnergiprisstigning) {
    $this->rapport_nominelEnergiprisstigning = $rapport_nominelEnergiprisstigning;

    return $this;
  }

  public function getNominelEnergiprisstigning() {
    return $this->rapport_nominelEnergiprisstigning;
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
