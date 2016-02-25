<?php
/**
 * @file
 * Baseline Entity.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Baseline.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BaselineRepository")
 */
class Baseline {
  use BlameableEntity;
  use TimestampableEntity;

  /**
   * Constructor
   */
  public function __construct() {}

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer", nullable=true)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\OneToOne(targetEntity="Bygning", inversedBy="baseline", fetch="EAGER")
   **/
  protected $bygning;

  /**
   * @ORM\ManyToOne(targetEntity="ELOKategori")
   * @ORM\JoinColumn(name="elo_kategori_id", referencedColumnName="id")
   **/
  protected $eloKategori;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return mixed
   */
  public function getBygning() {
    return $this->bygning;
  }

  /**
   * @param mixed $bygning
   */
  public function setBygning($bygning) {
    $this->bygning = $bygning;
  }

  /**
   * @return mixed
   */
  public function getEloKategori() {
    return $this->eloKategori;
  }

  /**
   * @param mixed $eloKategori
   */
  public function setEloKategori($eloKategori) {
    $this->eloKategori = $eloKategori;
  }
}
