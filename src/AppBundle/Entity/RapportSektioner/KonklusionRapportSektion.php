<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\RapportSektionWithHiddenType;
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

    /**
     * {@inheritdoc }
     */
    public function getFormType() {
        return new RapportSektionWithHiddenType();
    }

}

