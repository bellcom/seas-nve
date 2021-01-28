<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Formula;
use Doctrine\ORM\Mapping as ORM;

/**
 * BelysningTiltag.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class VindueTiltag extends NyKlimaskaermTiltag {

  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();

    // @Todo: Find af way to use the translations system or move this to some place else....
    $this->setTitle('Vindue');
  }

  /**
   * {@inheritDoc}
   */
  protected function calculateForbrugFoerVarme() {
    $result = $this->sum(function($detail) { return abs($detail->getEWEksKWhM2Aar()); });
    return $result;
  }

}
