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
class BaselineRepository extends BaseRepository {

  /**
   * Check if a User has edit rights to a BAseline
   *
   * @param User $user
   * @param Rapport $baseline
   * @return bool
   */
  public function canEdit(User $user, Baseline $baseline) {
    if($baseline->getBygning()->getStatus() === BygningStatusType::TILKNYTTET_RAADGIVER) {
      return $baseline->getBygning()->getEnergiRaadgiver()->contains($user);
    }

    return $this->hasFullAccess($user);
  }

}
