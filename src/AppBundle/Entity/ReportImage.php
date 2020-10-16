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
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;


/**
 * Report image.
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
class ReportImage {

  use BlameableEntity;
  use TimestampableEntity;

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
   * @var string
   *
   * @ORM\Column(name="title", type="string", length=255, nullable=true)
   */
  protected $title;

  /**
   * @var string
   *
   * @ORM\Column(name="type", type="string", length=255, nullable=true)
   */
  protected $type;

  /**
   * @var boolean
   *
   * @ORM\Column(name="standard", type="boolean", nullable=true)
   */
  protected $standard;

  /**
   * @return string
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * @param string $title
   */
  public function setTitle($title) {
    $this->title = $title;
  }

  /**
   * @return string
   */
  public function getType() {
    return $this->type;
  }

  /**
   * @param string $type
   */
  public function setType($type) {
    $this->type = $type;
  }

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
   * Sets is standard.
   *
   * @param boolean $standard
   */
  public function setStandard($standard) {
    $this->standard = $standard;
  }

  /**
   * @return boolean
   */
  public function isStandard() {
    return $this->standard;
  }
}
