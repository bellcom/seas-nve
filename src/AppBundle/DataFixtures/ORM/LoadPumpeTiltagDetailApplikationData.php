<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Segment;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use Ddeboer\DataImport\Writer\CallbackWriter;

use AppBundle\Entity\PumpeTiltagDetailApplikation;

/**
 * Class LoadPumpeTiltagDetailApplikationData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadPumpeTiltagDetailApplikationData extends LoadData {
  protected $order = 2;
  protected $flush = true;

  protected function createWriter(ObjectManager $manager) {
    return new CallbackWriter(function($item) use ($manager) {
      $applikation = new PumpeTiltagDetailApplikation();

      $applikation->setNavn($item['navn']);
      $manager->persist($applikation);
    });
  }
}
