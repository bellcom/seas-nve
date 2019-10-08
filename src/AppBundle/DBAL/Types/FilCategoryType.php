<?php
namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class FilCategoryType extends AbstractEnumType
{
  const NONE = '';
  const RAPPORT_RESULTATOVERSIGT = 'rapport_resultatoversigt';
  const RAPPORT_DETAILARK = 'rapport_detailark';
  const RAPPORT_KORTLAEGNING = 'rapport_kortlaegning';

  protected static $choices = [
    self::NONE => '',
    self::RAPPORT_RESULTATOVERSIGT => 'Resultatoversigt',
    self::RAPPORT_DETAILARK => 'Detailark',
    self::RAPPORT_KORTLAEGNING => 'Kortlægning',
  ];
}
