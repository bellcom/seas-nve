<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\BaeredygtighedRapportSektionType;
use AppBundle\Form\Type\RapportSektion\FaktaOmVirksomedRapportSektionType;
use AppBundle\Form\Type\RapportSektion\FinansieringRapportSektionType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;

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

}

