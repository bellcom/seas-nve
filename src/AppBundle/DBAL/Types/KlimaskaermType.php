<?php
namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class KlimaskaermType extends AbstractEnumType
{
  const NONE = '';
  const KLIMASKAERM = 'klimaskaerm';
  const WINDOW = 'window';

  protected static $choices = [
    self::NONE => '',
    self::KLIMASKAERM => 'Klimaskaerm',
    self::WINDOW => 'Window',
  ];
}
