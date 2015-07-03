<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Rollerworks\Bundle\PasswordStrengthBundle\Validator\Constraints as RollerworksPassword;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {

  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   *
   * @ORM\Column(name="firstname", type="string", length=10, nullable=true)
   */
  private $firstname;

  /**
   * @var string
   *
   * @ORM\Column(name="lastname", type="string", length=10, nullable=true)
   */
  private $lastname;

  /**
   * @var string
   *
   * @ORM\Column(name="phone", type="string", length=10, nullable=true)
   */
  private $phone;

  /**
   * Plain password. Used for model validation. Must not be persisted.
   *
   * @var string
   *
   * @RollerworksPassword\PasswordStrength(minLength=7, minStrength=3)
   */
  protected $plainPassword;

  /**
   * @ORM\ManyToMany(targetEntity="Group")
   * @ORM\JoinTable(name="fos_user_group",
   *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
   * )
   */
  protected $groups;

  public function setGroups(ArrayCollection $groups) {
    $this->groups = $groups;

    return $this;
  }

  /**
   * @ORM\ManyToMany(targetEntity="Bygning", mappedBy="users")
   */
  protected $bygninger;

  public function setBygninger($bygninger) {
    $this->bygninger = $bygninger;

    return $this;
  }

  public function getBygninger() {
    return $this->bygninger;
  }

  public function __construct() {
    parent::__construct();
    $this->groups = new ArrayCollection();
    $this->bygninger = new ArrayCollection();
  }

  /**
   * Add bygninger
   *
   * @param \AppBundle\Entity\Bygning $bygninger
   *
   * @return User
   */
  public function addBygninger(\AppBundle\Entity\Bygning $bygninger)
  {
    $this->bygninger[] = $bygninger;

    return $this;
  }

  /**
   * Remove bygninger
   *
   * @param \AppBundle\Entity\Bygning $bygninger
   */
  public function removeBygninger(\AppBundle\Entity\Bygning $bygninger)
  {
    $this->bygninger->removeElement($bygninger);
  }

  /**
   * Set firstname
   *
   * @param string $firstname
   *
   * @return User
   */
  public function setFirstname($firstname)
  {
    $this->firstname = $firstname;

    return $this;
  }

  /**
   * Get firstname
   *
   * @return string
   */
  public function getFirstname()
  {
    return $this->firstname;
  }

  /**
   * Set lastname
   *
   * @param string $lastname
   *
   * @return User
   */
  public function setLastname($lastname)
  {
    $this->lastname = $lastname;

    return $this;
  }

  /**
   * Get lastname
   *
   * @return string
   */
  public function getLastname()
  {
    return $this->lastname;
  }

  /**
   * Set phone
   *
   * @param string $phone
   *
   * @return User
   */
  public function setPhone($phone)
  {
    $this->phone = $phone;

    return $this;
  }

  /**
   * Get phone
   *
   * @return string
   */
  public function getPhone()
  {
    return $this->phone;
  }
}
