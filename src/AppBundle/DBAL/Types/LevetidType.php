<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class LevetidType extends AbstractEnumType {

  const NONE  = '';
  const LEVETID5 = 5;
  const LEVETID10 = 10;
  const LEVETID15 = 15;
  const LEVETID20 = 20;
  const LEVETID25 = 25;
  const LEVETID30 = 30;
  const LEVETID40 = 40;

  protected static $choices = [
    self::NONE  => '-',
    self::LEVETID5  => '5',
    self::LEVETID10  => '10',
    self::LEVETID15  => '15',
    self::LEVETID20  => '20',
    self::LEVETID25  => '25',
    self::LEVETID30  => '30',
    self::LEVETID40  => '40',
  ];
}