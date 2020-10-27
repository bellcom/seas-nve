<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Entity\RapportSektioner\Traits\FilepathField;
use AppBundle\Form\Type\RapportSektion\ForsideRapportSektionType;
use AppBundle\Form\Type\RapportSektion\OpsummeringRapportSektionType;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
use Gedmo\Uploadable\Mapping\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ForsideRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @Gedmo\Uploadable(
 *   path="uploads/images/rapport/forside/",
 *   filenameGenerator=Validator::FILENAME_GENERATOR_ALPHANUMERIC,
 *   allowOverwrite=false,
 *   appendNumber=true,
 *   allowedTypes="image/jpeg,image/pjpeg,image/png,image/x-png"
 * )
 */
class ForsideRapportSektion extends RapportSektion {

    use FilepathField;

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Energisysnrapport';
        parent::__construct($params);
    }

    /**
     * @inheritDoc
     */
    public function getFormType() {
        return new ForsideRapportSektionType();
    }

    /**
     * Gets Virksomhed address.
     */
    public function getAddress() {
        return $this->getVirksomhedOversigtRapport()->getVirksomhed()->getFullAddress();
    }

    /**
     * Gets Virksomhed name.
     */
    public function getVirksomhedNavn() {
        return $this->getVirksomhedOversigtRapport()->getVirksomhed()->getName();
    }

    /**
     * Gets Virksomhed datering.
     */
    public function getDatering() {
        return $this->getVirksomhedOversigtRapport()->getDatering();
    }

    /**
     * @inheritDoc
     */
    public static function getExtrasDefault() {
        return array(
            'rapportTypeNavn' => 'Resulatatoversigt',
            'underTekst' => 'Undersagsnavn',
        );
    }

    public function getRapportTypeNavn() { return $this->getExtrasKeyValue('rapportTypeNavn'); }
    public function getUnderTekst() { return $this->getExtrasKeyValue('underTekst'); }

    /**
     * Sets filepath.
     *
     * @param UploadedFile $filepath
     */
    public function setFilepath(UploadedFile $filepath = null) {
        $this->filepath = $filepath;
    }

}

