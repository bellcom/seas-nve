<?php

namespace AppBundle\Security\Authorization\Voter;

use AppBundle\Entity\VirksomhedRapport;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use AppBundle\Entity\VirksomhedRapportRepository;

class VirksomhedRapportVoter implements VoterInterface {
  /** @var VirksomhedRapportRepository $virksomhedRapportRepository */
  private $virksomhedRapportRepository;

  /** @var RoleHierarchyInterface $roleHierarchy */
  private $roleHierarchy;

    /** @var Request $request */
    protected $request;

  public function __construct(EntityManager $em, RoleHierarchyInterface $roleHierarchy, RequestStack $requestStack) {
    $this->virksomhedRapportRepository = $em->getRepository('AppBundle:VirksomhedRapport');
    $this->roleHierarchy = $roleHierarchy;
    $this->request = $requestStack->getCurrentRequest();
  }

  const VIEW = 'VIRKSOMHED_RAPPORT_VIEW';
  const EDIT = 'VIRKSOMHED_RAPPORT_EDIT';
  const CREATE = 'VIRKSOMHED_RAPPORT_CREATE';

  public function supportsAttribute($attribute) {
    return in_array($attribute, array(
      self::VIEW,
      self::EDIT,
      self::CREATE,
    ));
  }

  public function supportsClass($class) {
    $supportedClass = 'AppBundle\Entity\VirksomhedRapport';

    return $supportedClass === $class || is_subclass_of($class, $supportedClass);
  }

  public function vote(TokenInterface $token, $virksomhed_rapport, array $attributes) {
    // check if class of this object is supported by this voter
    if ($virksomhed_rapport === null || !$this->supportsClass(get_class($virksomhed_rapport))) {
      return VoterInterface::ACCESS_ABSTAIN;
    }

    // check if the voter is used correct, only allow one attribute
    // this isn't a requirement, it's just one easy way for you to
    // design your voter
    if (1 !== count($attributes)) {
      throw new \InvalidArgumentException(
        'Only one attribute is allowed for CREATE, VIEW or EDIT'
      );
    }

    // set the attribute to check against
    $attribute = $attributes[0];

    // check if the given attribute is covered by this voter
    if (!$this->supportsAttribute($attribute)) {
      return VoterInterface::ACCESS_ABSTAIN;
    }

    switch($attribute) {
      case self::VIEW:
        if ($this->hasRole($token, 'ROLE_VIRKSOMHED_RAPPORT_VIEW') || $this->hasValidToken($virksomhed_rapport)) {
          return VoterInterface::ACCESS_GRANTED;
        }
        break;

      case self::EDIT:
        if ($this->hasRole($token, 'ROLE_VIRKSOMHED_RAPPORT_EDIT')) {
          return VoterInterface::ACCESS_GRANTED;
        }
        break;

      case self::CREATE:
        if ($this->hasRole($token, 'ROLE_VIRKSOMHED_RAPPORT_CREATE')) {
          return VoterInterface::ACCESS_GRANTED;
        }
        break;
    }

    return VoterInterface::ACCESS_DENIED;
  }

  private function hasRole(TokenInterface $token, $roleName) {
    if (null === $this->roleHierarchy) {
      return in_array($roleName, $token->getRoles(), true);
    }

    foreach ($this->roleHierarchy->getReachableRoles($token->getRoles()) as $role) {
      if ($roleName === $role->getRole()) {
        return true;
      }
    }

    return false;
  }

    private function hasValidToken(VirksomhedRapport $virksomhed_rapport) {
        return $this->request->query->get('token') == $virksomhed_rapport->getVirksomhed()->getUser()->getToken();
    }

}
