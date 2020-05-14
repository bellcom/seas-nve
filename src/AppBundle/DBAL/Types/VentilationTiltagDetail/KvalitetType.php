<?php
namespace AppBundle\DBAL\Types\VentilationTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class KvalitetType extends AbstractEnumType
{
  const NONE = '';
  const _1 = 1;
  const _2 = 2;
  const _3 = 3;

  protected static $choices = [
    self::NONE => 'None',
    self::_1 => self::_1,
    self::_2 => self::_2,
    self::_3 => self::_3,
  ];
}
