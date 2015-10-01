<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\BelysningTiltagDetail\Tiltag;
use Doctrine\Common\Persistence\ObjectManager;
use Ddeboer\DataImport\Writer\CallbackWriter;


/**
 * Class LoadplaceringData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadTiltagData extends LoadData {
  protected $order = 5;
  protected $flush = true;

  protected function createWriter(ObjectManager $manager) {
    return new CallbackWriter(function($item) use ($manager) {
      $tiltag = new Tiltag();
      $tiltag->setName($item['name']);

      $this->setEntityReference('belysningstiltag', $item['id'], $tiltag);

      $manager->persist($tiltag);
    });
  }
}
