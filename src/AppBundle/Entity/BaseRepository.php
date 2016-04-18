<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\BygningStatusType;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

/**
 * BygningRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BaseRepository extends EntityRepository {

  /**
   * The ugly function to check if a user is allowed to do everything …
   *
   * @param $user
   * @return bool
   */
  protected function hasFullAccess($user) {
    return $user && $user->hasRole('ROLE_ADMIN');
  }

  /**
   * Check if a User has access to a Bygning
   *
   * @param User $user
   * @param Bygning $bygning
   * @return bool
   */
  public function hasAccess(User $user, Bygning $bygning) {
    if ($this->hasFullAccess($user)) {
      return TRUE;
    }

    if ($bygning->getEnergiRaadgiver() == $user) {
      return TRUE;
    }

    if ($bygning->getProjektleder() == $user) {
      return TRUE;
    }

    $bygninger = $this->findByUser($user);
    return $bygninger && in_array($bygning, $bygninger);
  }

}