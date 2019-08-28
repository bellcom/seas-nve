<?php

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\VirksomhedTypeType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use AppBundle\Entity\VirksomhedRapport;
use JMS\Serializer\Annotation as JMS;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(name="cvr_number", type="string", length=255)
     */
    private $cvrNumber;

    /**
     * @var array
     *
     * @ORM\Column(name="ean_numbers", type="array", nullable=true)
     */
    private $eanNumbers;

    /**
     * @var array
     *
     * @ORM\Column(name="p_numbers", type="array", nullable=true)
     */
    private $pNumbers;

    /**
     * @var string
     *
     * @ORM\Column(name="crm_number", type="string", length=255, nullable=true)
     */
    private $crmNumber;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ContactPerson", mappedBy="virksomhed", cascade={"persist", "remove"})
     *
     * @Assert\NotBlank
     */
    private $contactPersons;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_number", type="string", length=255, nullable=true)
     */
    private $customerNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="project_number", type="string", length=255, nullable=true)
     */
    private $projectNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="aftager_number", type="string", length=255, nullable=true)
     */
    private $aftagerNumber;

    /**
     * @var VirksomhedTypeType
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\VirksomhedTypeType")
     * @ORM\Column(name="type_name", type="VirksomhedTypeType", nullable=true)
     **/
    protected $typeName;

    /**
     * @ORM\OneToOne(targetEntity="VirksomhedRapport", mappedBy="virksomhed", cascade={"persist"})
     * @JMS\Exclude
     **/
    protected $rapport;

    /**
     * @var string
     *
     * @ORM\Column(name="nace_code", type="string", length=255, nullable=true)
     */
    private $naceCode;

    /**
     * @var string
     *
     * @ORM\Column(name="dsm_code", type="string", length=255, nullable=true)
     */
    private $dsmCode;

    /**
     * @var float
     *
     * @ORM\Column(name="energy_price", scale=4, nullable=true)
     */
    private $energyPrice;

    /**
     * @var float
     * @ORM\Column(name="subsidy_size", type="decimal", scale=4, nullable=true)
     */
    protected $subsidySize;

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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bygning", mappedBy="virksomhed", cascade={"persist"})
     */
    private $bygninger;

    /**
     * @ORM\ManyToOne(targetEntity="Virksomhed")
     * @JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     **/
    protected $parent;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Virksomhed", mappedBy="parent", cascade={"persist"})
     */
    private $datterSelskaber;

    /**
     * @var string
     *
     * @ORM\Column(name="kommune", type="string", length=255, nullable=true)
     */
    private $kommune;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="by_nanv", type="string", length=255, nullable=true)
     */
    private $byNavn;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="postnummer", type="string", length=255, nullable=true)
     */
    private $postnummer;

    /**
     * @var string
     *
     * @ORM\Column(name="erhvervs_areal", type="string", length=255, nullable=true)
     */
    private $erhvervsAreal;

    /**
     * @var string
     *
     * @ORM\Column(name="opvarmet_areal", type="string", length=255, nullable=true)
     */
    private $opvarmetAreal;

    /**
     * @var string
     *
     * @ORM\Column(name="aars_vaerk", type="string", length=255, nullable=true)
     */
    private $aarsVaerk;

    /**
     * @var string
     *
     * @ORM\Column(name="forbrug", type="string", length=255, nullable=true)
     */
    private $forbrug;

    /**
     * @var string
     *
     * @ORM\Column(name="er", type="string", length=255, nullable=true)
     */
    private $er;

    /**
     * @var string
     *
     * @ORM\Column(name="kam", type="string", length=255, nullable=true)
     */
    private $kam;

    /**
     * @var User $user
     *
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     * @JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    protected $user;

    /**
     * Virksomhed constructor.
     */
    public function __construct()
    {
        $this->contactPersons = new ArrayCollection();
        $this->datterSelskaber = new ArrayCollection();
        $this->bygninger = new ArrayCollection();
        $this->user = new User();
    }

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
     * Set eanNumbers
     *
     * @param array $eanNumbers
     *
     * @return Virksomhed
     */
    public function setEanNumbers(array $eanNumbers)
    {
        $this->eanNumbers = $eanNumbers;

        return $this;
    }

    /**
     * Get eanNumbers
     *
     * @return array
     */
    public function getEanNumbers()
    {
        return $this->eanNumbers;
    }

    /**
     * Set pNumbers
     *
     * @param array $pNumbers
     *
     * @return Virksomhed
     */
    public function setPNumbers(array $pNumbers)
    {
        $this->pNumbers = $pNumbers;

        return $this;
    }

    /**
     * Get pNumbers
     *
     * @return array
     */
    public function getPNumbers()
    {
        return $this->pNumbers;
    }

    /**
     * Set crmNumber
     *
     * @param string $crmNumber
     *
     * @return Virksomhed
     */
    public function setCrmNumber($crmNumber)
    {
        $this->crmNumber = $crmNumber;

        return $this;
    }

    /**
     * Get crmNumber
     *
     * @return string
     */
    public function getCrmNumber()
    {
        return $this->crmNumber;
    }

    /**
     * Set contactPersons
     *
     * @param ArrayCollection $contactPersons
     *
     * @return Virksomhed
     */
    public function setContactPersons($contactPersons)
    {
        $this->contactPersons = $contactPersons;

        return $this;
    }

    /**
     * Get contactPersons
     *
     * @return ArrayCollection
     */
    public function getContactPersons()
    {
        return $this->contactPersons;
    }

    /**
     * Adds contact person to collection.
     *
     * @param ContactPerson $contactPerson
     */
    public function addContactPerson(ContactPerson $contactPerson)
    {
        $contactPerson->setVirksomhed($this);
        $this->contactPersons->add($contactPerson);
    }

    /**
     * Removes contact person from collection.
     *
     * @param ContactPerson $contactPerson
     */
    public function removeContactPerson(ContactPerson $contactPerson)
    {
        $this->contactPersons->removeElement($contactPerson);
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
     * Set projectNumber
     *
     * @param string $projectNumber
     *
     * @return Virksomhed
     */
    public function setProjectNumber($projectNumber)
    {
        $this->projectNumber = $projectNumber;

        return $this;
    }

    /**
     * Get projectNumber
     *
     * @return string
     */
    public function getProjectNumber()
    {
        return $this->projectNumber;
    }

    /**
     * Set aftagerNumber
     *
     * @param string $aftagerNumber
     *
     * @return Virksomhed
     */
    public function setAftagerNumber($aftagerNumber)
    {
        $this->aftagerNumber = $aftagerNumber;

        return $this;
    }

    /**
     * Get aftagerNumber
     *
     * @return string
     */
    public function getAftagerNumber()
    {
        return $this->aftagerNumber;
    }

    /**
     * Set type name
     *
     * @param VirksomhedTypeType $typeName
     *
     * @return Virksomhed
     */
    public function setTypeName($typeName = NULL) {
        $this->typeName = $typeName;

        return $this;
    }

    /**
     * Get type name
     *
     * @return \AppBundle\DBAL\Types\VirksomhedTypeType
     */
    public function getTypeName() {
        return $this->typeName;
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
     * Set naceCode
     *
     * @param string $naceCode
     *
     * @return Virksomhed
     */
    public function setNaceCode($naceCode)
    {
        $this->naceCode = $naceCode;

        return $this;
    }

    /**
     * Get naceCode
     *
     * @return string
     */
    public function getNaceCode()
    {
        return $this->naceCode;
    }

    /**
     * Set dsmCode
     *
     * @param string $dsmCode
     *
     * @return Virksomhed
     */
    public function setDsmCode($dsmCode)
    {
        $this->dsmCode = $dsmCode;

        return $this;
    }

    /**
     * Get dsmCode
     *
     * @return string
     */
    public function getDsmCode()
    {
        return $this->dsmCode;
    }

    /**
     * Set energyPrice
     *
     * @param float $energyPrice
     *
     * @return Virksomhed
     */
    public function setEnergyPrice($energyPrice)
    {
        $this->energyPrice = $energyPrice;

        return $this;
    }

    /**
     * Get energyPrice
     *
     * @return float
     */
    public function getEnergyPrice()
    {
        return $this->dsmCode;
    }

    /**
     * Set subsidy size
     *
     * @param float $subsidySize
     *
     * @return Virksomhed
     */
    public function setSubsidySize($subsidySize)
    {
        $this->subsidySize = $subsidySize;

        return $this;
    }

    /**
     * Get subsidy size
     *
     * @return float
     */
    public function getSubsidySize()
    {
        return $this->subsidySize;
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
     * Set bygninger
     *
     * @return Virksomhed
     */
    public function setBygninger($bygninger) {
        $this->bygninger = $bygninger;

        return $this;
    }

    /**
     * Get bygninger
     *
     * @return ArrayCollection
     */
    public function getBygninger() {
        return $this->bygninger;
    }

    /**
     * Get bygninger
     *
     * @return array
     */
    public function getAllBygninger() {
        $bygninger = array();
        /** @var Bygning $bygning */
        foreach ($this->getBygninger()as $bygning) {
            $bygninger[$bygning->getId()] = $bygning;
        }
        /** @var Virksomhed $datterSelskab */
        foreach ($this->getDatterSelskaber() as $datterSelskab) {
            foreach ($datterSelskab->getBygninger() as $bygning) {
                if (isset($bygninger[$bygning->getId()])) {
                    continue;
                }
                $bygninger[$bygning->getId()] = $bygning;
            }
        }

        return $bygninger;
    }

    /**
     * Adds bygning to collection.
     *
     * @param Bygning $bygning
     */
    public function addBygninger(Bygning $bygning)
    {
        $bygning->setVirksomhed($this);
        $this->bygninger->add($bygning);
    }

    /**
     * Removes bygning from collection.
     *
     * @param Bygning $bygning
     */
    public function removeBygninger(Bygning $bygning)
    {
        $this->bygninger->removeElement($bygning);
    }

    public function getBygningerAreal() {
        $areal = 0;
        $bygnings = $this->getBygninger();
        /** @var Bygning $bygning */
        foreach ($bygnings as $bygning) {
            $areal += $bygning->getAreal();
        }
        return $areal;
    }

    /**
     * Set datterSelskaber
     *
     * @return Virksomhed
     */
    public function setDatterSelskaber($datterSelskaber) {
        $this->datterSelskaber = $datterSelskaber;

        return $this;
    }

    /**
     * Get datterSelskaber
     *
     * @return ArrayCollection
     */
    public function getDatterSelskaber() {
        return $this->datterSelskaber;
    }

    /**
     * Adds datterSelskaber to collection.
     *
     * @param Virksomhed|null $virksomhed
     */
    public function addDatterSelskaber($virksomhed = NULL)
    {
        if ($virksomhed instanceof Virksomhed) {
            $virksomhed->setParent($this);
            $this->datterSelskaber->add($virksomhed);
        }
    }

    /**
     * Removes contact person from collection.
     *
     * @param Virksomhed $virksomhed
     */
    public function removeDatterSelskaber(Virksomhed $virksomhed)
    {
        $this->datterSelskaber->removeElement($virksomhed);
    }

    /**
     * Set parent Virksomhed.
     *
     * @param Virksomhed $parent
     *
     * @return Virksomhed
     */
    public function setParent(Virksomhed $parent = NULL) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent Virksomhed
     *
     * @return Virksomhed
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Set kommune
     *
     * @param string $kommune
     *
     * @return Virksomhed
     */
    public function setKommune($kommune)
    {
        $this->kommune = $kommune;

        return $this;
    }

    /**
     * Get kommune
     *
     * @return string
     */
    public function getKommune()
    {
        return $this->kommune;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return Virksomhed
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set by navn
     *
     * @param string $byNavn
     *
     * @return Virksomhed
     */
    public function setByNavn($byNavn)
    {
        $this->byNavn = $byNavn;

        return $this;
    }

    /**
     * Get by navn
     *
     * @return string
     */
    public function getByNavn()
    {
        return $this->byNavn;
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
     * Set postnummer
     *
     * @param string $postnummer
     *
     * @return Virksomhed
     */
    public function setPostnummer($postnummer)
    {
        $this->postnummer = $postnummer;

        return $this;
    }

    /**
     * Get postnummer
     *
     * @return string
     */
    public function getPostnummer()
    {
        return $this->postnummer;
    }

    /**
     * Set erhvervsAreal
     *
     * @param string $erhvervsAreal
     *
     * @return Virksomhed
     */
    public function setErhvervsAreal($erhvervsAreal)
    {
        $this->erhvervsAreal = $erhvervsAreal;

        return $this;
    }

    /**
     * Get erhvervsAreal
     *
     * @return string
     */
    public function getErhvervsAreal()
    {
        return $this->erhvervsAreal;
    }

    /**
     * Set opvarmetAreal
     *
     * @param string $opvarmetAreal
     *
     * @return Virksomhed
     */
    public function setOpvarmetAreal($opvarmetAreal)
    {
        $this->opvarmetAreal = $opvarmetAreal;

        return $this;
    }

    /**
     * Get opvarmetAreal
     *
     * @return string
     */
    public function getOpvarmetAreal()
    {
        return $this->opvarmetAreal;
    }

    /**
     * Set aarsVaerk
     *
     * @param string $aarsVaerk
     *
     * @return Virksomhed
     */
    public function setAarsVaerk($aarsVaerk)
    {
        $this->aarsVaerk = $aarsVaerk;

        return $this;
    }

    /**
     * Get aarsVaerk
     *
     * @return string
     */
    public function getAarsVaerk()
    {
        return $this->aarsVaerk;
    }

    /**
     * Set forbrug
     *
     * @param string $forbrug
     *
     * @return Virksomhed
     */
    public function setForbrug($forbrug)
    {
        $this->forbrug = $forbrug;

        return $this;
    }

    /**
     * Get forbrug
     *
     * @return string
     */
    public function getForbrug()
    {
        return $this->forbrug;
    }

    /**
     * Set ER
     *
     * @param string $er
     *
     * @return Virksomhed
     */
    public function setEr($er)
    {
        $this->er = $er;

        return $this;
    }

    /**
     * Get ER
     *
     * @return string
     */
    public function getEr()
    {
        return $this->er;
    }

    /**
     * Set KAM
     *
     * @param string $kam
     *
     * @return Virksomhed
     */
    public function setKam($kam)
    {
        $this->kam = $kam;

        return $this;
    }

    /**
     * Get KAM
     *
     * @return string
     */
    public function getKam()
    {
        return $this->kam;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Virksomhed
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
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

    /**
     * Filters empty values for entity.
     */
    public function filterEmptyValues() {
        $this->setEanNumbers(array_filter($this->getEanNumbers()));
        $this->setPNumbers(array_filter($this->getPNumbers()));
        $datterSelskaber = $this->getDatterSelskaber();
        foreach ($datterSelskaber as $virksomhed) {
            if (empty($virksomhed->getId())) {
                $datterSelskaber->removeElement($virksomhed);
            }
        }
        $this->setDatterSelskaber($datterSelskaber);
    }

    /**
     * Sets default values for entity if they are empty.
     */
    public function setDefaultValues() {
        if (empty($this->getEanNumbers())) {
            $this->setEanNumbers(array(0 => ''));
        }
        if (empty($this->getPNumbers())) {
            $this->setPNumbers(array(0 => ''));
        }
        if (empty($this->getDatterSelskaber()->first())) {
            $this->setDatterSelskaber(new ArrayCollection(array(new Virksomhed())));
        }
    }

}

