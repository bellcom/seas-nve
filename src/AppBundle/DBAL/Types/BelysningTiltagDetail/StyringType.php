<?php
namespace AppBundle\DBAL\Types\BelysningTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class StyringType extends AbstractEnumType
{
  const NONE = '';
  const AFBRYDER_I_RUM   = 'afbryder_i_rum';
  const PIR_ON_OFF       = 'pir_on_off';
  const PIR_DGS          = 'pir_dgs';
  const SKUMRINGSRELAE   = 'skumringsrelae';
  const PIR_I_AFBRYDER   = 'pir_i_afbryder';
  const CENTRAL_AFBRYDER = 'central_afbryder';
  const URSTYRET         = 'urstyret';
  const ANDET_SE_NOTER   = 'andet_se_noter';

  protected static $choices = [
    self::NONE             => '',
    self::AFBRYDER_I_RUM   => 'Afbryder i rum',
    self::PIR_ON_OFF       => 'PIR on/off',
    self::PIR_DGS          => 'PIR-/DGS',
    self::SKUMRINGSRELAE   => 'Skumringsrelæ',
    self::PIR_I_AFBRYDER   => 'PIR i afbryder',
    self::CENTRAL_AFBRYDER => 'Central afbryder',
    self::URSTYRET         => 'Urstyret',
    self::ANDET_SE_NOTER   => 'Andet, se Noter',
 ];
}