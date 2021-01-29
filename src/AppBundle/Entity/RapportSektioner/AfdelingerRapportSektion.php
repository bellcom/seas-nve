<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\KontaktInformationRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * AfdelingerRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class AfdelingerRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Afdelinger';
        parent::__construct($params);
    }

}

