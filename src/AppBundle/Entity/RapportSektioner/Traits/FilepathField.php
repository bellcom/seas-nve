<?php
namespace AppBundle\Entity\RapportSektioner\Traits;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

trait FilepathField {

    /**
     * @ORM\Column(name="filepath", type="string", nullable=true)
     * @Gedmo\UploadableFilePath
     * @Assert\File()
     */
    protected $filepath;

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

}
