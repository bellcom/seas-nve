<?php

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\MonthType;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotations\Calculated;
use AppBundle\DBAL\Types\CardinalDirectionType;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * NyKlimaskaermTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class NyKlimaskaermTiltagDetail extends TiltagDetail
{
    /**
     * @var string
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\CardinalDirectionType")
     * @ORM\Column(name="orientering", type="CardinalDirectionType", nullable=true)
     */
    protected $orientering;

    /**
     * @var Klimaskaerm
     *
     * @ORM\ManyToOne(targetEntity="Klimaskaerm", fetch="EAGER")
     * @ORM\JoinColumn(name="klimaskaerm_id", referencedColumnName="id", nullable=true)
     **/
    protected $klimaskaerm;

    /**
     * @var float
     *
     * @ORM\Column(name="klimaskaermOverskrevetPris", type="decimal", scale=4, nullable=true)
     *
     * @Assert\Expression(
     *  "(this.getKlimaskaerm() !== null || this.getKlimaskaermOverskrevetPris() !== null) || this.isBatchEdit()",
     *  message="appbundle.klimaskaermtiltagdetail.klimaskaermOverskrevetPris.validation",
     *  groups={"klimaskaerm"}
     * )
     */
    protected $klimaskaermOverskrevetPris;

    /**
     * @var string
     *
     * @ORM\Column(name="placering", type="string", length=255)
     */
    protected $placering;

    /**
     * @var float
     *
     * @ORM\Column(name="hoejdeElLaengdeM", type="decimal", scale=4)
     */
    protected $hoejdeElLaengdeM;

    /**
     * @var float
     *
     * @ORM\Column(name="breddeM", type="decimal", scale=4)
     */
    protected $breddeM;

    /**
     * @var string
     *
     * @ORM\Column(name="antalStk", type="string")
     */
    protected $antalStk;

    /**
     * @var float
     *
     * @ORM\Column(name="andelAfArealDerEfterisoleres", type="decimal", scale=4, nullable=true)
     */
    protected $andelAfArealDerEfterisoleres;

    /**
     * @var float
     *
     * @ORM\Column(name="uEksWM2K", type="decimal", scale=4, precision=14)
     */
    protected $uEksWM2K;

    /**
     * @var float
     *
     * @ORM\Column(name="uNyWM2K", type="decimal", scale=4, nullable=true)
     */
    protected $uNyWM2K;

    /**
     * @var float
     *
     * @ORM\Column(name="tIndeC", type="decimal", scale=4, nullable=true)
     */
    protected $tIndeC;

    /**
     * @var float
     *
     * @ORM\Column(name="tUdeC", type="decimal", scale=4, nullable=true)
     */
    protected $tUdeC;

    /**
     * @var float
     *
     * @ORM\Column(name="tOpvarmningTimerAar", type="decimal", scale=4, nullable=true)
     */
    protected $tOpvarmningTimerAar;

    /**
     * @var float
     *
     * @ORM\Column(name="yderligereBesparelserPct", type="decimal", scale=4, nullable=true)
     */
    protected $yderligereBesparelserPct;

    /**
     * @var float
     *
     * @ORM\Column(name="prisfaktor", type="decimal", scale=4, nullable=true)
     */
    protected $prisfaktor = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet", type="text", nullable=true)
     */
    protected $noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet;

    /**
     * @var integer
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\LevetidType")
     * @ORM\Column(name="levetidAar", type="LevetidType", nullable=true)
     */
    protected $levetidAar;

    /**
     * @var string
     *
     * @ORM\Column(name="noteGenerelt", type="text", nullable=true)
     *
     * @Assert\Length(
     *  max = 360,
     *  maxMessage = "maxLength"
     * )
     */
    protected $noteGenerelt;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="arealM2", type="float")
     */
    protected $arealM2;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="besparelseKWhAar", type="float")
     */
    protected $besparelseKWhAar;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="samletInvesteringKr", type="float")
     */
    protected $samletInvesteringKr;

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
     * @ORM\Column(name="faktorForReinvestering", type="float")
     */
    protected $faktorForReinvestering;

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
     * @ORM\Column(name="kWhBesparElvaerkEksternEnergikilde", type="float")
     */
    protected $kWhBesparElvaerkEksternEnergikilde;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="kWhBesparVarmevaerkEksternEnergikilde", type="float")
     */
    protected $kWhBesparVarmevaerkEksternEnergikilde;


    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="beskrivelse", type="text", nullable=true)
     *
     * @Assert\Length(
     *  max = 10000,
     *  maxMessage = "maxLength"
     * )
     */
    protected $beskrivelse;

    /**
     * @var string
     *
     * @ORM\Column(name="titel", type="string")
     */
    protected $titel;

    /**
     * @var GraddageFordeling
     *
     * @ORM\ManyToOne(targetEntity="GraddageFordeling", fetch="EAGER")
     * @ORM\JoinColumn(name="graddageFordeling", referencedColumnName="id", nullable=true)
     **/
    protected $graddageFordeling;

    /**
     * @var float
     *
     * @ORM\Column(name="fradragM", type="decimal", scale=4, nullable=true)
     */
    protected $fradragM;

    /**
     * @var array
     *
     * @ORM\Column(name="tOpvarmningTimerAarMonthly", type="array")
     */
    protected $tOpvarmningTimerAarMonthly;

    /**
     * @var array
     *
     * @ORM\Column(name="tIndeMonthly", type="array")
     */
    private $tIndeMonthly;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tIndeDetailed", type="boolean", nullable=true)
     */
    protected $tIndeDetailed = false;

    /**
     * @var array
     *
     * @ORM\Column(name="tUdeMonthly", type="array")
     */
    private $tUdeMonthly;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tUdeDetailed", type="boolean", nullable=true)
     */
    protected $tUdeDetailed = false;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->andelAfArealDerEfterisoleres = 1;
        $this->prisfaktor = 1;
        foreach (MonthType::getChoices() as $key => $value) {
            if (empty($key)) {
                continue;
            }
            $this->tIndeMonthly[$key] = NULL;
            $this->tUdeMonthly[$key] = NULL;
            $this->tOpvarmningTimerAarMonthly[$key] = NULL;
        }
    }

    public function setKlimaskaerm($klimaskaerm) {
        $this->klimaskaerm = $klimaskaerm;

        return $this;
    }

    public function getKlimaskaerm() {
        return $this->klimaskaerm;
    }

    /**
     * @return mixed
     */
    public function getKlimaskaermOverskrevetPris() {
        return $this->klimaskaermOverskrevetPris;
    }

    /**
     * @param mixed $klimaskaermOverskrevetPris
     */
    public function setKlimaskaermOverskrevetPris($klimaskaermOverskrevetPris) {
        $this->klimaskaermOverskrevetPris = $klimaskaermOverskrevetPris;
    }

    public function setOrientering($orientering) {
        $this->orientering = $orientering;

        return $this;
    }

    public function getOrientering() {
        return $this->orientering;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return NyKlimaskaermTiltagDetail
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set placering
     *
     * @param string $placering
     * @return NyKlimaskaermTiltagDetail
     */
    public function setPlacering($placering) {
        $this->placering = $placering;

        return $this;
    }

    /**
     * Get placering
     *
     * @return string
     */
    public function getPlacering() {
        return $this->placering;
    }

    /**
     * Set hoejdeElLaengdeM
     *
     * @param float $hoejdeElLaengdeM
     * @return NyKlimaskaermTiltagDetail
     */
    public function setHoejdeElLaengdeM($hoejdeElLaengdeM) {
        $this->hoejdeElLaengdeM = $hoejdeElLaengdeM;

        return $this;
    }

    /**
     * Get hoejdeElLaengdeM
     *
     * @return float
     */
    public function getHoejdeElLaengdeM() {
        return $this->hoejdeElLaengdeM;
    }

    /**
     * Set breddeM
     *
     * @param float $breddeM
     * @return NyKlimaskaermTiltagDetail
     */
    public function setBreddeM($breddeM) {
        $this->breddeM = $breddeM;

        return $this;
    }

    /**
     * Get breddeM
     *
     * @return float
     */
    public function getBreddeM() {
        return $this->breddeM;
    }

    /**
     * Set antalStk
     *
     * @param string $antalStk
     * @return NyKlimaskaermTiltagDetail
     */
    public function setAntalStk($antalStk) {
        $this->antalStk = $antalStk;

        return $this;
    }

    /**
     * Get antalStk
     *
     * @return string
     */
    public function getAntalStk() {
        return $this->antalStk;
    }

    /**
     * Set andelAfArealDerEfterisoleres
     *
     * @param float $andelAfArealDerEfterisoleres
     * @return NyKlimaskaermTiltagDetail
     */
    public function setAndelAfArealDerEfterisoleres($andelAfArealDerEfterisoleres) {
        $this->andelAfArealDerEfterisoleres = $andelAfArealDerEfterisoleres;

        return $this;
    }

    /**
     * Get andelAfArealDerEfterisoleres
     *
     * @return float
     */
    public function getAndelAfArealDerEfterisoleres() {
        return $this->andelAfArealDerEfterisoleres;
    }

    /**
     * Set uEksWM2K
     *
     * @param float $uEksWM2K
     * @return NyKlimaskaermTiltagDetail
     */
    public function setUEksWM2K($uEksWM2K) {
        $this->uEksWM2K = $uEksWM2K;

        return $this;
    }

    /**
     * Get uEksWM2K
     *
     * @return float
     */
    public function getUEksWM2K() {
        return $this->uEksWM2K;
    }

    /**
     * Set uNyWM2K
     *
     * @param float $uNyWM2K
     * @return NyKlimaskaermTiltagDetail
     */
    public function setUNyWM2K($uNyWM2K) {
        $this->uNyWM2K = $uNyWM2K;

        return $this;
    }

    /**
     * Get uNyWM2K
     *
     * @return float
     */
    public function getUNyWM2K() {
        return $this->uNyWM2K;
    }

    /**
     * Set tIndeC
     *
     * @param float $tIndeC
     * @return NyKlimaskaermTiltagDetail
     */
    public function setTIndeC($tIndeC) {
        $this->tIndeC = $tIndeC;

        return $this;
    }

    /**
     * Set tOpvarmningTimerAar
     *
     * @param float $tOpvarmningTimerAar
     * @return NyKlimaskaermTiltagDetail
     */
    public function setTOpvarmningTimerAar($tOpvarmningTimerAar) {
        $this->tOpvarmningTimerAar = $tOpvarmningTimerAar;

        return $this;
    }

    /**
     * Get tOpvarmningTimerAar
     *
     * @return float
     */
    public function getTOpvarmningTimerAar() {
        return $this->tOpvarmningTimerAar;
    }

    /**
     * Set yderligereBesparelserPct
     *
     * @param float $yderligereBesparelserPct
     * @return NyKlimaskaermTiltagDetail
     */
    public function setYderligereBesparelserPct($yderligereBesparelserPct) {
        $this->yderligereBesparelserPct = $yderligereBesparelserPct;

        return $this;
    }

    /**
     * Get yderligereBesparelserPct
     *
     * @return float
     */
    public function getYderligereBesparelserPct() {
        return $this->yderligereBesparelserPct;
    }

    /**
     * Set prisfaktor
     *
     * @param float $prisfaktor
     * @return NyKlimaskaermTiltagDetail
     */
    public function setPrisfaktor($prisfaktor) {
        $this->prisfaktor = $prisfaktor;

        return $this;
    }

    /**
     * Get prisfaktor
     *
     * @return float
     */
    public function getPrisfaktor() {
        return empty($this->prisfaktor) ? 1 : $this->prisfaktor;
    }

    /**
     * Set noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet
     *
     * @param string $noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet
     * @return NyKlimaskaermTiltagDetail
     */
    public function setNoterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet($noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet) {
        $this->noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet = $noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet;

        return $this;
    }

    /**
     * Get noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet
     *
     * @return string
     */
    public function getNoterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet() {
        return $this->noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet;
    }

    /**
     * Set levetidAar
     *
     * @param integer $levetidAar
     * @return NyKlimaskaermTiltagDetail
     */
    public function setLevetidAar($levetidAar) {
        $this->levetidAar = $levetidAar;

        return $this;
    }

    /**
     * Get levetidAar
     *
     * @return integer
     */
    public function getLevetidAar() {
        return $this->levetidAar;
    }

    /**
     * Set noteGenerelt
     *
     * @param integer $noteGenerelt
     * @return NyKlimaskaermTiltagDetail
     */
    public function setNoteGenerelt($noteGenerelt) {
        $this->noteGenerelt = $noteGenerelt;

        return $this;
    }

    /**
     * Get noteGenerelt
     *
     * @return integer
     */
    public function getNoteGenerelt() {
        return $this->noteGenerelt;
    }

    /**
     * Get arealM2
     *
     * @return float
     */
    public function getArealM2() {
        return $this->arealM2;
    }

    /**
     * Get besparelseKWhAar
     *
     * @return float
     */
    public function getBesparelseKWhAar() {
        return $this->besparelseKWhAar;
    }

    /**
     * Set samletInvesteringKr
     *
     * @param float $samletInvesteringKr
     * @return NyKlimaskaermTiltagDetail
     */
    public function setSamletInvesteringKr($samletInvesteringKr) {
        $this->samletInvesteringKr = $samletInvesteringKr;

        return $this;
    }

    /**
     * Get samletInvesteringKr
     *
     * @return float
     */
    public function getSamletInvesteringKr() {
        return $this->samletInvesteringKr;
    }

    /**
     * Get simpelTilbagebetalingstidAar
     *
     * @return float
     */
    public function getSimpelTilbagebetalingstidAar() {
        return $this->simpelTilbagebetalingstidAar;
    }

    /**
     * Get faktorForReinvestering
     *
     * @return float
     */
    public function getFaktorForReinvestering() {
        return $this->faktorForReinvestering;
    }

    /**
     * Get nutidsvaerdiSetOver15AarKr
     *
     * @return float
     */
    public function getNutidsvaerdiSetOver15AarKr() {
        return $this->nutidsvaerdiSetOver15AarKr;
    }

    /**
     * Get kWhBesparElvaerkEksternEnergikilde
     *
     * @return float
     */
    public function getKWhBesparElvaerkEksternEnergikilde() {
        return $this->kWhBesparElvaerkEksternEnergikilde;
    }

    /**
     * Get kWhBesparVarmevaerkEksternEnergikilde
     *
     * @return float
     */
    public function getKWhBesparVarmevaerkEksternEnergikilde() {
        return $this->kWhBesparVarmevaerkEksternEnergikilde;
    }


    /**
     * Get pris pr. m2 for klimaskærm
     *
     * If klimaskaermOverskrevetPris is set, this price takes precedence. Otherwise use default price klimaskaerm table
     *
     * @return float
     */
    public function getEnhedsprisEksklMoms() {
        if($this->klimaskaermOverskrevetPris !== null) {
            return $this->klimaskaermOverskrevetPris;
        } else if ($this->klimaskaerm !== null) {
            return $this->klimaskaerm->getEnhedsprisEksklMoms();
        }

        return 0;
    }

    /**
     * Set titel
     *
     * @param string $titel
     * @return NyKlimaskaermTiltagDetail
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
     * Set beskrivelse
     *
     * @param string $beskrivelse
     * @return NyKlimaskaermTiltagDetail
     */
    public function setBeskrivelse($beskrivelse) {
        $this->beskrivelse = $beskrivelse;

        return $this;
    }

    /**
     * Get beskrivelse
     *
     * @return string
     */
    public function getBeskrivelse() {
        return $this->beskrivelse;
    }

    /**
     * Set graddageFordeling
     *
     * @param GraddageFordeling $graddageFordeling
     * @return NyKlimaskaermTiltagDetail
     */
    public function setGraddageFordeling($graddageFordeling) {
        $this->graddageFordeling = $graddageFordeling;

        return $this;
    }

    /**
     * Get graddageFordeling
     *
     * @return GraddageFordeling
     */
    public function getGraddageFordeling() {
        return $this->graddageFordeling;
    }

    /**
     * Set fradragM
     *
     * @param float $fradragM
     * @return NyKlimaskaermTiltagDetail
     */
    public function setFradragM($fradragM) {
        $this->fradragM = $fradragM;

        return $this;
    }

    /**
     * Get fradragM
     *
     * @return float
     */
    public function getFradragM() {
        return $this->fradragM;
    }

    /**
     * Set tOpvarmningTimerAarMonthly
     *
     * @param array $tOpvarmningTimerAarMonthly
     *
     * @return NyKlimaskaermTiltagDetail
     */
    public function setTOpvarmningTimerAarMonthly($tOpvarmningTimerAarMonthly)
    {
        $this->tOpvarmningTimerAarMonthly = $tOpvarmningTimerAarMonthly;
        return $this;
    }

    /**
     * Get tOpvarmningTimerAarMonthly
     *
     * @return array
     */
    public function getTOpvarmningTimerAarMonthly()
    {
        $graddageFordeling = $this->getGraddageFordeling();
        if (!empty($graddageFordeling)) {
            $accessor = PropertyAccess::createPropertyAccessor();
            foreach (MonthType::getChoices() as $key => $value) {
                if (empty($key)) {
                    continue;
                }
                $this->tOpvarmningTimerAarMonthly[$key] = $accessor->getValue($graddageFordeling, $key);
            }
        }
        return $this->tOpvarmningTimerAarMonthly;
    }

    /**
     * Set tIndeMonthly
     *
     * @param array $tIndeMonthly
     *
     * @return NyKlimaskaermTiltagDetail
     */
    public function setTIndeMonthly($tIndeMonthly)
    {
        $this->tIndeMonthly = $tIndeMonthly;
        return $this;
    }

    /**
     * Get tIndeMonthly
     *
     * @return array
     */
    public function getTIndeMonthly()
    {
        if (!$this->tIndeDetailed) {
            $this->tIndeMonthly = array();
            foreach (MonthType::getChoices() as $key => $value) {
                if (empty($key)) {
                    continue;
                }
                $this->tIndeMonthly[$key] = $this->tIndeC;
            }
        }
        return $this->tIndeMonthly;
    }

    /**
     * Set tIndeDetailed
     *
     * @param boolean $tIndeDetailed
     * @return NyKlimaskaermTiltagDetail
     */
    public function setTIndeDetailed($tIndeDetailed) {
        $this->tIndeDetailed = $tIndeDetailed;

        return $this;
    }

    /**
     * Get tIndeDetailed
     *
     * @return boolean
     */
    public function getTIndeDetailed() {
        return $this->tIndeDetailed;
    }

    /**
     * Set tUdeMonthly
     *
     * @param array $tUdeMonthly
     *
     * @return NyKlimaskaermTiltagDetail
     */
    public function setTUdeMonthly($tUdeMonthly)
    {
        $this->tUdeMonthly = $tUdeMonthly;
        return $this;
    }

    /**
     * Get tUdeMonthly
     *
     * @return array
     */
    public function getTUdeMonthly()
    {
        if (!$this->tUdeDetailed) {
            $this->tUdeMonthly = array();
            foreach (MonthType::getChoices() as $key => $value) {
                if (empty($key)) {
                    continue;
                }
                $this->tUdeMonthly[$key] = $this->tUdeC;
            }
        }
        return $this->tUdeMonthly;
    }

    /**
     * Set tUdeDetailed
     *
     * @param boolean $tUdeDetailed
     * @return NyKlimaskaermTiltagDetail
     */
    public function setTUdeDetailed($tUdeDetailed) {
        $this->tUdeDetailed = $tUdeDetailed;
        return $this;
    }

    /**
     * Get tUdeDetailed
     *
     * @return boolean
     */
    public function getTUdeDetailed() {
        return $this->tUdeDetailed;
    }

    /**
     * @inheritDoc
     */
    public function getTIndeC() {
        return $this->tIndeC;
    }

    /**
     * Set tUdeC
     *
     * @param float $tUdeC
     * @return NyKlimaskaermTiltagDetail
     */
    public function setTUdeC($tUdeC) {
        $this->tUdeC = $tUdeC;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTUdeC() {
        return $this->tUdeC;
    }

    protected $propertiesRequiredForCalculation = [
        'antalStk',
        'breddeM',
        'hoejdeElLaengdeM',
        'tIndeC',
        'tUdeC',
        'uEksWM2K',
        'uNyWM2K',
        'samletInvesteringKr',
    ];

    private function calculateSimpelTilbagebetalingstidAar() {
        // "AF": "Simpel tilbagebetalingstid (år)"
        return $this->divide($this->samletInvesteringKr,
            $this->kWhBesparElvaerkEksternEnergikilde * $this->getRapport()->getElKrKWh() + $this->kWhBesparVarmevaerkEksternEnergikilde * $this->getRapport()
                ->getVarmeKrKWh());
    }

    private function calculateFaktorForReinvestering() {
        // "AM": "Faktor for reinvestering"
        return 1;
    }

    private function calculateNutidsvaerdiSetOver15AarKr() {
        // "AN": "Nutidsværdi set over 15 år (kr)"
        if ($this->kWhBesparElvaerkEksternEnergikilde == 0 && $this->kWhBesparVarmevaerkEksternEnergikilde == 0) {
            return 0;
        }
        else {
            return $this->nvPTO2($this->samletInvesteringKr, $this->kWhBesparVarmevaerkEksternEnergikilde, $this->kWhBesparElvaerkEksternEnergikilde, 0, 0, 0, $this->levetidAar, $this->faktorForReinvestering, 0);
        }
    }

    private function calculateKWhBesparElvaerkEksternEnergikilde() {
        // "AO": "kWh-bespar. Elværk (Ekstern energikilde)"
        if ($this->besparelseKWhAar == 0) {
            return 0;
        }
        elseif ($this->besparelseKWhAar > 0) {
            if ($this->getRapport()->getStandardforsyning()) {
                return 0;
            }
            else {
                return $this->fordelbesparelse($this->besparelseKWhAar, $this->tiltag->getForsyningVarme(), 'EL');
            }
        }
        else {
            return 0;
        }
    }

    private function calculateKWhBesparVarmevaerkEksternEnergikilde() {
        // "AP": "kWh-bespar. Varmeværk (ekstern energikilde)"
        if ($this->besparelseKWhAar == 0) {
            return 0;
        }
        else {
            if ($this->besparelseKWhAar > 0) {
                if ($this->getRapport()->getStandardforsyning()) {
                    return $this->besparelseKWhAar;
                }
                else {
                    return $this->fordelbesparelse($this->besparelseKWhAar, $this->tiltag->getForsyningVarme(), 'VARME');
                }
            }
            else {
                return 0;
            }
        }
    }

    /**
     * We do not calculate SamletInvesteringKr in NyKlimaskaermTiltagDetail.
     *
     * @return float
     */
    protected function calculateSamletInvesteringKr() {
        return $this->getSamletInvesteringKr();
    }

    /**
     * Summarize heating hours for current year.
     *
     * @return float
     */
    private function calculateTOpvarmningTimerAar() {
        if (empty($this->getGraddageFordeling())) {
            return array_sum(empty($this->getTOpvarmningTimerAarMonthly()) ? array() : $this->getTOpvarmningTimerAarMonthly());
        }
        else {
            return round($this->getGraddageFordeling()->getSumAar());
        }
    }

    protected function calculateArealM2() {
        if (!$this->hoejdeElLaengdeM || !$this->breddeM || !$this->antalStk) {
            return 0;
        }
        else {
            return $this->breddeM * $this->hoejdeElLaengdeM * $this->antalStk - $this->fradragM;
        }
    }

    protected function calculateBesparelseKWhAar() {
        if ($this->arealM2 == 0) {
            return 0;
        }
        else {
            $values = array();
            $tIndeMonthly = $this->getTIndeMonthly();
            $tUdeMonthly = $this->getTUdeMonthly();
            $tOpvarmningTimerAarMonthly = $this->getTOpvarmningTimerAarMonthly();

            foreach (MonthType::getChoices() as $key => $value) {
                if (empty($key)) {
                    continue;
                }
                $values[] = (($this->uEksWM2K - $this->uNyWM2K) * $this->arealM2 * ($tIndeMonthly[$key] - $tUdeMonthly[$key]) * $tOpvarmningTimerAarMonthly[$key] / 1000 * $this->andelAfArealDerEfterisoleres) * (1 + $this->yderligereBesparelserPct);
            }
            return array_sum($values);
        }
    }

    public function calculate() {
        $this->tOpvarmningTimerAar = $this->calculateTOpvarmningTimerAar();
        $this->arealM2 = $this->calculateArealM2();
        $this->besparelseKWhAar = $this->calculateBesparelseKWhAar();
        $this->samletInvesteringKr = $this->calculateSamletInvesteringKr();
        $this->faktorForReinvestering = $this->calculateFaktorForReinvestering();
        $this->kWhBesparElvaerkEksternEnergikilde = $this->calculateKWhBesparElvaerkEksternEnergikilde();
        $this->kWhBesparVarmevaerkEksternEnergikilde = $this->calculateKWhBesparVarmevaerkEksternEnergikilde();
        $this->nutidsvaerdiSetOver15AarKr = $this->calculateNutidsvaerdiSetOver15AarKr();
        $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
        parent::calculate();
    }

    /**
     * PreFlush handler.
     *
     * @ORM\PreFlush
     * @param \Doctrine\ORM\Event\PreFlushEventArgs $event
     */
    public function preFlush(PreFlushEventArgs $event) {
        if ($this->tIndeDetailed && !empty($this->getTIndeMonthly())) {
             $this->tIndeC = array_sum($this->getTIndeMonthly()) / count($this->getTIndeMonthly());
        }

        if ($this->tUdeDetailed && !empty($this->getTUdeMonthly())) {
            $this->tUdeC = array_sum($this->getTUdeMonthly()) / count($this->getTUdeMonthly());
        }
    }

}
