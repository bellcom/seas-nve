<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Rollerworks\Bundle\PasswordStrengthBundle\Validator\Constraints as RollerworksPassword;
use Doctrine\ORM\Mapping\OneToMany;

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
   * @ORM\Column(name="firstname", type="string", length=20, nullable=true)
   */
  private $firstname;

  /**
   * @var string
   *
   * @ORM\Column(name="lastname", type="string", length=30, nullable=true)
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

  /**
   * @OneToMany(targetEntity="Segment", mappedBy="segmentAnsvarlig")
   **/
  protected $segmenter;


  public function __construct() {
    parent::__construct();
    $this->groups = new ArrayCollection();
    $this->bygninger = new ArrayCollection();
    $this->segmenter = new ArrayCollection();
    $this->username = 'username';
  }

  public function setGroups(ArrayCollection $groups) {
    $this->groups = $groups;

    return $this;
  }

  /**
   * @ORM\ManyToMany(targetEntity="Bygning", mappedBy="users")
   */
  protected $bygninger;


  /**
   * Set bygninger
   */
  public function setBygninger(\Doctrine\Common\Collections\Collection $bygninger) {
    $this->bygninger = $bygninger;

    return $this;
  }

  public function getBygninger() {
    return $this->bygninger;
  }

  /**
   * Add bygninger
   *
   * @param \AppBundle\Entity\Bygning $bygninger
   *
   * @return User
   */
  public function addBygninger(\AppBundle\Entity\Bygning $bygning)
  {
    $this->bygninger[] = $bygning;
    $bygning->addUser($this);

    return $this;
  }

  /**
   * Remove bygninger
   *
   * @param \AppBundle\Entity\Bygning $bygninger
   */
  public function removeBygninger(\AppBundle\Entity\Bygning $bygning)
  {
    $this->bygninger->removeElement($bygning);
    $bygning->removeUser($this);
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


  /**
   * Add segmenter
   *
   * @param \AppBundle\Entity\Segment $segmenter
   *
   * @return User
   */
  public function addSegmenter(\AppBundle\Entity\Segment $segment)
  {
    $this->segmenter[] = $segment;
    $segment->setSegmentAnsvarlig($this);

    return $this;
  }

  /**
   * Remove segmenter
   *
   * @param \AppBundle\Entity\Segment $segmenter
   */
  public function removeSegmenter(\AppBundle\Entity\Segment $segment)
  {
    $this->segmenter->removeElement($segment);
    $segment->removeSegmentAnsvarlig();
  }

  /**
   * Get segmenter
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getSegmenter()
  {
    return $this->segmenter;
  }

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    return $this->getFirstname().' '.$this->getLastname();
  }

  /**
   * Sets the email.
   *
   * @param string $email
   * @return User
   */
  public function setEmail($email)
  {
    $this->setUsername($email);

    return parent::setEmail($email);
  }

  /**
   * Set the canonical email.
   *
   * @param string $emailCanonical
   * @return User
   */
  public function setEmailCanonical($emailCanonical)
  {
    $this->setUsernameCanonical($emailCanonical);

    return parent::setEmailCanonical($emailCanonical);
  }
}
