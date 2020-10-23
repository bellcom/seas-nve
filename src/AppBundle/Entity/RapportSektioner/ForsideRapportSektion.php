<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\ForsideRapportSektionType;
use AppBundle\Form\Type\RapportSektion\OpsummeringRapportSektionType;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
use Gedmo\Uploadable\Mapping\Validator;
use Gedmo\Uploadable\Uploadable;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ForsideRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @Gedmo\Uploadable(
 *   path="uploads/report_images/",
 *   filenameGenerator=Validator::FILENAME_GENERATOR_ALPHANUMERIC,
 *   allowOverwrite=false,
 *   appendNumber=true,
 *   allowedTypes="image/jpeg,image/pjpeg,image/png,image/x-png"
 * )
 */
class ForsideRapportSektion extends RapportSektion {

    /**
     * @ORM\Column(name="filepath", type="string", nullable=true)
     * @Gedmo\UploadableFilePath
     * @Assert\File()
     */
    protected $filepath;

    /**
     * Constructor
     */
    public function __construct() {
        $this->title = 'Energisysnrapport';
        parent::__construct();
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

    /**
     * Get filepath.
     *
     * @return UploadedFile
     */
    public function getFilepath() {
        return $this->filepath;
    }

    /**
     * Get filename.
     *
     * @return string
     */
    public function getFilename() {
        return basename($this->filepath);
    }

    /**
     * Get image file.
     *
     * @return string
     */
    public function getBillede() {
        return $this->getFilename();
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

