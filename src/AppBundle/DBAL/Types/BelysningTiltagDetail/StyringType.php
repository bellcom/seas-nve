<?php
namespace AppBundle\DBAL\Types\BelysningTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class StyringType extends AbstractEnumType
{
  const NONE                                          = '';
  const S1_AFBRYDER_I_RUM                             = 'S1';
  const S2_PIR_I_LOFT_ON_OFF_MED_LUXFOELER            = 'S2';
  const S3_PIR_I_EKSISTERENDE_AFBRYDER                = 'S3';
  const S4_PIR_I_LOFT_MED_KONTINUERLIG_DAGSLYSSTYRING = 'S4';
  const S5_NOEGLE_AFBRYDER                            = 'S5';
  const S6_URSTYRET                                   = 'S6';
  const S7_SKUMRINGSRELAE                             = 'S7';
  const S8_SKUMRINGSRELAE_MED_OVERSTYRING_AF_UR       = 'S8';
  const S9_ANDET_SE_NOTER                             = 'S9';

  protected static $choices = [
    self::NONE                                          => '',
    self::S1_AFBRYDER_I_RUM                             => 'S1-Afbryder i rum',
    self::S2_PIR_I_LOFT_ON_OFF_MED_LUXFOELER            => 'S2-PIR i loft on/off med luxføler',
    self::S3_PIR_I_EKSISTERENDE_AFBRYDER                => 'S3-PIR i eksisterende afbryder ',
    self::S4_PIR_I_LOFT_MED_KONTINUERLIG_DAGSLYSSTYRING => 'S4-PIR i loft med kontinuerlig dagslysstyring',
    self::S5_NOEGLE_AFBRYDER                            => 'S5-Nøgle afbryder',
    self::S6_URSTYRET                                   => 'S6-Urstyret',
    self::S7_SKUMRINGSRELAE                             => 'S7-Skumringsrelæ',
    self::S8_SKUMRINGSRELAE_MED_OVERSTYRING_AF_UR       => 'S8-Skumringsrelæ med overstyring af ur',
    self::S9_ANDET_SE_NOTER                             => 'S9-Andet, se noter',
  ];
}
