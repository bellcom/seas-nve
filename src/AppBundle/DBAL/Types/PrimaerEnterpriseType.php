<?php
namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class PrimaerEnterpriseType extends AbstractEnumType
{
  const NONE = '';
  const EL = 'el';
  const TOEMRER_ISOLATOER = 't/i';
  const VE = 've';
  const VVS = 'vvs';
  const HAARDE_HVIDEVARER = 'hh';
  const AUTOMATIK = 'a';
  const INTERNE_I_AAK = 'ia';
  const TOEMRER = 't';

  protected static $choices = [
    self::NONE => '',
    self::EL => 'El',
    self::TOEMRER_ISOLATOER => 'Tømrer/Isolatør',
    self::VE => 'VE',
    self::VVS => 'VVS',
    self::HAARDE_HVIDEVARER => 'Hårde hvidevarer',
    self::AUTOMATIK => 'Automatik',
    self::INTERNE_I_AAK => 'Interne i AAK',
    self::TOEMRER => 'Tømrer',
  ];
}
