<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\BelysningTiltagDetail\Styring;
use AppBundle\Entity\BygningStatus;
use Doctrine\Common\Persistence\ObjectManager;
use Ddeboer\DataImport\Writer\CallbackWriter;

/**
 * Class LoadplaceringData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadStyringData extends LoadData {
  protected $order = 5;
  protected $flush = true;

  protected function createWriter(ObjectManager $manager) {
    return new CallbackWriter(function($item) use ($manager) {
      $styring = new Styring();
      $styring->setName($item['name']);

      $this->setEntityReference('styring', $item['id'], $styring);

      $manager->persist($styring);
    });
  }
}
