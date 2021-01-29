<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\KontaktInformationRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * EnergiportefoelgeRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class EnergiportefoelgeRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Energiportefølge';
        parent::__construct($params);
    }

}

