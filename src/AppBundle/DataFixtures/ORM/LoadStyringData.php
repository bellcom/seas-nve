<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Ddeboer\DataImport\Writer\CallbackWriter;

use AppBundle\Entity\BelysningTiltagDetail\Placering;

/**
 * Class LoadplaceringData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadPlaceringData extends LoadData {
  protected $order = 4;
  protected $flush = true;

  protected function createWriter(ObjectManager $manager) {
    return new CallbackWriter(function($item) use ($manager) {
      $placering = new Placering();
      $placering->setName($item['name']);

      $this->setEntityReference('placering', $item['id'], $placering);

      $manager->persist($placering);
    });
  }
}
