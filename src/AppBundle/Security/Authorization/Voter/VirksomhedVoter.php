<?php

namespace AppBundle\Security\Authorization\Voter;

use AppBundle\Entity\User;
use AppBundle\Entity\Virksomhed;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class VirksomhedVoter implements VoterInterface {

  /** @var RoleHierarchyInterface $roleHierarchy */
  private $roleHierarchy;

  /** @var Request $request */
  protected $request;

  public function __construct(EntityManager $em, RoleHierarchyInterface $roleHierarchy, RequestStack $requestStack) {
    $this->roleHierarchy = $roleHierarchy;
    $this->request = $requestStack->getCurrentRequest();
  }

  const VIEW = 'VIRKSOMHED_VIEW';
  const EDIT = 'VIRKSOMHED_EDIT';
  const CREATE = 'VIRKSOMHED_CREATE';

  public function supportsAttribute($attribute) {
    return in_array($attribute, array(
      self::VIEW,
      self::EDIT,
      self::CREATE,
    ));
  }

  public function supportsClass($class) {
    $supportedClass = 'AppBundle\Entity\Virksomhed';

    return $supportedClass === $class || is_subclass_of($class, $supportedClass);
  }

    /**
     * @inheritDoc
     */
  public function vote(TokenInterface $token, $virksomhed, array $attributes) {
    // check if class of this object is supported by this voter
    if ($virksomhed === null || !$this->supportsClass(get_class($virksomhed))) {
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
        if ($this->hasRole($token, 'ROLE_VIRKSOMHED_VIEW') || $this->hasValidToken($virksomhed)) {
          return VoterInterface::ACCESS_GRANTED;
        }
        break;

      case self::EDIT:
        if ($this->hasRole($token, 'ROLE_VIRKSOMHED_EDIT')) {
          return VoterInterface::ACCESS_GRANTED;
        }
        break;

      case self::CREATE:
        if ($this->hasRole($token, 'ROLE_VIRKSOMHED_CREATE')) {
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

  /**
   * Matches token from request by virksomhed user token or parent virksomhed token.
   *
   * @param Virksomhed $virksomhed
   * @return bool
   */
  private function hasValidToken(Virksomhed $virksomhed) {
      $token = $this->request->query->get('token');
      $user = $virksomhed->getUser();
      $userToken = $user instanceof User ? $user->getToken() : '';

      $parentUserToken = '';
      $parentVirksomhed = $virksomhed->getParent();
      if ($parentVirksomhed instanceof Virksomhed) {
          $user = $parentVirksomhed->getUser();
          $parentUserToken = $user instanceof User ? $user->getToken() : '';
      }

      return !empty($token) && ($token == $userToken || $token == $parentUserToken);
  }
}
