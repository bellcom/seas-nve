<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use Ddeboer\DataImport\Writer\CallbackWriter;

use AppBundle\Entity\BelysningTiltagDetail\Lyskilde as BelysningTiltagDetailLyskilde;

/**
 * Class LoadUserData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadBelysningTiltagDetailLyskildeData extends LoadData {
  protected $flush = true;

  protected function createWriter(ObjectManager $manager) {
    return new CallbackWriter(function($item) use ($manager) {
        $lyskilde = new BelysningTiltagDetailLyskilde();
        $lyskilde->setNavn($item['navn']);
        $lyskilde->setType($item['type']);
        $lyskilde->setForkobling($item['forkobling']);
        $lyskilde->setUdgift($item['udgift']);
        $lyskilde->setLevetid($item['levetid']);
        $manager->persist($lyskilde);
    });
  }
}
