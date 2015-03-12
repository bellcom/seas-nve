<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Uploadable\Mapping\Validator;
use Gedmo\Uploadable\Uploadable;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @Gedmo\Uploadable(
 *   path="uploads/specialtiltag/",
 *   filenameGenerator=Validator::FILENAME_GENERATOR_ALPHANUMERIC,
 *   allowOverwrite=false,
 *   appendNumber=true
 * )
 */
class SpecialTiltagDetail extends TiltagDetail {
  /**
   * @var string
   *
   * @ORM\Column(name="Kommentar", type="text", nullable=true)
   */
  private $kommentar;

  public function setKommentar($kommentar) {
    $this->kommentar = $kommentar;
  }

  public function getKommentar() {
    return $this->kommentar;
  }

  /**
   * @ORM\Column(name="filepath", type="string", nullable=true)
   * @Gedmo\UploadableFilePath
   * @Assert\File()
   */
  private $filepath;

  public function setFilepath($filepath) {
    $this->filepath = $filepath;

    return $this;
  }

  public function getFilepath() {
    return $this->filepath;
  }

  public function handleUploads($manager) {
    if ($this->getFilepath()) {
      $manager->markEntityToUpload($this, $this->getFilepath());
    }
  }

}
