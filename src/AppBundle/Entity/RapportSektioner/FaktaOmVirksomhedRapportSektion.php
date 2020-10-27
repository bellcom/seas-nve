<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\FaktaOmVirksomedRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * FaktaOmVirksomhedRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class FaktaOmVirksomhedRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Fakta om virksomhed';
        parent::__construct($params);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType() {
        return new FaktaOmVirksomedRapportSektionType();
    }

}

