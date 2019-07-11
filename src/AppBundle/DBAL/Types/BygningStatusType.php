<?php
namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class BygningStatusType extends AbstractEnumType
{

  const IKKE_STARTET  = '1_IS';
  const DATA_VERIFICERET = '2_DV';
  const TILKNYTTET_RAADGIVER  = '3_TR';
  const AFLEVERET_RAADGIVER = '4_AR';
  const AAPLUS_VERIFICERET  = '5_AV';
  const GODKENDT_AF_MAGISTRAT = '6_GM';
  const UNDER_UDFOERSEL = '7_UU';
  const DRIFT = '8_DR';

  protected static $choices = [
    self::IKKE_STARTET  => '1. Ikke startet',
    self::DATA_VERIFICERET => '2. Data verificeret',
    self::TILKNYTTET_RAADGIVER  => '3. Tilknyttet Rådgiver',
    self::AFLEVERET_RAADGIVER => '4. Afleveret af Rådgiver',
    // @SEAS-NVE adaptation begin.
    // @ToBeRefactored with using configuration layer.
    self::AAPLUS_VERIFICERET  => '5. Verificeret',
    self::GODKENDT_AF_MAGISTRAT => '6. Godkendt',
    // @SEAS-NVE adaptation end.
    self::UNDER_UDFOERSEL => '7. Under udførsel',
    self::DRIFT => '8. Drift',
  ];
}
