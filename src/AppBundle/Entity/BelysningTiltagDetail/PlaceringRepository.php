<?php
/**
 * @file
 */

namespace AppBundle\Entity\BelysningTiltagDetail;

use AppBundle\Entity\BelysningTiltagDetail\Placering;
/**
 * The Placering repository.
 */
class PlaceringRepository {
  public function loadChoiceList() {
    $items = array(
      new Placering('', ''),
      new Placering('1', 'Nedhængt'),
      new Placering('2', 'Indbygget'),
      new Placering('3', 'Påbygget'),
      new Placering('4', 'Stående'),
      new Placering('5', 'Andet, se Noter'),
    );

    return array_combine($items, array_map(function($item) {
      return $item->getId();
    }, $items));
  }

}
