<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Ddeboer\DataImport\Writer\CallbackWriter;

use AppBundle\Entity\Group;

/**
 * Class LoadGroupData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadGroupsData extends LoadData {
  protected $order = 1;
  protected $flush = true;

  protected function createWriter(ObjectManager $manager) {
    return new CallbackWriter(function($item) use ($manager) {
        $group = new Group($item['name']);
        $group->setRoles($item['roles'] ? explode(',', $item['roles']) : array());
        $manager->persist($group);
    });
  }
}
