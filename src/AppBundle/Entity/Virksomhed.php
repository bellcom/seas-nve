<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\VirksomhedRapport;
use JMS\Serializer\Annotation as JMS;

/**
 * Virksomhed entity.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\VirksomhedRepository")
 */
class Virksomhed
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
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="cvr_number", type="string", length=255)
     */
    private $cvrNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="branch_code", type="string", length=255)
     */
    private $branchCode;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_person", type="string", length=255)
     */
    private $contactPerson;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_number", type="string", length=255)
     */
    private $customerNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @ORM\OneToOne(targetEntity="VirksomhedRapport", mappedBy="virksomhed", cascade={"persist"})
     * @JMS\Exclude
     **/
    protected $rapport;

    /**
     * @var float
     * @ORM\Column(name="subsidy_level", type="decimal", scale=4, nullable=true)
     */
    protected $subsidyLevel;

    /**
     * @var float
     * @ORM\Column(name="kalkulationsrente", type="decimal", scale=4, nullable=true)
     */
    protected $kalkulationsrente;

    /**
     * @var float
     * @ORM\Column(name="inflation", type="decimal", scale=4, nullable=true)
     */
    protected $inflation;

    /**
     * @var float
     * @ORM\Column(name="lobetid", type="decimal", scale=4, nullable=true)
     */
    protected $lobetid;

    /**
     * @var string
     *
     * @ORM\Column(name="env_p_number", type="string", length=255, nullable=true)
     */
    private $evtPNumber;

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
     * @return Virksomhed
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
     * Set address
     *
     * @param string $address
     *
     * @return Virksomhed
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set cvrNumber
     *
     * @param string $cvrNumber
     *
     * @return Virksomhed
     */
    public function setCvrNumber($cvrNumber)
    {
        $this->cvrNumber = $cvrNumber;

        return $this;
    }

    /**
     * Get cvrNumber
     *
     * @return string
     */
    public function getCvrNumber()
    {
        return $this->cvrNumber;
    }

    /**
     * Set branchCode
     *
     * @param string $branchCode
     *
     * @return Virksomhed
     */
    public function setBranchCode($branchCode)
    {
        $this->branchCode = $branchCode;

        return $this;
    }

    /**
     * Get branchCode
     *
     * @return string
     */
    public function getBranchCode()
    {
        return $this->branchCode;
    }

    /**
     * Set contactPerson
     *
     * @param string $contactPerson
     *
     * @return Virksomhed
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;

        return $this;
    }

    /**
     * Get contactPerson
     *
     * @return string
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     * Set customerNumber
     *
     * @param string $customerNumber
     *
     * @return Virksomhed
     */
    public function setCustomerNumber($customerNumber)
    {
        $this->customerNumber = $customerNumber;

        return $this;
    }

    /**
     * Get customerNumber
     *
     * @return string
     */
    public function getCustomerNumber()
    {
        return $this->customerNumber;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Virksomhed
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
     * Set rapport
     *
     * @param VirksomhedRapport $rapport
     *
     * @return Virksomhed
     */
    public function setRapport(VirksomhedRapport $rapport = NULL) {
        $this->rapport = $rapport;
        if($rapport !== null) {
            $rapport->setVirksomhed($this);
        }

        return $this;
    }

    /**
     * Get rapport
     *
     * @return VirksomhedRapport
     */
    public function getRapport() {
        return $this->rapport;
    }

    /**
     * Set subsidy level
     *
     * @param float $subsidyLevel
     *
     * @return Virksomhed
     */
    public function setSubsidyLevel($subsidyLevel)
    {
        $this->subsidyLevel = $subsidyLevel;

        return $this;
    }

    /**
     * Get subsidy level
     *
     * @return float
     */
    public function getSubsidyLevel()
    {
        return $this->subsidyLevel;
    }

    /**
     * Set kalkulationsrente
     *
     * @param float $kalkulationsrente
     *
     * @return Virksomhed
     */
    public function setKalkulationsrente($kalkulationsrente)
    {
        $this->kalkulationsrente = $kalkulationsrente;

        return $this;
    }

    /**
     * Get kalkulationsrente
     *
     * @return float
     */
    public function getKalkulationsrente()
    {
        return $this->kalkulationsrente;
    }

    /**
     * Set inflation
     *
     * @param float $inflation
     *
     * @return Virksomhed
     */
    public function setInflation($inflation)
    {
        $this->inflation = $inflation;

        return $this;
    }

    /**
     * Get inflation
     *
     * @return float
     */
    public function getInflation()
    {
        return $this->inflation;
    }

    /**
     * Set lobetid
     *
     * @param float $lobetid
     *
     * @return Virksomhed
     */
    public function setLobetid($lobetid)
    {
        $this->lobetid = $lobetid;

        return $this;
    }

    /**
     * Get lobetid
     *
     * @return float
     */
    public function getLobetid()
    {
        return $this->lobetid;
    }

    /**
     * Set evt. P-number
     *
     * @param string $evtPNumber
     *
     * @return Virksomhed
     */
    public function setEvtPNumber($evtPNumber)
    {
        $this->evtPNumber = $evtPNumber;

        return $this;
    }

    /**
     * Get evt. P-number
     *
     * @return string
     */
    public function getEvtPNumber()
    {
        return $this->evtPNumber;
    }

    public function getBygnings() {
        global $kernel;
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository('AppBundle:Bygning');
        return $repository->findBy(array('virksomhed' => $this->getId()));
    }

    public function getBygningsAreal() {
        $areal = 0;
        $bygnings = $this->getBygnings();
        /** @var Bygning $bygning */
        foreach ($bygnings as $bygning) {
            $areal += $bygning->getAreal();
        }
        return $areal;
    }

    /**
     * To string converting method
     *
     * @return string
     */
    public function __toString() {
        if (!empty($this->name)) {
            return $this->name;
        }
        if (!empty($this->address)) {
            return $this->address;
        }
        return strval($this->id);
    }

}

