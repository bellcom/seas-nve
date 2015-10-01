<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotations\Calculated;

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
   * @ORM\Column(name="solenergitransmittansNy", type="decimal", scale=4)
   */
  protected $solenergitransmittansNy;

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

  public function calculate() {
    $this->arealM2 = $this->calculateArealM2();
    $this->eRefEksKWhM2Aar = $this->calculateERefEksKWhM2Aar();
    $this->eWEksKWhM2Aar = $this->calculateEWEksKWhM2Aar();
    $this->eRefNyKWhM2Aar = $this->calculateERefNyKWhM2Aar();
    $this->eWNyKWhM2Aar = $this->calculateEWNyKWhM2Aar();
    parent::calculate();
  }

  protected function calculateERefEksKWhM2Aar() {
    if (!$this->orientering) {
      return 0;
    }

    $solenergitransmittansFactor = 0;
    switch ($this->orientering) {
      case 'north':
        $solenergitransmittansFactor = 73.15;
        break;
      case 'south':
        $solenergitransmittansFactor = 301.98;
        break;
      case 'east':
      case 'west':
        $solenergitransmittansFactor = 162.47;
    }

    return $solenergitransmittansFactor * $this->solenergitransmittansEks - 90.36 * $this->uEksWM2K;
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
      case 'Nord':
        $solenergitransmittansFactor = 73.15;
        break;
      case 'Syd':
        $solenergitransmittansFactor = 301.98;
        break;
      case 'Øst':
      case 'Vest':
        $solenergitransmittansFactor = 162.47;
    }

    return $solenergitransmittansFactor * $this->solenergitransmittansNy - 90.36 * $this->uNyWM2K;
  }

  protected function calculateEWNyKWhM2Aar() {
    return $this->arealM2 * $this->eRefNyKWhM2Aar;
  }

  protected function calculateBesparelseKWhAar() {
    return ($this->eWEksKWhM2Aar == 0) ? 0 : $this->eWNyKWhM2Aar - $this->eWEksKWhM2Aar;
  }

}
