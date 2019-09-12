<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\BygningStatusType;
use DateTime;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
    return $user && ($user->hasRole('ROLE_ADMIN') || $user->hasRole('ROLE_SUPER_ADMIN'));
  }

  /**
   * Limit Query to buildings user has access to
   *
   * @param User $user
   * @param QueryBuilder $qb
   * @param bool $onlyOwnBuildings
   * @param string $buildingAlias
   */
  protected function limitQueryToUserAccess(User $user, QueryBuilder $qb, $onlyOwnBuildings = FALSE, $buildingAlias = 'b') {
    if (!$this->hasFullAccess($user)) {
      $qb->andWhere(':user MEMBER OF '.$buildingAlias.'.users');
      $qb->setParameter('user', $user);
      $qb->orWhere($buildingAlias.'.energiRaadgiver = :energiRaadgiver');
      $qb->setParameter('energiRaadgiver', $user);
      $qb->orWhere($buildingAlias.'.projektleder = :projektleder');
      $qb->setParameter('projektleder', $user);
      $qb->orWhere($buildingAlias.'.projekterende = :projekterende');
      $qb->setParameter('projekterende', $user);
    } else if($onlyOwnBuildings) {
      $qb->andWhere('b.aaplusAnsvarlig = :aaplusAnsvarlig');
      $qb->setParameter('aaplusAnsvarlig', $user);
    }
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

    if ($bygning->getEnergiRaadgiver()->contains($user)) {
      return TRUE;
    }

    if ($bygning->getProjektleder() == $user) {
      return TRUE;
    }

    if ($bygning->getProjekterende() == $user) {
      return TRUE;
    }

    $bygninger = $this->findBygningerByUser($user);
    return $bygninger && in_array($bygning, $bygninger);
  }

  private $container;

  public function setContainer(ContainerInterface $container) {
    $this->container = $container;

    return $this;
  }

  public function findAtTime(DateTime $timestamp, FormInterface $form) {
    return $this->container->get('aaplus.entityaudit.reader')
      ->setFilter($form)
      ->getEntitiesAtTime($this->getClassName(), $timestamp);
  }

  private function findBygningerByUser($user) {
    $em = $this->_em->getRepository('AppBundle:Bygning');
    $bygninger = $em->findByUser($user);

    return $bygninger;
  }

}
