<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\OpsummeringRapportSektionType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;

/**
 * KundeinformationRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class KontaktinformationRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct() {
        $this->title = 'Kundeinformation';
        parent::__construct();
    }

    public function getRapport() {
        return $this->getVirksomhedOversigtRapport();
    }
}

