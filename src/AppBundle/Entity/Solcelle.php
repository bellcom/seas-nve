<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solcelle
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SolcelleRepository")
 */
class Solcelle {
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var float
   *
   * @ORM\Column(name="KWp", type="decimal", scale=4, precision=14)
   */
  protected $KWp;

  /**
   * @var float
   *
   * @ORM\Column(name="inverterpris", type="decimal", scale=4, precision=14)
   */
  protected $inverterpris;

  /**
   * @var float
   *
   * @ORM\Column(name="drift", type="decimal", scale=4, precision=14)
   */
  protected $drift;

  public function getId() {
    return $this->id;
  }

  public function setKWp($KWp) {
    $this->KWp = $KWp;

    return $this;
  }

  public function getKWp() {
    return $this->KWp;
  }

  public function setInverterpris($inverterpris) {
    $this->inverterpris = $inverterpris;

    return $this;
  }

  public function getInverterpris() {
    return $this->inverterpris;
  }

  public function setDrift($drift) {
    $this->drift = $drift;

    return $this;
  }

  public function getDrift() {
    return $this->drift;
  }

}
