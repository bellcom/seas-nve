<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use Ddeboer\DataImport\Writer\CallbackWriter;

use AppBundle\Entity\User;

/**
 * Class LoadUserData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadUsersData extends LoadData {
  protected $order = 12;
  protected $flush = true;

  protected function createWriter(ObjectManager $manager) {
    return new CallbackWriter(function($item) use ($manager) {
        $user = new User();

        $groups = new ArrayCollection();

        if ($item['groups']) {
          $ids = explode(',', $item['groups']);
          $repository = $manager->getRepository('AppBundle:Group');
          $groups = new ArrayCollection($repository->findBy(array('id' => $ids)));
        }

        $encoder = $this->container->get('security.password_encoder');
        $user->setUsername($item['username'])
          ->setPassword($encoder->encodePassword($user, $item['password']))
          ->setEmail($item['email'])
          ->setFirstname($item['firstname'])
          ->setLastname($item['lastname'])
          ->setPhone($item['phone'])
          ->setRoles($item['roles'] ? explode(',', $item['roles']) : array())
          ->setGroups($groups)
          ->setEnabled(true);
        $manager->persist($user);
      });
  }
}
