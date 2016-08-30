<?php

namespace AppBundle\Entity\TekniskIsoleringTiltagDetail;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Komponent
 *
 * @ORM\Table()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TekniskIsoleringTiltagDetail\KomponentRepository")
 */
class Komponent {
  use SoftDeleteableEntity;

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
   * @var string
   *
   * @ORM\Column(name="roerlaengde", type="decimal", scale=4)
   */
  private $roerlaengde;

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    return $this->getTitel().' (' . number_format($this->getRoerlaengde(), 2, ',', '.') . 'm)';
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
   * Set titel
   *
   * @param string $titel
   *
   * @return Komponent
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

  /**
   * Set roerlaengde
   *
   * @param float $roerlaengde
   *
   * @return Komponent
   */
  public function setRoerlaengde($roerlaengde) {
    $this->roerlaengde = $roerlaengde;

    return $this;
  }

  /**
   * Get roerlaengde
   *
   * @return float
   */
  public function getRoerlaengde() {
    return $this->roerlaengde;
  }

}
