<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Entity\RapportSektioner\Traits\FilepathField;
use AppBundle\Form\Type\RapportSektion\AnbefalingRapportSektionType;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Uploadable\Mapping\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * AnbefalingRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @Gedmo\Uploadable(
 *   path="uploads/images/rapport/anbefaling/",
 *   filenameGenerator=Validator::FILENAME_GENERATOR_ALPHANUMERIC,
 *   allowOverwrite=false,
 *   appendNumber=true,
 *   allowedTypes="image/jpeg,image/pjpeg,image/png,image/x-png"
 * )
 */
class AnbefalingRapportSektion extends RapportSektion {

    use FilepathField;

    /**
     * Constructor
     */
    public function __construct() {
        $this->title = 'Anbefaling';
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType() {
        return new AnbefalingRapportSektionType();
    }

    /**
     * Defines allowed actions with SektionType.
     *
     * @return array
     */
    protected function allowedActions() {
        return array(
            self::ACTION_ADD,
            self::ACTION_DELETE
        );
    }

}

