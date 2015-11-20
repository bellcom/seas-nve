<?php
namespace AppBundle\DBAL\Types\BelysningTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class PlaceringType extends AbstractEnumType
{
  const NONE = '';
  const NEDHAENGT      = 'nedhaengt';
  const INDBYGGET      = 'indbygget';
  const PAABYGGET      = 'paabygget';
  const STAAENDE       = 'staaende';
  const ANDET_SE_NOTER = 'andet_se_noter';

  protected static $choices = [
    self::NONE           => '',
    self::NEDHAENGT      => 'Nedhængt',
    self::INDBYGGET      => 'Indbygget',
    self::PAABYGGET      => 'Påbygget',
    self::STAAENDE       => 'Stående',
    self::ANDET_SE_NOTER => 'Andet, se Noter',
  ];
}