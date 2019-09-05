<?php

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\ContactPersonReferenceType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * ContactPerson
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ContactPersonRepository")
 */
class ContactPerson
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     * @ORM\Column(name="reference_id", type="integer", nullable=true)
     */
    private $referenceId;

    /**
     * @ORM\Column(name="reference_type", type="ContactPersonReferenceType")
     **/
    private $referenceType;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @Assert\Email
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ContactPerson
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set reference_type
     *
     * @param string $referenceType
     *
     * @return ContactPerson
     */
    public function setReferenceType($referenceType)
    {
        $this->referenceType = $referenceType;

        return $this;
    }

    /**
     * Get reference_type
     *
     * @return string
     */
    public function getReferenceType()
    {
        return $this->referenceType;
    }

    /**
     * Set reference_id
     *
     * @param string $referenceId
     *
     * @return ContactPerson
     */
    public function setReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;

        return $this;
    }

    /**
     * Get reference_id
     *
     * @return string
     */
    public function getReferenceId()
    {
        return $this->referenceId;
    }

  /**
   * Set reference
   *
   * @param object $reference
   *
   * @return ContactPerson
   * @throws
   */
  public function setReference($reference)
  {
      $reference_type = strtolower((new \ReflectionClass($reference))->getShortName());
      if (!ContactPersonReferenceType::isValueExist($reference_type)) {
          return NULL;
      }
      $this->setReferenceType($reference_type);
      $this->setReferenceId($reference->getId());
      return $this;
  }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return ContactPerson
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return ContactPerson
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * To string converting method
     *
     * @return string
     */
    public function __toString() {
        return $this->name;
    }

}

