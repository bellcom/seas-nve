<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\KontaktInformationRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * IndledningRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class IndledningRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Indledning';
        parent::__construct($params);
    }

}

