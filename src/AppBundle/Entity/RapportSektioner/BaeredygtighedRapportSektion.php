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
    public function __construct() {
        $this->title = 'Bæredygtighed';
        parent::__construct();
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

}

