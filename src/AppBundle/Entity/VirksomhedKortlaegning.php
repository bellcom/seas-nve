<?php

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\SlutanvendelseType;
use Doctrine\ORM\Mapping as ORM;

/**
 * VirksomhedKortlaegning
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\VirksomhedKortlaegningRepository")
 */
class VirksomhedKortlaegning
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
     * @ORM\Column(name="titel", type="string", length=255)
     */
    private $titel;

    /**
     * @ORM\OneToOne(targetEntity="Virksomhed", mappedBy="kortlaegning")
     **/
    protected $virksomhed;

    /**
     * @var float
     *
     * @ORM\Column(name="total_forbrug", type="float", scale=4, nullable=true)
     */
    private $totalForbrug;

    /**
     * @var array
     *
     * @ORM\Column(name="slutanvendelser", type="array")
     */
    private $slutanvendelser;

    /**
     * @var string
     *
     * @ORM\Column(name="aar", type="string", length=255)
     */
    private $aar;

    public function __construct() {
        $this->slutanvendelser = array();
        foreach (SlutanvendelseType::getChoices() as $key => $value) {
            $this->slutanvendelser[$key] = array(
                'procent' => NULL,
                'forbrug' => NULL,
            );
        }
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
     * Set titel
     *
     * @param string $titel
     *
     * @return VirksomhedKortlaegning
     */
    public function setTitel($titel)
    {
        $this->titel = $titel;

        return $this;
    }

    /**
     * Get titel
     *
     * @return string
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * @return Virksomhed|null
     */
    public function getVirksomhed() {
        return $this->virksomhed;
    }


    /**
     * Set virksomhed
     *
     * @param Virksomhed $virksomhed
     *
     * @return VirksomhedKortlaegning
     */
    public function setVirksomhed(Virksomhed $virksomhed = NULL) {
        $this->virksomhed = $virksomhed;

        return $this;
    }

    /**
     * Set totalForbrug
     *
     * @param float $totalForbrug
     * @return VirksomhedKortlaegning
     */
    public function setTotalForbrug($totalForbrug)
    {
        $this->totalForbrug = $totalForbrug;
        return $this;
    }

    /**
     * Get totalForbrug
     *
     * @return float
     */
    public function getTotalForbrug()
    {
        return $this->totalForbrug;
    }

    /**
     * Set slutanvendelser
     *
     * @param array $slutanvendelser
     *
     * @return VirksomhedKortlaegning
     */
    public function setSlutanvendelser($slutanvendelser)
    {
        $this->slutanvendelser = $slutanvendelser;

        return $this;
    }

    /**
     * Get slutanvendelser
     *
     * @return array
     */
    public function getSlutanvendelser()
    {
        return $this->slutanvendelser;
    }

    /**
     * Set aar
     *
     * @param string $aar
     *
     * @return VirksomhedKortlaegning
     */
    public function setAar($aar)
    {
        $this->aar = $aar;

        return $this;
    }

    /**
     * Get aar
     *
     * @return string
     */
    public function getAar()
    {
        return $this->aar;
    }
}

