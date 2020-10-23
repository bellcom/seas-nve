<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\OpsummeringRapportSektionType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;

/**
 * ForsideRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ForsideRapportSektion extends RapportSektion {

    public function getAddress() {
        return $this->getVirksomhedOversigtRapport()->getVirksomhed()->getFullAddress();
    }

    public function getVirksomhedNavn() {
        return $this->getVirksomhedOversigtRapport()->getVirksomhed()->getName();
    }

    public function getDatering() {
        return $this->getVirksomhedOversigtRapport()->getDatering();
    }

    public function getBillede() {
        // @TODO add ability to edit this value.
        return 'https://picsum.photos/1000/750';
    }

    public function getRapportTypeNavn() {
        // @TODO add ability to edit this value.
        return 'Detailark';
    }

    public function getOverTekst() {
        // @TODO add ability to edit this value.
        return 'Energysysnsrapport';
    }

    public function getUnderTekst() {
        // @TODO add ability to edit this value.
        return 'Undersagsnavn';
    }
}

