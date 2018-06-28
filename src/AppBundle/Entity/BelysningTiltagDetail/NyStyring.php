<?php

namespace AppBundle\Entity\BelysningTiltagDetail;

use Doctrine\ORM\Mapping as ORM;

/**
 * Styring
 *
 * @ORM\Table(name="BelysningTiltagDetail_NyStyring")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BelysningTiltagDetail\NyStyringRepository")
 */
class NyStyring {
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
   * @ORM\Column(name="titel", type="string", length=255)
   */
  private $titel;

  /**
   * @var float
   *
   * @ORM\Column(name="pris", type="decimal", scale=4, nullable=true)
   */
  protected $pris;

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
   * Set titel
   *
   * @param string $titel
   *
   * @return Styring
   */
  public function setTitel($titel) {
    $this->titel = $titel;

    return $this;
  }

  /**
   * Get titel
   *
   * @return string
   */
  public function getTitel() {
    return $this->titel;
  }

  public function __toString() {
    $result = $this->titel;

    if($this->pris) {
      $result .= ' - '.number_format($this->pris, 2, ',', '.').' kr';
    }
    return $result;
  }

  /**
   * @return float
   */
  public function getPris() {
    return $this->pris;
  }

  /**
   * @param float $pris
   */
  public function setPris($pris) {
    $this->pris = $pris;
  }

  /**
   * @return string
   */
  public function getNoter() {
    return $this->noter;
  }

  /**
   * @param string $noter
   */
  public function setNoter($noter) {
    $this->noter = $noter;
  }

  /**
   * @var \DateTime $deactivatedAt
   *
   * @ORM\Column(name="deactivated_at", type="datetime", nullable=true)
   */
  private $deactivatedAt;

}
