<?php

/**
 * @file
 * VarmeTiltagDetail entity.
 *
 * See calculation file xls/VarmeTiltagDetail/Energibesparelsesberegning_Varmekompressor.xlsx.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Annotations\Formula;
use AppBundle\Entity\Traits\FormulableCalculationEntity;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * VarmeTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
abstract class VarmeTiltagDetail extends TiltagDetail
{
    use FormulableCalculationEntity;

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
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Set varmebespKwhAar
     *
     * @param integer $varmebespKwhAar
     *
     * @return VarmeTiltagDetail
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
     * @return VarmeTiltagDetail
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
     * @return VarmeTiltagDetail
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
     * @return VarmeTiltagDetail
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
     * Post load handler.
     *
     * @ORM\PostLoad
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     */
    public function postLoad(LifecycleEventArgs $event) {
        $this->initFormulableCalculation();
    }

}

