<?php
/**
 * @file
 * Contains BaselineRepository.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\DBAL\Types\BygningStatusType;

/**
 * BaselineRepository.
 */
class BaselineRepository extends EntityRepository {
  /**
   * Check if a User has access to a Baseline
   *
   * @param User $user
   * @param Baseline $baseline
   * @return bool
   */
  public function hasAccess(User $user, Baseline $baseline) {
    if ($this->hasFullAccess($user)) {
      return true;
    }

    return $baseline->getBygning()->getEnergiRaadgiver() == $user || $baseline->getBygning()->getUsers()->contains($user);
  }

  /**
   * Check if a User has edit rights to a Baseline
   *
   * @param User $user
   * @param Baseline $baseline
   * @return bool
   */
  public function canEdit(User $user, Baseline $baseline) {
    if ($this->hasFullAccess($user) && $baseline->getBygning()->getStatus() !== BygningStatusType::TILKNYTTET_RAADGIVER) {
      return true;
    }

    return $baseline->getBygning()->getEnergiRaadgiver() == $user && $baseline->getBygning()->getStatus() === BygningStatusType::TILKNYTTET_RAADGIVER;
  }

  /**
   * The ugly function to check if a user is allowed to do everything …
   *
   * ROLE_ADMIN == Aa+
   *
   * @param $user
   * @return bool
   */
  private function hasFullAccess($user) {
    return $user && $user->hasRole('ROLE_ADMIN');
  }
}
