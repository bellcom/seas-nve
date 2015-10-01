<?php
namespace AppBundle\DBAL\Types\Energiforsyning\InternProduktion;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class PrisgrundlagType extends AbstractEnumType
{
  const NONE  = '';
  const EL    = 'el';
  const VAND  = 'vand';
  const VARME = 'varme';

  protected static $choices = [
    self::NONE  => '',
    self::EL    => 'El',
    self::VAND  => 'Vand',
    self::VARME => 'Varme',
  ];
}