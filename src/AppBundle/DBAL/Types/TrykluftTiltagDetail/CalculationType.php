<?php
namespace AppBundle\DBAL\Types\TrykluftTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class CalculationType extends AbstractEnumType
{
  const ON_OFF = 'on_off';
  const FREKVENSSTYRET = 'frekvensstyret';

  protected static $choices = [
    self::ON_OFF => 'appbundle.tryklufttiltagdetail.indData.type.' . self::ON_OFF,
    self::FREKVENSSTYRET => 'appbundle.tryklufttiltagdetail.indData.type.' . self::FREKVENSSTYRET,
  ];
}
