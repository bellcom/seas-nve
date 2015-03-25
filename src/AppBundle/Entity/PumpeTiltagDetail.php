<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * PumpeTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PumpeDetailRepository")
 */
class PumpeTiltagDetail extends TiltagDetail {
  /**
   * @var string
   *
   * @ORM\Column(name="PumpeID", type="string", length=50)
   */
  private $pumpeID;

  /**
   * @var string
   *
   * @ORM\Column(name="Forsyningsomraade", type="string", length=255)
   */
  private $forsyningsomraade;

  /**
   * @var string
   *
   * @ORM\Column(name="Placering", type="string", length=255)
   */
  private $placering;

  /**
   * @var string
   *
   * @ORM\Column(name="Applikation", type="string", length=10)
   */
  private $applikation;

  /**
   * @var boolean
   *
   * @ORM\Column(name="Isoleringskappe", type="boolean")
   */
  private $isoleringskappe = false;

  /**
   * @var string
   *
   * @ORM\Column(name="b_faktor", type="decimal")
   */
  private $b_faktor;

  /**
   * @var string
   *
   * @ORM\Column(name="Noter", type="text")
   */
  private $noter;

  /**
   * @var integer
   *
   * @ORM\Column(name="EksisterendeDrifttid", type="integer")
   */
  private $eksisterendeDrifttid;

  /**
   * @var integer
   *
   * @ORM\Column(name="NyDrifttid", type="integer")
   */
  private $nyDrifttid;

  /**
   * @var string
   *
   * @ORM\Column(name="Prisfaktor", type="decimal")
   */
  private $prisfaktor;

  /**
   * @ManyToOne(targetEntity="Pumpe")
   * @JoinColumn(name="pumpe_id", referencedColumnName="id")
   **/
  private $pumpe;

  /**
   * Set pumpeID
   *
   * @param string $pumpeID
   * @return PumpeDetail
   */
  public function setPumpeID($pumpeID) {
    $this->pumpeID = $pumpeID;

    return $this;
  }

  /**
   * Get pumpeID
   *
   * @return string
   */
  public function getPumpeID() {
    return $this->pumpeID;
  }

  /**
   * Set forsyningsomraade
   *
   * @param string $forsyningsomraade
   * @return PumpeDetail
   */
  public function setForsyningsomraade($forsyningsomraade) {
    $this->forsyningsomraade = $forsyningsomraade;

    return $this;
  }

  /**
   * Get forsyningsomraade
   *
   * @return string
   */
  public function getForsyningsomraade() {
    return $this->forsyningsomraade;
  }

  /**
   * Set placering
   *
   * @param string $placering
   * @return PumpeDetail
   */
  public function setPlacering($placering) {
    $this->placering = $placering;

    return $this;
  }

  /**
   * Get placering
   *
   * @return string
   */
  public function getPlacering() {
    return $this->placering;
  }

  /**
   * Set applikation
   *
   * @param string $applikation
   * @return PumpeDetail
   */
  public function setApplikation($applikation) {
    $this->applikation = $applikation;

    return $this;
  }

  /**
   * Get applikation
   *
   * @return string
   */
  public function getApplikation() {
    return $this->applikation;
  }

  /**
   * Set isoleringskappe
   *
   * @param boolean $isoleringskappe
   * @return PumpeDetail
   */
  public function setIsoleringskappe($isoleringskappe) {
    $this->isoleringskappe = $isoleringskappe;

    return $this;
  }

  /**
   * Get isoleringskappe
   *
   * @return boolean
   */
  public function getIsoleringskappe() {
    return $this->isoleringskappe;
  }

  /**
   * Set b_faktor
   *
   * @param string $bFaktor
   * @return PumpeDetail
   */
  public function setBFaktor($bFaktor) {
    $this->b_faktor = $bFaktor;

    return $this;
  }

  /**
   * Get b_faktor
   *
   * @return string
   */
  public function getBFaktor() {
    return $this->b_faktor;
  }

  /**
   * Set noter
   *
   * @param string $noter
   * @return PumpeDetail
   */
  public function setNoter($noter) {
    $this->noter = $noter;

    return $this;
  }

  /**
   * Get noter
   *
   * @return string
   */
  public function getNoter() {
    return $this->noter;
  }

  /**
   * Set eksisterendeDrifttid
   *
   * @param integer $eksisterendeDrifttid
   * @return PumpeDetail
   */
  public function setEksisterendeDrifttid($eksisterendeDrifttid) {
    $this->eksisterendeDrifttid = $eksisterendeDrifttid;

    return $this;
  }

  /**
   * Get eksisterendeDrifttid
   *
   * @return integer
   */
  public function getEksisterendeDrifttid() {
    return $this->eksisterendeDrifttid;
  }

  /**
   * Set nyDrifttid
   *
   * @param integer $nyDrifttid
   * @return PumpeDetail
   */
  public function setNyDrifttid($nyDrifttid) {
    $this->nyDrifttid = $nyDrifttid;

    return $this;
  }

  /**
   * Get nyDrifttid
   *
   * @return integer
   */
  public function getNyDrifttid() {
    return $this->nyDrifttid;
  }

  /**
   * Set prisfaktor
   *
   * @param string $prisfaktor
   * @return PumpeDetail
   */
  public function setPrisfaktor($prisfaktor) {
    $this->prisfaktor = $prisfaktor;

    return $this;
  }

  /**
   * Get prisfaktor
   *
   * @return string
   */
  public function getPrisfaktor() {
    return $this->prisfaktor;
  }

  /**
   * Set pumpe
   *
   * @param \AppBundle\Entity\Pumpe $pumpe
   * @return PumpeDetail
   */
  public function setPumpe(Pumpe $pumpe = NULL) {
    $this->pumpe = $pumpe;
    $this->addData('pumpe', $pumpe);

    return $this;
  }

  /**
   * Get pumpe
   *
   * @return \AppBundle\Entity\Pumpe
   */
  public function getPumpe() {
    return $this->pumpe;
  }
}
