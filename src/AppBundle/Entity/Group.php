<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
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

  public function __construct() {
    parent::__construct();
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
   * @param \AppBundle\Entity\User $user
   *
   * @return Bygning
   */
  public function addUser(\AppBundle\Entity\User $user)
  {
    $this->users[] = $user;

    return $this;
  }

  /**
   * Remove user
   *
   * @param \AppBundle\Entity\User $user
   */
  public function removeUser(\AppBundle\Entity\User $user)
  {
    $this->users->removeElement($user);
  }
}
