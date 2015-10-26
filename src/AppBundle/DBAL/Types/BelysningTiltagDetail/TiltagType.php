<?php
namespace AppBundle\DBAL\Types\BelysningTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class TiltagType extends AbstractEnumType
{
  const NONE               = '';
  const PIR_I_AFBRYDER     = 'pir_i_afbryder';
  const PIR_ON_OFF_CENTRAL = 'pir_on_off_central';
  const PIR_DGS_CENT       = 'pir_dgs_cent';
  const ARM_EVT_PIR_DGS    = 'arm_evt_pir_dgs';
  const LED_I_EKSIST_ARM   = 'led_i_eksist_arm';
  const NY_INDSATS_I_ARM   = 'ny_indsats_i_arm';
  const ANDET_SE_NOTER     = 'andet_se_noter';

  protected static $choices = [
    self::NONE               => '',
    self::PIR_I_AFBRYDER     => 'PIR i afbryder',
    self::PIR_ON_OFF_CENTRAL => 'PIR on/off, central',
    self::PIR_DGS_CENT       => 'PIR/DGS, cent.',
    self::ARM_EVT_PIR_DGS    => 'Arm. + evt. PIR/DGS',
    self::LED_I_EKSIST_ARM   => 'LED i eksist. arm.',
    self::NY_INDSATS_I_ARM   => 'Ny indsats i arm.',
    self::ANDET_SE_NOTER     => 'Andet, se Noter',
  ];
}