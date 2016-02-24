<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class RisikovurderingType extends AbstractEnumType {
  const LAV = 'lav';
  const MELLEM = 'mellem';
  const HOEJ = 'hoej';

  protected static $choices = [
    self::LAV => 'Lav',
    self::MELLEM => 'Mellem',
    self::HOEJ => 'Høj',
  ];
}