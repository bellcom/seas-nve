<?php
namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class MonthType extends AbstractEnumType
{
  const NONE = '';
    const JANUAR = 'januar';
    const FEBRUAR = 'februar';
    const MARTS = 'marts';
    const APRIL = 'april';
    const MAJ = 'maj';
    const JUNI = 'juni';
    const JULI = 'juli';
    const AUGUST = 'august';
    const SEPTEMBER = 'september';
    const OKTOBER = 'oktober';
    const NOVEMBER = 'november';
    const DECEMBER = 'december';

  protected static $choices = [
    self::NONE => '',
    self::JANUAR => 'Januar',
    self::FEBRUAR =>'Februar',
    self::MARTS => 'Marts',
    self::APRIL => 'April',
    self::MAJ => 'Maj',
    self::JUNI => 'Juni',
    self::JULI => 'Juli',
    self::AUGUST => 'August',
    self::SEPTEMBER => 'September',
    self::OKTOBER => 'Oktober',
    self::NOVEMBER => 'November',
    self::DECEMBER => 'December',
  ];
}
