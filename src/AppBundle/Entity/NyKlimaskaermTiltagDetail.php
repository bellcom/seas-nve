<?php

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\MonthType;
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

    /**
     * Set fradragM
     *
     * @param float $fradragM
     * @return KlimaskaermTiltagDetail
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
        if ($this->tIndeDetailed && !empty($this->getTIndeMonthly())) {
            return array_sum($this->getTIndeMonthly()) / count($this->getTIndeMonthly());
        }
        return $this->tIndeC;
    }

    /**
     * @inheritDoc
     */
    public function getTUdeC() {
        if ($this->tUdeDetailed && !empty($this->getTUdeMonthly())) {
            return array_sum($this->getTUdeMonthly()) / count($this->getTUdeMonthly());
        }
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
        parent::calculate();
    }

}
