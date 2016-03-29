<?php

namespace AppBundle\Entity\BelysningTiltagDetail;

use Doctrine\ORM\Mapping as ORM;

/**
 * BelysningTiltagDetail:NytArmatur
 *
 * @ORM\Table(name="BelysningTiltagDetail_NytArmatur")
 * @ORM\Entity
 */
class NytArmatur {
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
   * @ORM\Column(name="nyLyskildeAntal", type="integer", nullable=true)
   */
  private $nyLyskildeAntal;

  /**
   * @var integer
   *
   * @ORM\Column(name="wattage", type="integer", nullable=true)
   */
  private $wattage;

  /**
   * @var integer
   *
   * @ORM\Column(name="nyeForkoblingerAntal", type="integer", nullable=true)
   */
  private $nyeForkoblingerAntal;

  /**
   * @var float
   *
   * @ORM\Column(name="pris", type="decimal", scale=4, nullable=true)
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

  public function __toString() {
    return $this->arbejdeOmfang.' - '.number_format($this->pris, 2, ',', '.').' kr.';
  }

  /**
   * Set arbejdeOmfang
   *
   * @param string $arbejdeOmfang
   *
   * @return BelysningTiltagDetail:NytArmatur
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
   * Set nyLyskildeAntal
   *
   * @param integer $nyLyskildeAntal
   *
   * @return BelysningTiltagDetail:NytArmatur
   */
  public function setNyLyskildeAntal($nyLyskildeAntal) {
    $this->nyLyskildeAntal = $nyLyskildeAntal;

    return $this;
  }

  /**
   * Get nyLyskildeAntal
   *
   * @return integer
   */
  public function getNyLyskildeAntal() {
    return $this->nyLyskildeAntal;
  }

  /**
   * Set wattage
   *
   * @param integer $wattage
   *
   * @return BelysningTiltagDetail:NytArmatur
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
   * Set nyeForkoblingerAntal
   *
   * @param integer $nyeForkoblingerAntal
   *
   * @return BelysningTiltagDetail:NytArmatur
   */
  public function setNyeForkoblingerAntal($nyeForkoblingerAntal) {
    $this->nyeForkoblingerAntal = $nyeForkoblingerAntal;

    return $this;
  }

  /**
   * Get nyeForkoblingerAntal
   *
   * @return integer
   */
  public function getNyeForkoblingerAntal() {
    return $this->nyeForkoblingerAntal;
  }

  /**
   * Set pris
   *
   * @param float $pris
   *
   * @return BelysningTiltagDetail:NytArmatur
   */
  public function setPris($pris) {
    $this->pris = $pris;

    return $this;
  }

  /**
   * Get pris
   *
   * @return float
   */
  public function getPris() {
    return $this->pris;
  }

  /**
   * Set noter
   *
   * @param string $noter
   *
   * @return BelysningTiltagDetail:NytArmatur
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
}

