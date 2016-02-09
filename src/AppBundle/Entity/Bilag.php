<?php
/**
 * @file
 * Bilag Entity.
 */

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Uploadable\Mapping\Validator;
use Gedmo\Uploadable\Uploadable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bilag
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @Gedmo\Uploadable(
 *   path="uploads/bilag/",
 *   filenameGenerator=Validator::FILENAME_GENERATOR_ALPHANUMERIC,
 *   allowOverwrite=false,
 *   appendNumber=true
 * )
 */
class Bilag {
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer", nullable=true)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\Column(name="filepath", type="string", nullable=true)
   * @Gedmo\UploadableFilePath
   * @Assert\File()
   */
  protected $filepath;

  /**
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id) {
    $this->id = $id;
  }

  /**
   * @ORM\ManyToOne(targetEntity="Rapport", inversedBy="bilag", fetch="EAGER")
   * @ORM\JoinColumn(name="rapport_id", referencedColumnName="id")
   **/
  protected $rapport;

  /**
   * Set rapport
   *
   * @param \AppBundle\Entity\Rapport $rapport
   * @return Bilag
   */
  public function setRapport(Rapport $rapport = NULL) {
    $this->rapport = $rapport;

    return $this;
  }

  public function getRapport() {
    return $this->rapport;
  }

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

  public function handleUploads($manager) {
    $fileInfo = $this->getFilepath();
    if (is_object($fileInfo) && $fileInfo instanceof UploadedFile) {
      $manager->markEntityToUpload($this, $fileInfo);
    }
  }
}
