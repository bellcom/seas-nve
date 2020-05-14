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

  public static function getMonthDays() {
    return [
      self::JANUAR => 31,
      self::FEBRUAR => 28,
      self::MARTS => 31,
      self::APRIL => 30,
      self::MAJ => 31,
      self::JUNI => 30,
      self::JULI => 31,
      self::AUGUST => 31,
      self::SEPTEMBER => 30,
      self::OKTOBER => 31,
      self::NOVEMBER => 30,
      self::DECEMBER => 31,
    ];
  }
}
