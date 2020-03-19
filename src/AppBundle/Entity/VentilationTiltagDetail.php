<?php

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Annotations\Formula;
use AppBundle\DBAL\Types\MonthType;
use AppBundle\DBAL\Types\VentilationTiltagDetail\ForureningType;
use AppBundle\DBAL\Types\VentilationTiltagDetail\KvalitetType;
use AppBundle\Entity\Traits\FormulableCalculationEntity;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * VentilationTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class VentilationTiltagDetail extends TiltagDetail
{
    use FormulableCalculationEntity;

    /**
     * @var float
     *
     * @ORM\Column(name="laengdeVentileretRum", type="float")
     */
    private $laengdeVentileretRum;

    /**
     * @var float
     *
     * @ORM\Column(name="breddeVentileretRum", type="float")
     */
    private $breddeVentileretRum;

    /**
     * @var string
     *
     * @ORM\Column(name="hoejdeVentileterRum", type="string", length=255)
     */
    private $hoejdeVentileterRum;

    /**
     * @var integer
     *
     * @ORM\Column(name="antalPersoner", type="integer")
     */
    private $antalPersoner;

    /**
     * @var float
     *
     * @ORM\Column(name="udeluftTilfoersel", type="float")
     */
    private $udeluftTilfoersel;

    /**
     * @var string
     *
     * @ORM\Column(name="forurening", type="string", length=255)
     */
    private $forurening;

    /**
     * @var string
     *
     * @ORM\Column(name="kvalitet", type="string", length=255)
     */
    private $kvalitet;

    /**
     * @var array
     *
     * @ORM\Column(name="indDataFoer", type="array")
     */
    private $indDataFoer;

    /**
     * @var array
     *
     * @ORM\Column(name="indDataEfter", type="array")
     */
    private $indDataEfter;

    /**
     * @var array
     *
     * @ORM\Column(name="udeluftbehov", type="array")
     */
    private $udeluftbehov;

    /**
     * @var array
     *
     * @ORM\Column(name="varmeForbrugMaaneligeFoer", type="array")
     */
    private $varmeForbrugMaaneligeFoer;

    /**
     * @var array
     *
     * @ORM\Column(name="varmeForbrugMaaneligeEfter", type="array")
     */
    private $varmeForbrugMaaneligeEfter;

    /**
     * @var integer
     * @Formula("1000000 * ($this->getAntalPersoner() * 19 + $this->getUdeluftTilfoersel() * 100) / 3600 / $this->getUdeluftbehovTotalLps() + 350")
     * @ORM\Column(name="co2PpmIRum", type="integer")
     */
    private $co2PpmIRum;

    /**
     * @var float
     *
     * @Calculated
     * @Formula("$this->getVarmeForbrugKwhAarFoer() - $this->getVarmeForbrugKwhAarEfter()")
     * @ORM\Column(name="varmebespKwhAar", type="float")
     */
    protected $varmebespKwhAar;

    /**
     * @var float
     *
     * @Formula("($this->getVarmeForbrugKwhAarFoer() - $this->getVarmeForbrugKwhAarEfter())/$this->getVarmeForbrugKwhAarFoer()")
     */
    protected $varmebespKwhAarProcent;

    /**
     * @var float
     */
    protected $varmeForbrugKwhAarFoer;

    /**
     * @var float
     */
    protected $varmeForbrugKwhAarEfter;

    /**
     * @var float
     *
     * @Calculated
     * @Formula("$this->getElForbrugKwhAarFoer() - $this->getElForbrugKwhAarEfter()")
     * @ORM\Column(name="elbespKwhAar", type="float")
     */
    protected $elbespKwhAar;

    /**
     * @var float
     */
    protected $elForbrugKwhAarFoer;

    /**
     * @var float
     */
    protected $elForbrugKwhAarEfter;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        foreach (self::getIndDataFoerInputKeys() as $key) {
            $this->indDataFoer[$key] = NULL;
        }
        foreach (self::getIndDataEfterInputKeys() as $key) {
            $this->indDataEfter[$key] = NULL;
        }
    }

    /**
     * Grundventilation matrix.
     *
     * @return array
     */
    public function getGrundventilationMatrix() {
        return $this->getConfiguration()->getGrundventilationMatrix();
    }

    /**
     * Grundventilation matrix value.
     *
     * @param $forunering
     * @param $kvalitet
     *
     * @return float|integer|null
     */
    public function getGrundventilationMatrixValue($forunering, $kvalitet) {
        $matrix = $this->getGrundventilationMatrix();
        return isset($matrix[$forunering][$kvalitet]) ? $matrix[$forunering][$kvalitet] : NULL;
    }

    /**
     * Grundventilation matrix value by current forunering and kvalitet.
     *
     * @return float|integer|null
     */
    public function getCurrentGrundventilationMatrixValue() {
        return $this->getGrundventilationMatrixValue($this->getForurening(), $this->getKvalitet());
    }

    /**
     * UdeluftTilfoersel matrix.
     *
     * Udelufttilførsel i l/s til personer.
     *
     * @return array
     */
    public function getUdeluftTilfoerselMatrix() {
        return $this->getConfiguration()->getUdeluftTilfoerselMatrix();
    }

    /**
     * UdeluftTilfoersel matrix value.
     *
     * @param $type
     * @param $kvalitet
     *
     * @return float|integer|null
     */
    public function getUdeluftTilfoerselMatrixValue($type, $kvalitet) {
        $matrix = $this->getUdeluftTilfoerselMatrix();
        return isset($matrix[$type][$kvalitet]) ? $matrix[$type][$kvalitet] : NULL;
    }

    /**
     * UdeluftTilfoersel litre per person per second value by current kvalitet.
     *
     * @return float
     */
    public function getCurrentUdeluftTilfoerselLpsValue() {
        return $this->getUdeluftTilfoerselMatrixValue('lps_per_person', $this->getKvalitet());
    }

    /**
     * UdeluftTilfoersel % utilfredse value by current kvalitet.
     *
     * @return float
     */
    public function getCurrentUdeluftTilfoerselMatrixValue() {
        return $this->getUdeluftTilfoerselMatrixValue('del_utilfredse_personer', $this->getKvalitet());
    }

    /**
     * Set laengdeVentileretRum
     *
     * @param float $laengdeVentileretRum
     *
     * @return VentilationTiltagDetail
     */
    public function setLaengdeVentileretRum($laengdeVentileretRum)
    {
        $this->laengdeVentileretRum = $laengdeVentileretRum;

        return $this;
    }

    /**
     * Get laengdeVentileretRum
     *
     * @return float
     */
    public function getLaengdeVentileretRum()
    {
        return $this->laengdeVentileretRum;
    }

    /**
     * Set breddeVentileretRum
     *
     * @param float $breddeVentileretRum
     *
     * @return VentilationTiltagDetail
     */
    public function setBreddeVentileretRum($breddeVentileretRum)
    {
        $this->breddeVentileretRum = $breddeVentileretRum;

        return $this;
    }

    /**
     * Get breddeVentileretRum
     *
     * @return float
     */
    public function getBreddeVentileretRum()
    {
        return $this->breddeVentileretRum;
    }

    /**
     * Set hoejdeVentileterRum
     *
     * @param string $hoejdeVentileterRum
     *
     * @return VentilationTiltagDetail
     */
    public function setHoejdeVentileterRum($hoejdeVentileterRum)
    {
        $this->hoejdeVentileterRum = $hoejdeVentileterRum;

        return $this;
    }

    /**
     * Get hoejdeVentileterRum
     *
     * @return string
     */
    public function getHoejdeVentileterRum()
    {
        return $this->hoejdeVentileterRum;
    }

    /**
     * Set antalPersoner
     *
     * @param integer $antalPersoner
     *
     * @return VentilationTiltagDetail
     */
    public function setAntalPersoner($antalPersoner)
    {
        $this->antalPersoner = $antalPersoner;

        return $this;
    }

    /**
     * Get antalPersoner
     *
     * @return integer
     */
    public function getAntalPersoner()
    {
        return $this->antalPersoner;
    }

    /**
     * Set udeluftTilfoersel
     *
     * @param float $udeluftTilfoersel
     *
     * @return VentilationTiltagDetail
     */
    public function setUdeluftTilfoersel($udeluftTilfoersel)
    {
        $this->udeluftTilfoersel = $udeluftTilfoersel;

        return $this;
    }

    /**
     * Get udeluftTilfoersel
     *
     * @return float
     */
    public function getUdeluftTilfoersel()
    {
        return $this->udeluftTilfoersel;
    }

    /**
     * Set forurening
     *
     * @param string $forurening
     *
     * @return VentilationTiltagDetail
     */
    public function setForurening($forurening)
    {
        $this->forurening = $forurening;

        return $this;
    }

    /**
     * Get forurening
     *
     * @return string
     */
    public function getForurening()
    {
        return $this->forurening;
    }

    /**
     * Set kvalitet
     *
     * @param string $kvalitet
     *
     * @return VentilationTiltagDetail
     */
    public function setKvalitet($kvalitet)
    {
        $this->kvalitet = $kvalitet;

        return $this;
    }

    /**
     * Get kvalitet
     *
     * @return string
     */
    public function getKvalitet()
    {
        return $this->kvalitet;
    }

    /**
     * Set indDataFoer
     *
     * @param array $indDataFoer
     *
     * @return VentilationTiltagDetail
     */
    public function setIndDataFoer($indDataFoer)
    {
        $this->indDataFoer = $indDataFoer;

        return $this;
    }

    /**
     * Get indDataFoer
     *
     * @return array
     */
    public function getIndDataFoer()
    {
        return $this->indDataFoer;
    }

    /**
     * Get indDataFoer keys that should be filled in form.
     *
     * @return array
     */
    public static function getIndDataFoerInputKeys()
    {
        return array(
            'luftflow',
            'rumtemperatur',
            'driftstimerDag',
            'driftsdageUge',
            'genvindings',
            'sommerUnderkoeling',
            'trykabAnlaeg',
            'virkningsgradVentilator',
        );
    }

    /**
     * Get indDataFoer key value
     *
     * @return float
     */
    public function getIndDataFoerKeyValue($key)
    {
        return isset($this->indDataFoer[$key]) ? $this->indDataFoer[$key] : NULL;
    }

    public function getIndDataFoerLuftflow() { return $this->getIndDataFoerKeyValue('luftflow'); }
    public function getIndDataFoerRumtemperatur() { return $this->getIndDataFoerKeyValue('rumtemperatur'); }
    public function getIndDataFoerDriftstimerDag() { return $this->getIndDataFoerKeyValue('driftstimerDag'); }
    public function getIndDataFoerDriftsdageUge() { return $this->getIndDataFoerKeyValue('driftsdageUge'); }
    public function getIndDataFoerGenvindings() { return $this->getIndDataFoerKeyValue('genvindings'); }
    public function getIndDataFoerSommerUnderkoeling() { return $this->getIndDataFoerKeyValue('sommerUnderkoeling'); }
    public function getIndDataFoerTrykabAnlaeg() { return $this->getIndDataFoerKeyValue('trykabAnlaeg'); }
    public function getIndDataFoerVirkningsgradVentilator() { return $this->getIndDataFoerKeyValue('virkningsgradVentilator'); }
    public function getIndDataFoerOpvarmingIVentilator() { return $this->getIndDataFoerKeyValue('opvarmingIVentilator'); }

    /**
     * Set indDataEfter
     *
     * @param array $indDataEfter
     *
     * @return VentilationTiltagDetail
     */
    public function setIndDataEfter($indDataEfter)
    {
        $this->indDataEfter = $indDataEfter;

        return $this;
    }

    /**
     * Get indDataEfter
     *
     * @return array
     */
    public function getIndDataEfter()
    {
        return $this->indDataEfter;
    }

    /**
     * Get indDataEfter keys that should be filled in form.
     *
     * @return array
     */
    public static function getIndDataEfterInputKeys()
    {
        return array(
            'luftflow',
            'rumtemperatur',
            'driftstimerDag',
            'driftsdageUge',
            'genvindings',
            'sommerUnderkoeling',
            'virkningsgradVentilator',
        );
    }

    /**
     * Get indDataEfter key value
     *
     * @return float
     */
    public function getIndDataEfterKeyValue($key)
    {
        return isset($this->indDataEfter[$key]) ? $this->indDataEfter[$key] : NULL;
    }

    public function getIndDataEfterLuftflow() { return $this->getIndDataEfterKeyValue('luftflow'); }
    public function getIndDataEfterRumtemperatur() { return $this->getIndDataEfterKeyValue('rumtemperatur'); }
    public function getIndDataEfterDriftstimerDag() { return $this->getIndDataEfterKeyValue('driftstimerDag'); }
    public function getIndDataEfterDriftsdageUge() { return $this->getIndDataEfterKeyValue('driftsdageUge'); }
    public function getIndDataEfterGenvindings() { return $this->getIndDataEfterKeyValue('genvindings'); }
    public function getIndDataEfterSommerUnderkoeling() { return $this->getIndDataEfterKeyValue('sommerUnderkoeling'); }
    public function getIndDataEfterTrykabAnlaeg() { return $this->getIndDataEfterKeyValue('trykabAnlaeg'); }
    public function getIndDataEfterVirkningsgradVentilator() { return $this->getIndDataEfterKeyValue('virkningsgradVentilator'); }
    public function getIndDataEfterOpvarmingIVentilator() { return $this->getIndDataEfterKeyValue('opvarmingIVentilator'); }

    /**
     * Set udeluftbehov
     *
     * @param array $udeluftbehov
     *
     * @return VentilationTiltagDetail
     */
    public function setUdeluftbehov($udeluftbehov)
    {
        $this->udeluftbehov = $udeluftbehov;

        return $this;
    }

    /**
     * Get udeluftbehov
     *
     * @return array
     */
    public function getUdeluftbehov()
    {
        return $this->udeluftbehov;
    }

    /**
     * Set udeluftbehov Total l/s
     *
     * @return VentilationTiltagDetail
     */
    public function setUdeluftbehovTotalLps($udeluftbehovTotalLps)
    {
        $this->udeluftbehov['total'] = $udeluftbehovTotalLps;
        return $this;
    }

    /**
     * Get udeluftbehov total l/s
     *
     * @return float
     */
    public function getUdeluftbehovTotalLps()
    {
        if (!isset($this->udeluftbehov['total'])) {
            $this->udeluftbehov['total'] = $this->getUdeluftbehovGrundLps() + $this->getUdeluftbehovPersonLps();
        }
        return $this->udeluftbehov['total'];
    }

    /**
     * Get udeluftbehov total m3/h
     *
     * @return float
     */
    public function getUdeluftbehovTotalM3h()
    {
        return $this->getUdeluftbehovTotalLps() * 3600 / 1000;
    }

    /**
     * Get udeluftbehov total luftskifte per time
     *
     * @return float
     */
    public function getUdeluftbehovTotalSpt()
    {
        return $this->getUdeluftbehovTotalM3h() / $this->getVolumen();
    }

    /**
     * Get udeluftbehov Grund l/s.
     *
     * @return float
     */
    public function getUdeluftbehovGrundLps()
    {
        return isset($this->udeluftbehov['grund']) ? $this->udeluftbehov['grund'] : NULL;
    }

    /**
     * Set udeluftbehov Grund l/s
     *
     * @return VentilationTiltagDetail
     */
    public function setUdeluftbehovGrundLps($udeluftbehovGrundLps)
    {
        $this->udeluftbehov['grund'] = $udeluftbehovGrundLps;
        return $this;
    }

    /**
     * Get udeluftbehov Grund m3/h
     *
     * @return float
     */
    public function getUdeluftbehovGrundM3h()
    {
        return $this->getUdeluftbehovGrundLps() * 3600 / 1000;
    }

    /**
     * Get udeluftbehov Grund luftskifte per time
     *
     * @return float
     */
    public function getUdeluftbehovGrundSpt()
    {
        return $this->getUdeluftbehovGrundM3h() / $this->getVolumen();
    }

    /**
     * Get udeluftbehov Person l/s
     *
     * @return float
     */
    public function getUdeluftbehovPersonLps()
    {
        return isset($this->udeluftbehov['person']) ? $this->udeluftbehov['person'] : NULL;
    }

    /**
     * Set udeluftbehov Person l/s
     *
     * @return VentilationTiltagDetail
     */
    public function setUdeluftbehovPersonLps($udeluftbehovPersonLps)
    {
        $this->udeluftbehov['person'] = $udeluftbehovPersonLps;
        return $this;
    }

    /**
     * Get udeluftbehov Person m3/h
     *
     * @return float
     */
    public function getUdeluftbehovPersonM3h()
    {
        return $this->getUdeluftbehovPersonLps() * 3600 / 1000;
    }

    /**
     * Get udeluftbehov Person luftskifte per time
     *
     * @return float
     */
    public function getUdeluftbehovPersonSpt()
    {
        return $this->getUdeluftbehovPersonM3h() / $this->getVolumen();
    }

    /**
     * Get volumen.
     *
     * @return float
     */
    public function getVolumen()
    {
        return $this->calculateVolumen();
    }

    /**
     * Get elForbrugKwhAarFoer.
     *
     * @return float
     */
    public function getElForbrugKwhAarFoer()
    {
        if ($this->elForbrugKwhAarFoer == NULL) {
            $this->elForbrugKwhAarFoer = $this->calculateElForbrugKwhAarFoer();
        }
        return $this->elForbrugKwhAarFoer;
    }
    /**
     * Get elForbrugKwhAarEfter.
     *
     * @return float
     */
    public function getElForbrugKwhAarEfter()
    {
        if ($this->elForbrugKwhAarEfter == NULL) {
            $this->elForbrugKwhAarEfter = $this->calculateElForbrugKwhAarEfter();
        }
        return $this->elForbrugKwhAarEfter;
    }

    /**
     * Set varmeForbrugMaaneligeFoer
     *
     * @param array $varmeForbrugMaaneligeFoer
     *
     * @return VentilationTiltagDetail
     */
    public function setVarmeForbrugMaaneligeFoer($varmeForbrugMaaneligeFoer)
    {
        $this->varmeForbrugMaaneligeFoer = $varmeForbrugMaaneligeFoer;

        return $this;
    }

    /**
     * Get varmeForbrugMaaneligeFoer
     *
     * @return array
     */
    public function getVarmeForbrugMaaneligeFoer()
    {
        return $this->varmeForbrugMaaneligeFoer;
    }

    /**
     * Set varmeForbrugMaaneligeEfter
     *
     * @param array $varmeForbrugMaaneligeEfter
     *
     * @return VentilationTiltagDetail
     */
    public function setVarmeForbrugMaaneligeEfter($varmeForbrugMaaneligeEfter)
    {
        $this->varmeForbrugMaaneligeEfter = $varmeForbrugMaaneligeEfter;

        return $this;
    }

    /**
     * Get varmeForbrugMaaneligeEfter
     *
     * @return array
     */
    public function getVarmeForbrugMaaneligeEfter()
    {
        return $this->varmeForbrugMaaneligeEfter;
    }

    /**
     * Set co2PpmIRum
     *
     * @param integer $co2PpmIRum
     *
     * @return VentilationTiltagDetail
     */
    public function setCo2PpmIRum($co2PpmIRum)
    {
        $this->co2PpmIRum = $co2PpmIRum;

        return $this;
    }

    /**
     * Get co2PpmIRum
     *
     * @return integer
     */
    public function getCo2PpmIRum()
    {
        return $this->co2PpmIRum;
    }

    /**
     * Set varmebespKwhAar
     *
     * @param integer $varmebespKwhAar
     *
     * @return VentilationTiltagDetail
     */
    public function setVarmebespKwhAar($varmebespKwhAar)
    {
        $this->varmebespKwhAar = $varmebespKwhAar;

        return $this;
    }

    /**
     * Get varmebespKwhAar
     *
     * @return float
     */
    public function getVarmebespKwhAar() {
        return $this->varmebespKwhAar;
    }

    /**
     * Get varmebespKwhAarProcent
     *
     * @return float
     */
    public function getVarmebespKwhAarProcent() {
        if ($this->varmebespKwhAarProcent == NULL) {
            $this->varmebespKwhAarProcent = $this->calculateByFormula('varmebespKwhAarProcent');
        }
        return $this->varmebespKwhAarProcent;
    }

    /**
     * Get varmeForbrugKwhAarFoer.
     *
     * @return float
     */
    public function getVarmeForbrugKwhAarFoer()
    {
        if ($this->varmeForbrugKwhAarFoer == NULL) {
            $this->varmeForbrugKwhAarFoer = $this->calculateVarmeForbrugKwhAarFoer();
        }
        return $this->varmeForbrugKwhAarFoer;
    }
    /**
     * Get varmeForbrugKwhAarEfter.
     *
     * @return float
     */
    public function getVarmeForbrugKwhAarEfter()
    {
        if ($this->varmeForbrugKwhAarEfter == NULL) {
            $this->varmeForbrugKwhAarEfter = $this->calculateVarmeForbrugKwhAarEfter();
        }
        return $this->varmeForbrugKwhAarEfter;
    }

    /**
     * Set elbespKwhAar
     *
     * @param integer $elbespKwhAar
     *
     * @return VentilationTiltagDetail
     */
    public function setElbespKwhAar($elbespKwhAar)
    {
        $this->elbespKwhAar = $elbespKwhAar;

        return $this;
    }

    /**
     * Get elbespKwhAar
     *
     * @return float
     */
    public function getElbespKwhAar() {
        return $this->elbespKwhAar;
    }

    /**
     * Sets configuration.
     *
     * @param Configuration $configuration
     * @return $this
     */
    public function setConfiguration(Configuration $configuration) {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * Gets configuration.
     *
     * @return Configuration
     */
    public function getConfiguration() {
        return $this->configuration;
    }

    /**
     * Calculate stuff.
     */
    public function calculate() {
        $this->setUdeluftbehovGrundLps($this->calculateUdeluftBehovGrundLps());
        $this->setUdeluftbehovPersonLps($this->calculateUdeluftBehovPersonLps());
        $this->setUdeluftbehovTotalLps($this->calculateUdeluftBehovTotalLps());
        $this->co2PpmIRum = $this->calculateByFormula('co2PpmIRum');
        $this->indDataEfter['trykabAnlaeg'] = $this->calculateTrykabAnlaegEfter();
        $this->elForbrugKwhAarFoer = $this->calculateElForbrugKwhAarFoer();
        $this->elForbrugKwhAarEfter = $this->calculateElForbrugKwhAarEfter();
        $this->indDataFoer['opvarmingIVentilator'] = $this->calculateOpvarmingIVentilatorFoer();
        $this->indDataEfter['opvarmingIVentilator'] = $this->calculateOpvarmingIVentilatorEfter();
        $this->elbespKwhAar = $this->calculateByFormula('elbespKwhAar');
        $this->varmeForbrugMaaneligeFoer = $this->calculateVarmeForbrugMaaneligeFoer();
        $this->varmeForbrugKwhAarFoer = $this->calculateVarmeForbrugKwhAarFoer();
        $this->varmeForbrugMaaneligeEfter = $this->calculateVarmeForbrugMaaneligeEfter();
        $this->varmeForbrugKwhAarEfter = $this->calculateVarmeForbrugKwhAarEfter();
        $this->varmebespKwhAar = $this->calculateByFormula('varmebespKwhAar');
        $this->varmebespKwhAarProcent = $this->calculateByFormula('varmebespKwhAarProcent');
    }

    /**
     * @Formula("$this->getUdeluftbehovGrundLps() + $this->getUdeluftbehovPersonLps()")
     */
    protected function calculateUdeluftBehovTotalLps() {
        return $this->getUdeluftbehovGrundLps() + $this->getUdeluftbehovPersonLps();
    }

    /**
     * @Formula("$this->getCurrentGrundventilationMatrixValue() * $this->getLaengdeVentileretRum() * $this->getBreddeVentileretRum()")
     */
    protected function calculateUdeluftBehovGrundLps() {
        return $this->getCurrentGrundventilationMatrixValue() * $this->getLaengdeVentileretRum() * $this->getBreddeVentileretRum();
    }

    /**
     * @Formula("$this->getCurrentUdeluftTilfoerselLpsValue() * $this->getAntalPersoner() +  $this->getCurrentUdeluftTilfoerselLpsValue() * $this->getBreddeVentileretRum()")
     */
    protected function calculateUdeluftBehovPersonLps() {
        return $this->getCurrentUdeluftTilfoerselLpsValue() * $this->getAntalPersoner() +  $this->getCurrentUdeluftTilfoerselLpsValue() * $this->getBreddeVentileretRum();
    }

    /**
     * @Formula("$this->getLaengdeVentileretRum() * $this->getBreddeVentileretRum() * $this->getHoejdeVentileterRum()")
     */
    protected function calculateVolumen() {
        return $this->getLaengdeVentileretRum() * $this->getBreddeVentileretRum() * $this->getHoejdeVentileterRum();
    }

    protected function calculateTrykabAnlaegEfter() {
        if (empty($this->getIndDataFoerTrykabAnlaeg()) || empty($this->getIndDataFoerLuftflow()) || empty($this->getIndDataEfterLuftflow())) {
            return 0;
        }
        return $this->getIndDataFoerTrykabAnlaeg() * ($this->getIndDataEfterLuftflow() / $this->getIndDataFoerLuftflow()) ** 2;
    }

    protected function calculateElForbrugKwhAarFoer() {
        if (empty($this->getIndDataFoerVirkningsgradVentilator())) {
            return 0;
        }
        return ($this->getIndDataFoerLuftflow() / 3600 * $this->getIndDataFoerTrykabAnlaeg() / $this->getIndDataFoerVirkningsgradVentilator() / 1000) * 2 * $this->getIndDataFoerDriftstimerDag() * $this->getIndDataFoerDriftsdageUge() / 7 * 365;
    }

    protected function calculateElForbrugKwhAarEfter() {
        if (empty($this->getIndDataEfterVirkningsgradVentilator())) {
            return 0;
        }
        return ($this->getIndDataEfterLuftflow() / 3600 * $this->getIndDataEfterTrykabAnlaeg() / $this->getIndDataEfterVirkningsgradVentilator() / 1000) * 2 * $this->getIndDataEfterDriftstimerDag() * $this->getIndDataEfterDriftsdageUge() / 7 * 365;
    }

    protected function calculateOpvarmingIVentilatorFoer() {
        if (empty($this->getIndDataFoerLuftflow())
            || empty($this->getElForbrugKwhAarFoer())
            || empty($this->getIndDataFoerDriftstimerDag())
            || empty($this->getIndDataFoerDriftsdageUge())
        ) {
            return 0;
        }
        return $this->getElForbrugKwhAarFoer()/2/($this->getIndDataFoerDriftstimerDag()*$this->getIndDataFoerDriftsdageUge()/7*365)/$this->getIndDataFoerLuftflow() / 0.000336;
    }

    protected function calculateOpvarmingIVentilatorEfter() {
        if (empty($this->getIndDataEfterLuftflow())
            || empty($this->getElForbrugKwhAarEfter())
            || empty($this->getIndDataEfterDriftstimerDag())
            || empty($this->getIndDataEfterDriftsdageUge())
        ) {
            return 0;
        }
        return $this->getElForbrugKwhAarEfter() / 2 / ($this->getIndDataEfterDriftstimerDag() * $this->getIndDataEfterDriftsdageUge() / 7 * 365) / $this->getIndDataEfterLuftflow() / 0.000336;
    }

    protected function calculateVarmeForbrugMaaneligeFoer() {
        $months = MonthType::getMonthDays();
        $tUdeMontly = $this->getConfiguration()->getTUdeMonthly();
        $varmeForbrugMaanelige = array();
        foreach ($months as $month => $days) {
            $varmeForbrug = 0;
            if (($this->getIndDataFoerRumtemperatur() - $this->getIndDataFoerOpvarmingIVentilator() - $tUdeMontly[$month] ) >= $this->getIndDataFoerSommerUnderkoeling()) {
                $varmeForbrug = 0.000336 * $this->getIndDataFoerLuftflow()
                    * ($this->getIndDataFoerRumtemperatur() - $this->getIndDataFoerOpvarmingIVentilator() - $tUdeMontly[$month])
                    * (1 - $this->getIndDataFoerGenvindings()) * $this->getIndDataFoerDriftstimerDag() * $this->getIndDataFoerDriftsdageUge() / 7 * $days;
            }
            $varmeForbrugMaanelige[$month] = $varmeForbrug;
        }
        return $varmeForbrugMaanelige;
    }

    protected function calculateVarmeForbrugKwhAarFoer() {
        return array_sum($this->getVarmeForbrugMaaneligeFoer());
    }

    protected function calculateVarmeForbrugMaaneligeEfter() {
        $months = MonthType::getMonthDays();
        $tUdeMontly = $this->getConfiguration()->getTUdeMonthly();
        $varmeForbrugMaanelige = array();
        foreach ($months as $month => $days) {
            $varmeForbrug = 0;
            if (($this->getIndDataEfterRumtemperatur() - $this->getIndDataEfterOpvarmingIVentilator() - $tUdeMontly[$month]) >= $this->getIndDataEfterSommerUnderkoeling()) {
                $varmeForbrug = 0.000336 * $this->getIndDataEfterLuftflow()
                    * ($this->getIndDataEfterRumtemperatur() - $this->getIndDataEfterOpvarmingIVentilator() - $tUdeMontly[$month])
                    * (1 - $this->getIndDataEfterGenvindings()) * $this->getIndDataEfterDriftstimerDag() * $this->getIndDataEfterDriftsdageUge() / 7 * $days;
            }
            $varmeForbrugMaanelige[$month] = $varmeForbrug;
        }
        return $varmeForbrugMaanelige;
    }

    protected function calculateVarmeForbrugKwhAarEfter() {
        return array_sum($this->getVarmeForbrugMaaneligeEfter());
    }

    /**
     * Pre persist handler.
     *
     * @ORM\PrePersist
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event) {
        $repository = $event->getEntityManager()
            ->getRepository('AppBundle:Configuration');
        $this->setConfiguration($repository->getConfiguration());
    }

    /**
     * Post load handler.
     *
     * @ORM\PostLoad
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     */
    public function postLoad(LifecycleEventArgs $event) {
        $this->initFormulableCalculation();
        $repository = $event->getEntityManager()
            ->getRepository('AppBundle:Configuration');
        $this->setConfiguration($repository->getConfiguration());
        $this->calculate();
    }

}

