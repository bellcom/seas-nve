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
 * Report text.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ReportText {

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
   * @var string
   *
   * @ORM\Column(name="title", type="string", length=255, nullable=true)
   */
  protected $title;

  /**
   * @var string
   *
   * @ORM\Column(name="body", type="text", nullable=true)
   *
   * @Assert\Length(
   *  max = 10000,
   *  maxMessage = "maxLength"
   * )
   */
  protected $body;

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
   * @return string
   */
  public function getBody() {
    return $this->body;
  }

  /**
   * @param string $body
   */
  public function setBody($body) {
    $this->body = $body;
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
