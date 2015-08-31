<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\BygningStatus;
use Doctrine\Common\Persistence\ObjectManager;
use Ddeboer\DataImport\Writer\CallbackWriter;

use AppBundle\Entity\User;

/**
 * Class LoadUserData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadBygningStatusData extends LoadData {
  protected $order = 13;
  protected $flush = true;

  protected function createWriter(ObjectManager $manager) {
    return new CallbackWriter(function($item) use ($manager) {
      $status = new Bygningstatus();

      $status->setNavn($item['navn']);
      $manager->persist($status);
    });
  }
}
