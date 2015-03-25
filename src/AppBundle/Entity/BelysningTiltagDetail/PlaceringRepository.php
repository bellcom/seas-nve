<?php
/**
 * @file
 */

namespace AppBundle\Entity\BelysningTiltagDetail;

use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

/**
 * The Placering class.
 */
class PlaceringRepository extends LazyChoiceList {
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
      new \AppBundle\Entity\BelysningTiltagDetail\Placering('', ''),
      new \AppBundle\Entity\BelysningTiltagDetail\Placering('1', 'Nedhængt'),
      new \AppBundle\Entity\BelysningTiltagDetail\Placering('2', 'Indbygget'),
      new \AppBundle\Entity\BelysningTiltagDetail\Placering('3', 'Påbygget'),
      new \AppBundle\Entity\BelysningTiltagDetail\Placering('4', 'Stående'),
      new \AppBundle\Entity\BelysningTiltagDetail\Placering('5', 'Andet, se Noter'),
    );

    return new ChoiceList(array_map(function($item) {
      return $item->getId();
    }, $items), $items);
  }

}
