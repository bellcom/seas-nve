<?php
/**
 * @file
 */

namespace AppBundle\Entity;

use AppBundle\Entity\BygningStatus;
/**
 * The Bygning Status repository.
 */
class BygningStatusRepository {
  public function loadChoiceList() {
    $items = array(
      new Bygningstatus('', ''),
      new Bygningstatus('1', 'Ikke startet'),
      new Bygningstatus('2', 'Data verificeret/'),
      new Bygningstatus('3', 'Afleveret af Rådgiver'),
      new Bygningstatus('4', 'AaPlus Verificeret'),
      new Bygningstatus('5', 'Godkendt af magistrat'),
      new Bygningstatus('6', 'Under udførsel'),
      new Bygningstatus('7', 'Drift'),
    );

    return array_combine($items, array_map(function($item) {
      return $item->getId();
    }, $items));
  }

}