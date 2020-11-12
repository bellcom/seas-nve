<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Entity\RapportSektioner\Traits\FilepathField;
use AppBundle\Form\Type\RapportSektion\ForsideRapportSektionType;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
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
        $this->title = 'Energisynsrapport';
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
        if (!empty($this->getErstatningAdresse())) {
            return $this->getErstatningAdresse();
        }
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
        return $this->getVirksomhedOversigtRapport()->getUpdatedAt();
    }

    /**
     * @inheritDoc
     */
    public static function getExtrasDefault() {
        return array(
            'rapportTypeNavn' => 'Resultatoversigt',
            'skjuleKort' => FALSE,
            'erstatningAdresse' => '',
            'underTekst' => 'Undersagsnavn',
        );
    }

    public function getRapportTypeNavn() { return $this->getExtrasKeyValue('rapportTypeNavn'); }
    public function getSkjuleKort() { return $this->getExtrasKeyValue('skjuleKort'); }
    public function getErstatningAdresse() { return $this->getExtrasKeyValue('erstatningAdresse'); }
    public function getUnderTekst() { return $this->getExtrasKeyValue('underTekst'); }

    /**
     * {@inheritDoc}
     */
    public static function getDefaultableTextFields() {
        return array();
    }

}

