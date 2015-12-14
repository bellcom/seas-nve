<?php

namespace AppBundle\Entity\TekniskIsoleringTiltagDetail;

use Doctrine\ORM\Mapping as ORM;

/**
 * NyttiggjortVarme
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class NyttiggjortVarme {
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var float
   *
   * @ORM\Column(name="faktor", type="float")
   */
  private $faktor;

  /**
   * @var string
   *
   * @ORM\Column(name="titel", type="string", length=255)
   */
  private $titel;

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    return $this->getFaktor().' - '.$this->getTitel();
  }

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set faktor
   *
   * @param float $faktor
   *
   * @return NyttiggjortVarme
   */
  public function setFaktor($faktor) {
    $this->faktor = $faktor;

    return $this;
  }

  /**
   * Get faktor
   *
   * @return float
   */
  public function getFaktor() {
    return $this->faktor;
  }

  /**
   * Set titel
   *
   * @param string $titel
   *
   * @return NyttiggjortVarme
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
}

