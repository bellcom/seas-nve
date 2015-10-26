<?php
namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class BygningStatusType extends AbstractEnumType
{

  const IKKE_STARTET  = 'Ikke startet';
  const DATA_VERIFICERET = 'Data verificeret';
  const TILKNYTTET_RAADGIVER  = 'Tilknyttet Rådgiver';
  const AFLEVERET_RAADGIVER = 'Afleveret af Rådgiver';
  const AAPLUS_VERIFICERET  = 'AaPlus Verificeret';
  const GODKENDT_AF_MAGISTRAT = 'Godkendt af magistrat';
  const UNDER_UDFOERSEL = 'Under udførsel';
  const DRIFT = 'Drift';

  protected static $choices = [
    self::IKKE_STARTET  => 'Ikke startet',
    self::DATA_VERIFICERET => 'Data verificeret',
    self::TILKNYTTET_RAADGIVER  => 'Tilknyttet Rådgiver',
    self::AFLEVERET_RAADGIVER => 'Afleveret af Rådgiver',
    self::AAPLUS_VERIFICERET  => 'AaPlus Verificeret',
    self::GODKENDT_AF_MAGISTRAT => 'Godkendt af magistrat',
    self::UNDER_UDFOERSEL => 'Under udførsel',
    self::DRIFT => 'Drift',
  ];
}