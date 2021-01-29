<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\KontaktInformationRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * KonklusionRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class KonklusionRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Konklusion';
        parent::__construct($params);
    }

}

