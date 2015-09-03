<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BygningStatus
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BygningStatusRepository")
 */
class BygningStatus
{
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="navn", type="string", length=255)
   */
  private $navn;


  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    return $this->getNavn();
  }

  /**
   * Get id
   *
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set navn
   *
   * @param string $navn
   *
   * @return BygningStatus
   */
  public function setNavn($navn)
  {
    $this->navn = $navn;

    return $this;
  }

  /**
   * Get navn
   *
   * @return string
   */
  public function getNavn()
  {
    return $this->navn;
  }
}

