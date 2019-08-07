<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository {

  /**
   * Get users by group id.
   *
   * @return array
   */
  public function getByGroupId($group_id) {
      $qb = $this->_em->createQueryBuilder();
      $qb->select('u.id')
          ->from('AppBundle:User', 'u')
          ->leftJoin('u.groups', 'g')
          ->andWhere('g.id = :group_id')
          ->setParameters(array('group_id' => $group_id));
      return $qb->getQuery()->getResult();
  }

}
