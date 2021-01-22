<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Calculation\Calculation;
use AppBundle\Form\Type\RapportSektion\OpsummeringRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * OpsummeringRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class OpsummeringRapportSektion extends RapportSektion implements SamletForbrugGrafDataInterface, ROIGrafDataInterface {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Opsummering';
        parent::__construct($params);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType() {
        return new OpsummeringRapportSektionType();
    }

    public function getAnbefalinger () {
        $anbefalinger = $this->getRapportSections()->filter(function ($section) { return $section->getType() == 'anbefaling'; });
        return array_values($anbefalinger->toArray());
    }

    public function getSeasAnbefalerUnderTekst () {
        return $this->getExtrasKeyValue('seasAnbefalerUnderTekst');
    }

    public function getPotentieltBesparesleKwh() {
        return $this->getRapport()->getSamletEnergibesparelse();
    }

    public function getPotentieltBesparesleKr() {
        return $this->getRapport()->getSamletEnergibesparelseKr();
    }

    public function getPotentieltBesparesleCo2() {
        return $this->getRapport()->getForbrugFoerCo2() -  $this->getRapport()->getForbrugEfterCo2();
    }

    /**
     * {@inheritDoc}
     */
    public function getNuvaerendeForbrug() {
        return $this->getRapport()->getForbrugFoer();
    }

    /**
     * {@inheritDoc}
     */
    public function getOptimeretForbrug() {
        return $this->getRapport()->getForbrugEfter();
    }

    /**
     * {@inheritDoc}
     */
    public function getOptimeretForbrugKr() {
        return $this->getRapport()->getForbrugEfterKr();
    }

    /**
     * {@inheritDoc}
     */
    public function getNuvaerendeForbrugKr() {
        return $this->getRapport()->getForbrugFoerKr();
    }

    /**
     * {@inheritDoc}
     */
    public function getInvestering() {
        return $this->getRapport()->getAnlaegsinvestering();
    }

}

