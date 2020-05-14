<?php
namespace AppBundle\DBAL\Types\TrykluftTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class ElForbrugBeregningType extends AbstractEnumType
{
  const CALCULATED = 'calculated';
  const FIXED = 'fixed';

  protected static $choices = [
    self::CALCULATED => 'appbundle.tryklufttiltagdetail.indData.elForbrugBeregning.' . self::CALCULATED,
    self::FIXED => 'appbundle.tryklufttiltagdetail.indData.elForbrugBeregning.' . self::FIXED,
  ];
}
