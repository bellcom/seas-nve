<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\RapportSektionWithHiddenType;
use Doctrine\ORM\Mapping as ORM;

/**
 * ForudsaetningerRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ForudsaetningerRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Forudsætninger';
        parent::__construct($params);
    }

    /**
     * {@inheritdoc }
     */
    public function getFormType() {
        return new RapportSektionWithHiddenType();
    }

}

