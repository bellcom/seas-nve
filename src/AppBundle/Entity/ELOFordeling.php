<?php
/**
 * @file
 * ELOFordeling Entity.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ELOFordeling.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ELOFordeling extends AarsFordeling {
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer", nullable=true)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\OneToOne(targetEntity="ELOKategori", inversedBy="fordelingVarmeGUF", fetch="EAGER")
   **/
  protected $eloKategoriFordelingVarmeGUF;

  /**
   * @ORM\OneToOne(targetEntity="ELOKategori", inversedBy="fordelingVarmeGAF", fetch="EAGER")
   **/
  protected $eloKategoriFordelingVarmeGAF;

  /**
   * @ORM\OneToOne(targetEntity="ELOKategori", inversedBy="fordelingEl", fetch="EAGER")
   **/
  protected $eloKategoriFordelingEl;

  /**
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return mixed
   */
  public function getEloKategoriFordelingVarmeGUF() {
    return $this->eloKategoriFordelingVarmeGUF;
  }

  /**
   * @param mixed $eloKategoriFordelingVarmeGUF
   */
  public function setEloKategoriFordelingVarmeGUF($eloKategoriFordelingVarmeGUF) {
    $this->eloKategoriFordelingVarmeGUF = $eloKategoriFordelingVarmeGUF;
  }

  /**
   * @return mixed
   */
  public function getEloKategoriFordelingVarmeGAF() {
    return $this->eloKategoriFordelingVarmeGAF;
  }

  /**
   * @param mixed $eloKategoriFordelingVarmeGAF
   */
  public function setEloKategoriFordelingVarmeGAF($eloKategoriFordelingVarmeGAF) {
    $this->eloKategoriFordelingVarmeGAF = $eloKategoriFordelingVarmeGAF;
  }

  /**
   * @return mixed
   */
  public function getEloKategoriFordelingEl() {
    return $this->eloKategoriFordelingEl;
  }

  /**
   * @param mixed $eloKategoriFordelingEl
   */
  public function setEloKategoriFordelingEl($eloKategoriFordelingEl) {
    $this->eloKategoriFordelingEl = $eloKategoriFordelingEl;
  }
}
