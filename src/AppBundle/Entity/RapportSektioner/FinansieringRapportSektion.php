<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Calculation\Calculation;
use AppBundle\Form\Type\RapportSektion\FinansieringRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * FinansieringRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class FinansieringRapportSektion extends RapportSektion implements ROIGrafDataInterface {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Finansiering';
        parent::__construct($params);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType() {
        return new FinansieringRapportSektionType();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDefaultableTextFields()
    {
        $textFields = parent::getDefaultableTextFields();
        $textFields[] = 'noegletal';
        $textFields[] = 'finansieringTekst';

        return $textFields;
    }

    /**
     * Gets nøgletaltekst.
     */
    public function getNoegletal() {
        return $this->getExtrasKeyValue('noegletal');
    }

    /**
     * Gets finansieringTekst.
     */
    public function getFinansieringTekst() {
        return $this->getExtrasKeyValue('finansieringTekst');
    }

    /**
     * Gets tekniskelevetid.
     */
    public function getTekniskelevetid() {
        return $this->getExtrasKeyValue('tekniskelevetid');
    }

    /**
     * Gets samletBesparelseOverAar.
     */
    public function getSamletBesparelseOverAar($years = 1) {
        return $this->getRapport()->getSamletEnergibesparelseKr() * $years;
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

