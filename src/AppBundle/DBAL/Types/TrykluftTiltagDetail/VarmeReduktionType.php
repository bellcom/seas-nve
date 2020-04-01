<?php
namespace AppBundle\DBAL\Types\TrykluftTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class VarmeReduktionType extends AbstractEnumType
{
  const NONE = 'none';
  const LUFT_BASERET = 'luftbaseret';
  const VAND_BASERET = 'vandbaseret';

  protected static $choices = [
    self::NONE => 'None',
    self::LUFT_BASERET => 'Luftbaseret varmegenvinding, luften føres ind i lokalet eller til tilstødende lokaler. (Potentiale 80%)',
    self::VAND_BASERET => 'Vandbaseret varmegenvinding via oliekøler. (Potentiale 65%)',
  ];
}
