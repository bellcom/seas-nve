<?php

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\BelysningTiltagDetail\Lyskilde as BelysningTiltagDetailLyskilde;
use AppBundle\DBAL\Types\BelysningTiltagDetail\PlaceringType;
use AppBundle\DBAL\Types\BelysningTiltagDetail\StyringType;
use AppBundle\Entity\BelysningTiltagDetail\NyStyring;
use AppBundle\DBAL\Types\BelysningTiltagDetail\TiltagType;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * BelysningTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class BelysningTiltagDetail extends TiltagDetail
{
    /**
     * @var string
     *
     * @ORM\Column(name="lokale_navn", type="string", length=255)
     */
    protected $lokale_navn;

    /**
     * @var string
     *
     * @ORM\Column(name="lokale_type", type="string", length=255, nullable=true)
     */
    protected $lokale_type;

    /**
     * @var float
     *
     * @ORM\Column(name="armaturhoejdeM", type="decimal", scale=4, nullable=true)
     */
    protected $armaturhoejdeM;

    /**
     * @var float
     *
     * @ORM\Column(name="rumstoerrelseM2", type="decimal", scale=4, nullable=true)
     */
    protected $rumstoerrelseM2;

    /**
     * @var integer
     *
     * @ORM\Column(name="lokale_antal", type="integer", nullable=true)
     */
    protected $lokale_antal;

    /**
     * @var string
     *
     * @ORM\Column(name="drifttidTAar", type="integer")
     */
    protected $drifttidTAar;

    /**
     * @var BelysningTiltagDetailLyskilde
     *
     * Belysningstype
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BelysningTiltagDetail\Lyskilde")
     * ORM\JoinColumn(name="lyskilde_id", referencedColumnName="id")
     **/
    protected $lyskilde;

    /**
     * @var integer
     *
     * @ORM\Column(name="lyskildeStkArmatur", type="integer", nullable=true )
     */
    protected $lyskildeStkArmatur;

    /**
     * @var integer
     *
     * @ORM\Column(name="lyskildeStk", type="integer")
     */
    protected $lyskildeStk;

    /**
     * @var integer
     *
     * @ORM\Column(name="lyskildeWLyskilde", type="integer")
     */
    protected $lyskildeWLyskilde;

    /**
     * @var float
     *
     * @ORM\Column(name="benyttelsesFaktor", type="float")
     */
    protected $benyttelsesFaktor;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="installeretEffektW", type="float")
     */
    protected $installeretEffektW;

    /**
     * @var integer
     *
     * @ORM\Column(name="forkoblingStkArmatur", type="integer")
     */
    protected $forkoblingStkArmatur;

    /**
     * @var integer
     *
     * @ORM\Column(name="armaturerStkLokale", type="integer", nullable=true)
     */
    protected $armaturerStkLokale;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="elforbrugWM2", type="float")
     */
    protected $elforbrugWM2;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="elforbrugkWtAar", type="float")
     */
    protected $elforbrugkWtAar;

    /**
     * @var string
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\BelysningTiltagDetail\PlaceringType")
     * @ORM\Column(name="placering", type="PlaceringType")
     **/
    protected $placering;

    /**
     * @var string
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\BelysningTiltagDetail\StyringType")
     * @ORM\Column(name="styring", type="StyringType", nullable=true)
     **/
    protected $styring;

    /**
     * @var string
     *
     * This is: noterForEksisterendeBelysning
     *
     * @ORM\Column(name="noter", type="text", nullable=true)
     */
    protected $noter;

    /**
     * @var string
     *
     * @ORM\Column(name="noterForNyBelysning", type="text", nullable=true)
     */
    protected $noterForNyBelysning;

    /**
     * @var string
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\BelysningTiltagDetail\TiltagType")
     * @ORM\Column(name="belysningstiltag", type="TiltagType", nullable=true)
     */
    protected $belysningstiltag;

    /**
     * @var integer
     *
     * @ORM\Column(name="nyeSensorerStkLokale", type="integer", nullable=true)
     */
    protected $nyeSensorerStkLokale;

    /**
     * @var float
     *
     * @ORM\Column(name="standardinvestSensorKrStk", type="decimal", scale=4, nullable=true)
     */
    protected $standardinvestSensorKrStk;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="nyDriftstid", type="float")
     */
    protected $nyDriftstid;

    /**
     * @var float
     *
     * @ORM\Column(name="standardinvestArmaturKrStk", type="decimal", scale=4, nullable=true)
     */
    protected $standardinvestArmaturKrStk;

    /**
     * @var float
     *
     * @ORM\Column(name="standardinvestLyskildeKrStk", type="decimal", scale=4, nullable=true)
     */
    protected $standardinvestLyskildeKrStk;

    /**
     * @var BelysningTiltagDetailErstatningsLyskilde
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BelysningTiltagDetail\ErstatningsLyskilde")
     * ORM\JoinColumn(name="ny_erstatningslyskilde_id", referencedColumnName="id")
     */
    protected $erstatningsLyskilde;

    /**
     * @var BelysningTiltagDetailLyskilde
     *
     * Belysningstype
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BelysningTiltagDetail\Lyskilde")
     * ORM\JoinColumn(name="ny_lyskilde_id", referencedColumnName="id")
     */
    protected $nyLyskilde;

    /**
     * @var integer
     *
     * @ORM\Column(name="nyLyskildeStk", type="integer", nullable=true)
     */
    protected $nyLyskildeStk;

    /**
     * @var integer
     *
     * @ORM\Column(name="nyLyskildeStkArmatur", type="integer", nullable=true)
     */
    protected $nyLyskildeStkArmatur;

    /**
     * @var integer
     *
     * @ORM\Column(name="nyLyskildeWLyskilde", type="integer", nullable=true)
     */
    protected $nyLyskildeWLyskilde;

    /**
     * @var float
     *
     * @ORM\Column(name="nyBenyttelsesFaktor", type="float")
     */
    protected $nyBenyttelsesFaktor;

    /**
     * @var integer
     *
     * @ORM\Column(name="nyForkoblingStkArmatur", type="integer", nullable=true)
     */
    protected $nyForkoblingStkArmatur;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="nyArmatureffektWStk", type="float")
     */
    protected $nyArmatureffektWStk;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="nyInstalleretEffektW", type="float")
     */
    protected $nyInstalleretEffektW;

    /**
     * @var integer
     *
     * @ORM\Column(name="nyeArmaturerStkLokale", type="integer", nullable=true)
     */
    protected $nyeArmaturerStkLokale;

    /**
     * @var NyStyring
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BelysningTiltagDetail\NyStyring")
     * ORM\JoinColumn(name="nyStyring_id", referencedColumnName="id", nullable=true)
     **/
    protected $nyStyring;

    /**
     * @var \AppBundle\Entity\BelysningTiltagDetail\NytArmatur
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BelysningTiltagDetail\NytArmatur", fetch="EAGER")
     * ORM\JoinColumn(name="nytArmatur_id", referencedColumnName="id", nullable=true)
     **/
    protected $nytArmatur;

    /**
     * @var float
     *
     * @ORM\Column(name="nyttiggjortVarmeAfElBesparelse", type="decimal", scale=4, nullable=true)
     */
    protected $nyttiggjortVarmeAfElBesparelse;

    /**
     * @var float
     *
     * @ORM\Column(name="prisfaktor", type="decimal", scale=4, nullable=true)
     */
    protected $prisfaktor;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="prisfaktorTillaegKrLokale", type="float")
     */
    protected $prisfaktorTillaegKrLokale;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="investeringAlleLokalerKr", type="float")
     */
    protected $investeringAlleLokalerKr;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="nytElforbrugWM2", type="float")
     */
    protected $nytElforbrugWM2;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="nytElforbrugkWtAar", type="float")
     */
    protected $nytElforbrugkWtAar;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="driftsbesparelseTilLyskilderKrAar", type="float")
     */
    protected $driftsbesparelseTilLyskilderKrAar;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="simpelTilbagebetalingstidAar", type="float")
     */
    protected $simpelTilbagebetalingstidAar;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="vaegtetLevetidAar", type="float")
     */
    protected $vaegtetLevetidAar;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="nutidsvaerdiSetOver15AarKr", type="float")
     */
    protected $nutidsvaerdiSetOver15AarKr;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="kWhBesparelseEl", type="float")
     */
    protected $kWhBesparelseEl;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="kWhBesparelseVarmeFraVarmevaerket", type="float")
     */
    protected $kWhBesparelseVarmeFraVarmevaerket;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="elbespKrAar", type="float")
     *
     * See calculation file, cell [].
     */
    protected $elbespKrAar;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return string
     */
    public function getNoterForNyBelysning()
    {
        return $this->noterForNyBelysning;
    }

    /**
     * @param string $noterForNyBelysning
     */
    public function setNoterForNyBelysning($noterForNyBelysning)
    {
        $this->noterForNyBelysning = $noterForNyBelysning;
    }

    /**
     * Set lokale_navn
     *
     * @param string $lokaleNavn
     * @return BelysningTiltagDetail
     */
    public function setLokaleNavn($lokaleNavn)
    {
        $this->lokale_navn = $lokaleNavn;

        return $this;
    }

    /**
     * Get lokale_navn
     *
     * @return string
     */
    public function getLokaleNavn()
    {
        return $this->lokale_navn;
    }

    /**
     * Set lokale_type
     *
     * @param string $lokaleType
     * @return BelysningTiltagDetail
     */
    public function setLokaleType($lokaleType)
    {
        $this->lokale_type = $lokaleType;

        return $this;
    }

    /**
     * Get lokale_type
     *
     * @return string
     */
    public function getLokaleType()
    {
        return $this->lokale_type;
    }

    /**
     * Set armaturhoejdeM.
     *
     * @param float $armaturhoejdeM
     * @return BelysningTiltagDetail
     */
    public function setArmaturhoejdeM($armaturhoejdeM)
    {
        $this->armaturhoejdeM = $armaturhoejdeM;

        return $this;
    }

    /**
     * Get armaturhoejdeM
     *
     * @return float
     */
    public function getArmaturhoejdeM()
    {
        return $this->armaturhoejdeM;
    }

    /**
     * Set rumstoerrelseM2
     *
     * @param float $rumstoerrelseM2
     * @return BelysningTiltagDetail
     */
    public function setRumstoerrelseM2($rumstoerrelseM2)
    {
        $this->rumstoerrelseM2 = $rumstoerrelseM2;

        return $this;
    }

    /**
     * Get rumstoerrelseM2
     *
     * @return float
     */
    public function getRumstoerrelseM2()
    {
        return $this->rumstoerrelseM2;
    }

    /**
     * Set lokale_antal
     *
     * @param integer $lokaleAntal
     * @return BelysningTiltagDetail
     */
    public function setLokaleAntal($lokaleAntal)
    {
        $this->lokale_antal = $lokaleAntal;

        return $this;
    }

    /**
     * Get lokale_antal
     *
     * @return integer
     */
    public function getLokaleAntal()
    {
        return $this->lokale_antal;
    }

    /**
     * Set drifttidTAar
     *
     * @param string $drifttidTAar
     * @return BelysningTiltagDetail
     */
    public function setDrifttidTAar($drifttidTAar)
    {
        $this->drifttidTAar = $drifttidTAar;

        return $this;
    }

    /**
     * Get drifttidTAar
     *
     * @return float
     */
    public function getDrifttidTAar()
    {
        return $this->drifttidTAar;
    }

    /**
     * Set lyskilde
     *
     * @param BelysningTiltagDetailLyskilde $lyskilde
     * @return BelysningTiltagDetail
     */
    public function setLyskilde(BelysningTiltagDetailLyskilde $lyskilde = null)
    {
        $this->lyskilde = $lyskilde;

        return $this;
    }

    /**
     * Get lyskilde.
     *
     * @return BelysningTiltagDetailLyskilde
     */
    public function getLyskilde()
    {
        return $this->lyskilde;
    }

    /**
     * Set lyskildeStkArmatur
     *
     * @param integer $lyskildeStkArmatur
     * @return BelysningTiltagDetail
     */
    public function setLyskildeStkArmatur($lyskildeStkArmatur)
    {
        $this->lyskildeStkArmatur = $lyskildeStkArmatur;

        return $this;
    }

    /**
     * Get lyskildeStkArmatur
     *
     * @return integer
     */
    public function getLyskildeStkArmatur()
    {
        return $this->lyskildeStkArmatur;
    }

    /**
     * Set lyskildeStk
     *
     * @param integer $lyskildeStk
     * @return BelysningTiltagDetail
     */
    public function setLyskildeStk($lyskildeStk)
    {
        $this->lyskildeStk = $lyskildeStk;

        return $this;
    }

    /**
     * Get lyskildeStk
     *
     * @return integer
     */
    public function getLyskildeStk()
    {
        return $this->lyskildeStk;
    }

    /**
     * Set lyskildeWLyskilde
     *
     * @param integer $lyskildeWLyskilde
     * @return BelysningTiltagDetail
     */
    public function setLyskildeWLyskilde($lyskildeWLyskilde)
    {
        $this->lyskildeWLyskilde = $lyskildeWLyskilde;

        return $this;
    }

    /**
     * Get lyskildeWLyskilde
     *
     * @return integer
     */
    public function getLyskildeWLyskilde()
    {
        return $this->lyskildeWLyskilde;
    }

    /**
     * Set forkoblingStkArmatur
     *
     * @param integer $forkoblingStkArmatur
     * @return BelysningTiltagDetail
     */
    public function setForkoblingStkArmatur($forkoblingStkArmatur)
    {
        $this->forkoblingStkArmatur = $forkoblingStkArmatur;

        return $this;
    }

    /**
     * Get forkoblingStkArmatur
     *
     * @return integer
     */
    public function getForkoblingStkArmatur()
    {
        return $this->forkoblingStkArmatur;
    }

    /**
     * Set benyttelsesFaktor
     *
     * @param integer $benyttelsesFaktor
     * @return BelysningTiltagDetail
     */
    public function setBenyttelsesFaktor($benyttelsesFaktor)
    {
        $this->benyttelsesFaktor = $benyttelsesFaktor;

        return $this;
    }

    /**
     * Get benyttelsesFaktor
     *
     * @return integer
     */
    public function getBenyttelsesFaktor()
    {
        return $this->benyttelsesFaktor;
    }

    /**
     * Set installeretEffektW
     *
     * @param integer $installeretEffektW
     * @return BelysningTiltagDetail
     */
    public function setInstalleretEffektW($installeretEffektW)
    {
        $this->installeretEffektW = $installeretEffektW;

        return $this;
    }

    /**
     * Get installeretEffektW
     *
     * @return integer
     */
    public function getInstalleretEffektW()
    {
        return $this->installeretEffektW;
    }

    /**
     * Set armaturerStkLokale
     *
     * @param integer $armaturerStkLokale
     * @return BelysningTiltagDetail
     */
    public function setArmaturerStkLokale($armaturerStkLokale)
    {
        $this->armaturerStkLokale = $armaturerStkLokale;

        return $this;
    }

    /**
     * Get armaturerStkLokale
     *
     * @return integer
     */
    public function getArmaturerStkLokale()
    {
        return $this->armaturerStkLokale;
    }

    /**
     * Get elforbrugWM2
     *
     * @return float
     */
    public function getElforbrugWM2()
    {
        return $this->elforbrugWM2;
    }

    /**
     * Set elforbrugkWtAar
     *
     * @param string $elforbrugkWtAar
     * @return BelysningTiltagDetail
     */
    public function setElforbrugkWtAar($elforbrugkWtAar)
    {
        $this->elforbrugkWtAar = $elforbrugkWtAar;
        return $this;
    }
    /**
     * Get elforbrugkWtAar
     *
     * @return float
     */
    public function getElforbrugkWtAar()
    {
        return $this->elforbrugkWtAar;
    }

    /**
     * Set placering
     *
     * @param string $placering
     * @return BelysningTiltagDetail
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
     * Set styring
     *
     * @param string $styring
     * @return BelysningTiltagDetail
     */
    public function setStyring($styring)
    {
        $this->styring = $styring;

        return $this;
    }

    /**
     * Get styring
     *
     * @return string
     */
    public function getStyring()
    {
        return $this->styring;
    }


    /**
     * Set noter
     *
     * @param string $noter
     * @return BelysningTiltagDetail
     */
    public function setNoter($noter)
    {
        $this->noter = $noter;

        return $this;
    }

    /**
     * Get noter
     *
     * @return string
     */
    public function getNoter()
    {
        return $this->noter;
    }

    /**
     * Set tiltag
     *
     * @param string $belysningstiltag
     * @return BelysningTiltagDetail
     */
    public function setBelysningstiltag($belysningstiltag)
    {
        $this->belysningstiltag = $belysningstiltag;

        return $this;
    }

    /**
     * Get belysningtiltag
     *
     * @return string
     */
    public function getBelysningstiltag()
    {
        return $this->belysningstiltag;
    }

    /**
     * Set nyeSensorerStkLokale
     *
     * @param integer $nyeSensorerStkLokale
     * @return BelysningTiltagDetail
     */
    public function setNyeSensorerStkLokale($nyeSensorerStkLokale)
    {
        $this->nyeSensorerStkLokale = $nyeSensorerStkLokale;

        return $this;
    }

    /**
     * Get nyeSensorerStkLokale
     *
     * @return integer
     */
    public function getNyeSensorerStkLokale()
    {
        return $this->nyeSensorerStkLokale;
    }

    /**
     * Set standardinvestSensorKrStk
     *
     * @param string $standardinvestSensorKrStk
     * @return BelysningTiltagDetail
     */
    public function setStandardinvestSensorKrStk($standardinvestSensorKrStk)
    {
        $this->standardinvestSensorKrStk = $standardinvestSensorKrStk;

        return $this;
    }

    /**
     * Get standardinvestSensorKrStk
     *
     * @return float
     */
    public function getStandardinvestSensorKrStk()
    {
        return $this->standardinvestSensorKrStk;
    }

    /**
     * Set nyDriftstid
     *
     * @param string $nyDriftstid
     * @return BelysningTiltagDetail
     */
    public function setNyDriftstid($nyDriftstid)
    {
        $this->nyDriftstid = $nyDriftstid;

        return $this;
    }

    /**
     * Get nyDriftstid
     *
     * @return float
     */
    public function getNyDriftstid()
    {
        return $this->nyDriftstid;
    }

    /**
     * Set standardinvestArmaturKrStk
     *
     * @param string $standardinvestArmaturKrStk
     * @return BelysningTiltagDetail
     */
    public function setStandardinvestArmaturKrStk($standardinvestArmaturKrStk)
    {
        $this->standardinvestArmaturKrStk = $standardinvestArmaturKrStk;

        return $this;
    }

    /**
     * Get standardinvestArmaturKrStk
     *
     * @return float
     */
    public function getStandardinvestArmaturKrStk()
    {
        return $this->standardinvestArmaturKrStk;
    }

    /**
     * Set standardinvestLyskildeKrStk
     *
     * @param string $standardinvestLyskildeKrStk
     * @return BelysningTiltagDetail
     */
    public function setStandardinvestLyskildeKrStk($standardinvestLyskildeKrStk)
    {
        $this->standardinvestLyskildeKrStk = $standardinvestLyskildeKrStk;

        return $this;
    }

    /**
     * Get standardinvestLyskildeKrStk
     *
     * @return float
     */
    public function getStandardinvestLyskildeKrStk()
    {
        return $this->standardinvestLyskildeKrStk;
    }

    /**
     * Set nyLyskilde
     *
     * @param BelysningTiltagDetailLyskilde $nyLyskilde
     * @return BelysningTiltagDetail
     */
    public function setNyLyskilde($nyLyskilde = null)
    {
        $this->nyLyskilde = $nyLyskilde;

        return $this;
    }

    /**
     * Get nyLyskilde.
     *
     * @return BelysningTiltagDetailLyskilde
     * @see getLyskilde()
     *
     */
    public function getNyLyskilde()
    {
        return $this->nyLyskilde;
    }

    /**
     * Set nyLyskildeStkArmatur
     *
     * @param integer $nyLyskildeStkArmatur
     * @return BelysningTiltagDetail
     */
    public function setNyLyskildeStkArmatur($nyLyskildeStkArmatur)
    {
        $this->nyLyskildeStkArmatur = $nyLyskildeStkArmatur;

        return $this;
    }

    /**
     * Get nyLyskildeStkArmatur
     *
     * @return integer
     */
    public function getNyLyskildeStkArmatur()
    {
        return $this->nyLyskildeStkArmatur;
    }

    /**
     * Set nyLyskildeStk
     *
     * @param integer $nyLyskildeStk
     * @return BelysningTiltagDetail
     */
    public function setNyLyskildeStk($nyLyskildeStk)
    {
        $this->nyLyskildeStk = $nyLyskildeStk;

        return $this;
    }

    /**
     * Get nyLyskildeStk
     *
     * @return integer
     */
    public function getNyLyskildeStk()
    {
        return $this->nyLyskildeStk;
    }

    /**
     * Set nyLyskildeWLyskilde
     *
     * @param integer $nyLyskildeWLyskilde
     * @return BelysningTiltagDetail
     */
    public function setNyLyskildeWLyskilde($nyLyskildeWLyskilde)
    {
        $this->nyLyskildeWLyskilde = $nyLyskildeWLyskilde;

        return $this;
    }

    /**
     * Get nyLyskildeWLyskilde
     *
     * @return integer
     */
    public function getNyLyskildeWLyskilde()
    {
        return $this->nyLyskildeWLyskilde;
    }

    /**
     * Set nyForkoblingStkArmatur
     *
     * @param integer $nyForkoblingStkArmatur
     * @return BelysningTiltagDetail
     */
    public function setNyForkoblingStkArmatur($nyForkoblingStkArmatur)
    {
        $this->nyForkoblingStkArmatur = $nyForkoblingStkArmatur;

        return $this;
    }

    /**
     * Get nyForkoblingStkArmatur
     *
     * @return integer
     */
    public function getNyForkoblingStkArmatur()
    {
        return $this->nyForkoblingStkArmatur;
    }

    /**
     * Set nyBenyttelsesFaktor
     *
     * @param integer $nyBenyttelsesFaktor
     * @return BelysningTiltagDetail
     */
    public function setNyBenyttelsesFaktor($nyBenyttelsesFaktor)
    {
        $this->nyBenyttelsesFaktor = $nyBenyttelsesFaktor;

        return $this;
    }

    /**
     * Get nyBenyttelsesFaktor
     *
     * @return integer
     */
    public function getNyBenyttelsesFaktor()
    {
        return $this->nyBenyttelsesFaktor;
    }

    /**
     * Set nyInstalleretEffektW
     *
     * @param integer $nyInstalleretEffektW
     * @return BelysningTiltagDetail
     */
    public function setNyInstalleretEffektW($nyInstalleretEffektW)
    {
        $this->nyInstalleretEffektW = $nyInstalleretEffektW;

        return $this;
    }

    /**
     * Get nyNyInstalleretEffektW
     *
     * @return integer
     */
    public function getNyInstalleretEffektW()
    {
        return $this->nyInstalleretEffektW;
    }

    /**
     * Get nyArmatureffektWStk
     *
     * @return float
     */
    public function getNyArmatureffektWStk()
    {
        return $this->nyArmatureffektWStk;
    }

    /**
     * Set nyeArmaturerStkLokale
     *
     * @param integer $nyeArmaturerStkLokale
     * @return BelysningTiltagDetail
     */
    public function setNyeArmaturerStkLokale($nyeArmaturerStkLokale)
    {
        $this->nyeArmaturerStkLokale = $nyeArmaturerStkLokale;

        return $this;
    }

    /**
     * Get nyeArmaturerStkLokale
     *
     * @return integer
     */
    public function getNyeArmaturerStkLokale()
    {
        return $this->nyeArmaturerStkLokale;
    }

    /**
     * Set nyttiggjortVarmeAfElBesparelse
     *
     * @param string $nyttiggjortVarmeAfElBesparelse
     * @return BelysningTiltagDetail
     */
    public function setNyttiggjortVarmeAfElBesparelse($nyttiggjortVarmeAfElBesparelse)
    {
        $this->nyttiggjortVarmeAfElBesparelse = $nyttiggjortVarmeAfElBesparelse;

        return $this;
    }

    /**
     * Get nyttiggjortVarmeAfElBesparelse
     *
     * @return float
     */
    public function getNyttiggjortVarmeAfElBesparelse()
    {
        return $this->nyttiggjortVarmeAfElBesparelse;
    }

    /**
     * Set prisfaktor
     *
     * @param string $prisfaktor
     * @return BelysningTiltagDetail
     */
    public function setPrisfaktor($prisfaktor)
    {
        $this->prisfaktor = $prisfaktor;

        return $this;
    }

    /**
     * Get prisfaktor
     *
     * @return float
     */
    public function getPrisfaktor()
    {
        return $this->prisfaktor;
    }

    /**
     * Get prisfaktorTillaegKrLokale
     *
     * @return float
     */
    public function getPrisfaktorTillaegKrLokale()
    {
        return $this->prisfaktorTillaegKrLokale;
    }

    /**
     * Get investeringAlleLokalerKr
     *
     * @return float
     */
    public function getInvesteringAlleLokalerKr()
    {
        return $this->investeringAlleLokalerKr;
    }

    /**
     * Get nytElforbrugWM2
     *
     * @return float
     */
    public function getNytElforbrugWM2()
    {
        return $this->nytElforbrugWM2;
    }

    /**
     * Set nytElforbrugkWtAar
     *
     * @param string $nytElforbrugkWtAar
     * @return BelysningTiltagDetail
     */
    public function setNytElforbrugkWtAar($nytElforbrugkWtAar)
    {
        $this->nytElforbrugkWtAar = $nytElforbrugkWtAar;
        return $this;
    }

    /**
     * Get nytElforbrugkWtAar
     *
     * @return float
     */
    public function getNytElforbrugkWtAar()
    {
        return $this->nytElforbrugkWtAar;
    }

    /**
     * Get driftsbesparelseTilLyskilderKrAar
     *
     * @return float
     */
    public function getDriftsbesparelseTilLyskilderKrAar()
    {
        return $this->driftsbesparelseTilLyskilderKrAar;
    }

    /**
     * Get simpelTilbagebetalingstidAar
     *
     * @return float
     */
    public function getSimpelTilbagebetalingstidAar()
    {
        return $this->simpelTilbagebetalingstidAar;
    }

    /**
     * Get vaegtetLevetidAar
     *
     * @return float
     */
    public function getVaegtetLevetidAar()
    {
        return $this->vaegtetLevetidAar;
    }

    /**
     * Get nutidsvaerdiSetOver15AarKr
     *
     * @return float
     */
    public function getNutidsvaerdiSetOver15AarKr()
    {
        return $this->nutidsvaerdiSetOver15AarKr;
    }

    /**
     * Get kWhBesparelseEl
     *
     * @return float
     */
    public function getKwhBesparelseEl()
    {
        return $this->kWhBesparelseEl;
    }

    /**
     * Get kWhBesparelseVarmeFraVarmevaerket
     *
     * @return float
     */
    public function getKwhBesparelseVarmeFraVarmevaerket()
    {
        return $this->kWhBesparelseVarmeFraVarmevaerket;
    }

    /**
     * @return BelysningTiltagDetailNyStyring
     */
    public function getNyStyring()
    {
        return $this->nyStyring;
    }

    /**
     * @param BelysningTiltagDetailNyStyring $nyStyring
     */
    public function setNyStyring($nyStyring)
    {
        $this->nyStyring = $nyStyring;
    }

    /**
     * @return BelysningTiltagDetailNytArmatur
     */
    public function getNytArmatur()
    {
        return $this->nytArmatur;
    }

    /**
     * @param BelysningTiltagDetailNytArmatur $nytArmatur
     */
    public function setNytArmatur($nytArmatur)
    {
        $this->nytArmatur = $nytArmatur;
    }

    /**
     * @return BelysningTiltagDetailErstatningsLyskilde
     */
    public function getErstatningsLyskilde()
    {
        return $this->erstatningsLyskilde;
    }

    /**
     * @param BelysningTiltagDetailErstatningsLyskilde $erstatningsLyskilde
     */
    public function setErstatningsLyskilde($erstatningsLyskilde)
    {
        $this->erstatningsLyskilde = $erstatningsLyskilde;
    }

    /**
     * Set elbespKrAar
     *
     * @param integer $elbespKrAar
     *
     * @return BelysningTiltagDetail
     */
    public function setElbespKrAar($elbespKrAar)
    {
        $this->elbespKrAar = $elbespKrAar;

        return $this;
    }

    /**
     * Get elbespKrAar
     *
     * @return float
     */
    public function getElbespKrAar() {
        return $this->elbespKrAar;
    }

    protected $propertiesRequiredForCalculation = [
        'lokaleNavn',
        'drifttidTAar',
        'lyskildeStk',
        'lyskildeWLyskilde',
        'benyttelsesFaktor',
        'nyDriftstid',
        'nyLyskildeStk',
        'nyLyskildeWLyskilde',
        'nyBenyttelsesFaktor',
    ];

    public function getPropertiesRequiredForCalculation()
    {
        $properties = parent::getPropertiesRequiredForCalculation();

        if ($this->getNyStyring()) {
            $properties[] = 'nyeSensorerStkLokale';
            $properties[] = 'standardinvestSensorKrStk';
        }

        $tiltag = $this->getBelysningstiltag();
        switch ($tiltag) {
            case TiltagType::ARMATUR:
                break;

            case TiltagType::LED_I_EKSIST_ARM:
            case TiltagType::NY_INDSATS_I_ARM:
                $properties[] = 'erstatningsLyskilde';
                $properties[] = 'standardinvestLyskildeKrStk';
                break;
        }

        return $properties;
    }

    public function calculate()
    {
        $this->installeretEffektW = $this->calculateInstalleretEffektW();
        $this->nyInstalleretEffektW = $this->calculateNyInstalleretEffektW();
        $this->elforbrugkWtAar = $this->calculateElforbrugkWtAar();
        $this->nytElforbrugkWtAar = $this->calculateNytElforbrugkWtAar();
        $this->kWhBesparelseEl = $this->calculateKwhBesparelseEl();
        $this->elbespKrAar = $this->calculateElbespKrAar();

        $this->elforbrugWM2 = $this->calculateElforbrugWM2();
        $this->nyArmatureffektWStk = $this->calculateNyArmatureffektWStk();
        $this->prisfaktorTillaegKrLokale = $this->calculatePrisfaktorTillaegKrLokale();
        $this->investeringAlleLokalerKr = $this->calculateInvesteringAlleLokalerKr();
        $this->nytElforbrugWM2 = $this->calculateNytElforbrugWM2();
        $this->driftsbesparelseTilLyskilderKrAar = $this->calculateDriftsbesparelseTilLyskilderKrAar();
        $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
        $this->vaegtetLevetidAar = $this->calculateVaegtetLevetidAar();
        $this->nutidsvaerdiSetOver15AarKr = $this->calculateNutidsvaerdiSetOver15AarKr();
        parent::calculate();
    }

    private function calculateInstalleretEffektW()
    {
        return $this->getLyskildeStk() * $this->getLyskildeWLyskilde();
    }

    private function calculateNyInstalleretEffektW()
    {
        return $this->getNyLyskildeStk() * $this->getNyLyskildeWLyskilde();
    }

    private function calculateElforbrugkWtAar()
    {
        return $this->getInstalleretEffektW() * $this->getDrifttidTAar() * $this->getBenyttelsesFaktor() / 1000;
    }

    private function calculateNytElforbrugkWtAar()
    {
        return $this->getNyInstalleretEffektW() * $this->getNyDriftstid() * $this->getNyBenyttelsesFaktor() / 1000;
    }

    private function calculateElbespKrAar()
    {
        return $this->kWhBesparelseEl * $this->getRapport()->getElKrKWh();
    }

    private function calculateElforbrugWM2()
    {
        // AC
        $armaturEffekt = $this->_computeArmaturEffekt($this->getLyskilde(true));

        if ($this->rumstoerrelseM2 === null || $this->rumstoerrelseM2 == 0 || $armaturEffekt == 0 || $this->armaturerStkLokale == 0) {
            return 0;
        } else {
            return $armaturEffekt * $this->armaturerStkLokale / $this->rumstoerrelseM2;
        }
    }

    private function calculateNyArmatureffektWStk()
    {
        // AW
        return $this->__computeArmaturEffekt($this->getNyLyskilde(true), $this->nyLyskildeStkArmatur, $this->nyLyskildeWLyskilde, $this->nyForkoblingStkArmatur);
    }

    private function calculatePrisfaktorTillaegKrLokale()
    {
        // BA
        if ($this->prisfaktor == 0) {
            return 0;
        } else {
            return ($this->nyeSensorerStkLokale * $this->standardinvestSensorKrStk
                    + $this->standardinvestArmaturKrStk * $this->nyeArmaturerStkLokale
                    + $this->standardinvestLyskildeKrStk * $this->nyLyskildeStkArmatur)
                * ($this->prisfaktor - 1);
        }
    }

    private function calculateInvesteringAlleLokalerKr()
    {
        // BB
        $nyLyskilde = $this->getNyLyskilde(true);
        if (!$nyLyskilde || !$this->lokale_antal) {
            return 0;
        } elseif ($nyLyskilde->getType() == 'LED-arm.') {
            return ($this->nyeSensorerStkLokale * $this->standardinvestSensorKrStk
                    + $this->standardinvestArmaturKrStk * $this->nyeArmaturerStkLokale
                    + $this->prisfaktorTillaegKrLokale) * $this->lokale_antal;
        } else {
            return ($this->nyeSensorerStkLokale * $this->standardinvestSensorKrStk
                    + $this->standardinvestArmaturKrStk * $this->nyeArmaturerStkLokale
                    + $this->standardinvestLyskildeKrStk * $this->nyLyskildeStkArmatur * $this->nyeArmaturerStkLokale
                    + $this->prisfaktorTillaegKrLokale) * $this->lokale_antal;
        }
    }

    private function calculateNytElforbrugWM2()
    {
        // BD
        if ($this->rumstoerrelseM2 === null || $this->rumstoerrelseM2 == 0) {
            return 0;
        } else {
            if ($this->nyArmatureffektWStk == 0) {
                return $this->elforbrugWM2;
            } else {
                return $this->nyArmatureffektWStk * $this->nyeArmaturerStkLokale / $this->rumstoerrelseM2;
            }
        }
    }

    private function calculateDriftsbesparelseTilLyskilderKrAar()
    {

        // BK
        $lyskilde = $this->getLyskilde(true);
        $nyLyskilde = $this->getNyLyskilde(true);

        $nyLyskildeLevetid = 0;
        $nyLyskildeUdgift = 0;
        if ($nyLyskilde) {
            $nyLyskildeLevetid = $nyLyskilde->getLevetid();
            $nyLyskildeUdgift = $nyLyskilde->getUdgift();
        } elseif ($this->nyeSensorerStkLokale && $lyskilde) {
            $nyLyskildeLevetid = $lyskilde->getLevetid();
            $nyLyskildeUdgift = $lyskilde->getUdgift();
        }

        if (!$this->lokale_antal || !$lyskilde || $lyskilde->getLevetid() == 0 || $nyLyskildeLevetid == 0) {
            return 0;
        } else {
            return ($this->lyskildeStkArmatur * $this->armaturerStkLokale * $lyskilde->getUdgift() * $this->drifttidTAar / $lyskilde->getLevetid()
                    - $this->nyLyskildeStkArmatur * $this->nyeArmaturerStkLokale * $nyLyskildeUdgift * $this->nyDriftstid / $nyLyskildeLevetid)
                * $this->lokale_antal;
        }
    }

    private function calculateKwhBesparelseEl()
    {
        return $this->getElforbrugkWtAar() - $this->getNytElforbrugkWtAar();
        // @TODO Review/Remove old calculation.
        /* Old calculation.
                $computeElforbrugPrLokale = function () {
            // AB
            $armaturEffekt = $this->_computeArmaturEffekt($this->getLyskilde(true));
            if ($armaturEffekt == 0 || $this->armaturerStkLokale == 0) {
                return 0;
            } else {
                return $armaturEffekt * $this->drifttidTAar * $this->armaturerStkLokale / 1000;
            }
        };

        $computeNytElforbrugPrLokale = function () {
            // BC
            if ($this->nyDriftstid == 0) {
                return 0;
            } elseif ($this->nyArmatureffektWStk == 0) {
                $armaturEffekt = $this->_computeArmaturEffekt($this->getLyskilde(true));
                return $armaturEffekt * $this->nyDriftstid * $this->armaturerStkLokale / 1000;
            } else {
                return $this->nyArmatureffektWStk * $this->nyDriftstid * $this->nyeArmaturerStkLokale / 1000;
            }
        };

        $elforbrug = $computeElforbrugPrLokale();
        $nytElforbrug = $computeNytElforbrugPrLokale();

        if ($elforbrug == 0 || $nytElforbrug == 0 || $this->lokale_antal == 0 || $this->lokale_antal === null) {
            return 0;
        } else {
            return ($elforbrug - $nytElforbrug) * $this->lokale_antal;
        }
        */
    }

    private function calculateSimpelTilbagebetalingstidAar()
    {
        return $this->divide($this->investeringAlleLokalerKr,
            $this->getElbespKrAar() + $this->driftsbesparelseTilLyskilderKrAar);
    }

    private function calculateVaegtetLevetidAar()
    {
        // BM
        if ($this->investeringAlleLokalerKr == 0) {
            return 0;
        } elseif ($this->nyLyskilde == null) {
            return 10;
        } else {
            $udgiftSensorer = $this->_computeUdgiftSensorer();
            $levetidSensor = $this->_computeLevetidSensor();
            $udgiftArmatur = $this->_computeUdgiftArmatur();
            $levetidArmatur = $this->_computeLevetidArmatur();
            $udgiftLyskilde = $this->_computeUdgiftLyskilde();
            $levetidLyskilde = $this->_computeLevetidLyskilde();

            return $this->divide($udgiftSensorer * $levetidSensor + $udgiftArmatur * $levetidArmatur + $udgiftLyskilde * $levetidLyskilde,
                $udgiftSensorer + $udgiftArmatur + $udgiftLyskilde);
        }
    }

    private function _computeUdgiftSensorer()
    {
        // BN
        if ($this->nyeSensorerStkLokale == 0 || $this->lokale_antal === NULL) {
            return 0;
        } else {
            return $this->nyeSensorerStkLokale * $this->standardinvestSensorKrStk * $this->prisfaktor * $this->lokale_antal;
        }
    }

    private function _computeLevetidSensor()
    {
        return 10;
    }

    private function _computeUdgiftArmatur()
    {
        // BO
        if ($this->standardinvestArmaturKrStk == 0 || $this->lokale_antal === NULL) {
            return 0;
        } else {
            return $this->standardinvestArmaturKrStk * $this->nyeArmaturerStkLokale * $this->lokale_antal * $this->prisfaktor;
        }
    }

    private function _computeUdgiftLyskilde()
    {
        // BP
        if ($this->standardinvestLyskildeKrStk == 0) {
            return 0;
        } else {
            return $this->standardinvestLyskildeKrStk * $this->nyLyskildeStkArmatur * $this->prisfaktor;
        }
    }

    private function _computeLevetidArmatur()
    {
        // BQ
        $nyLyskilde = $this->getNyLyskilde(true);
        $levetid = $nyLyskilde ? $nyLyskilde->getLevetid() : 0;

        if ($levetid == 0 || $this->nyDriftstid == 0) {
            return 0;
        } else {
            return min(25, $levetid / $this->nyDriftstid);
        }
    }

    private function _computeLevetidLyskilde()
    {
        // BR
        return $this->_computeLevetidArmatur();
    }

    private function calculateNutidsvaerdiSetOver15AarKr()
    {
        // BV
        $faktorForReinvestering = $this->_computeFaktorForReinvestering();
        if ($this->vaegtetLevetidAar == 0 || $faktorForReinvestering == 0) {
            return 0;
        } elseif ($this->getNyLyskilde(true) == null) {
            return $this->nvPTO2($this->investeringAlleLokalerKr, $this->kWhBesparelseVarmeFraVarmevaerket, $this->kWhBesparelseEl, 0, 0, 0, round($this->vaegtetLevetidAar), $faktorForReinvestering, 0);
        } else {
            return $this->nvPTO2($this->investeringAlleLokalerKr, $this->kWhBesparelseVarmeFraVarmevaerket, $this->kWhBesparelseEl, 0, $this->driftsbesparelseTilLyskilderKrAar, 0, round($this->vaegtetLevetidAar), $faktorForReinvestering, 0);
        }
    }

    private function _computeFaktorForReinvestering()
    {
        return 1;
    }

    private function _computeArmaturEffekt()
    {
        return $this->__computeArmaturEffekt($this->getLyskilde(true), $this->lyskildeStkArmatur, $this->lyskildeWLyskilde, $this->forkoblingStkArmatur);
    }

    /**
     *
     * @param BelysningTiltagDetailLyskilde|NULL $lyskilde
     *   The Lyskilde.
     * @param integer $lyskildeStkArmatur
     *   .
     * @param float $lyskildeWLyskilde
     *   .
     * @param integer $forkoblingStkArmatur
     *   .
     *
     * @return float
     *   .
     */
    private function __computeArmaturEffekt($lyskilde, $lyskildeStkArmatur, $lyskildeWLyskilde, $forkoblingStkArmatur)
    {
        // Z, AW
        if (!$lyskilde || $lyskildeStkArmatur == 0 || $lyskildeWLyskilde == 0) {
            return 0;
        } else {
            switch ($lyskilde->getType()) {
                case 'LED-rør':
                case 'LEDpære':
                    return ($lyskildeWLyskilde) * $lyskildeStkArmatur;

                case 'Hal.':
                case 'Gl':
                case 'Sp.':
                case 'LED-arm.':
                    return $lyskildeWLyskilde * $lyskildeStkArmatur;

                case 'Kom. K':
                    return $lyskildeStkArmatur * $lyskildeWLyskilde * 1.1817 + 2.44275 + (1.2794 * ($lyskildeStkArmatur - 1)) * 0.9432;

                case 'Hal.': // @FIXME: Duplicate case!
                    return 1.0832 * $lyskildeWLyskilde + 0.192;

                default:
                    switch ($lyskilde->getForkobling()) {
                        case 'konv.':
                            if ($lyskildeWLyskilde < 14.99) {
                                return 8.5 * $forkoblingStkArmatur + $lyskildeStkArmatur * $lyskildeWLyskilde;
                            } elseif ($lyskildeWLyskilde < 35.99) {
                                return 10 * $forkoblingStkArmatur + $lyskildeStkArmatur * $lyskildeWLyskilde;
                            } else {
                                return 12 * $forkoblingStkArmatur + $lyskildeStkArmatur * $lyskildeWLyskilde;
                            }
                        case 'hf':
                            return $forkoblingStkArmatur * 2 + $lyskildeWLyskilde * $lyskildeStkArmatur;
                        default:
                            return null;
                    }
            }
        }
    }

    protected $udgiftSensorer;

    public function getUdgiftSensorer()
    {
        if ($this->udgiftSensorer === NULL) {
            $this->udgiftSensorer = $this->_computeUdgiftSensorer();
        }
        return $this->udgiftSensorer;
    }

    protected $udgiftArmaturer;

    public function getUdgiftArmaturer()
    {
        if ($this->udgiftArmaturer === NULL) {
            $this->udgiftArmaturer = $this->_computeUdgiftArmatur();
        }
        return $this->udgiftArmaturer;
    }

    protected $udgiftLyskilde;

    public function getUdgiftLyskilde()
    {
        if ($this->udgiftLyskilde === NULL) {
            $this->udgiftLyskilde = $this->_computeUdgiftLyskilde();
        }
        return $this->udgiftLyskilde;
    }

    protected $levetidSensor;

    public function getLevetidSensor()
    {
        if ($this->levetidSensor === NULL) {
            $this->levetidSensor = $this->_computeLevetidSensor();
        }
        return $this->levetidSensor;
    }

    protected $armaturvaegtning;

    public function getArmaturvaegtning()
    {
        if ($this->armaturvaegtning === NULL) {
            $this->armaturvaegtning = $this->getUdgiftArmaturer() * $this->_computeLevetidArmatur();
        }
        return $this->armaturvaegtning;
    }

    protected $lyskildevaegtning;

    public function getLyskildevaegtning()
    {
        if ($this->lyskildevaegtning === NULL) {
            $this->lyskildevaegtning = $this->getUdgiftLyskilde() * $this->_computeLevetidLyskilde();
        }
        return $this->lyskildevaegtning;
    }

}
