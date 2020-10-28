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
    public function __construct($params) {
        $this->title = 'Kontaktinformation';
        parent::__construct($params);
    }

    public function getRapport() {
        return $this->getVirksomhedOversigtRapport();
    }
}

