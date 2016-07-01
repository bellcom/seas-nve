<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotations\Calculated;
use AppBundle\DBAL\Types\CardinalDirectionType;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * VindueTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class VindueTiltagDetail extends KlimaskaermTiltagDetail {
  /**
   * @var float
   *
   * @ORM\Column(name="solenergitransmittansEks", type="decimal", scale=4)
   */
  protected $solenergitransmittansEks;

  /**
   * @var float
   *
   * @ORM\Column(name="solenergitransmittansNy", type="decimal", scale=4, nullable=true)
   */
  protected $solenergitransmittansNy;

  /**
   * @var float
   *
   * @ORM\Column(name="glasandel", type="decimal", scale=4, nullable=true)
   */
  protected $glasandel = 1;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="eRefEksKWhM2Aar", type="float")
   */
  protected $eRefEksKWhM2Aar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="eWEksKWhM2Aar", type="float")
   */
  protected $eWEksKWhM2Aar;

  /**
   * @var float
   *
   * @Calculated
   * @ORM\Column(name="eRefNyKWhM2Aar", type="float")
   */
  protected $eRefNyKWhM2Aar;

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
   * @ORM\Column(name="eWNyKWhM2Aar", type="float")
   */
  protected $eWNyKWhM2Aar;

  public function setSolenergitransmittansEks($solenergitransmittansEks) {
    $this->solenergitransmittansEks = $solenergitransmittansEks;

    return $this;
  }

  public function getSolenergitransmittansEks() {
    return $this->solenergitransmittansEks;
  }

  public function setSolenergitransmittansNy($solenergitransmittansNy) {
    $this->solenergitransmittansNy = $solenergitransmittansNy;

    return $this;
  }

  public function getSolenergitransmittansNy() {
    return $this->solenergitransmittansNy;
  }

  public function setGlasandel($glasandel) {
    $this->glasandel = $glasandel;

    return $this;
  }

  public function setNoteGenerelt($noteGenerelt) {
    $this->noteGenerelt = $noteGenerelt;

    return $this;
  }

  public function getGlasandel() {
    return $this->glasandel;
  }

  public function getERefEksKWhM2Aar() {
    return $this->eRefEksKWhM2Aar;
  }

  public function getEWEksKWhM2Aar() {
    return $this->eWEksKWhM2Aar;
  }

  public function getERefNyKWhM2Aar() {
    return $this->eRefNyKWhM2Aar;
  }

  public function getEWNyKWhM2Aar() {
    return $this->eWNyKWhM2Aar;
  }

  public function getNoteGenerelt() {
    return $this->noteGenerelt;
  }

  public function calculate() {
    $this->arealM2 = $this->calculateArealM2();
    $this->eRefEksKWhM2Aar = $this->calculateERefEksKWhM2Aar();
    $this->eWEksKWhM2Aar = $this->calculateEWEksKWhM2Aar();
    $this->eRefNyKWhM2Aar = $this->calculateERefNyKWhM2Aar();
    $this->eWNyKWhM2Aar = $this->calculateEWNyKWhM2Aar();
    parent::calculate();
  }

  protected function calculateArealM2() {
    return parent::calculateArealM2();
  }

  protected function calculateERefEksKWhM2Aar() {
    if (!$this->orientering) {
      return 0;
    }

    $solenergitransmittansFactor = 0;
    switch ($this->orientering) {
      case CardinalDirectionType::NORTH:
        $solenergitransmittansFactor = 73.15;
        break;
      case CardinalDirectionType::SOUTH:
        $solenergitransmittansFactor = 301.98;
        break;
      case CardinalDirectionType::EAST:
      case CardinalDirectionType::WEST:
        $solenergitransmittansFactor = 162.47;
        break;
    }

    return $this->glasandel * $solenergitransmittansFactor * $this->solenergitransmittansEks - 90.36 * $this->uEksWM2K;
  }

  protected function calculateEWEksKWhM2Aar() {
    return $this->arealM2 * $this->eRefEksKWhM2Aar;
  }

  protected function calculateERefNyKWhM2Aar() {
    if (!$this->orientering) {
      return 0;
    }

    $solenergitransmittansFactor = 0;
    switch ($this->orientering) {
      case CardinalDirectionType::NORTH:
        $solenergitransmittansFactor = 73.15;
        break;
      case CardinalDirectionType::SOUTH:
        $solenergitransmittansFactor = 301.98;
        break;
      case CardinalDirectionType::EAST:
      case CardinalDirectionType::WEST:
        $solenergitransmittansFactor = 162.47;
        break;
    }

    return $this->glasandel * $solenergitransmittansFactor * $this->solenergitransmittansNy - 90.36 * $this->uNyWM2K;
  }

  protected function calculateEWNyKWhM2Aar() {
    return $this->arealM2 * $this->eRefNyKWhM2Aar;
  }

  protected function calculateBesparelseKWhAar() {
    if ($this->eWEksKWhM2Aar == 0) {
      return 0;
    }
    else {
      return ($this->eWNyKWhM2Aar - $this->eWEksKWhM2Aar) * (1 + $this->yderligereBesparelserPct);
    }
  }

}
