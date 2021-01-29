<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\KontaktInformationRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * KortlaegningRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class KortlaegningRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Kortlægning og analyser';
        parent::__construct($params);
    }

}

