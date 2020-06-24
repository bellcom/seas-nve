<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Formula;
use Doctrine\ORM\Mapping as ORM;

/**
 * NyKlimaskaermTiltag.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class NyKlimaskaermTiltag extends KlimaskaermTiltag {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        // @Todo: Find af way to use the translations system or move this to some place else....
        $this->setTitle('Klimaskærm');
    }

}
