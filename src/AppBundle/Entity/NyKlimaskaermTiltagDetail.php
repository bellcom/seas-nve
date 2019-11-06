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
     * @var float
     *
     * @ORM\Column(name="klimaskaermOverskrevetPris", type="decimal", scale=4, nullable=true)
     */
    protected $klimaskaermOverskrevetPris;

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

    protected $propertiesRequiredForCalculation = [
        'antalStk',
        'breddeM',
        'hoejdeElLaengdeM',
        'tIndeC',
        'tOpvarmningTimerAar',
        'tUdeC',
        'uEksWM2K',
        'uNyWM2K',
    ];

}
