<?php
/**
 * @file
 */

namespace AppBundle\Entity\BelysningTiltagDetail;

use AppBundle\Entity\BelysningTiltagDetail\Tiltag;

/**
 * The Tiltag repository.
 */
class TiltagRepository  {
  public function loadChoiceList() {
    $items = array(
      new Tiltag('', ''),
      new Tiltag('1', 'PIR i afbryder'),
      new Tiltag('2', 'PIR on/off, central'),
      new Tiltag('3', 'PIR/DGS, cent.'),
      new Tiltag('4', 'Arm. + evt. PIR/DGS'),
      new Tiltag('5', 'LED i eksist. arm. '),
      new Tiltag('6', 'Ny indsats i arm. '),
      new Tiltag('7', 'Andet, se Noter'),
    );

    return array_combine($items, array_map(function($item) {
      return $item->getId();
    }, $items));
  }

}
