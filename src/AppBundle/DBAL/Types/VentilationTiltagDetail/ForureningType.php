<?php
namespace AppBundle\DBAL\Types\VentilationTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class ForureningType extends AbstractEnumType
{
  const NONE = '';
  const A = 'A';
  const B = 'B';
  const C = 'C';

  protected static $choices = [
    self::NONE => 'None',
    self::A => 'A: Meget lav forurenet',
    self::B => 'B: Lavt forurenet',
    self::C => 'C: Ikke lavt forurenet',
  ];
}
