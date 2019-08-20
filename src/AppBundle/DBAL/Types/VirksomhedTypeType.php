<?php
namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class VirksomhedTypeType extends AbstractEnumType
{
  const SCREENING = 'screening';
  const UNDERSEOGELSE = 'undeseogelse';
  const EMO = 'emo';
  const ENERGILEDELSE = 'energiledelse';
  const ENERGISYN = 'energisyn';

  protected static $choices = [
    self::SCREENING  => 'Screening',
    self::UNDERSEOGELSE  => 'Undersøgelse',
    self::EMO  => 'EMO',
    self::ENERGILEDELSE  => 'Energiledelse',
    self::ENERGISYN  => 'Energisyn',
  ];
}
