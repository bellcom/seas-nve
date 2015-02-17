<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Rapport
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RapportRepository")
 */
class Rapport
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
     * @ManyToOne(targetEntity="Bygning", inversedBy="rapporter")
     * @JoinColumn(name="bygning_id", referencedColumnName="id")
     **/
    private $bygning;


    /**
     * @OneToMany(targetEntity="Tiltag", mappedBy="rapport")
     */
    private $tiltag;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=255)
     */
    private $version;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Datering", type="date")
     */
    private $datering;


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
     * Set version
     *
     * @param string $version
     * @return Rapport
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set datering
     *
     * @param \DateTime $datering
     * @return Rapport
     */
    public function setDatering($datering)
    {
        $this->datering = $datering;

        return $this;
    }

    /**
     * Get datering
     *
     * @return \DateTime 
     */
    public function getDatering()
    {
        return $this->datering;
    }


    /**
     * Set bygning
     *
     * @param \AppBundle\Entity\Bygning $bygning
     * @return Rapport
     */
    public function setBygning(\AppBundle\Entity\Bygning $bygning = null)
    {
        $this->bygning = $bygning;

        return $this;
    }

    /**
     * Get bygning
     *
     * @return \AppBundle\Entity\Bygning 
     */
    public function getBygning()
    {
        return $this->bygning;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tiltag = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tiltag
     *
     * @param \AppBundle\Entity\Tiltag $tiltag
     * @return Rapport
     */
    public function addTiltag(\AppBundle\Entity\Tiltag $tiltag)
    {
        $this->tiltag[] = $tiltag;

        return $this;
    }

    /**
     * Remove tiltag
     *
     * @param \AppBundle\Entity\Tiltag $tiltag
     */
    public function removeTiltag(\AppBundle\Entity\Tiltag $tiltag)
    {
        $this->tiltag->removeElement($tiltag);
    }

    /**
     * Get tiltag
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTiltag()
    {
        return $this->tiltag;
    }
}
