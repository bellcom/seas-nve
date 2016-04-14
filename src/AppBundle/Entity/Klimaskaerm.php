<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\DBAL\Types\KlimaskaermType;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Klimaskaerm
 *
 * @ORM\Table()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Entity(repositoryClass="AppBundle\Entity\KlimaskaermRepository")
 */
class Klimaskaerm {
  use SoftDeleteableEntity;

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   *
   * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\KlimaskaermType")
   * @ORM\Column(name="type", type="KlimaskaermType")
   */
  protected $type;

  /**
   * @var string
   *
   * @ORM\Column(name="post", type="string", length=255)
   */
  protected $post;

  /**
   * @var string
   *
   * @ORM\Column(name="klimaskaerm", type="string", length=255, nullable=true)
   */
  protected $klimaskaerm;

  /**
   * @var string
   *
   * @ORM\Column(name="arbejdeOmfang", type="string", length=255, nullable=true)
   */
  protected $arbejdeOmfang;

  /**
   * @var float
   *
   * @ORM\Column(name="enhedsprisEksklMoms", type="decimal", scale=4, precision=14)
   */
  protected $enhedsprisEksklMoms;

  /**
   * @var string
   *
   * @ORM\Column(name="enhed", type="string", length=255)
   */
  protected $enhed;

  /**
   * @var string
   *
   * @ORM\Column(name="noter", type="text", nullable=true)
   */
  protected $noter;

  public function getId() {
    return $this->id;
  }

  public function setType($type) {
    $this->type = $type;

    return $this;
  }

  public function getType() {
    return $this->type;
  }

  public function setPost($post) {
    $this->post = $post;

    return $this;
  }

  public function getPost() {
    return $this->post;
  }

  public function setKlimaskaerm($klimaskaerm) {
    $this->klimaskaerm = $klimaskaerm;

    return $this;
  }

  public function getKlimaskaerm() {
    return $this->klimaskaerm;
  }

  public function setArbejdeOmfang($arbejdeOmfang) {
    $this->arbejdeOmfang = $arbejdeOmfang;

    return $this;
  }

  public function getArbejdeOmfang() {
    return $this->arbejdeOmfang;
  }

  public function setEnhedsprisEksklMoms($enhedsprisEksklMoms) {
    $this->enhedsprisEksklMoms = $enhedsprisEksklMoms;

    return $this;
  }

  public function getEnhedsprisEksklMoms() {
    return $this->enhedsprisEksklMoms;
  }

  public function setEnhed($enhed) {
    $this->enhed = $enhed;

    return $this;
  }

  public function getEnhed() {
    return $this->enhed;
  }

  public function setNoter($noter) {
    $this->noter = $noter;

    return $this;
  }

  public function getNoter() {
    return $this->noter;
  }

  public function __toString() {
    return $this->post . ': ' . $this->klimaskaerm . ($this->arbejdeOmfang ? ' – ' . $this->arbejdeOmfang : '') . ($this->enhedsprisEksklMoms ? ' - ' . round($this->enhedsprisEksklMoms, 2) . ' ' . $this->enhed  : '');
  }

}
