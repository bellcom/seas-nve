<?php

/**
 * @file
 * VarmePumpeTiltagDetail entity.
 *
 * See calculation file xls/VarmePumpeTiltagDetail/Energibesparelsesberegning_Varmekompressor.xlsx.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Annotations\Formula;
use AppBundle\DBAL\Types\VarmePumpeTiltag\EnergiType;
use AppBundle\Entity\Traits\FormulableCalculationEntity;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * VarmePumpeTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class VarmePumpeTiltagDetail extends VarmeTiltagDetail
{

    /**
     * @var string
     *
     * @ORM\Column(name="energiTypePrimaerFoer", type="string")
     */
        private $energiTypePrimaerFoer;

    /**
     * @var array
     *
     * @ORM\Column(name="energiForbrugPrimaerFoer", type="array")
     */
    private $energiForbrugPrimaerFoer;

    /**
     * @var array
     *
     * @ORM\Column(name="varmePumpeForbrug", type="array")
     */
    private $varmePumpeForbrug;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        foreach (array_filter(array_keys(EnergiType::getChoices())) as $key) {
            $this->energiForbrugPrimaerFoer[$key] = $this->getEnergiForbrugTypeDefault();
        }
        $this->varmePumpeForbrug = $this->getEnergiForbrugTypeDefault();

    }

    /**
     * Set energiTypePrimaerFoer
     *
     * @param integer $energiTypePrimaerFoer
     *
     * @return VarmeTiltagDetail
     */
    public function setEnergiTypePrimaerFoer($energiTypePrimaerFoer)
    {
        $this->energiTypePrimaerFoer = $energiTypePrimaerFoer;

        return $this;
    }

    /**
     * Get energiTypePrimaerFoer
     *
     * @return string
     */
    public function getEnergiTypePrimaerFoer() {
        return $this->energiTypePrimaerFoer;
    }

    /**
     * Set energiForbrugPrimaerFoer
     *
     * @param integer $energiForbrugPrimaerFoer
     *
     * @return VarmeTiltagDetail
     */
    public function setEnergiForbrugPrimaerFoer($energiForbrugPrimaerFoer)
    {
        $this->energiForbrugPrimaerFoer = $energiForbrugPrimaerFoer;

        return $this;
    }

    /**
     * Get energiForbrugPrimaerFoer
     *
     * @return array
     */
    public function getEnergiForbrugPrimaerFoer()
    {
        return $this->energiForbrugPrimaerFoer;
    }

    /**
     * Get EnergiForbrug keys that should be filled in form.
     *
     * @return array
     */
    public static function getEnergiForbrugTypeInputKeys()
    {
        return array(
            'forbrug',
            'faktor',
        );
    }

    /**
     * Get EnergiForbrug default value.
     *
     * @return array
     */
    public static function getEnergiForbrugTypeDefault()
    {
        return array(
            'forbrug' => NULL,
            'faktor' => NULL,
            'forbrugKWh' => NULL,
            'forbrugKr' => NULL,
        );
    }

    /**
     * Get energiForbrugPrimaerFoer key value
     *
     * @return float
     */
    public function getEnergiForbrugPrimaerFoerTypeKeyValue($type, $key)
    {
        return isset($this->energiForbrugPrimaerFoer[$type][$key]) ? $this->energiForbrugPrimaerFoer[$type][$key] : NULL;
    }

    /**
     * Get energiForbrugPrimaerFoerKwh
     *
     * @return float
     */
    public function getEnergiForbrugPrimaerFoerKwh()
    {
        return $this->getEnergiForbrugPrimaerFoerTypeKeyValue($this->getEnergiTypePrimaerFoer(), 'forbrugKWh');
    }

    /**
     * Get energiForbrugPrimaerFoerKr
     *
     * @return float
     */
    public function getEnergiForbrugPrimaerFoerKr()
    {
        return $this->getEnergiForbrugPrimaerFoerTypeKeyValue($this->getEnergiTypePrimaerFoer(), 'forbrugKr');
    }

    /**
     * Get energiForbrugPrimaerFoerPris
     *
     * @return float
     */
    public function getEnergiForbrugPrimaerFoerPris()
    {
        $priser = $this->getTiltag()->getPriserOverride();
        $type = $this->getEnergiTypePrimaerFoer();
        return isset($priser[$type]['pris']) ? $priser[$type]['pris'] : 0;
    }

    /**
     * Set varmePumpeForbrug
     *
     * @param integer $varmePumpeForbrug
     *
     * @return VarmeTiltagDetail
     */
    public function setVarmePumpeForbrug($varmePumpeForbrug)
    {
        $this->varmePumpeForbrug = $varmePumpeForbrug;

        return $this;
    }

    /**
     * Get varmePumpeForbrug
     *
     * @return array
     */
    public function getVarmePumpeForbrug()
    {
        return $this->varmePumpeForbrug;
    }

    /**
     * Get varmePumpeForbrug keys that should be filled in form.
     *
     * @return array
     */
    public static function getVarmePumpeForbrugInputKeys()
    {
        return array(
            'opvarmetArealBrutto',
            'varmeTabM2',
            'type',
            'effektFaktor',
        );
    }

    /**
     * Get varmePumpeForbrug default value.
     *
     * @return array
     */
    public static function getVarmePumpeForbrugDefault()
    {
        return array(
            'opvarmetArealBrutto' => NULL,
            'opvarmetArealNetto' => NULL,
            'varmeTabM2' => NULL,
            'varmeTab' => NULL,
            'opvarmingForbrug' => NULL,
            'vandOpvarmingForbrug' => NULL,
            'nettoEnergiforbrug' => NULL,
            'forbrugKWh' => NULL,
            'type' => NULL,
            'effektFaktor' => NULL,
            'forbrugKr' => NULL,
        );
    }

    /**
     * Get varmePumpeForbrug key value
     *
     * @return float
     */
    public function getVarmePumpeForbrugKeyValue($key)
    {
        return isset($this->varmePumpeForbrug[$key]) ? $this->varmePumpeForbrug[$key] : NULL;
    }

    // Set of get functions for varmePumpeForbrug.
    public function getVarmePumpeForbrugOpvarmetArealBrutto() { return $this->getVarmePumpeForbrugKeyValue('opvarmetArealBrutto'); }
    public function getVarmePumpeForbrugOpvarmetArealNetto() { return $this->getVarmePumpeForbrugKeyValue('opvarmetArealNetto'); }
    public function getVarmePumpeForbrugVarmeTabM2() { return $this->getVarmePumpeForbrugKeyValue('varmeTabM2'); }
    public function getVarmePumpeForbrugVarmeTab() { return $this->getVarmePumpeForbrugKeyValue('varmeTab'); }
    public function getVarmePumpeForbrugOpvarmingForbrug() { return $this->getVarmePumpeForbrugKeyValue('opvarmingForbrug'); }
    public function getVarmePumpeForbrugVandOpvarmingForbrug() { return $this->getVarmePumpeForbrugKeyValue('vandOpvarmingForbrug'); }
    public function getVarmePumpeForbrugNettoEnergiforbrug() { return $this->getVarmePumpeForbrugKeyValue('nettoEnergiforbrug'); }
    public function getVarmePumpeForbrugEffektFaktor() { return $this->getVarmePumpeForbrugKeyValue('effektFaktor'); }
    public function getVarmePumpeForbrugType() { return $this->getVarmePumpeForbrugKeyValue('type'); }
    public function getVarmePumpeForbrugKWh() { return $this->getVarmePumpeForbrugKeyValue('forbrugKWh'); }
    public function getVarmePumpeForbrugKr() { return $this->getVarmePumpeForbrugKeyValue('forbrugKr'); }

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
     *
     * See calculation file xls/VarmePumpe/Bereging_af_armepumpe_redigeret_til_screeningsvaerktoej_V.1.xls
     */
    public function calculate() {
        $this->calculatEnergiForbrugPrimaerFoerForbrugKWh();
        $this->calculatEnergiForbrugPrimaerFoerForbrugKr();
        $this->calculateVarmeTab();
        $this->calculateOpvarmingForbrug();
        $this->calculateVandOpvarmingForbrug();
        $this->calculateNettoEnergiForbrug();
        $this->calculateVarmePumpeForbrugKWh();
        $this->calculateVarmePumpeForbrugKr();
        $this->calculateVarmebespKwhAar();
        $this->calculateVarmebespKrAar();
    }

    /**
     * See calculation file, cell G11 - G31.
     */
    public function calculatEnergiForbrugPrimaerFoerForbrugKWh() {
        $type = $this->getEnergiTypePrimaerFoer();
        $forbrug = $this->getEnergiForbrugPrimaerFoerTypeKeyValue($type, 'forbrug');
        $faktor = $this->getEnergiForbrugPrimaerFoerTypeKeyValue($type, 'faktor');
        $varmeEnergiFaktor = $this->getConfiguration()->getVarmeEnergiFaktor();
        $this->energiForbrugPrimaerFoer[$type]['forbrugKWh'] = $forbrug * $faktor * $varmeEnergiFaktor[$type];
    }

    /**
     * See calculation file, cell K11 - K31.
     */
    public function calculatEnergiForbrugPrimaerFoerForbrugKr() {
        $type = $this->getEnergiTypePrimaerFoer();
        $forbrug = $this->getEnergiForbrugPrimaerFoerTypeKeyValue($type, 'forbrug');
        $this->energiForbrugPrimaerFoer[$type]['forbrugKr'] = $forbrug * $this->getEnergiForbrugPrimaerFoerPris();
    }

    /**
     * See calculation file, cell U16.
     */
    public function calculateVarmeTab() {
        $this->varmePumpeForbrug['opvarmetArealNetto'] = $this->getVarmePumpeForbrugOpvarmetArealBrutto() * (1 - 0.15);
        $this->varmePumpeForbrug['varmeTab'] = $this->getVarmePumpeForbrugOpvarmetArealNetto() * $this->getVarmePumpeForbrugVarmeTabM2();
    }

    /**
     * See calculation file, cell O23.
     */
    public function calculateOpvarmingForbrug() {
        $this->varmePumpeForbrug['opvarmingForbrug'] = $this->getVarmePumpeForbrugVarmeTab() * 1.1 * 2830 * 24/32/1000;
    }

    /**
     * See calculation file, cell T28.
     */
    public function calculateVandOpvarmingForbrug() {
        $this->varmePumpeForbrug['vandOpvarmingForbrug'] = 4 * 1000;
    }

    /**
     * See calculation file, cell T30.
     */
    public function calculateNettoEnergiForbrug() {
        $this->varmePumpeForbrug['nettoEnergiforbrug'] = $this->getVarmePumpeForbrugOpvarmingForbrug() + $this->getVarmePumpeForbrugVandOpvarmingForbrug();
    }

    /**
     * See calculation file, cell R35.
     */
    public function calculateVarmePumpeForbrugKWh() {
        $this->varmePumpeForbrug['forbrugKWh'] = $this->divide($this->getVarmePumpeForbrugNettoEnergiforbrug(), $this->getVarmePumpeForbrugEffektFaktor());
    }

    /**
     * See calculation file, cell U35.
     */
    public function calculateVarmePumpeForbrugKr() {
        $priser = $this->getTiltag()->getPriserOverride();
        $this->varmePumpeForbrug['forbrugKr'] = $this->getVarmePumpeForbrugKWh() * $priser['elrumvarme']['pris'];
    }

    /**
     * See calculation file, cell U38.
     */
    public function calculateVarmebespKwhAar() {
        $this->varmebespKwhAar = $this->getEnergiForbrugPrimaerFoerKwh() - $this->getVarmePumpeForbrugKWh();
    }

    /**
     * See calculation file, cell U39.
     */
    public function calculateVarmebespKrAar() {
        $type = $this->getEnergiTypePrimaerFoer();
        $this->varmebespKrAar = $this->getEnergiForbrugPrimaerFoerTypeKeyValue($type, 'forbrugKr') - $this->getVarmePumpeForbrugKr();
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
    }

}

