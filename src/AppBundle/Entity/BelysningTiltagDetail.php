<?php

/**
 * @file
 * BelysningTiltagDetail entity.
 *
 * See calculation file xls/BelysningTiltagDetail/Belysning-forslag-example.xlsx.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Annotations\Formula;
use AppBundle\Entity\BelysningTiltagDetail\ErstatningsLyskilde;
use AppBundle\Entity\Traits\FormulableCalculationEntity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\BelysningTiltagDetail\Lyskilde as BelysningTiltagDetailLyskilde;
use AppBundle\DBAL\Types\BelysningTiltagDetail\PlaceringType;
use AppBundle\DBAL\Types\BelysningTiltagDetail\StyringType;
use AppBundle\Entity\BelysningTiltagDetail\NyStyring;
use AppBundle\Entity\BelysningTiltagDetail\NytArmatur;
use AppBundle\DBAL\Types\BelysningTiltagDetail\TiltagType;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * BelysningTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class BelysningTiltagDetail extends TiltagDetail
{
    use FormulableCalculationEntity;

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
    protected $lokale_antal = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="drifttidTAar", type="integer", nullable=true)
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
     * @ORM\Column(name="lyskildeWLyskilde", type="integer", nullable=true)
     */
    protected $lyskildeWLyskilde;

    /**
     * @var float
     *
     * @ORM\Column(name="benyttelsesFaktor", type="float", nullable=true)
     */
    protected $benyttelsesFaktor;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="installeretEffektW", type="float")
     * @Formula("$this->getLokaleAntal() * $this->getLyskildeStkArmatur() * $this->getLyskildeWLyskilde() * $this->getArmaturerStkLokale()")
     *
     * See calculation file, cell F8.
     */
    protected $installeretEffektW;

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
     * @ORM\Column(name="elforbrugkWtAar", type="float")
     * @Formula("$this->getInstalleretEffektW() * $this->getDrifttidTAar() * $this->getBenyttelsesFaktor() / 1000")
     *
     * See calculation file, cell I8.
     */
    protected $elforbrugkWtAar;

    /**
     * @var string
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\BelysningTiltagDetail\PlaceringType")
     * @ORM\Column(name="placering", type="PlaceringType", nullable=true)
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
     * @ORM\Column(name="nyDriftstid", type="float", nullable=true)
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
     * @var ErstatningsLyskilde
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
     * @ORM\Column(name="nyBenyttelsesFaktor", type="float", nullable=true)
     */
    protected $nyBenyttelsesFaktor;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="nyInstalleretEffektW", type="float")
     * @Formula("$this->getLokaleAntal() * $this->getNyLyskildeStkArmatur() * $this->getNyLyskildeWLyskilde() * $this->getNyeArmaturerStkLokale()")
     *
     * See calculation file, cell M8.
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
     * @Calculated
     * @ORM\Column(name="investeringAlleLokalerKr", type="float")
     * @Formula("$this->getLokaleAntal() * ($this->getNyLyskildeStkArmatur() * $this->getNyeArmaturerStkLokale() * $this->getStandardinvestLyskildeKrStk() + $this->getNyeArmaturerStkLokale() * $this->getStandardinvestArmaturKrStk() + $this->getNyeSensorerStkLokale() * $this->getStandardinvestSensorKrStk())")
     *
     * See calculation file, cell W8.
     */
    protected $investeringAlleLokalerKr;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="nytElforbrugkWtAar", type="float")
     * @Formula("$this->getNyInstalleretEffektW() * $this->getNyDriftstid() * $this->getNyBenyttelsesFaktor() / 1000")
     *
     * See calculation file, cell Q8.
     */
    protected $nytElforbrugkWtAar;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="simpelTilbagebetalingstidAar", type="float")
     * @Formula("($this->getInvesteringAlleLokalerKr() + $this->getTiltagOpstartsomkostninger()) / $this->getElbespKrAar()")
     *
     * See calculation file, cell X8.
     */
    protected $simpelTilbagebetalingstidAar;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="kWhBesparelseEl", type="float")
     * @Formula("$this->getElforbrugkWtAar() - $this->getNytElforbrugkWtAar()")
     *
     * See calculation file, cell R8.
     */
    protected $kWhBesparelseEl;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="elbespKrAar", type="float")
     * @Formula("$this->getKwhBesparelseEl() * $this->getTiltagElKrKWh()")
     *
     * See calculation file, cell S8.
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
     * Set investeringAlleLokalerKr
     *
     * @param string $investeringAlleLokalerKr
     * @return BelysningTiltagDetail
     */
    public function setInvesteringAlleLokalerKr($investeringAlleLokalerKr)
    {
        $this->investeringAlleLokalerKr = $investeringAlleLokalerKr;

        return $this;
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
     * Get simpelTilbagebetalingstidAar
     *
     * @return float
     */
    public function getSimpelTilbagebetalingstidAar()
    {
        return $this->simpelTilbagebetalingstidAar;
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
     * @return NyStyring
     */
    public function getNyStyring()
    {
        return $this->nyStyring;
    }

    /**
     * @param NyStyring $nyStyring
     */
    public function setNyStyring($nyStyring)
    {
        $this->nyStyring = $nyStyring;
    }

    /**
     * @return NytArmatur
     */
    public function getNytArmatur()
    {
        return $this->nytArmatur;
    }

    /**
     * @param NytArmatur $nytArmatur
     */
    public function setNytArmatur($nytArmatur)
    {
        $this->nytArmatur = $nytArmatur;
    }

    /**
     * @return ErstatningsLyskilde
     */
    public function getErstatningsLyskilde()
    {
        return $this->erstatningsLyskilde;
    }

    /**
     * @param ErstatningsLyskilde $erstatningsLyskilde
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

    /**
     * Get elbespKrAar
     *
     * @return float
     */
    public function getTiltagElKrKWh() {
        return $this->getRapport()->getElKrKWh();
    }

    /**
     * Get tiltag opstartsomkostninger
     *
     * @return float
     */
    public function getTiltagOpstartsomkostninger() {
        return $this->getTiltag()->getOpstartsomkostninger();
    }

    protected $propertiesRequiredForCalculation = [
        'lokale_antal',
        'drifttidTAar',
        'lyskildeStkArmatur',
        'lyskildeWLyskilde',
        'armaturerStkLokale',
        'benyttelsesFaktor',
        'nyDriftstid',
        'nyLyskildeStkArmatur',
        'nyeArmaturerStkLokale',
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
        $this->installeretEffektW = $this->calculateByFormula('installeretEffektW');
        $this->nyInstalleretEffektW = $this->calculateByFormula('nyInstalleretEffektW');
        $this->elforbrugkWtAar = $this->calculateByFormula('elforbrugkWtAar');
        $this->nytElforbrugkWtAar = $this->calculateByFormula('nytElforbrugkWtAar');
        $this->kWhBesparelseEl = $this->calculateByFormula('kWhBesparelseEl');
        $this->elbespKrAar = $this->calculateByFormula('elbespKrAar');
        $this->investeringAlleLokalerKr = $this->calculateByFormula('investeringAlleLokalerKr');
        $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
        parent::calculate();
    }

    /**
     * See calculation file, cell X8.
     * @return float
     */
    private function calculateSimpelTilbagebetalingstidAar()
    {
        return $this->divide(($this->getInvesteringAlleLokalerKr() + $this->getTiltagOpstartsomkostninger()), $this->getElbespKrAar());
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist() {
        $this->initFormulableCalculation();
    }

    /**
     * @ORM\PostLoad()
     */
    public function postLoad() {
        $this->initFormulableCalculation();
    }

}
