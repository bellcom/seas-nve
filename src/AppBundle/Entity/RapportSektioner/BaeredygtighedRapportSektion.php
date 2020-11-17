<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\BaeredygtighedRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * BaeredygtighedRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class BaeredygtighedRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Bæredygtighed';
        parent::__construct($params);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType() {
        return new BaeredygtighedRapportSektionType();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDefaultableTextFields()
    {
        $textFields = parent::getDefaultableTextFields();
        $textFields[] = 'besparelseeffekt';

        return $textFields;
    }

    /**
     * Gets besparelseeffekt.
     */
    public function getBesparelseeffekt() {
        return $this->getExtrasKeyValue('besparelseeffekt');
    }

    /**
     * Gets besparelseeffekt.
     */
    public function getBesparelseeffektUnderTekst() {
        return $this->getExtrasKeyValue('besparelseeffektUnderTekst');
    }

    public function getEffektBesparesleKwh() {
        return $this->getRapport()->getSamletEnergibesparelse();
    }

    public function getEffektBesparesleKr() {
        return $this->getRapport()->getSamletEnergibesparelseKr();
    }

    public function getEffektBesparesleCo2() {
        return $this->getRapport()->getForbrugFoerCo2() - $this->getRapport()->getForbrugEfterCo2();
    }

}

