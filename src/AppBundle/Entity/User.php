<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Rollerworks\Bundle\PasswordStrengthBundle\Validator\Constraints as RollerworksPassword;
use Rollerworks\Bundle\PasswordStrengthBundle\Validator\Constraints\PasswordRequirements;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OrderBy;
use JMS\Serializer\Annotation as JMS;
use AppBundle\Validator\Constraints as AppBundleAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
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
   * @AppBundleAssert\UserEmail
   * @Assert\Email
   */
  protected $email;

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
   * @RollerworksPassword\PasswordStrength(minLength=8, minStrength=3, message="Vælg et stærkere kodeord")
   * @RollerworksPassword\PasswordRequirements(
   *  requireLetters=true,
   *  requireNumbers=true,
   *  requireCaseDiff=true,
   *  tooShortMessage="Kodeord skal være på mindst 8 tegn",
   *  requireCaseDiffMessage="Kodeordet skal indeholde både store og små bogstaver",
   *  missingNumbersMessage="Kodeordet skal indeholde tal",
   *  missingSpecialCharacterMessage="Kodeordet skal indeholde bogstaver")
   */
  protected $plainPassword;

  /**
   * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
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

  /**
   * @OneToMany(targetEntity="Bygning", mappedBy="aaplusAnsvarlig")
   * @OrderBy({"navn" = "ASC"})
   * @JMS\Exclude
   **/
  protected $ansvarlig;

  /**
   * @ManyToMany(targetEntity="Bygning", mappedBy="energiRaadgiver")
   * @OrderBy({"navn" = "ASC"})
   * @JMS\Exclude
   **/
  protected $energiRaadgiver;

  /**
   * @OneToMany(targetEntity="Bygning", mappedBy="projektleder")
   * @OrderBy({"navn" = "ASC"})
   * @JMS\Exclude
   **/
  protected $projektleder;

  /**
   * @OneToMany(targetEntity="Bygning", mappedBy="projekterende")
   * @OrderBy({"navn" = "ASC"})
   * @JMS\Exclude
   **/
  protected $projekterende;

  /**
   * The token
   *
   * @ORM\Column(name="token", type="string", length=255)
   */
  protected $token;

  public function __construct() {
    parent::__construct();
    $this->groups = new ArrayCollection();
    $this->bygninger = new ArrayCollection();
    $this->segmenter = new ArrayCollection();
    $this->username = 'username';
    $this->generateToken();
  }

  public function setGroups($groups) {
    if(is_a($groups, 'Doctrine\Common\Collections\ArrayCollection')) {
      $this->groups = $groups;
    } else {
      $this->groups->add($groups);
    }

    return $this;
  }

  public function getGroup() {
    return implode(", ", $this->getGroupNames());
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
    return implode(' ', array_filter(array(
      $this->getFirstname(),
      $this->getLastname(),
    )));
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

  /**
   * Generates token for user.
   *
   * @return string
   */
  public function generateToken()
  {
      $this->token = hash('md5', $this->getSalt());
  }

  /**
   * Get user token.
   *
   * @return string
   */
  public function getToken()
  {
      return $this->token;
  }
}
