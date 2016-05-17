<?php

namespace AppBundle\Entity\BelysningTiltagDetail;

use Doctrine\ORM\Mapping as ORM;

/**
 * NyLyskilde
 *
 * @ORM\Table(name="BelysningTiltagDetail_ErstatningsLyskilde")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BelysningTiltagDetail\ErstatningsLyskildeRepository")
 */
class ErstatningsLyskilde {
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="arbejde_omfang", type="string", length=255)
   */
  private $arbejdeOmfang;

  /**
   * @var integer
   *
   * @ORM\Column(name="antal", type="integer", nullable=true)
   */
  private $antal;

  /**
   * @var integer
   *
   * @ORM\Column(name="wattage", type="integer", nullable=true)
   */
  private $wattage;

  /**
   * @var integer
   *
   * @ORM\Column(name="nyeForkoblinger", type="integer", nullable=true)
   */
  private $nyeForkoblinger;

  /**
   * @var string
   *
   * @ORM\Column(name="pris", type="decimal", scale=2, nullable=true)
   */
  private $pris;

  /**
   * @var string
   *
   * @ORM\Column(name="noter", type="string", length=255, nullable=true)
   */
  private $noter;


  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set arbejdeOmfang
   *
   * @param string $arbejdeOmfang
   *
   * @return NyLyskilde
   */
  public function setArbejdeOmfang($arbejdeOmfang) {
    $this->arbejdeOmfang = $arbejdeOmfang;

    return $this;
  }

  /**
   * Get arbejdeOmfang
   *
   * @return string
   */
  public function getArbejdeOmfang() {
    return $this->arbejdeOmfang;
  }

  /**
   * Set antal
   *
   * @param integer $antal
   *
   * @return NyLyskilde
   */
  public function setAntal($antal) {
    $this->antal = $antal;

    return $this;
  }

  /**
   * Get antal
   *
   * @return integer
   */
  public function getAntal() {
    return $this->antal;
  }

  /**
   * Set wattage
   *
   * @param integer $wattage
   *
   * @return NyLyskilde
   */
  public function setWattage($wattage) {
    $this->wattage = $wattage;

    return $this;
  }

  /**
   * Get wattage
   *
   * @return integer
   */
  public function getWattage() {
    return $this->wattage;
  }

  /**
   * Set nyeForkoblinger
   *
   * @param integer $nyeForkoblinger
   *
   * @return NyLyskilde
   */
  public function setNyeForkoblinger($nyeForkoblinger) {
    $this->nyeForkoblinger = $nyeForkoblinger;

    return $this;
  }

  /**
   * Get nyeForkoblinger
   *
   * @return integer
   */
  public function getNyeForkoblinger() {
    return $this->nyeForkoblinger;
  }

  /**
   * Set pris
   *
   * @param string $pris
   *
   * @return NyLyskilde
   */
  public function setPris($pris) {
    $this->pris = $pris;

    return $this;
  }

  /**
   * Get pris
   *
   * @return string
   */
  public function getPris() {
    return $this->pris;
  }

  /**
   * Set noter
   *
   * @param string $noter
   *
   * @return NyLyskilde
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

  public function __toString() {
    $result = $this->arbejdeOmfang;

    if($this->wattage) {
      $result .= ' - '.$this->wattage.'w';
    }

    if($this->pris) {
      $result .= ' - '.number_format($this->pris, 2, ',', '.').' kr';
    }
    return $result;
  }

}

