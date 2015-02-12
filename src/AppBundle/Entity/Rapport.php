<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
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
     * @JoinColumn(name="rapport_id", referencedColumnName="id")
     **/
    private $bygning;

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

}
