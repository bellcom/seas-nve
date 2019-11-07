<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotations\Calculated;
use AppBundle\DBAL\Types\CardinalDirectionType;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * NyKlimaskaermTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class NyKlimaskaermTiltagDetail extends KlimaskaermTiltagDetail
{
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
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->andelAfArealDerEfterisoleres = 1;
        $this->prisfaktor = 1;
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
     * @return KlimaskaermTiltagDetail
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

    protected $propertiesRequiredForCalculation = [
        'antalStk',
        'breddeM',
        'hoejdeElLaengdeM',
        'tIndeC',
        'tOpvarmningTimerAar',
        'tUdeC',
        'uEksWM2K',
        'uNyWM2K',
        'samletInvesteringKr',
    ];

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
        if (!empty($this->getGraddageFordeling())) {
            return round($this->getGraddageFordeling()->getSumAar());
        }

        return $this->getTOpvarmningTimerAar();
    }

    public function calculate() {
        $this->tOpvarmningTimerAar = $this->calculateTOpvarmningTimerAar();
        parent::calculate();
    }

}
