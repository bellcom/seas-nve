<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\OpsummeringRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * OpsummeringRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class OpsummeringRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Opsummering';
        parent::__construct($params);
    }

    /**
     * Defines allowed actions with SektionType.
     *
     * @return array
     */
    protected function allowedActions() {
        return array(
            self::ACTION_ADD,
            self::ACTION_DELETE
        );
    }

}

