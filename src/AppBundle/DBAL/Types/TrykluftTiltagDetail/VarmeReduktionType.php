<?php
namespace AppBundle\DBAL\Types\TrykluftTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class VarmeReduktionType extends AbstractEnumType
{
  const LUFT_BASERET = 'luftbaseret';
  const VAND_BASERET = 'vandbaseret';

  protected static $choices = [
    self::LUFT_BASERET => 'Luftbaseret varmegenvinding, luften føres ind i lokalet eller til tilstødende lokaler.',
    self::VAND_BASERET => 'Vandbaseret varmegenvinding via oliekøler.',
  ];
}
