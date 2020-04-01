<?php

/**
 * @file
 * TrykluftTiltagDetail entity.
 *
 * See calculation file xls/TrykluftTiltagDetail/Energibesparelsesberegning_trykluftkompressor.xlsx.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Annotations\Formula;
use AppBundle\DBAL\Types\TrykluftTiltagDetail\ElReduktionType;
use AppBundle\Entity\Traits\FormulableCalculationEntity;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * TrykluftTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class TrykluftTiltagDetail extends TiltagDetail
{
    use FormulableCalculationEntity;

    /**
     * @var array
     *
     * @ORM\Column(name="trykLuftIndData", type="array")
     */
    private $indData;

    /**
     * @var array
     *
     * @ORM\Column(name="trykLuftElForbrug", type="array")
     */
    private $elForbrug;

    /**
     * @var array
     *
     * @ORM\Column(name="trykLuftElReduktion", type="array")
     */
    private $elReduktion;

    /**
     * @var array
     *
     * @ORM\Column(name="trykLuftVarmeReduktion", type="array")
     */
    private $varmeReduktion;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="varmebespKwhAar", type="float")
     */
    protected $varmebespKwhAar;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="varmebespKrAar", type="float")
     */
    protected $varmebespKrAar;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="elbespKwhAar", type="float")
     */
    protected $elbespKwhAar;

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
     * @var string
     *
     * @ORM\Column(name="Noter", type="text", nullable=true)
     */
    protected $noter;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="simpelTilbagebetalingstidAar", type="float")
     */
    protected $simpelTilbagebetalingstidAar;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        foreach (self::getIndDataInputKeys() as $key) {
            $this->indData[$key] = NULL;
        }
        foreach (self::getElForbrugDefault() as $key) {
            $this->elForbrug[$key] = NULL;
        }
        $elReduktionTypes = array_filter(array_keys(ElReduktionType::getChoices()));
        foreach ($elReduktionTypes as $key) {
            $this->elReduktion[$key] = self::getElReduktionTypeDefault();
        }
        $this->varmeReduktion = self::getVarmeReduktionDefault();
    }

    /**
     * Set indData
     *
     * @param integer $indData
     *
     * @return TrykluftTiltagDetail
     */
    public function setIndData($indData)
    {
        $this->indData = $indData;

        return $this;
    }

    /**
     * Get indData
     *
     * @return array
     */
    public function getIndData() {
        return $this->indData;
    }

    /**
     * Get indData keys that should be filled in form.
     *
     * @return array
     */
    public static function getIndDataInputKeys()
    {
        return array(
            'type',
            'kompressorNavn',
            'elForbrugBeregning',
            'paastempelEffekt',
            'tidsmaalingBelastet',
            'tidsmaalingAflastet',
            'gennemsnitligBelastning',
            'driftstimerDag',
            'driftsdageUge',
            'driftsUgeAar',
        );
    }

    /**
     * Get indData
     *
     * @return float
     */
    public function getIndDataKeyValue($key) {
        $indData = $this->getIndData();
        return isset($indData[$key]) ? $indData[$key] : NULL;
    }

    public function getIndDataType() { return $this->getIndDataKeyValue('type'); }
    public function getIndDataKompressorNavn() { return $this->getIndDataKeyValue('kompressorNavn'); }
    public function getIndDataElForbrugBeregning() { return $this->getIndDataKeyValue('elForbrugBeregning'); }
    public function getIndDataPaastempelEffekt() { return $this->getIndDataKeyValue('paastempelEffekt'); }
    public function getIndDataTidsmaalingBelastet() { return $this->getIndDataKeyValue('tidsmaalingBelastet'); }
    public function getIndDataTidsmaalingAflastet() { return $this->getIndDataKeyValue('tidsmaalingAflastet'); }
    public function getIndDataGennemsnitligBelastning() { return $this->getIndDataKeyValue('gennemsnitligBelastning'); }
    public function getIndDataDriftstimerDag() { return $this->getIndDataKeyValue('driftstimerDag'); }
    public function getIndDataDriftsdageUge() { return $this->getIndDataKeyValue('driftsdageUge'); }
    public function getIndDataDriftsUgeAar() { return $this->getIndDataKeyValue('driftsUgeAar'); }

    /**
     * Set elForbrug
     *
     * @param integer $elForbrug
     *
     * @return TrykluftTiltagDetail
     */
    public function setElForbrug($elForbrug)
    {
        $this->elForbrug = $elForbrug;

        return $this;
    }

    /**
     * Get elForbrug
     *
     * @return array
     */
    public function getElForbrug() {
        return array_filter($this->elForbrug, function($key) {
            if (in_array($key, array_keys($this->getElForbrugDefault()))) {
                return TRUE;
            }
            return FALSE;
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Get elForbrug keys that should be filled in form.
     *
     * @return array
     */
    public static function getElForbrugInputKeys()
    {
        return array(
            'herafBelastet',
            'herafAflastet',
        );
    }

    /**
     * Get elForbrug default value
     *
     * @return array
     */
    public function getElForbrugDefault() {
        return array(
            'herafBelastet' => NULL,
            'herafAflastet' => NULL,
            'skoennetAarsforbrug' => NULL,
        );
    }

    /**
     * Get elForbrug
     *
     * @return float
     */
    public function getElForbrugKeyValue($key) {
        $elForbrug = $this->getElForbrug();
        return isset($elForbrug[$key]) ? $elForbrug[$key] : NULL;
    }

    public function getElForbrugHerafBelastet() {
        if ($this->getIndDataElForbrugBeregning() == 'calculated'
            && $this->getElForbrugKeyValue('herafBelastet') == NULL) {
            $this->elForbrug['herafBelastet'] = $this->calculateHerafBelastet();
        }
        return $this->getElForbrugKeyValue('herafBelastet');
    }

    public function getElForbrugHerafAflastet() {
        if ($this->getIndDataElForbrugBeregning() == 'calculated'
            && $this->getElForbrugKeyValue('herafAflastet') == NULL) {
            $this->elForbrug['herafAflastet'] = $this->calculateHerafAflastet();
        }
        return $this->getElForbrugKeyValue('herafAflastet');
    }

    public function getElForbrugSkoennetAarsforbrug() {
        if ($this->getElForbrugKeyValue('skoennetAarsforbrug') == NULL) {
            $this->elForbrug['skoennetAarsforbrug'] = $this->calculateSkoennetAarsforbrug();
        }
        return $this->getElForbrugKeyValue('skoennetAarsforbrug');
    }

    /**
     * Get elReduktion default value
     *
     * @return array
     */
    public function getElReduktionTypeDefault() {
        return array(
            'enabled' => NULL,
            'reduktion' => NULL,
            'besparelseKwh' => NULL,
            'besparelseKr' => NULL,
            'investering' => NULL,
            'TBT' => NULL,
        );
    }

    /**
     * Get reduktion keys that should be filled in form.
     *
     * @return array
     */
    public static function getElReduktionInputKeys()
    {
        return array(
            'enabled',
            'reduktion',
            'investering',
        );
    }

    /**
     * Set elReduktion
     *
     * @param integer $elReduktion
     *
     * @return TrykluftTiltagDetail
     */
    public function setElReduktion($elReduktion)
    {
        $this->elReduktion = $elReduktion;

        return $this;
    }

    /**
     * Get elReduktion
     *
     * @return array
     */
    public function getElReduktion() {
        return $this->elReduktion;
    }

    /**
     * Get elReduktion type .
     *
     * @return array
     */
    public function getElReduktionKeyValue($type, $key)
    {
        $elReduktion = $this->getElReduktion();
        $elReduktionDefault = $this->getElReduktionTypeDefault();
        return isset($elReduktion[$type][$key]) ? $elReduktion[$type][$key] : $elReduktionDefault[$key];
    }

    // Set of get functions for ElReduktion "tryk" type.
    public function getElReduktionTrykEnabled() { return $this->getElReduktionKeyValue('tryk', 'enabled'); }
    public function getElReduktionTrykReduktion() {
        return $this->getElReduktionTrykEnabled() ? $this->getElReduktionKeyValue('tryk', 'reduktion') : 0;
    }
    public function getElReduktionTrykIvestering() { return $this->getElReduktionKeyValue('tryk', 'investering'); }
    public function getElReduktionTrykBesparelseKwh() { return $this->getElReduktionKeyValue('tryk', 'besparelseKwh');}
    public function getElReduktionTrykBesparelseKr() { return $this->getElReduktionKeyValue('tryk', 'besparelseKr');}
    public function getElReduktionTrykTBT() { return $this->getElReduktionKeyValue('tryk', 'TBT');}

    // Set of get functions for ElReduktion "temperatur" type.
    public function getElReduktionTemperaturEnabled() { return $this->getElReduktionKeyValue('temperatur', 'enabled'); }
    public function getElReduktionTemperaturReduktion() {
        return $this->getElReduktionTemperaturEnabled() ?  $this->getElReduktionKeyValue('temperatur', 'reduktion') : 0;
    }
    public function getElReduktionTemperaturIvestering() { return $this->getElReduktionKeyValue('temperatur', 'investering'); }
    public function getElReduktionTemperaturBesparelseKwh() { return $this->getElReduktionKeyValue('temperatur', 'besparelseKwh');}
    public function getElReduktionTemperaturBesparelseKr() { return $this->getElReduktionKeyValue('temperatur', 'besparelseKr');}
    public function getElReduktionTemperaturTBT() { return $this->getElReduktionKeyValue('temperatur', 'TBT');}

    // Set of get functions for ElReduktion "laekagetab" type.
    public function getElReduktionLaekagetabEnabled() { return $this->getElReduktionKeyValue('laekagetab', 'enabled'); }
    public function getElReduktionLaekagetabReduktion() {
        return $this->getElReduktionLaekagetabEnabled() ?  $this->getElReduktionKeyValue('laekagetab', 'reduktion') : 0;
    }
    public function getElReduktionLaekagetabIvestering() { return $this->getElReduktionKeyValue('laekagetab', 'investering'); }
    public function getElReduktionLaekagetabBesparelseKwh() { return $this->getElReduktionKeyValue('laekagetab', 'besparelseKwh'); }
    public function getElReduktionLaekagetabBesparelseKr() { return $this->getElReduktionKeyValue('laekagetab', 'besparelseKr');}
    public function getElReduktionLaekagetabTBT() { return $this->getElReduktionKeyValue('laekagetab', 'TBT'); }

    // Set of get functions for ElReduktion "stop" type.
    public function getElReduktionStopEnabled() { return $this->getElReduktionKeyValue('stop', 'enabled'); }
    public function getElReduktionStopReduktion() {
        return $this->getElReduktionStopEnabled() ?  $this->getElReduktionKeyValue('stop', 'reduktion') : 0;
    }
    public function getElReduktionStopIvestering() { return $this->getElReduktionKeyValue('stop', 'investering'); }
    public function getElReduktionStopBesparelseKwh() { return $this->getElReduktionKeyValue('stop', 'besparelseKwh');}
    public function getElReduktionStopBesparelseKr() { return $this->getElReduktionKeyValue('stop', 'besparelseKr'); }
    public function getElReduktionStopTBT() { return $this->getElReduktionKeyValue('stop', 'TBT'); }

    // Set of get functions for ElReduktion "frekvensstyring" type.
    public function getElReduktionFrekvensstyringEnabled() { return $this->getElReduktionKeyValue('frekvensstyring', 'enabled'); }
    public function getElReduktionFrekvensstyringReduktion() {
        return $this->getElReduktionFrekvensstyringEnabled() ?  $this->getElReduktionKeyValue('frekvensstyring', 'reduktion') : 0;
    }
    public function getElReduktionFrekvensstyringIvestering() { return $this->getElReduktionKeyValue('frekvensstyring', 'investering'); }
    public function getElReduktionFrekvensstyringBesparelseKwh() {return $this->getElReduktionKeyValue('frekvensstyring', 'besparelseKwh');}
    public function getElReduktionFrekvensstyringBesparelseKr() { return $this->getElReduktionKeyValue('frekvensstyring', 'besparelseKr'); }
    public function getElReduktionFrekvensstyringTBT() { return $this->getElReduktionKeyValue('frekvensstyring', 'TBT'); }

    /**
     * Get varmReduktion default value
     *
     * @return array
     */
    public function getVarmeReduktionDefault() {
        return array(
            'type' => 'none',
            'reduktion' => NULL,
            'besparelseKwh' => NULL,
            'besparelseKr' => NULL,
            'investering' => NULL,
            'TBT' => NULL,
        );
    }

    /**
     * Get reduktion keys that should be filled in form.
     *
     * @return array
     */
    public static function getVarmeReduktionInputKeys()
    {
        return array(
            'type',
            'reduktion',
            'investering',
        );
    }

    /**
     * Set varmeReduktion
     *
     * @param integer $varmeReduktion
     *
     * @return TrykluftTiltagDetail
     */
    public function setVarmeReduktion($varmeReduktion)
    {
        $this->varmeReduktion = $varmeReduktion;

        return $this;
    }

    /**
     * Get varmeReduktion
     *
     * @return array
     */
    public function getVarmeReduktion() {
        return $this->varmeReduktion;
    }

    /**
     * Get varmeReduktion type .
     *
     * @return array
     */
    public function getVarmeReduktionKeyValue($key)
    {
        $varmeReduktion = $this->getVarmeReduktion();
        $varmeReduktionDefault = $this->getElReduktionTypeDefault();
        return isset($varmeReduktion[$key]) ? $varmeReduktion[$key] : $varmeReduktionDefault[$key];
    }

    // Set of get functions for VarmeReduktion.
    public function getVarmeReduktionType() { return $this->getVarmeReduktionKeyValue('type'); }
    public function getVarmeReduktionReduktion() { return $this->getVarmeReduktionKeyValue('reduktion'); }
    public function getVarmeReduktionIvestering() { return $this->getVarmeReduktionKeyValue('investering'); }
    public function getVarmeReduktionBesparelseKwh() { return $this->getVarmeReduktionKeyValue('besparelseKwh');}
    public function getVarmeReduktionBesparelseKr() { return $this->getVarmeReduktionKeyValue('besparelseKr'); }
    public function getVarmeReduktionTBT() { return $this->getVarmeReduktionKeyValue('TBT'); }

    /**
     * Set varmebespKwhAar
     *
     * @param integer $varmebespKwhAar
     *
     * @return TrykluftTiltagDetail
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
     * Set varmebespKrAar
     *
     * @param integer $varmebespKrAar
     *
     * @return TrykluftTiltagDetail
     */
    public function setVarmebespKrAar($varmebespKrAar)
    {
        $this->varmebespKrAar = $varmebespKrAar;

        return $this;
    }

    /**
     * Get varmebespKrAar
     *
     * @return float
     */
    public function getVarmebespKrAar() {
        return $this->varmebespKrAar;
    }

    /**
     * Set elbespKwhAar
     *
     * @param integer $elbespKwhAar
     *
     * @return TrykluftTiltagDetail
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
     * Set elbespKrAar
     *
     * @param integer $elbespKrAar
     *
     * @return TrykluftTiltagDetail
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
     * Set noter
     *
     * @param string $noter
     * @return TrykluftTiltagDetail
     */
    public function setNoter($noter) {
        $this->noter = $noter;

        return $this;
    }

    /**
     * Get noter
     *
     * @return string
     */
    public function getNoter() {
        return $this->noter;
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
     * Calculate stuff.
     *
     * See calculation file xls/TrykluftTiltagDetail/Energibesparelsesberegning_trykluftkompressor.xlsx
     */
    public function calculate() {
        if ($this->getIndDataElForbrugBeregning() == 'calculated') {
            $this->elForbrug['herafBelastet'] = $this->calculateHerafBelastet();
            $this->elForbrug['herafAflastet'] = $this->calculateHerafAflastet();
        }
        $this->elForbrug['skoennetAarsforbrug'] = $this->calculateSkoennetAarsforbrug();
        $this->elReduktion['tryk']['besparelseKwh'] = $this->calculateElReduktionTrykBesparelseKwh();
        $this->elReduktion['tryk']['besparelseKr'] = $this->calculateElKwhToKr($this->getElReduktionTrykBesparelseKwh());
        $this->elReduktion['tryk']['TBT'] = $this->calculateTBT($this->getElReduktionTrykIvestering(), $this->getElReduktionTrykBesparelseKr());
        $this->elReduktion['temperatur']['besparelseKwh'] = $this->calculateElReduktionTemperaturBesparelseKwh();
        $this->elReduktion['temperatur']['besparelseKr'] = $this->calculateElKwhToKr($this->getElReduktionTemperaturBesparelseKwh());
        $this->elReduktion['temperatur']['TBT'] = $this->calculateTBT($this->getElReduktionTemperaturIvestering(), $this->getElReduktionTemperaturBesparelseKr());
        $this->elReduktion['laekagetab']['besparelseKwh'] = $this->calculateElReduktionLaekagetabBesparelseKwh();
        $this->elReduktion['laekagetab']['besparelseKr'] = $this->calculateElKwhToKr($this->getElReduktionLaekagetabBesparelseKwh());
        $this->elReduktion['laekagetab']['TBT'] = $this->calculateTBT($this->getElReduktionLaekagetabIvestering(), $this->getElReduktionLaekagetabBesparelseKr());
        $this->elReduktion['stop']['besparelseKwh'] = $this->calculateElReduktionStopBesparelseKwh();
        $this->elReduktion['stop']['besparelseKr'] = $this->calculateElKwhToKr($this->getElReduktionStopBesparelseKwh());
        $this->elReduktion['stop']['TBT'] = $this->calculateTBT($this->getElReduktionStopIvestering(), $this->getElReduktionStopBesparelseKr());
        $this->elReduktion['frekvensstyring']['besparelseKwh'] = $this->calculateElReduktionFrekvensstyringBesparelseKwh();
        $this->elReduktion['frekvensstyring']['besparelseKr'] = $this->calculateElKwhToKr($this->getElReduktionFrekvensstyringBesparelseKwh());
        $this->elReduktion['frekvensstyring']['TBT'] = $this->calculateTBT($this->getElReduktionFrekvensstyringIvestering(), $this->getElReduktionFrekvensstyringBesparelseKr());
        $this->varmeReduktion['besparelseKwh'] = $this->calculateVarmeReduktionBesparelseKwh();
        $this->varmeReduktion['besparelseKr'] = $this->calculateVarmeKwhToKr($this->getVarmeReduktionBesparelseKwh());
        $this->varmeReduktion['TBT'] = $this->calculateTBT($this->getVarmeReduktionIvestering(), $this->getVarmeReduktionBesparelseKr());
        $this->elbespKwhAar = $this->calculateElbespKwhAar();
        $this->elbespKrAar = $this->calculateElbespKrAar();
        $this->varmebespKwhAar = $this->getVarmeReduktionBesparelseKwh();
        $this->varmebespKrAar = $this->calculateVarmebespKrAar();
        $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
        parent::calculate();
    }

    /**
     * Calculation depends on calculation type.
     */
    function calculateHerafBelastet() {
        $herafBelastet = NULL;
        switch ($this->getIndDataType()) {
            case 'on_off':
                $herafBelastet = $this->calculateHerafBelastetOnOff();
                break;

            case 'frekvensstyret':
                $herafBelastet = $this->calculateHerafBelastetFrekvensstyret();
                break;
        }
        return $herafBelastet;
    }

    /**
     * @Formula("($this->getIndDataTidsmaalingBelastet() / ($this->getIndDataTidsmaalingBelastet() + $this->getIndDataTidsmaalingAflastet())) * $this->getIndDataPaastempelEffekt() * $this->getIndDataDriftstimerDag() * $this->getIndDataDriftsdageUge() * $this->getIndDataDriftsUgeAar()")
     *
     * See calculation file, cell C18.
     */
    function calculateHerafBelastetOnOff() {
        return $this->divide($this->getIndDataTidsmaalingBelastet(), ($this->getIndDataTidsmaalingBelastet() + $this->getIndDataTidsmaalingAflastet()))
            *  $this->getIndDataPaastempelEffekt() * $this->getIndDataDriftstimerDag() * $this->getIndDataDriftsdageUge() * $this->getIndDataDriftsUgeAar();
    }

    /**
     * @Formula("($this->getIndDataTidsmaalingBelastet() / ($this->getIndDataTidsmaalingBelastet() + $this->getIndDataTidsmaalingAflastet())) * $this->getIndDataPaastempelEffekt() * $this->getIndDataDriftstimerDag() * $this->getIndDataDriftsdageUge() * $this->getIndDataDriftsUgeAar()")
     *
     * See calculation file, cell C53.
     */
    function calculateHerafBelastetFrekvensstyret() {
        return $this->getIndDataGennemsnitligBelastning() * $this->getIndDataDriftstimerDag() * $this->getIndDataDriftsdageUge() * $this->getIndDataDriftsUgeAar();
    }

    /**
     * Calculation depends on calculation type.
     */
    function calculateHerafAflastet() {
        $herafBelastet = NULL;
        switch ($this->getIndDataType()) {
            case 'on_off':
                $herafBelastet = $this->calculateHerafAflastetOnOff();
                break;

            case 'frekvensstyret':
                $herafBelastet = $this->calculateHerafAflastetFrekvensstyret();
                break;
        }
        return $herafBelastet;    }

    /**
     * @Formula("($this->getIndDataTidsmaalingAflastet() / ($this->getIndDataTidsmaalingBelastet() + $this->getIndDataTidsmaalingAflastet())) * 0.25 * $this->getIndDataPaastempelEffekt() * $this->getIndDataDriftstimerDag() * $this->getIndDataDriftsdageUge() * $this->getIndDataDriftsUgeAar()")
     *
     * See calculation file, cell C19.
     */
    function calculateHerafAflastetOnOff() {
        return $this->divide($this->getIndDataTidsmaalingAflastet(), ($this->getIndDataTidsmaalingBelastet() + $this->getIndDataTidsmaalingAflastet()))
            * 0.25 * $this->getIndDataPaastempelEffekt() * $this->getIndDataDriftstimerDag() * $this->getIndDataDriftsdageUge() * $this->getIndDataDriftsUgeAar();;
    }

    /**
     * Not used for Frekvensstyret calculation type.
     *
     * See calculation file, cell C54.
     */
    function calculateHerafAflastetFrekvensstyret() {
        return NULL;
    }

    /**
     * @Formula("$this->getElForbrugHerafAflastet() + $this->getElForbrugHerafBelastet()")
     *
     * See calculation file, cell C17.
     */
    function calculateSkoennetAarsforbrug() {
        return $this->getElForbrugHerafAflastet() + $this->getElForbrugHerafBelastet();
    }

    /**
     * @Formula("0.06 * $this->getElForbrugHerafBelastet() * $this->getElReduktionTrykReduktion()")
     *
     * See calculation file, cell C23.
     */
    function calculateElReduktionTrykBesparelseKwh() {
        return 0.06 * $this->getElForbrugHerafBelastet() * $this->getElReduktionTrykReduktion();
    }

    /**
     * @Formula("0.01 * $this->getElReduktionTemperaturReduktion() * ($this->getElForbrugSkoennetAarsforbrug() - $this->getElReduktionTrykBesparelseKwh())")
     *
     * See calculation file, cell C24.
     */
    function calculateElReduktionTemperaturBesparelseKwh() {
        return 0.01 * $this->getElReduktionTemperaturReduktion() * ($this->getElForbrugSkoennetAarsforbrug() - $this->getElReduktionTrykBesparelseKwh());
    }

    /**
     * @Formula("$this->getElReduktionLaekagetabReduktion() / 100 * ($this->getElForbrugSkoennetAarsforbrug() - $this->getElReduktionTrykBesparelseKwh()  - $this->getElReduktionTemperaturBesparelseKwh())")
     *
     * See calculation file, cell C25.
     */
    function calculateElReduktionLaekagetabBesparelseKwh() {
        return $this->getElReduktionLaekagetabReduktion() / 100 * ($this->getElForbrugSkoennetAarsforbrug() - $this->getElReduktionTrykBesparelseKwh()  - $this->getElReduktionTemperaturBesparelseKwh());
    }

    /**
     * @Formula("$this->getElReduktionLaekagetabBesparelseKwh() * $this->getElReduktionLaekagetabReduktion() / 100")
     *
     * See calculation file, cell C26.
     */
    function calculateElReduktionStopBesparelseKwh() {
        return $this->getElReduktionLaekagetabBesparelseKwh() * $this->getElReduktionStopReduktion() / 100;
    }

    /**
     * @Formula("$this->getElReduktionFrekvensstyringReduktion() / 100 * $this->getElForbrugHerafAflastet()")
     *
     * See calculation file, cell C27.
     */
    function calculateElReduktionFrekvensstyringBesparelseKwh() {
        return $this->getElReduktionFrekvensstyringReduktion() / 100 * $this->getElForbrugHerafAflastet();
    }

    /**
     * @Formula("$this->getElForbrugHerafBelastet() * $this->getElReduktionFrekvensstyringReduktion()")
     *
     * See calculation file, cell E33.
     */
    function calculateVarmeReduktionBesparelseKwh() {
        $besparelse = 0;
        if ($this->getVarmeReduktionType() && $this->getVarmeReduktionType() != 'none') {
            $besparelse = $this->getElForbrugHerafBelastet() * $this->getVarmeReduktionReduktion();
        }
        return $besparelse;
    }

    /**
     * Converts kWh to kr for el.
     *
     * See calculation file, cell F23 - F27.
     */
    function calculateElKwhToKr($kWh) {
        return $kWh * $this->getTiltag()->getElPris();
    }

    /**
     * Converts kWh to kr for varme.
     *
     * See calculation file, cell F33 - F34.
     */
    function calculateVarmeKwhToKr($kWh) {
        return $kWh * $this->getTiltag()->getVarmePris();
    }

    /**
     * Calculates TBT.
     *
     * See calculation file, cell F33 - F34.
     */
    function calculateTBT($investering, $besparelseKr) {
        return $this->divide($investering, $besparelseKr);
    }

    function calculateElbespKwhAar() {
        $elbespareseKwh = [];
        $elReduktionTypes = array_filter(array_keys(ElReduktionType::getChoices()));
        $elReduktion = $this->getElReduktion();
        foreach ($elReduktionTypes as $type) {
            $elbespareseKwh[] = $elReduktion[$type]['besparelseKwh'];
        }
        return array_sum($elbespareseKwh);
    }

    function calculateElbespKrAar() {
        return $this->calculateElKwhToKr($this->getElbespKwhAar());
    }

    function calculateVarmebespKrAar() {
        return $this->calculateVarmeKwhToKr($this->getVarmebespKwhAar());
    }

    private function calculateSimpelTilbagebetalingstidAar() {
        $investering = [];
        $elReduktionTypes = array_filter(array_keys(ElReduktionType::getChoices()));
        $elReduktion = $this->getElReduktion();
        foreach ($elReduktionTypes as $type) {
            $investering[] = $elReduktion[$type]['investering'];
        }
        $investering[] = $this->getVarmeReduktionIvestering();
        $besparelseKr = $this->getElbespKrAar() + $this->getVarmebespKrAar();
        return $this->divide(array_sum($investering), $besparelseKr);
    }

    /**
     * Post load handler.
     *
     * @ORM\PostLoad
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     */
    public function postLoad(LifecycleEventArgs $event) {
        $this->initFormulableCalculation();
    }

}

