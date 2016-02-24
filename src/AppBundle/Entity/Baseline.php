<?php
/**
 * @file
 * Baseline Entity.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Baseline.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BaselineRepository")
 */
class Baseline {
  /**
   * Constructor
   */
  public function __construct() {}

  /**
   * @OneToOne(targetEntity="Bygning", inversedBy="baseline", fetch="EAGER")
   **/
  protected $bygning;
}
