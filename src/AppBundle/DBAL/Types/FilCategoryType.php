<?php
namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class FilCategoryType extends AbstractEnumType
{
  const NONE = '';
  const RAPPORT_RESULTATOVERSIGT = 'rapport_resultatoversigt';
  const RAPPORT_ENERGISYN = 'rapport_energisyn';
  const RAPPORT_SCREENING = 'rapport_screening';
  const RAPPORT_DETAILARK = 'rapport_detailark';
  const RAPPORT_KORTLAEGNING = 'rapport_kortlaegning';

  protected static $choices = [
    self::NONE => '',
    self::RAPPORT_RESULTATOVERSIGT => 'Resultatoversigt',
    self::RAPPORT_ENERGISYN => 'Energisyn',
    self::RAPPORT_SCREENING => 'Screening',
    self::RAPPORT_DETAILARK => 'Detailark',
    self::RAPPORT_KORTLAEGNING => 'Kortlægning',
  ];
}
