<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\FaktaOmVirksomedRapportSektionType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;

/**
 * FaktaOmVirksomhed
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class FaktaOmVirksomhedSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct() {
        $this->title = 'Fakta om virksomhed';
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType() {
        return new FaktaOmVirksomedRapportSektionType();
    }

}

