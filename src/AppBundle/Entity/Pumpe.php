<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pumpe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PumpeRepository")
 */
class Pumpe
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
     * @ORM\Column(name="NuvaerendeType", type="string", length=255)
     */
    private $nuvaerendeType;

    /**
     * @var integer
     *
     * @ORM\Column(name="Byggemaal", type="integer")
     */
    private $byggemaal;

    /**
     * @var string
     *
     * @ORM\Column(name="Tilslutning", type="string", length=25)
     */
    private $tilslutning;

    /**
     * @var integer
     *
     * @ORM\Column(name="Indst", type="integer")
     */
    private $indst;

    /**
     * @var string
     *
     * @ORM\Column(name="Forbrug", type="string", length=25)
     */
    private $forbrug;

    /**
     * @var string
     *
     * @ORM\Column(name="Q", type="decimal")
     */
    private $q;

    /**
     * @var string
     *
     * @ORM\Column(name="H", type="decimal")
     */
    private $h;

    /**
     * @var integer
     *
     * @ORM\Column(name="Aarsforbrug", type="integer")
     */
    private $aarsforbrug;

    /**
     * @var string
     *
     * @ORM\Column(name="NyPumpe", type="string", length=255)
     */
    private $nyPumpe;

    /**
     * @var integer
     *
     * @ORM\Column(name="NyByggemaal", type="integer")
     */
    private $nyByggemaal;

    /**
     * @var string
     *
     * @ORM\Column(name="NyTilslutning", type="string", length=25)
     */
    private $nyTilslutning;

    /**
     * @var string
     *
     * @ORM\Column(name="vvsnr", type="string", length=20)
     */
    private $vvsnr;

    /**
     * @var integer
     *
     * @ORM\Column(name="NytAarsforbrug", type="integer")
     */
    private $nytAarsforbrug;

    /**
     * @var integer
     *
     * @ORM\Column(name="Elbesparelse", type="integer")
     */
    private $elbesparelse;

    /**
     * @var string
     *
     * @ORM\Column(name="Udligningssaet", type="string", length=20)
     */
    private $udligningssaet;

    /**
     * @var string
     *
     * @ORM\Column(name="Kommentarer", type="string", length=255)
     */
    private $kommentarer;

    /**
     * @var integer
     *
     * @ORM\Column(name="StandInvestering", type="integer", nullable=true)
     */
    private $standInvestering;

    /**
     * @var string
     *
     * @ORM\Column(name="Fabrikant", type="string", length=50)
     */
    private $fabrikant;

    /**
     * @var integer
     *
     * @ORM\Column(name="Roerlaengde", type="integer")
     */
    private $roerlaengde;

    /**
     * @var string
     *
     * @ORM\Column(name="Roerstoerrelse", type="string", length=10)
     */
    private $roerstoerrelse;


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
     * Set nuvaerendeType
     *
     * @param string $nuvaerendeType
     * @return Pumpe
     */
    public function setNuvaerendeType($nuvaerendeType)
    {
        $this->nuvaerendeType = $nuvaerendeType;

        return $this;
    }

    /**
     * Get nuvaerendeType
     *
     * @return string 
     */
    public function getNuvaerendeType()
    {
        return $this->nuvaerendeType;
    }

    /**
     * Set byggemaal
     *
     * @param integer $byggemaal
     * @return Pumpe
     */
    public function setByggemaal($byggemaal)
    {
        $this->byggemaal = $byggemaal;

        return $this;
    }

    /**
     * Get byggemaal
     *
     * @return integer 
     */
    public function getByggemaal()
    {
        return $this->byggemaal;
    }

    /**
     * Set tilslutning
     *
     * @param string $tilslutning
     * @return Pumpe
     */
    public function setTilslutning($tilslutning)
    {
        $this->tilslutning = $tilslutning;

        return $this;
    }

    /**
     * Get tilslutning
     *
     * @return string 
     */
    public function getTilslutning()
    {
        return $this->tilslutning;
    }

    /**
     * Set indst
     *
     * @param integer $indst
     * @return Pumpe
     */
    public function setIndst($indst)
    {
        $this->indst = $indst;

        return $this;
    }

    /**
     * Get indst
     *
     * @return integer 
     */
    public function getIndst()
    {
        return $this->indst;
    }

    /**
     * Set forbrug
     *
     * @param string $forbrug
     * @return Pumpe
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
     * Set q
     *
     * @param string $q
     * @return Pumpe
     */
    public function setQ($q)
    {
        $this->q = $q;

        return $this;
    }

    /**
     * Get q
     *
     * @return string 
     */
    public function getQ()
    {
        return $this->q;
    }

    /**
     * Set h
     *
     * @param string $h
     * @return Pumpe
     */
    public function setH($h)
    {
        $this->h = $h;

        return $this;
    }

    /**
     * Get h
     *
     * @return string 
     */
    public function getH()
    {
        return $this->h;
    }

    /**
     * Set aarsforbrug
     *
     * @param integer $aarsforbrug
     * @return Pumpe
     */
    public function setAarsforbrug($aarsforbrug)
    {
        $this->aarsforbrug = $aarsforbrug;

        return $this;
    }

    /**
     * Get aarsforbrug
     *
     * @return integer 
     */
    public function getAarsforbrug()
    {
        return $this->aarsforbrug;
    }

    /**
     * Set nyPumpe
     *
     * @param string $nyPumpe
     * @return Pumpe
     */
    public function setNyPumpe($nyPumpe)
    {
        $this->nyPumpe = $nyPumpe;

        return $this;
    }

    /**
     * Get nyPumpe
     *
     * @return string 
     */
    public function getNyPumpe()
    {
        return $this->nyPumpe;
    }

    /**
     * Set nyByggemaal
     *
     * @param integer $nyByggemaal
     * @return Pumpe
     */
    public function setNyByggemaal($nyByggemaal)
    {
        $this->nyByggemaal = $nyByggemaal;

        return $this;
    }

    /**
     * Get nyByggemaal
     *
     * @return integer 
     */
    public function getNyByggemaal()
    {
        return $this->nyByggemaal;
    }

    /**
     * Set nyTilslutning
     *
     * @param string $nyTilslutning
     * @return Pumpe
     */
    public function setNyTilslutning($nyTilslutning)
    {
        $this->nyTilslutning = $nyTilslutning;

        return $this;
    }

    /**
     * Get nyTilslutning
     *
     * @return string 
     */
    public function getNyTilslutning()
    {
        return $this->nyTilslutning;
    }

    /**
     * Set vvsnr
     *
     * @param string $vvsNr
     * @return Pumpe
     */
    public function setVvsNr($vvsNr)
    {
        $this->vvsnr = $vvsNr;

        return $this;
    }

    /**
     * Get vvsnr
     *
     * @return string 
     */
    public function getVvsNr()
    {
        return $this->vvsnr;
    }

    /**
     * Set nytAarsforbrug
     *
     * @param integer $nytAarsforbrug
     * @return Pumpe
     */
    public function setNytAarsforbrug($nytAarsforbrug)
    {
        $this->nytAarsforbrug = $nytAarsforbrug;

        return $this;
    }

    /**
     * Get nytAarsforbrug
     *
     * @return integer 
     */
    public function getNytAarsforbrug()
    {
        return $this->nytAarsforbrug;
    }

    /**
     * Set elbesparelse
     *
     * @param integer $elbesparelse
     * @return Pumpe
     */
    public function setElbesparelse($elbesparelse)
    {
        $this->elbesparelse = $elbesparelse;

        return $this;
    }

    /**
     * Get elbesparelse
     *
     * @return integer 
     */
    public function getElbesparelse()
    {
        return $this->elbesparelse;
    }

    /**
     * Set udligningssaet
     *
     * @param string $udligningssaet
     * @return Pumpe
     */
    public function setUdligningssaet($udligningssaet)
    {
        $this->udligningssaet = $udligningssaet;

        return $this;
    }

    /**
     * Get udligningssaet
     *
     * @return string 
     */
    public function getUdligningssaet()
    {
        return $this->udligningssaet;
    }

    /**
     * Set kommentarer
     *
     * @param string $kommentarer
     * @return Pumpe
     */
    public function setKommentarer($kommentarer)
    {
        $this->kommentarer = $kommentarer;

        return $this;
    }

    /**
     * Get kommentarer
     *
     * @return string 
     */
    public function getKommentarer()
    {
        return $this->kommentarer;
    }

    /**
     * Set standInvestering
     *
     * @param integer $standInvestering
     * @return Pumpe
     */
    public function setStandInvestering($standInvestering)
    {
        $this->standInvestering = $standInvestering;

        return $this;
    }

    /**
     * Get standInvestering
     *
     * @return integer 
     */
    public function getStandInvestering()
    {
        return $this->standInvestering;
    }

    /**
     * Set fabrikant
     *
     * @param string $fabrikant
     * @return Pumpe
     */
    public function setFabrikant($fabrikant)
    {
        $this->fabrikant = $fabrikant;

        return $this;
    }

    /**
     * Get fabrikant
     *
     * @return string 
     */
    public function getFabrikant()
    {
        return $this->fabrikant;
    }

    /**
     * Set roerlaengde
     *
     * @param integer $roerlaengde
     * @return Pumpe
     */
    public function setRoerlaengde($roerlaengde)
    {
        $this->roerlaengde = $roerlaengde;

        return $this;
    }

    /**
     * Get roerlaengde
     *
     * @return integer 
     */
    public function getRoerlaengde()
    {
        return $this->roerlaengde;
    }

    /**
     * Set roerstoerrelse
     *
     * @param string $roerstoerrelse
     * @return Pumpe
     */
    public function setRoerstoerrelse($roerstoerrelse)
    {
        $this->roerstoerrelse = $roerstoerrelse;

        return $this;
    }

    /**
     * Get roerstoerrelse
     *
     * @return string 
     */
    public function getRoerstoerrelse()
    {
        return $this->roerstoerrelse;
    }
}
