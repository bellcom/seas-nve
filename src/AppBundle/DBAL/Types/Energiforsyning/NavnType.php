<?php
namespace AppBundle\DBAL\Types\Energiforsyning;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class NavnType extends AbstractEnumType
{
  const NONE              = '';
  const FJERNVARME        = 'fjernvarme';
  const HOVEDFORSYNING_EL = 'hovedforsyning_el';
  const OLIEFYR           = 'oliefyr';
  const TRAEPILLEFYR      = 'traepillefyr';
  const VARMEPUMPE        = 'varmepumpe';
  const GAS               = 'gas';
  const FAST_BRAENDSEL    = 'fast_braendsel';

  protected static $choices = [
    self::NONE              => '',
    self::FJERNVARME        => 'Fjernvarme',
    self::HOVEDFORSYNING_EL => 'Hovedforsyning El',
    self::OLIEFYR           => 'Oliefyr',
    self::TRAEPILLEFYR      => 'Træpillefyr',
    self::VARMEPUMPE        => 'Varmepumpe',
    self::GAS               => 'Gas',
    self::FAST_BRAENDSEL    => 'Fast brændsel',
  ];
}
