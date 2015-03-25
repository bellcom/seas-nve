<?php
/**
 * @file
 */

namespace AppBundle\Entity\BelysningTiltagDetail;

/**
 * The Styring class.
 */
class Styring {
  /**
   * The id.
   *
   * @var string
   */
  private $id;

  /**
   * The name.
   *
   * @var string
   */
  private $name;

  /**
   * Get id.
   *
   * @return string
   *   The id.
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set name.
   *
   * @param string $name
   *   The name.
   *
   * @return Styring
   *   The styring.
   */
  public function setName($name) {
    $this->name = $name;

    return $this;
  }

  /**
   * Get name.
   *
   * @return string
   *   The name.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Construct a new Styring.
   *
   * @param int $id
   *   The id.
   * @param string $name
   *   The name.
   */
  public function __construct($id, $name) {
    $this->id = $id;
    $this->setName($name);
  }

  /**
   * Convert to string.
   *
   * @return string
   *   The string.
   */
  public function __toString() {
    return $this->name;
  }

}
