<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * Tiltag
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PumpeTiltagRepository")
 */
class PumpeTiltag extends Tiltag {
  /**
   * @OneToMany(targetEntity="PumpeDetail", mappedBy="pumpetiltag", cascade={"persist", "remove"})
   */
  private $pumpedetails;

  /**
   * Constructor
   */
  public function __construct() {
    $this->pumpedetails = new \Doctrine\Common\Collections\ArrayCollection();
  }

  public function __toString() {
    return "Pumpetiltag";
  }

  /**
   * Add pumpedetails
   *
   * @param \AppBundle\Entity\PumpeDetail $pumpedetails
   * @return PumpeTiltag
   */
  public function addPumpedetail(\AppBundle\Entity\PumpeDetail $pumpedetails) {
    $this->pumpedetails[] = $pumpedetails;

    return $this;
  }

  /**
   * Remove pumpedetails
   *
   * @param \AppBundle\Entity\PumpeDetail $pumpedetails
   */
  public function removePumpedetail(\AppBundle\Entity\PumpeDetail $pumpedetails) {
    $this->pumpedetails->removeElement($pumpedetails);
  }

  /**
   * Get pumpedetails
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getPumpedetails() {
    return $this->pumpedetails;
  }
}
