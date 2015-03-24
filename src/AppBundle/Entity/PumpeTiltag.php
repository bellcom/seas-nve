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

    // @Todo: Find af way to use the translations system or move this to some place else....
    $this->setTitle('Pumpeudskiftninger');
  }

  public function __toString() {
    return "Pumpetiltag";
  }
}
