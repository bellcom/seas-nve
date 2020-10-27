<?php

namespace AppBundle\Entity\RapportSektioner;

use Doctrine\ORM\Mapping as ORM;

/**
 * KontaktInformationRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class KontaktInformationRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct() {
        $this->title = 'KontaktIntinformation';
        parent::__construct();
    }

    public function getRapport() {
        return $this->getVirksomhedOversigtRapport();
    }
}

