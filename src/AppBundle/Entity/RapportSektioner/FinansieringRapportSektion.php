<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\FinansieringRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * FinansieringRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class FinansieringRapportSektion extends RapportSektion {

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

        return $textFields;
    }

}

