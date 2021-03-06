<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\KontaktInformationRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

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
    public function __construct($params) {
        $this->title = 'Kontaktinformation';
        parent::__construct($params);
    }

    /**
     * {@inheritdoc}
     */
    public static function getDefaultableTextFields()
    {
        $textFields = parent::getDefaultableTextFields();
        $textFields[] = 'underskrivelseTekst';

        return $textFields;
    }

    /**
     * @inheritDoc
     */
    public function getFormType() {
        return new KontaktInformationRapportSektionType();
    }

    /**
     * Gets gennemgangDato.
     */
    public function getGennemgangDato() {
        $dato = $this->getExtrasKeyValue('gennemgangDato');
        return $dato ?: $this->getRapport()->getDatering();
    }

    /**
     * Gets underskrivelseTekst.
     */
    public function getUnderskrivelseTekst() {
        return $this->getExtrasKeyValue('underskrivelseTekst');
    }

    /**
     * Gets kvalitetSikringTekst.
     */
    public function getKvalitetSikringTekst() {
        return $this->getExtrasKeyValue('kvalitetSikringTekst');
    }

}

