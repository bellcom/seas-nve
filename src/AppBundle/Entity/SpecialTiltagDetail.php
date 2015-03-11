<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity()
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
}
