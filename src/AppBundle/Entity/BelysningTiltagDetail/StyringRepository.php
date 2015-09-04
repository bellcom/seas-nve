<?php
/**
 * @file
 */

namespace AppBundle\Entity\BelysningTiltagDetail;

use AppBundle\Entity\BelysningTiltagDetail\Styring;

/**
 * The Styring repository.
 */
class StyringRepository {
  public function loadChoiceList() {
    $items = array(
      new Styring('', ''),
      new Styring('1', 'Afbryder i rum'),
      new Styring('2', 'PIR on/off'),
      new Styring('3', 'PIR-/DGS'),
      new Styring('4', 'Skumringsrelæ'),
      new Styring('5', 'PIR i afbryder'),
      new Styring('6', 'Central afbryder'),
      new Styring('7', 'Urstyret'),
      new Styring('8', 'Andet, se Noter')
    );

    return array_combine($items, array_map(function($item) {
      return $item->getId();
    }, $items));
  }

}
