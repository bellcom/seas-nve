<?php

/**
 * @file
 * VarmeanlaegTiltagDetail entity.
 *
 * See calculation file xls/VarmeanlaegTiltagDetail/.xlsx.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Annotations\Formula;
use AppBundle\DBAL\Types\VarmeanlaegTiltag\EnergiType;
use AppBundle\Entity\Traits\FormulableCalculationEntity;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * VarmeanlaegTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class VarmeanlaegTiltagDetail extends TiltagDetail
{
    use FormulableCalculationEntity;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="varmebespKWhAar", type="float")
     */
    protected $varmebespKWhAar;

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
     * @ORM\Column(name="elbespKWhAar", type="float")
     */
    protected $elbespKWhAar;

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
     * @var string
     *
     * @ORM\Column(name="energiTypeSekundaerFoer", type="string")
     */
    private $energiTypeSekundaerFoer;

    /**
     * @var array
     *
     * @ORM\Column(name="energiForbrugSekundaerFoer", type="array")
     */
    private $energiForbrugSekundaerFoer;

    /**
     * @var float
     *
     * @ORM\Column(name="nyVarmeKildePrimaerAndel", type="float")
     */
    private $nyVarmeKildePrimaerAndel;

    /**
     * @var float
     */
    private $nyVarmeKildeSekundaerAndel;

    /**
     * @var string
     *
     * @ORM\Column(name="energiTypePrimaerEfter", type="string")
     */
    private $energiTypePrimaerEfter;

    /**
     * @var array
     *
     * @ORM\Column(name="energiForbrugPrimaerEfter", type="array")
     */
    private $energiForbrugPrimaerEfter;

    /**
     * @var string
     *
     * @ORM\Column(name="energiTypeSekundaerEfter", type="string")
     */
    private $energiTypeSekundaerEfter;

    /**
     * @var array
     *
     * @ORM\Column(name="energiForbrugSekundaerEfter", type="array")
     */
    private $energiForbrugSekundaerEfter;

    /**
     * @var array
     *
     * @ORM\Column(name="forbrugFoer", type="array")
     */
    private $forbrugFoer;

    /**
     * @var array
     *
     * @ORM\Column(name="forbrugEfter", type="array")
     */
    private $forbrugEfter;

    /**
     * @var array
     *
     * @ORM\Column(name="forbrugBeregningKontrol", type="array")
     */
    private $forbrugBeregningKontrol;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var float
     *
     * @ORM\Column(name="samletBesparelse", type="float")
     */
    private $samletBesparelse;

    /**
     * @var float
     */
    private $driftbespKrAar;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        foreach (array_filter(array_keys(EnergiType::getChoices())) as $key) {
            $this->energiForbrugPrimaerFoer[$key] = $this->getEnergiForbrugTypeDefault();
            $this->energiForbrugSekundaerFoer[$key] = $this->getEnergiForbrugTypeDefault();
            $this->energiForbrugPrimaerEfter[$key] = $this->getEnergiForbrugTypeDefault();
            $this->energiForbrugSekundaerEfter[$key] = $this->getEnergiForbrugTypeDefault();
        }
        $this->forbrugBeregningKontrol = $this->getForbrugBeregningKontrolDefault();
        if ($this->nyVarmeKildePrimaerAndel == NULL) {
            $this->nyVarmeKildePrimaerAndel = 1;
        }
    }

    /**
     * Set varmebespKWhAar
     *
     * @param integer $varmebespKWhAar
     *
     * @return VarmeanlaegTiltagDetail
     */
    public function setVarmebespKWhAar($varmebespKWhAar)
    {
        $this->varmebespKWhAar = $varmebespKWhAar;

        return $this;
    }

    /**
     * Get varmebespKWhAar
     *
     * @return float
     */
    public function getVarmebespKWhAar() {
        return $this->varmebespKWhAar;
    }

    /**
     * Set varmebespKrAar
     *
     * @param integer $varmebespKrAar
     *
     * @return VarmeanlaegTiltagDetail
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
     * Set elbespKWhAar
     *
     * @param integer $elbespKWhAar
     *
     * @return VarmeanlaegTiltagDetail
     */
    public function setElbespKWhAar($elbespKWhAar)
    {
        $this->elbespKWhAar = $elbespKWhAar;

        return $this;
    }

    /**
     * Get elbespKWhAar
     *
     * @return float
     */
    public function getElbespKWhAar() {
        return $this->elbespKWhAar;
    }

    /**
     * Set elbespKrAar
     *
     * @param integer $elbespKrAar
     *
     * @return VarmeanlaegTiltagDetail
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
     * Set energiTypePrimaerFoer
     *
     * @param integer $energiTypePrimaerFoer
     *
     * @return VarmeanlaegTiltagDetail
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
     * @return VarmeanlaegTiltagDetail
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
     * Set energiTypeSekundaerFoer
     *
     * @param integer $energiTypeSekundaerFoer
     *
     * @return VarmeanlaegTiltagDetail
     */
    public function setEnergiTypeSekundaerFoer($energiTypeSekundaerFoer)
    {
        $this->energiTypeSekundaerFoer = $energiTypeSekundaerFoer;

        return $this;
    }

    /**
     * Get energiTypeSekundaerFoer
     *
     * @return string
     */
    public function getEnergiTypeSekundaerFoer() {
        return $this->energiTypeSekundaerFoer;
    }

    /**
     * Set energiForbrugSekundaerFoer
     *
     * @param integer $energiForbrugSekundaerFoer
     *
     * @return VarmeanlaegTiltagDetail
     */
    public function setEnergiForbrugSekundaerFoer($energiForbrugSekundaerFoer)
    {
        $this->energiForbrugSekundaerFoer = $energiForbrugSekundaerFoer;

        return $this;
    }

    /**
     * Get energiForbrugSekundaerFoer
     *
     * @return array
     */
    public function getEnergiForbrugSekundaerFoer()
    {
        return $this->energiForbrugSekundaerFoer;
    }

    /**
     * Set nyVarmeKildePrimaerAndel
     *
     * @param integer $nyVarmeKildePrimaerAndel
     *
     * @return VarmeanlaegTiltagDetail
     */
    public function setNyVarmeKildePrimaerAndel($nyVarmeKildePrimaerAndel)
    {
        $this->nyVarmeKildePrimaerAndel = $nyVarmeKildePrimaerAndel;

        return $this;
    }

    /**
     * Get nyVarmeKildePrimaerAndel
     *
     * @return float
     */
    public function getNyVarmeKildePrimaerAndel()
    {
        return $this->nyVarmeKildePrimaerAndel;
    }

    /**
     * Get nyVarmeKildeSekundaerAndel
     *
     * @return float
     */
    public function getNyVarmeKildeSekundaerAndel()
    {
        return 1 - $this->getNyVarmeKildePrimaerAndel();
    }

    /**
     * Get nyVarmeKildePrimaerAndel
     *
     * @return float
     */
    public function getNuvarendeVarmeKildePrimaerAndel()
    {
        return $this->divide($this->getEnergiForbrugPrimaerFoerNettoKWh(), $this->getForbrugFoerNEttoKWh());
    }

    /**
     * Get nuvarendeVarmeKildeSekundaerAndel
     *
     * @return float
     */
    public function getNuvarendeVarmeKildeSekundaerAndel()
    {
        if (empty($this->getEnergiTypePrimaerFoer())) {
            return 0;
        }
        return 1 - $this->getNuvarendeVarmeKildePrimaerAndel();
    }

    /**
     * Set energiTypePrimaerEfter
     *
     * @param integer $energiTypePrimaerEfter
     *
     * @return VarmeanlaegTiltagDetail
     */
    public function setEnergiTypePrimaerEfter($energiTypePrimaerEfter)
    {
        $this->energiTypePrimaerEfter = $energiTypePrimaerEfter;

        return $this;
    }

    /**
     * Get energiTypePrimaerEfter
     *
     * @return string
     */
    public function getEnergiTypePrimaerEfter() {
        return $this->energiTypePrimaerEfter;
    }

    /**
     * Set energiForbrugPrimaerEfter
     *
     * @param integer $energiForbrugPrimaerEfter
     *
     * @return VarmeanlaegTiltagDetail
     */
    public function setEnergiForbrugPrimaerEfter($energiForbrugPrimaerEfter)
    {
        $this->energiForbrugPrimaerEfter = $energiForbrugPrimaerEfter;

        return $this;
    }

    /**
     * Get energiForbrugPrimaerEfter
     *
     * @return array
     */
    public function getEnergiForbrugPrimaerEfter()
    {
        return $this->energiForbrugPrimaerEfter;
    }

    /**
     * Set energiTypeSekundaerEfter
     *
     * @param integer $energiTypeSekundaerEfter
     *
     * @return VarmeanlaegTiltagDetail
     */
    public function setEnergiTypeSekundaerEfter($energiTypeSekundaerEfter)
    {
        $this->energiTypeSekundaerEfter = $energiTypeSekundaerEfter;

        return $this;
    }

    /**
     * Get energiTypeSekundaerEfter
     *
     * @return string
     */
    public function getEnergiTypeSekundaerEfter() {
        return $this->energiTypeSekundaerEfter;
    }

    /**
     * Set energiForbrugSekundaerEfter
     *
     * @param integer $energiForbrugSekundaerEfter
     *
     * @return VarmeanlaegTiltagDetail
     */
    public function setEnergiForbrugSekundaerEfter($energiForbrugSekundaerEfter)
    {
        $this->energiForbrugSekundaerEfter = $energiForbrugSekundaerEfter;

        return $this;
    }

    /**
     * Get energiForbrugSekundaerEfter
     *
     * @return array
     */
    public function getEnergiForbrugSekundaerEfter()
    {
        return $this->energiForbrugSekundaerEfter;
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
            'driftOmkostning',
            // See custom adding to type AppBundle\Form\Type\VarmeTiltagDetail\EnergiForbrugType
            // 'andel',
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
            'nettoForbrugKWh' => NULL,
            'forbrugKr' => NULL,
            'andel' => NULL,
            'driftOmkostning' => NULL,
            'samletOmkostning' => NULL,
        );
    }

    /**
     * Get energiForbrugPrimaerFoer key value
     *
     * @return float
     */
    public function getEnergiForbrugPrimaerFoerTypeKeyValue($key)
    {
        $type = $this->getEnergiTypePrimaerFoer();
        return isset($this->energiForbrugPrimaerFoer[$type][$key]) ? $this->energiForbrugPrimaerFoer[$type][$key] : NULL;
    }

    // Set of get functions for energiForbrugPrimaerFoer.
    public function getEnergiForbrugPrimaerFoerForbrug() { return $this->getEnergiForbrugPrimaerFoerTypeKeyValue('forbrug');}
    public function getEnergiForbrugPrimaerFoerFaktor() { return $this->getEnergiForbrugPrimaerFoerTypeKeyValue('faktor');}
    public function getEnergiForbrugPrimaerFoerKWh() { return $this->getEnergiForbrugPrimaerFoerTypeKeyValue('forbrugKWh');}
    public function getEnergiForbrugPrimaerFoerNettoKWh() { return $this->getEnergiForbrugPrimaerFoerTypeKeyValue('nettoForbrugKWh');}
    public function getEnergiForbrugPrimaerFoerKr() { return $this->getEnergiForbrugPrimaerFoerTypeKeyValue('forbrugKr'); }
    public function getEnergiForbrugPrimaerFoerDriftOmkostning() { return $this->getEnergiForbrugPrimaerFoerTypeKeyValue('driftOmkostning'); }
    public function getEnergiForbrugPrimaerFoerSamletOmkostning() { return $this->getEnergiForbrugPrimaerFoerTypeKeyValue('samletOmkostning'); }

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
     * Get energiForbrugSekundaerFoer key value
     *
     * @return float
     */
    public function getEnergiForbrugSekundaerFoerTypeKeyValue($key)
    {
        $type = $this->getEnergiTypeSekundaerFoer();
        return isset($this->energiForbrugSekundaerFoer[$type][$key]) ? $this->energiForbrugSekundaerFoer[$type][$key] : NULL;
    }

    // Set of get functions for energiForbrugSekundaerFoer.
    public function getEnergiForbrugSekundaerFoerForbrug() { return $this->getEnergiForbrugSekundaerFoerTypeKeyValue('forbrug'); }
    public function getEnergiForbrugSekundaerFoerFaktor() { return $this->getEnergiForbrugSekundaerFoerTypeKeyValue('faktor'); }
    public function getEnergiForbrugSekundaerFoerKWh() { return $this->getEnergiForbrugSekundaerFoerTypeKeyValue('forbrugKWh'); }
    public function getEnergiForbrugSekundaerFoerNettoKWh() { return $this->getEnergiForbrugSekundaerFoerTypeKeyValue('nettoForbrugKWh');}
    public function getEnergiForbrugSekundaerFoerKr() {  return $this->getEnergiForbrugSekundaerFoerTypeKeyValue('forbrugKr'); }
    public function getEnergiForbrugSekundaerFoerDriftOmkostning() { return $this->getEnergiForbrugSekundaerFoerTypeKeyValue('driftOmkostning'); }
    public function getEnergiForbrugSekundaerFoerSamletOmkostning() { return $this->getEnergiForbrugSekundaerFoerTypeKeyValue('samletOmkostning'); }

    /**
     * Get energiForbrugSekundaerFoerPris
     *
     * @return float
     */
    public function getEnergiForbrugSekundaerFoerPris()
    {
        $priser = $this->getTiltag()->getPriserOverride();
        $type = $this->getEnergiTypeSekundaerFoer();
        return isset($priser[$type]['pris']) ? $priser[$type]['pris'] : 0;
    }

    /**
     * Get energiForbrugPrimaerEfter key value
     *
     * @return float
     */
    public function getEnergiForbrugPrimaerEfterTypeKeyValue($key)
    {
        $type = $this->getEnergiTypePrimaerEfter();
        return isset($this->energiForbrugPrimaerEfter[$type][$key]) ? $this->energiForbrugPrimaerEfter[$type][$key] : NULL;
    }

    // Set of get functions for energiForbrugPrimaerEfter.
    public function getEnergiForbrugPrimaerEfterForbrug() { return $this->getEnergiForbrugPrimaerEfterTypeKeyValue('forbrug'); }
    public function getEnergiForbrugPrimaerEfterFaktor() { return $this->getEnergiForbrugPrimaerEfterTypeKeyValue('faktor'); }
    public function getEnergiForbrugPrimaerEfterKWh() { return $this->getEnergiForbrugPrimaerEfterTypeKeyValue('forbrugKWh'); }
    public function getEnergiForbrugPrimaerEfterNettoKWh() { return $this->getEnergiForbrugPrimaerEfterTypeKeyValue('nettoForbrugKWh');}
    public function getEnergiForbrugPrimaerEfterKr() { return $this->getEnergiForbrugPrimaerEfterTypeKeyValue('forbrugKr');}
    public function getEnergiForbrugPrimaerEfterDriftOmkostning() { return $this->getEnergiForbrugPrimaerEfterTypeKeyValue('driftOmkostning'); }
    public function getEnergiForbrugPrimaerEfterSamletOmkostning() { return $this->getEnergiForbrugPrimaerEfterTypeKeyValue('samletOmkostning'); }

    /**
     * Get energiForbrugPrimaerEfterPris
     *
     * @return float
     */
    public function getEnergiForbrugPrimaerEfterPris()
    {
        $priser = $this->getTiltag()->getPriserOverride();
        $type = $this->getEnergiTypePrimaerEfter();
        return isset($priser[$type]['pris']) ? $priser[$type]['pris'] : 0;
    }

    /**
     * Get energiForbrugSekundaerEfter key value
     *
     * @return float
     */
    public function getEnergiForbrugSekundaerEfterTypeKeyValue($key)
    {
        $type = $this->getEnergiTypeSekundaerEfter();
        return isset($this->energiForbrugSekundaerEfter[$type][$key]) ? $this->energiForbrugSekundaerEfter[$type][$key] : NULL;
    }

    // Set of get functions for energiForbrugSekundaerEfter.
    public function getEnergiForbrugSekundaerEfterForbrug() { return $this->getEnergiForbrugSekundaerEfterTypeKeyValue('forbrug'); }
    public function getEnergiForbrugSekundaerEfterFaktor() { return $this->getEnergiForbrugSekundaerEfterTypeKeyValue('faktor'); }
    public function getEnergiForbrugSekundaerEfterKWh() { return $this->getEnergiForbrugSekundaerEfterTypeKeyValue('forbrugKWh'); }
    public function getEnergiForbrugSekundaerEfterNettoKWh() { return $this->getEnergiForbrugSekundaerEfterTypeKeyValue('nettoForbrugKWh'); }
    public function getEnergiForbrugSekundaerEfterKr() { return $this->getEnergiForbrugSekundaerEfterTypeKeyValue('forbrugKr'); }
    public function getEnergiForbrugSekundaerEfterDriftOmkostning() { return $this->getEnergiForbrugSekundaerEfterTypeKeyValue('driftOmkostning'); }
    public function getEnergiForbrugSekundaerEfterSamletOmkostning() { return $this->getEnergiForbrugSekundaerEfterTypeKeyValue('samletOmkostning'); }

    /**
     * Get energiForbrugSekundaerEfterPris
     *
     * @return float
     */
    public function getEnergiForbrugSekundaerEfterPris()
    {
        $priser = $this->getTiltag()->getPriserOverride();
        $type = $this->getEnergiTypeSekundaerEfter();
        return isset($priser[$type]['pris']) ? $priser[$type]['pris'] : 0;
    }

    /**
     * Set forbrugFoer
     *
     * @param integer $forbrugFoer
     *
     * @return VarmeanlaegTiltagDetail
     */
    public function setForbrugFoer($forbrugFoer)
    {
        $this->forbrugFoer = $forbrugFoer;

        return $this;
    }

    /**
     * Get forbrugFoer
     *
     * @return array
     */
    public function getForbrugFoer()
    {
        return $this->forbrugFoer;
    }

    /**
     * Get forbrugFoer default value.
     *
     * @return array
     */
    public static function getForbrugFoerDefault()
    {
        return array(
            'kWh' => NULL,
            'nettoKWh' => NULL,
            'varmeOmkostning' => NULL,
            'driftOmkostning' => NULL,
            'samletOmkostning' => NULL,
        );
    }

    /**
     * Get forbrugFoer key value
     *
     * @return float
     */
    public function getForbrugFoerKeyValue($key)
    {
        return isset($this->forbrugFoer[$key]) ? $this->forbrugFoer[$key] : NULL;
    }

    // Set of get functions for forbrugFoer.
    public function getForbrugFoerKWh() { return $this->getForbrugFoerKeyValue('kWh'); }
    public function getForbrugFoerNettoKWh() { return $this->getForbrugFoerKeyValue('nettoKWh'); }
    public function getForbrugFoerVarmeOmkostning() { return $this->getForbrugFoerKeyValue('varmeOmkostning'); }
    public function getForbrugFoerDriftOmkostning() { return $this->getForbrugFoerKeyValue('driftOmkostning'); }
    public function getForbrugFoerSamletOmkostning() { return $this->getForbrugFoerKeyValue('samletOmkostning'); }

    /**
     * Set forbrugEfter
     *
     * @param integer $forbrugEfter
     *
     * @return VarmeanlaegTiltagDetail
     */
    public function setForbrugEfter($forbrugEfter)
    {
        $this->forbrugEfter = $forbrugEfter;

        return $this;
    }

    /**
     * Get forbrugEfter
     *
     * @return array
     */
    public function getForbrugEfter()
    {
        return $this->forbrugEfter;
    }

    /**
     * Get forbrugEfter default value.
     *
     * @return array
     */
    public static function getForbrugEfterDefault()
    {
        return array(
            'kWh' => NULL,
            'nettoKWh' => NULL,
            'varmeOmkostning' => NULL,
            'driftOmkostning' => NULL,
            'samletOmkostning' => NULL,
        );
    }

    /**
     * Get forbrugEfter key value
     *
         * @return float
     */
    public function getForbrugEfterKeyValue($key)
    {
        return isset($this->forbrugEfter[$key]) ? $this->forbrugEfter[$key] : NULL;
    }

    // Set of get functions for forbrugEfter.
    public function getForbrugEfterKWh() { return $this->getForbrugEfterKeyValue('kWh'); }
    public function getForbrugEfterNettoKWh() { return $this->getForbrugEfterKeyValue('nettoKWh'); }
    public function getForbrugEfterVarmeOmkostning() { return $this->getForbrugEfterKeyValue('varmeOmkostning'); }
    public function getForbrugEfterDriftOmkostning() { return $this->getForbrugEfterKeyValue('driftOmkostning'); }
    public function getForbrugEfterSamletOmkostning() { return $this->getForbrugEfterKeyValue('samletOmkostning'); }

    /**
     * Set forbrugBeregningKontrol
     *
     * @param integer $forbrugBeregningKontrol
     *
     * @return VarmeanlaegTiltagDetail
     */
    public function setForbrugBeregningKontrol($forbrugBeregningKontrol)
    {
        $this->forbrugBeregningKontrol = $forbrugBeregningKontrol;

        return $this;
    }

    /**
     * Get forbrugBeregningKontrol
     *
     * @return array
     */
    public function getForbrugBeregningKontrol()
    {
        return $this->forbrugBeregningKontrol;
    }

    /**
     * Get forbrugBeregningKontrol keys that should be filled in form.
     *
     * @return array
     */
    public static function getForbrugBeregningKontrolInputKeys()
    {
        return array(
            'opvarmetArealBrutto',
            'varmeTabM2',
            'brugsvandsandel',
            'primaerFuldlastTimer',
            'sekundaerFuldlastTimer',
        );
    }

    /**
     * Get forbrugBeregningKontrol default value.
     *
     * @return array
     */
    public static function getForbrugBeregningKontrolDefault()
    {
        return array(
            'opvarmetArealBrutto' => NULL,
            'varmeTabM2' => NULL,
            'effektBehov' => NULL,
            'brugsvandsandel' => NULL,
            'primaerFuldlastTimer' => NULL,
            'sekundaerFuldlastTimer' => NULL,
        );
    }

    /**
     * Get forbrugBeregningKontrol key value
     *
     * @return float
     */
    public function getForbrugBeregningKontrolKeyValue($key)
    {
        return isset($this->forbrugBeregningKontrol[$key]) ? $this->forbrugBeregningKontrol[$key] : NULL;
    }

    // Set of get functions for forbrugBeregningKontrol.
    public function getForbrugBeregningKontrolOpvarmetArealBrutto() { return $this->getForbrugBeregningKontrolKeyValue('opvarmetArealBrutto'); }
    public function getForbrugBeregningKontrolVarmeTabM2() { return $this->getForbrugBeregningKontrolKeyValue('varmeTabM2'); }
    public function getForbrugBeregningKontrolBrugsvandsandel() { return $this->getForbrugBeregningKontrolKeyValue('brugsvandsandel'); }
    public function getForbrugBeregningKontrolPrimaerFuldlastTimer() { return $this->getForbrugBeregningKontrolKeyValue('primaerFuldlastTimer'); }
    public function getForbrugBeregningKontrolSekundaerFuldlastTimer() { return $this->getForbrugBeregningKontrolKeyValue('sekundaerFuldlastTimer'); }

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
     * Gets varmeBesparelseKr.
     *
     * @return float
     */
    public function getDriftbespKrAar() {
        if (empty($this->driftbespKrAar)) {
            $this->driftbespKrAar = $this->calculateDriftbespKrAar();
        }
        return $this->driftbespKrAar;
    }

    /**
     * Gets samletBesparelse.
     *
     * @return float
     */
    public function getSamletBesparelse() {
        return $this->samletBesparelse;
    }

    /**
     * Calculate stuff.
     *
     * See calculation file xls/VarmePumpe/Bereging_af_armepumpe_redigeret_til_screeningsvaerktoej_V.1.xls
     */
    public function calculate() {
        // Step 1
        if ($type = $this->getEnergiTypePrimaerFoer()) {
            $this->energiForbrugPrimaerFoer[$type]['forbrugKWh'] = $this->calculatEnergiForbrugPrimaerFoerForbrugKWh();
            $this->energiForbrugPrimaerFoer[$type]['nettoForbrugKWh'] = $this->calculatEnergiForbrugPrimaerFoerForbrugNettoKWh();
            $this->energiForbrugPrimaerFoer[$type]['forbrugKr'] = $this->calculatEnergiForbrugPrimaerFoerForbrugKr();
            $this->energiForbrugPrimaerFoer[$type]['samletOmkostning'] = $this->calculatEnergiForbrugPrimaerFoerForbrugSamletOmkostning();
        }
        if ($type = $this->getEnergiTypeSekundaerFoer()) {
            $this->energiForbrugSekundaerFoer[$type]['forbrugKWh'] = $this->calculatEnergiForbrugSekundaerFoerForbrugKWh();
            $this->energiForbrugSekundaerFoer[$type]['nettoForbrugKWh'] = $this->calculatEnergiForbrugSekundaerFoerForbrugNettoKWh();
            $this->energiForbrugSekundaerFoer[$type]['forbrugKr'] = $this->calculatEnergiForbrugSekundaerFoerForbrugKr();
            $this->energiForbrugSekundaerFoer[$type]['samletOmkostning'] = $this->calculatEnergiForbrugSekundaerFoerForbrugSamletOmkostning();
        }
        // Step 2
        $this->forbrugFoer['kWh'] = $this->calculatForbrugFoerKWh();
        $this->forbrugFoer['nettoKWh'] = $this->calculatForbrugFoerNettoKWh();
        $this->forbrugFoer['varmeOmkostning'] = $this->calculatForbrugFoerVarmeOmkostning();
        $this->forbrugFoer['driftOmkostning'] = $this->calculatForbrugFoerDriftOmkostning();
        $this->forbrugFoer['samletOmkostning'] = $this->calculatForbrugFoerSamletOmkostning();

        // Step 3
        $primaerEfterFobrugNettoKWh = $this->calculatEnergiForbrugPrimaerEfterForbrugNettoKWh();
        foreach (array_filter(array_keys(EnergiType::getChoices())) as $type) {
            $this->energiForbrugPrimaerEfter[$type]['nettoForbrugKWh'] = $primaerEfterFobrugNettoKWh;
        }
        if ($type = $this->getEnergiTypePrimaerEfter()) {
            $this->energiForbrugPrimaerEfter[$type]['forbrugKWh'] = $this->calculatEnergiForbrugPrimaerEfterForbrugKWh();
            $this->energiForbrugPrimaerEfter[$type]['forbrug'] = $this->calculatEnergiForbrugPrimaerEfterForbrug();
            $this->energiForbrugPrimaerEfter[$type]['forbrugKr'] = $this->calculatEnergiForbrugPrimaerEfterForbrugKr();
            $this->energiForbrugPrimaerEfter[$type]['samletOmkostning'] = $this->calculatEnergiForbrugPrimaerEfterForbrugSamletOmkostning();
        }
        $sekundaerEfterFobrugKWh = $this->calculatEnergiForbrugSekundaerEfterForbrugNettoKWh();
        foreach (array_filter(array_keys(EnergiType::getChoices())) as $type) {
            $this->energiForbrugSekundaerEfter[$type]['nettoForbrugKWh'] = $sekundaerEfterFobrugKWh;
        }
        if ($type = $this->getEnergiTypeSekundaerEfter()) {
            $this->energiForbrugSekundaerEfter[$type]['forbrugKWh'] = $this->calculatEnergiForbrugSekundaerEfterForbrugKWh();
            $this->energiForbrugSekundaerEfter[$type]['forbrug'] = $this->calculatEnergiForbrugSekundaerEfterForbrug();
            $this->energiForbrugSekundaerEfter[$type]['forbrugKr'] = $this->calculatEnergiForbrugSekundaerEfterForbrugKr();
            $this->energiForbrugSekundaerEfter[$type]['samletOmkostning'] = $this->calculatEnergiForbrugSekundaerEfterForbrugSamletOmkostning();
        }

        // Step 4
        $this->forbrugEfter['kWh'] = $this->calculatForbrugEfterKWh();
        $this->forbrugEfter['varmeOmkostning'] = $this->calculatForbrugEfterVarmeOmkostning();
        $this->forbrugEfter['driftOmkostning'] = $this->calculatForbrugEfterDriftOmkostning();
        $this->forbrugEfter['samletOmkostning'] = $this->calculatForbrugEfterSamletOmkostning();
        $this->varmebespKWhAar = $this->calculateVarmebespKWhAar();
        $this->varmebespKrAar = $this->calculateVarmebespKrAar();
        $this->samletBesparelse = $this->calculateSamletBesparelse();
    }

    /** BEGIN Step 1 calculation */

    /**
     * See calculation file, cell G9 - G29.
     */
    public function calculatEnergiForbrugPrimaerFoerForbrugKWh() {
        $forbrug = $this->getEnergiForbrugPrimaerFoerForbrug();
        $varmeEnergiFaktor = $this->getConfiguration()->getVarmeEnergiFaktor();
        return $forbrug * $varmeEnergiFaktor[$this->getEnergiTypePrimaerFoer()];
    }

    /**
     * See calculation file, cell H9 - H29.
     */
    public function calculatEnergiForbrugPrimaerFoerForbrugNettoKWh() {
        return $this->getEnergiForbrugPrimaerFoerKWh() * $this->getEnergiForbrugPrimaerFoerFaktor();
    }

    /**
     * See calculation file, cell L9 - L29.
     */
    public function calculatEnergiForbrugPrimaerFoerForbrugKr() {
        return $this->getEnergiForbrugPrimaerFoerForbrug() * $this->getEnergiForbrugPrimaerFoerPris();
    }

    /**
     * See calculation file, cell N9 - N29.
     */
    public function calculatEnergiForbrugPrimaerFoerForbrugSamletOmkostning() {
        return $this->getEnergiForbrugPrimaerFoerKr() + $this->getEnergiForbrugPrimaerFoerDriftOmkostning();
    }

    /**
     * See calculation file, cell G34 - G54.
     */
    public function calculatEnergiForbrugSekundaerFoerForbrugKWh() {
        $forbrug = $this->getEnergiForbrugSekundaerFoerForbrug();
        $varmeEnergiFaktor = $this->getConfiguration()->getVarmeEnergiFaktor();
        return $forbrug * $varmeEnergiFaktor[$this->getEnergiTypeSekundaerFoer()];
    }

    /**
     * See calculation file, cell H34 - H54.
     */
    public function calculatEnergiForbrugSekundaerFoerForbrugNettoKWh() {
        return $this->getEnergiForbrugSekundaerFoerKWh() * $this->getEnergiForbrugSekundaerFoerFaktor();
    }

    /**
     * See calculation file, cell L34 - K54.
     */
    public function calculatEnergiForbrugSekundaerFoerForbrugKr() {
        return  $this->getEnergiForbrugSekundaerFoerForbrug() * $this->getEnergiForbrugSekundaerFoerPris();
    }

    /**
     * See calculation file, cell N34 - N54.
     */
    public function calculatEnergiForbrugSekundaerFoerForbrugSamletOmkostning() {
        return $this->getEnergiForbrugSekundaerFoerKr() + $this->getEnergiForbrugSekundaerFoerDriftOmkostning();
    }

    /** END Step 1 calculation */


    /** BEGIN Step 2 calculation */

    /**
     * See calculation file, cell E65.
     */
    public function calculatForbrugFoerKWh() {
        return $this->getEnergiForbrugPrimaerFoerKWh() + $this->getEnergiForbrugSekundaerFoerKWh();
    }

    /**
     * See calculation file, cell F65.
     */
    public function calculatForbrugFoerNettoKWh() {
        return $this->getEnergiForbrugPrimaerFoerNettoKWh() + $this->getEnergiForbrugSekundaerFoerNettoKWh();
    }

    /**
     * See calculation file, cell L65.
     */
    public function calculatForbrugFoerVarmeOmkostning() {
        return $this->getEnergiForbrugPrimaerFoerKr() + $this->getEnergiForbrugSekundaerFoerKr();
    }

    /**
     * See calculation file, cell M65.
     */
    public function calculatForbrugFoerDriftOmkostning() {
        return $this->getEnergiForbrugPrimaerFoerDriftOmkostning() + $this->getEnergiForbrugSekundaerFoerDriftOmkostning();
    }

    /**
     * See calculation file, cell N65.
     */
    public function calculatForbrugFoerSamletOmkostning() {
        return $this->getEnergiForbrugPrimaerFoerSamletOmkostning() + $this->getEnergiForbrugSekundaerFoerSamletOmkostning();
    }

    /** END Step 2 calculation */

    /** BEGIN Step 3 calculation */

    /**
     * See calculation file, cell S9 - S29.
     */
    public function calculatEnergiForbrugPrimaerEfterForbrugNettoKWh() {
        return $this->getForbrugFoerNettoKWh() * $this->getNyVarmeKildePrimaerAndel();
    }

    /**
     * See calculation file, cell AA9 - AA29.
     */
    public function calculatEnergiForbrugPrimaerEfterForbrugKWh() {
        return $this->divide($this->getEnergiForbrugPrimaerEfterNettoKWh(), $this->getEnergiForbrugPrimaerEfterFaktor());
    }

    /**
     * See calculation file, cell Z10 - Z30.
     */
    public function calculatEnergiForbrugPrimaerEfterForbrug() {
        $varmeEnergiFaktor = $this->getConfiguration()->getVarmeEnergiFaktor();
        return $this->divide($this->divide($this->getEnergiForbrugPrimaerEfterNettoKWh(), $this->getEnergiForbrugPrimaerEfterFaktor()), $varmeEnergiFaktor[$this->getEnergiTypePrimaerEfter()]);
    }

    /**
     * See calculation file, cell AB9 - AB29.
     */
    public function calculatEnergiForbrugPrimaerEfterForbrugKr() {
        return $this->getEnergiForbrugPrimaerEfterForbrug() * $this->getEnergiForbrugPrimaerEfterPris();
    }

    /**
     * See calculation file, cell AD9 - AD29.
     */
    public function calculatEnergiForbrugPrimaerEfterForbrugSamletOmkostning() {
        return $this->getEnergiForbrugPrimaerEfterKr() + $this->getEnergiForbrugPrimaerEfterDriftOmkostning();
    }

    /**
     * See calculation file, cell S34 - S54.
     */
    public function calculatEnergiForbrugSekundaerEfterForbrugNettoKWh() {
        return $this->getForbrugFoerNettoKWh() * $this->getNyVarmeKildeSekundaerAndel();
    }

    /**
     * See calculation file, cell AA34 - AA54.
     */
    public function calculatEnergiForbrugSekundaerEfterForbrugKWh() {
        return $this->divide($this->getEnergiForbrugSekundaerEfterNettoKWh(), $this->getEnergiForbrugSekundaerEfterFaktor());
    }

    /**
     * See calculation file, cell Z35 - Z55.
     */
    public function calculatEnergiForbrugSekundaerEfterForbrug() {
        $varmeEnergiFaktor = $this->getConfiguration()->getVarmeEnergiFaktor();
        return $this->divide($this->divide($this->getEnergiForbrugSekundaerEfterNettoKWh(), $this->getEnergiForbrugSekundaerEfterFaktor()), $varmeEnergiFaktor[$this->getEnergiTypeSekundaerEfter()]);
    }

    /**
     * See calculation file, cell AB34 - AB54.
     */
    public function calculatEnergiForbrugSekundaerEfterForbrugKr() {
        return  $this->getEnergiForbrugSekundaerEfterForbrug() * $this->getEnergiForbrugSekundaerEfterPris();
    }

    /**
     * See calculation file, cell AD34 - AD54.
     */
    public function calculatEnergiForbrugSekundaerEfterForbrugSamletOmkostning() {
        return $this->getEnergiForbrugSekundaerEfterKr() + $this->getEnergiForbrugSekundaerEfterDriftOmkostning();
    }

    /** END Step 3 calculation */


    /** BEGIN Step 4 calculation */

    /**
     * See calculation file, cell U65.
     */
    public function calculatForbrugEfterKWh() {
        return $this->getEnergiForbrugPrimaerEfterKWh() + $this->getEnergiForbrugSekundaerEfterKWh();
    }

    /**
     * See calculation file, cell AB65.
     */
    public function calculatForbrugEfterVarmeOmkostning() {
        return $this->getEnergiForbrugPrimaerEfterKr() + $this->getEnergiForbrugSekundaerEfterKr();
    }

    /**
     * See calculation file, cell AC65.
     */
    public function calculatForbrugEfterDriftOmkostning() {
        return $this->getEnergiForbrugPrimaerEfterDriftOmkostning() + $this->getEnergiForbrugSekundaerEfterDriftOmkostning();
    }

    /**
     * See calculation file, cell AD65.
     */
    public function calculatForbrugEfterSamletOmkostning() {
        return $this->getEnergiForbrugPrimaerEfterSamletOmkostning() + $this->getEnergiForbrugSekundaerEfterSamletOmkostning();
    }

    /** END Step 4 calculation */


    /** BEGIN Step 5 calculation */

    /**
     * See calculation file, cell H74.
     */
    public function calculateVarmebespKWhAar() {
        return $this->getForbrugFoerKWh() - $this->getForbrugEfterKWh();
    }

    /**
     * See calculation file, cell H75.
     */
    public function calculateVarmebespKrAar() {
        return $this->getForbrugFoerVarmeOmkostning() - $this->getForbrugEfterVarmeOmkostning();
    }

    /**
     * See calculation file, cell H76.
     */
    public function calculateDriftbespKrAar() {
        return $this->getForbrugFoerDriftOmkostning() - $this->getForbrugEfterDriftOmkostning();
    }

    /**
     * See calculation file, cell H77.
     */
    public function calculateSamletBesparelse() {
        return $this->getForbrugFoerSamletOmkostning() - $this->getForbrugEfterSamletOmkostning();
    }

    /** END Step 5 calculation */

    /** BEGIN Step 6 calculation */

    /**
     * Gets NyPrimaerBruttoVarmeForbrugKWh.
     *
     * @return float
     */
    public function getNyPrimaerBruttoVarmeForbrugKWh() {
        if ($this->getEnergiTypePrimaerEfter() == 'varmepumpe') {
            return $this->getEnergiForbrugPrimaerFoerNettoKWh();
        }
        return $this->getEnergiForbrugPrimaerFoerKWh();
    }

    /**
     * Gets NySekundaerBruttoVarmeForbrugKWh.
     *
     * @return float
     */
    public function getNySekundaerBruttoVarmeForbrugKWh() {
        if ($this->getEnergiTypeSekundaerEfter() == 'varmepumpe') {
            return $this->getEnergiForbrugSekundaerEfterNettoKWh();
        }
        return $this->getEnergiForbrugSekundaerEfterKWh();
    }

    /**
     * Gets nyPrimaerBoligopvarmingKW.
     *
     * @return float
     */
    public function getPrimaerBoligOpvarmingKW() {
        return $this->getNyPrimaerBruttoVarmeForbrugKWh() / 2334.75;
    }

    /**
     * Gets nySekundaerBoligopvarmingKW.
     *
     * @return float
     */
    public function getSekundaerBoligOpvarmingKW() {
        return $this->getNySekundaerBruttoVarmeForbrugKWh() / 2334.75;
    }

    /**
     * Gets nyPrimaerErhSkOpvarmingKW.
     *
     * @return float
     */
    public function getPrimaerErhSkOpvarmingKW() {
        return $this->getPrimaerBoligopvarmingKW() * 1.2222;
    }

    /**
     * Gets nySekundaerErhSkOpvarmingKW.
     *
     * @return float
     */
    public function getSekundaerErhSkOpvarmingKW() {
        return $this->getSekundaerBoligopvarmingKW() * 1.2222;
    }

    /**
     * Gets SamletBoligOpvarmingKW.
     *
     * @return float
     */
    public function getSamletBoligOpvarmingKW() {
        return $this->getPrimaerBoligOpvarmingKW() + $this->getSekundaerBoligOpvarmingKW();
    }

    /**
     * Gets nySekundaerErhSkOpvarmingKW.
     *
     * @return float
     */
    public function getSamletErhSkOpvarmingKW() {
        return $this->getPrimaerErhSkOpvarmingKW() + $this->getSekundaerErhSkOpvarmingKW();
    }

    /** END Step 6 calculation */

    /** BEGIN Step 7 calculation */

    /**
     * Gets primaerEffektMetode1.
     *
     * @return float
     */
    public function getPrimaerEffektMetode1() {
        return $this->divide($this->getNyPrimaerBruttoVarmeForbrugKWh(), $this->getForbrugBeregningKontrolPrimaerFuldlastTimer());
    }

    /**
     * Gets sekundaerEffektMetode1.
     *
     * @return float
     */
    public function getSekundaerEffektMetode1() {
        return $this->divide($this->getNySekundaerBruttoVarmeForbrugKWh(), $this->getForbrugBeregningKontrolSekundaerFuldlastTimer());
    }

    /**
     * Gets samletEffektMetode1.
     *
     * @return float
     */
    public function getSamletEffektMetode1() {
        return $this->getPrimaerEffektMetode1() + $this->getSekundaerEffektMetode1();
    }

    /** END Step 7 calculation */

    /** BEGIN Step 8 calculation */

    /**
     * Gets OpvarmetArealNetto.
     *
     * @return float
     */
    public function getForbrugBeregningKontrolOpvarmetArealNetto() {
        return $this->getForbrugBeregningKontrolOpvarmetArealBrutto() * 0.85;
    }

    /**
     * Gets EffektBehov.
     *
     * @return float
     */
    public function getForbrugBeregningKontrolEffektBehov() {
        return $this->getForbrugBeregningKontrolOpvarmetArealNetto() * $this->getForbrugBeregningKontrolVarmeTabM2() / 1000;
    }

    /**
     * Gets OpvarmingForbrugKWh.
     *
     * @return float
     */
    public function getForbrugBeregningKontrolOpvarmingForbrugKWh() {
        return $this->getForbrugBeregningKontrolEffektBehov() * 1.1 * 2830 * 24 / 32;
    }

    /**
     * Gets forbrugKWh.
     *
     * @return float
     */
    public function getForbrugBeregningKontrolForbrugKWh() {
        return ($this->getForbrugBeregningKontrolBrugsvandsandel() + 1) * $this->getForbrugBeregningKontrolOpvarmingForbrugKWh();
    }

    /** END Step 8 calculation */

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

