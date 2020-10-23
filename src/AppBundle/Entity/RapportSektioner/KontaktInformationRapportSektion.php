<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\OpsummeringRapportSektionType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;

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
    public function __construct() {
        $this->title = 'KontaktIntinformation';
        parent::__construct();
    }

    public function getRapport() {
        return $this->getVirksomhedOversigtRapport();
    }
}

