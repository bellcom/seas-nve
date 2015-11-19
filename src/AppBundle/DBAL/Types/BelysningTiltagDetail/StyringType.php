<?php
namespace AppBundle\DBAL\Types\BelysningTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class StyringType extends AbstractEnumType
{
  const NONE           = '';
  const PIR_I_AFBRYDER = 'pir_i_afbryder';
  const PIR_ON_OFF     = 'pir_on_off';
  const PIR_DGS        = 'pir_dgs';
  const SKUMRINGSRELAE = 'skumringsrelae';
  const ANDET_SE_NOTER = 'andet_se_noter';

  protected static $choices = [
    self::NONE           => '',
    self::PIR_I_AFBRYDER => 'Pir i afbryder',
    self::PIR_ON_OFF     => 'Pir on/off centralt',
    self::PIR_DGS        => 'Pir/DGS centralt',
    self::SKUMRINGSRELAE => 'Skumringsrelæ',
    self::ANDET_SE_NOTER => 'Andet, se noter',
  ];
}