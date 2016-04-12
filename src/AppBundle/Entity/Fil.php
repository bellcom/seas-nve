<?php
/**
 * @file
 * Fil Entity.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;


/**
 * Fil
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\FilRepository")
 */
class Fil {
  use BlameableEntity;
  use TimestampableEntity;

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\Column(name="filepath", type="string")
   */
  protected $filepath;

  /**
   * @ORM\Column(name="type", type="string", nullable=true)
   */
  protected $type;

  /**
   * @var string
   *
   * @ORM\Column(name="navn", type="string", nullable=true)
   */
  protected $navn;

  /**
   * @var string
   *
   * @ORM\Column(name="entity_type", type="string")
   **/
  protected $entityType;

  /**
   * @var string
   *
   * @ORM\Column(name="entity_id", type="string")
   **/
  protected $entityId;

  /**
   * @return string
   */
  public function getNavn() {
    return $this->navn;
  }

  /**
   * @param string $navn
   */
  public function setNavn($navn) {
    $this->navn = $navn;

    return $this;
  }

  /**
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set entityType
   *
   * @param string $entityType
   * @return Fil
   */
  public function setEntityType($entityType) {
    $this->entityType = $entityType;

    return $this;
  }

  public function getEntityType() {
    return $this->entityType;
  }

  /**
   * Set entityId
   *
   * @param string $entityId
   * @return Fil
   */
  public function setEntityId($entityId) {
    $this->entityId = $entityId;

    return $this;
  }

  public function getEntityId() {
    return $this->entityId;
  }

  public function setEntity($entity) {
    $this->setEntityType(get_class($entity));
    $this->setEntityId($entity->getId());

    return $this;
  }

  /**
   * Sets filepath.
   *
   * @param string $filepath
   */
  public function setFilepath($filepath) {
    $this->filepath = $filepath;

    return $this;
  }

  /**
   * Get filepath.
   *
   * @return string
   */
  public function getFilepath() {
    return $this->filepath;
  }

  /**
   * Sets type.
   *
   * @param string $type
   */
  public function setType($type) {
    $this->type = $type;

    return $this;
  }

  /**
   * Get type.
   *
   * @return string
   */
  public function getType() {
    return $this->type;
  }
}
