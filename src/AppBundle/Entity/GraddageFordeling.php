<?php
/**
 * @file
 * GraddageFordeling Entity.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GraddageFordeling.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class GraddageFordeling extends AarsFordeling {
  /**
   * Constructor
   */
  public function __construct($titel, $januar = NULL, $februar = NULL, $marts = NULL, $april = NULL, $maj = NULL, $juni = NULL,
                              $juli = NULL, $august = NULL, $september = NULL, $oktober = NULL, $november = NULL, $december = NULL) {
    parent::__construct($januar, $februar, $marts, $april, $maj, $juni, $juli, $august, $september, $oktober, $november, $december);
    $this->titel = $titel;
  }

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer", nullable=true)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   *
   * @ORM\Column(name="titel", type="string", length=255, nullable=true)
   */
  protected $titel;

  /**
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getTitel() {
    return $this->titel;
  }

  /**
   * @param string $titel
   */
  public function setTitel($titel) {
    $this->titel = $titel;
  }

  /**
   * Get the sum of the year.
   *
   * @return float
   */
  public function getSumAar() {
    return
      $this->januar + $this->februar + $this->marts +
      $this->april + $this->maj + $this->juni +
      $this->juli + $this->august + $this->september +
      $this->oktober + $this->november + $this->december;
  }

  public function __toString() {
    return $this->titel;
  }
}
