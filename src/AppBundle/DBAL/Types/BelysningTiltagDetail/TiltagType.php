<?php
namespace AppBundle\DBAL\Types\BelysningTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class TiltagType extends AbstractEnumType
{
  const NONE             = '';
  const ARMATUR          = 'armatur';
  const LED_I_EKSIST_ARM = 'led_i_eksisterende_armatur';
  const NY_INDSATS_I_ARM = 'ny_indsats_i_arm';
  const ANDET_SE_NOTER   = 'andet_se_noter';

  protected static $choices = [
    self::NONE             => '',
    self::ARMATUR          => 'Armatur',
    self::LED_I_EKSIST_ARM => 'LED i eksisterende armatur.',
    self::NY_INDSATS_I_ARM => 'Ny indsats i armatur',
    self::ANDET_SE_NOTER   => 'Andet, se noter',
  ];
}