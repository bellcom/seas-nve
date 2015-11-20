<?php
namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class CardinalDirectionType extends AbstractEnumType
{
  const NONE  = '';
  const NORTH = 'north';
  const EAST  = 'east';
  const SOUTH = 'south';
  const WEST  = 'west';

  protected static $choices = [
    self::NONE  => '',
    self::NORTH => 'North',
    self::EAST  => 'East',
    self::SOUTH => 'South',
    self::WEST  => 'West',
  ];
}