<?php
/**
 * @file
 */

namespace AppBundle\Entity\BelysningTiltagDetail;

use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

/**
 * The Styring class.
 */
class StyringRepository extends LazyChoiceList {
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
      new \AppBundle\Entity\BelysningTiltagDetail\Styring('', ''),
      new \AppBundle\Entity\BelysningTiltagDetail\Styring('1', 'Afbryder i rum'),
      new \AppBundle\Entity\BelysningTiltagDetail\Styring('2', 'PIR on/off'),
      new \AppBundle\Entity\BelysningTiltagDetail\Styring('3', 'PIR-/DGS'),
      new \AppBundle\Entity\BelysningTiltagDetail\Styring('4', 'Skumringsrelæ'),
      new \AppBundle\Entity\BelysningTiltagDetail\Styring('5', 'PIR i afbryder'),
      new \AppBundle\Entity\BelysningTiltagDetail\Styring('6', 'Central afbryder'),
      new \AppBundle\Entity\BelysningTiltagDetail\Styring('7', 'Urstyret'),
      new \AppBundle\Entity\BelysningTiltagDetail\Styring('8', 'Andet, se Noter')
    );

    return new ChoiceList(array_map(function($item) {
      return $item->getId();
    }, $items), $items);
  }

}
