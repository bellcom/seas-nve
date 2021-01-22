<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Entity\RapportSektioner\Traits\FilepathField;
use AppBundle\Form\Type\RapportSektion\ForsideRapportSektionType;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Uploadable\Mapping\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * TiltagTableRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class TiltagTableRapportSektion extends RapportSektion {

    /**
     * {@inheritdoc }
     */
    public $landscape = true;

    /**
     * {@inheritDoc}
     */
    public static function getDefaultableTextFields() {
        return array();
    }

    public function getTiltage () {
        $anbefalinger = $this->getRapportSections()->filter(function ($section) { return $section->getType() == 'tiltag'; });
        return array_values($anbefalinger->toArray());
    }

}

