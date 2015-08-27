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

use AppBundle\Entity\User;

/**
 * Class LoadUserData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadSegmentData extends LoadData {
  protected $order = 13;
  protected $flush = true;

  protected function createWriter(ObjectManager $manager) {
    return new CallbackWriter(function($item) use ($manager) {
      $segment = new Segment();

      $segment->setNavn($item['navn'])
        ->setMagistrat($item['magistrat'])
        ->setForkortelse($item['forkortelse']);
      $manager->persist($segment);
    });
  }
}
