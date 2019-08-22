<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * ContactPerson
 *
 * @ORM\Table()
 * @ORM\Entity
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
     * @ORM\ManyToOne(targetEntity="Virksomhed")
     * @JoinColumn(name="virksomhed_id", referencedColumnName="id")
     **/
    private $virksomhed;

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
     * Set Virksomhed.
     *
     * @param Virksomhed $virksomhed
     *
     * @return ContactPerson
     */
    public function setVirksomhed(Virksomhed $virksomhed = NULL) {
        $this->virksomhed = $virksomhed;

        return $this;
    }

    /**
     * Get contact person tilknytet Virksomhed
     *
     * @return Virksomhed
     */
    public function getVirksomhed() {
        return $this->virksomhed;
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

