<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tiltag
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TiltagRepository")
 */
class Tiltag
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
     * @ORM\Column(name="Title", type="string", length=255)
     */
    private $title;

    /**
     * @var float
     *
     * @ORM\Column(name="Vandbesparelse", type="float")
     */
    private $vandbesparelse;

    /**
     * @var integer
     *
     * @ORM\Column(name="Faktor", type="integer")
     */
    private $faktor;

    /**
     * @var string
     *
     * @ORM\Column(name="PrimaerEnterprise", type="string", length=50)
     */
    private $primaerEnterprise;

    /**
     * @var string
     *
     * @ORM\Column(name="Tilbudskategori", type="string", length=50)
     */
    private $tilbudskategori;

    /**
     * @var string
     *
     * @ORM\Column(name="AnlaegsInvestering", type="decimal")
     */
    private $anlaegsInvestering;

    /**
     * @var string
     *
     * @ORM\Column(name="DVBesparelse", type="decimal")
     */
    private $dVBesparelse;

    /**
     * @var string
     *
     * @ORM\Column(name="Levetid", type="decimal")
     */
    private $levetid;

    /**
     * @var string
     *
     * @ORM\Column(name="ForsyningVarme", type="string", length=50)
     */
    private $forsyningVarme;

    /**
     * @var string
     *
     * @ORM\Column(name="El", type="string", length=50)
     */
    private $el;

    /**
     * @var string
     *
     * @ORM\Column(name="BeskrivelseNevaerende", type="text")
     */
    private $beskrivelseNevaerende;

    /**
     * @var string
     *
     * @ORM\Column(name="BeskrivelseForslag", type="text")
     */
    private $beskrivelseForslag;

    /**
     * @var string
     *
     * @ORM\Column(name="BeskrivelseOevrige", type="text")
     */
    private $beskrivelseOevrige;

    /**
     * @var string
     *
     * @ORM\Column(name="Risikovurdering", type="string", length=10)
     */
    private $risikovurdering;

    /**
     * @var string
     *
     * @ORM\Column(name="Placering", type="string", length=255)
     */
    private $placering;

    /**
     * @var string
     *
     * @ORM\Column(name="BeskrivelseBV", type="text")
     */
    private $beskrivelseBV;

    /**
     * @var string
     *
     * @ORM\Column(name="Indeklima", type="text")
     */
    private $indeklima;


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
     * @return Tiltag
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
     * Set vandbesparelse
     *
     * @param float $vandbesparelse
     * @return Tiltag
     */
    public function setVandbesparelse($vandbesparelse)
    {
        $this->vandbesparelse = $vandbesparelse;

        return $this;
    }

    /**
     * Get vandbesparelse
     *
     * @return float 
     */
    public function getVandbesparelse()
    {
        return $this->vandbesparelse;
    }

    /**
     * Set faktor
     *
     * @param integer $faktor
     * @return Tiltag
     */
    public function setFaktor($faktor)
    {
        $this->faktor = $faktor;

        return $this;
    }

    /**
     * Get faktor
     *
     * @return integer 
     */
    public function getFaktor()
    {
        return $this->faktor;
    }

    /**
     * Set primaerEnterprise
     *
     * @param string $primaerEnterprise
     * @return Tiltag
     */
    public function setPrimaerEnterprise($primaerEnterprise)
    {
        $this->primaerEnterprise = $primaerEnterprise;

        return $this;
    }

    /**
     * Get primaerEnterprise
     *
     * @return string 
     */
    public function getPrimaerEnterprise()
    {
        return $this->primaerEnterprise;
    }

    /**
     * Set tilbudskategori
     *
     * @param string $tilbudskategori
     * @return Tiltag
     */
    public function setTilbudskategori($tilbudskategori)
    {
        $this->tilbudskategori = $tilbudskategori;

        return $this;
    }

    /**
     * Get tilbudskategori
     *
     * @return string 
     */
    public function getTilbudskategori()
    {
        return $this->tilbudskategori;
    }

    /**
     * Set anlaegsInvestering
     *
     * @param string $anlaegsInvestering
     * @return Tiltag
     */
    public function setAnlaegsInvestering($anlaegsInvestering)
    {
        $this->anlaegsInvestering = $anlaegsInvestering;

        return $this;
    }

    /**
     * Get anlaegsInvestering
     *
     * @return string 
     */
    public function getAnlaegsInvestering()
    {
        return $this->anlaegsInvestering;
    }

    /**
     * Set dVBesparelse
     *
     * @param string $dVBesparelse
     * @return Tiltag
     */
    public function setDVBesparelse($dVBesparelse)
    {
        $this->dVBesparelse = $dVBesparelse;

        return $this;
    }

    /**
     * Get dVBesparelse
     *
     * @return string 
     */
    public function getDVBesparelse()
    {
        return $this->dVBesparelse;
    }

    /**
     * Set levetid
     *
     * @param string $levetid
     * @return Tiltag
     */
    public function setLevetid($levetid)
    {
        $this->levetid = $levetid;

        return $this;
    }

    /**
     * Get levetid
     *
     * @return string 
     */
    public function getLevetid()
    {
        return $this->levetid;
    }

    /**
     * Set forsyningVarme
     *
     * @param string $forsyningVarme
     * @return Tiltag
     */
    public function setForsyningVarme($forsyningVarme)
    {
        $this->forsyningVarme = $forsyningVarme;

        return $this;
    }

    /**
     * Get forsyningVarme
     *
     * @return string 
     */
    public function getForsyningVarme()
    {
        return $this->forsyningVarme;
    }

    /**
     * Set el
     *
     * @param string $el
     * @return Tiltag
     */
    public function setEl($el)
    {
        $this->el = $el;

        return $this;
    }

    /**
     * Get el
     *
     * @return string 
     */
    public function getEl()
    {
        return $this->el;
    }

    /**
     * Set beskrivelseNevaerende
     *
     * @param string $beskrivelseNevaerende
     * @return Tiltag
     */
    public function setBeskrivelseNevaerende($beskrivelseNevaerende)
    {
        $this->beskrivelseNevaerende = $beskrivelseNevaerende;

        return $this;
    }

    /**
     * Get beskrivelseNevaerende
     *
     * @return string 
     */
    public function getBeskrivelseNevaerende()
    {
        return $this->beskrivelseNevaerende;
    }

    /**
     * Set beskrivelseForslag
     *
     * @param string $beskrivelseForslag
     * @return Tiltag
     */
    public function setBeskrivelseForslag($beskrivelseForslag)
    {
        $this->beskrivelseForslag = $beskrivelseForslag;

        return $this;
    }

    /**
     * Get beskrivelseForslag
     *
     * @return string 
     */
    public function getBeskrivelseForslag()
    {
        return $this->beskrivelseForslag;
    }

    /**
     * Set beskrivelseOevrige
     *
     * @param string $beskrivelseOevrige
     * @return Tiltag
     */
    public function setBeskrivelseOevrige($beskrivelseOevrige)
    {
        $this->beskrivelseOevrige = $beskrivelseOevrige;

        return $this;
    }

    /**
     * Get beskrivelseOevrige
     *
     * @return string 
     */
    public function getBeskrivelseOevrige()
    {
        return $this->beskrivelseOevrige;
    }

    /**
     * Set risikovurdering
     *
     * @param string $risikovurdering
     * @return Tiltag
     */
    public function setRisikovurdering($risikovurdering)
    {
        $this->risikovurdering = $risikovurdering;

        return $this;
    }

    /**
     * Get risikovurdering
     *
     * @return string 
     */
    public function getRisikovurdering()
    {
        return $this->risikovurdering;
    }

    /**
     * Set placering
     *
     * @param string $placering
     * @return Tiltag
     */
    public function setPlacering($placering)
    {
        $this->placering = $placering;

        return $this;
    }

    /**
     * Get placering
     *
     * @return string 
     */
    public function getPlacering()
    {
        return $this->placering;
    }

    /**
     * Set beskrivelseBV
     *
     * @param string $beskrivelseBV
     * @return Tiltag
     */
    public function setBeskrivelseBV($beskrivelseBV)
    {
        $this->beskrivelseBV = $beskrivelseBV;

        return $this;
    }

    /**
     * Get beskrivelseBV
     *
     * @return string 
     */
    public function getBeskrivelseBV()
    {
        return $this->beskrivelseBV;
    }

    /**
     * Set indeklima
     *
     * @param string $indeklima
     * @return Tiltag
     */
    public function setIndeklima($indeklima)
    {
        $this->indeklima = $indeklima;

        return $this;
    }

    /**
     * Get indeklima
     *
     * @return string 
     */
    public function getIndeklima()
    {
        return $this->indeklima;
    }
}
