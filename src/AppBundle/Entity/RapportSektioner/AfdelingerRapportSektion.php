<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\RapportSektionWithHiddenType;
use Doctrine\ORM\Mapping as ORM;

/**
 * AfdelingerRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class AfdelingerRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Afdelinger';
        parent::__construct($params);
    }

    /**
     * {@inheritdoc }
     */
    public function getFormType() {
        return new RapportSektionWithHiddenType();
    }

}

