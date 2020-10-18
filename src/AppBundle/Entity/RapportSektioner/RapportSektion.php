<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Entity\Rapport;
use AppBundle\Entity\VirksomhedRapport;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;


/**
 * RapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RapportSektioner\RapportSektionRepository")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *    "standard" = "RapportSektion",
 *    "opsummering" = "OpsummeringRapportSektion",
 * })
 */
class RapportSektion {
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var array
     *
     * @ORM\Column(name="extras", type="array")
     */
    private $extras;

    /**
     * Rapport oversigt section reference to Bygning rapport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Rapport", inversedBy="rapportOversigtSektioner")
     * @ORM\JoinColumn(name="bygning_oversigt_rapport_id", referencedColumnName="id")
     */
    protected $bygningOversigtRapport;

    /**
     * Rapport oversigt section reference to Virksomhed rapport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\VirksomhedRapport", inversedBy="rapportSektioner")
     * @ORM\JoinColumn(name="virksomhed_oversigt_rapport_id", referencedColumnName="id")
     */
    protected $virksomhedOversigtRapport;

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
     * Set title
     *
     * @param string $title
     *
     * @return RapportSektion
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return RapportSektion
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set extras
     *
     * @param array $extras
     *
     * @return RapportSektion
     */
    public function setExtras($extras)
    {
        $this->extras = $extras;

        return $this;
    }

    /**
     * Get extras
     *
     * @return array
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * Set bygningOversigtRapport
     *
     * @param \AppBundle\Entity\Rapport $bygningOversigtRapport
     * @return RapportSektion
     */
    public function setByningOversigtRapport(Rapport $bygningOversigtRapport = NULL) {
        $this->bygningOversigtRapport = $bygningOversigtRapport;

        return $this;
    }

    /**
     * Get bygningOversigtRapport
     *
     * @return \AppBundle\Entity\Rapport
     */
    public function getBygningOversigtRapport() {
        return $this->bygningOversigtRapport;
    }

    /**
     * Set virksomhedOversigtRapport
     *
     * @param \AppBundle\Entity\VirksomhedRapport $virksomhedOversigtRapport
     * @return RapportSektion
     */
    public function setVirksomhedOversigtRapport(VirksomhedRapport $virksomhedOversigtRapport = NULL) {
        $this->virksomhedOversigtRapport = $virksomhedOversigtRapport;

        return $this;
    }

    /**
     * Get virksomhedOversigtRapport
     *
     * @return \AppBundle\Entity\VirksomhedRapport
     */
    public function getVirksomhedOversigtRapport() {
        return $this->virksomhedOversigtRapport;
    }

}

