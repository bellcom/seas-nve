<?php
namespace AppBundle\Security;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\HttpUtils;

class TokenAccessUserProvider implements UserProviderInterface
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getUsernameForApiKey($token)
    {
        $repository = $this->entityManager->getRepository('AppBundle:User');
        /** @var \AppBundle\Entity\User $user */
        $user = $repository->findOneBy(array('token' => $token));
        return empty($user) ? NULL : $user->getUsername();
    }

    public function loadUserByUsername($username)
    {
        $repository = $this->entityManager->getRepository('AppBundle:User');
        $user = $repository->findOneBy(array('username' => $username));
        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
