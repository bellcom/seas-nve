<?php
/**
 * @file
 */

namespace AppBundle\Entity\BelysningTiltagDetail;

use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

/**
 * The Tiltag class.
 */
class TiltagRepository extends LazyChoiceList {
  /**
   * Convert to string.
   *
   * @return string
   *   The string.
   */
  public function __toString() {
    return $this->name;
  }

  protected function loadChoiceList() {
    $items = array(
      new \AppBundle\Entity\BelysningTiltagDetail\Tiltag('', ''),
      new \AppBundle\Entity\BelysningTiltagDetail\Tiltag('1', 'PIR i afbryder'),
      new \AppBundle\Entity\BelysningTiltagDetail\Tiltag('2', 'PIR on/off, central'),
      new \AppBundle\Entity\BelysningTiltagDetail\Tiltag('3', 'PIR/DGS, cent.'),
      new \AppBundle\Entity\BelysningTiltagDetail\Tiltag('4', 'Arm. + evt. PIR/DGS'),
      new \AppBundle\Entity\BelysningTiltagDetail\Tiltag('5', 'LED i eksist. arm. '),
      new \AppBundle\Entity\BelysningTiltagDetail\Tiltag('6', 'Ny indsats i arm. '),
      new \AppBundle\Entity\BelysningTiltagDetail\Tiltag('7', 'Andet, se Noter'),
    );

    return new ChoiceList(array_map(function($item) {
      return $item->getId();
    }, $items), $items);
  }

}
