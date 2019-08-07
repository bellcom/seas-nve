<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use FOS\UserBundle\Model\GroupInterface;
use FOS\UserBundle\Model\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\GroupRepository")
 * @ORM\Table(name="fos_group")
 */
class Group extends BaseGroup {
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ManyToMany(targetEntity="User", mappedBy="groups")
   * @JMS\Exclude
   **/
  protected $users;

  public function __construct($name, $roles = array()) {
    parent::__construct($name, $roles);
    $this->users = new ArrayCollection();
  }

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    return $this->getName();
  }

  /**
   * Get users
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getUsers() {
    return $this->users;
  }

  /**
   * Add user
   *
   * @param UserInterface $user
   *
   * @return GroupInterface
   */
  public function addUser(UserInterface $user)
  {
    $this->users[] = $user;

    return $this;
  }

  /**
   * Remove user
   *
   * @param UserInterface $user
   */
  public function removeUser(UserInterface $user)
  {
    $this->users->removeElement($user);
  }

  /**
   * Fetch all roles in system as associated array.
   *
   * Key is machine role name and list of included roles as value.
   */
  public static function getAllRoles()
  {
    global $kernel;
    $roles = $kernel->getContainer()->getParameter('security.role_hierarchy.roles');
    foreach ($roles as $role_machine_name => &$included_roles) {
      $included_roles = self::getIncludedRoles($included_roles, $roles);
    }
    return $roles;
  }

  private static function getIncludedRoles($included_roles, $roles)
  {
    $checked_roles = $included_roles;
    foreach ($checked_roles as $role_name) {
      if (!empty($roles[$role_name])) {
        $included_roles = array_unique(array_merge($included_roles, self::getIncludedRoles($roles[$role_name], $roles)));
        continue;
      }
    }
    return $included_roles;
  }

}
