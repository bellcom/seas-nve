<?php
namespace AppBundle\DBAL\Types\Energiforsyning;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class NavnType extends AbstractEnumType
{
  const NONE              = '';
  const HOVEDFORSYNING_EL = 'hovedforsyning_el';
  const OLIEFYR           = 'oliefyr';
  const TRÆPILLEFYR       = 'træpillefyr';
  const VARMEPUMPE        = 'varmepumpe';

  protected static $choices = [
    self::NONE              => '',
    self::HOVEDFORSYNING_EL => 'Hovedforsyning El',
    self::OLIEFYR           => 'Oliefyr',
    self::TRÆPILLEFYR       => 'Træpillefyr',
    self::VARMEPUMPE        => 'Varmepumpe',
  ];
}