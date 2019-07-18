<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * GroupRepository
 */
class GroupRepository extends EntityRepository {

  /**
   * {@inheritDoc}
   */
  public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) {
    $entities = parent::findBy($criteria, $orderBy, $limit, $offset);

    // Excluding hidden groups from listing.
    $entities = array_filter($entities, function($group) {
      if (in_array($group->getName(), $this->getHiddenGroups())) {
        return FALSE;
      }
      return TRUE;
    });
    return $entities;
  }

  /**
   * Declare groups that are not supposed to use
   * but still required in the system.
   *
   * @return array
   */
  public function getHiddenGroups() {
    return array(
      'Interessent',
      'Projekterende',
      'Projektleder',
    );
  }

}
