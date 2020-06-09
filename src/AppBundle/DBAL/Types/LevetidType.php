<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class LevetidType extends AbstractEnumType {

  const NONE  = '';
  const LEVETID5 = 5;
  const LEVETID10 = 10;
  const LEVETID15 = 15;
  const LEVETID20 = 20;
  const LEVETID25 = 25;
  const LEVETID30 = 30;
  const LEVETID40 = 40;

  protected static $choices = [
    self::NONE  => '-',
    self::LEVETID5  => '5 år - Lyskilder',
    self::LEVETID10  => '10 år - Fugetætningsarbejder',
    self::LEVETID15  => '15 år - Belysninsarmaturer. Automatik til varme og klimaanlæg.',
    self::LEVETID20  => '20 år - Varmeproducerende anlæg mv., f.eks kedler, varmepumper, solvarmeanlæg, ventilationsaggregater ',
    self::LEVETID25  => '25 år - Solceller',
    self::LEVETID30  => '30 år - Vinduer samt fotsatsrammer og koblede rammer. Varmeanlæg, radiatorer og gulvvarme samt ventilationskanaler og armaturer inklusive isolering.',
    self::LEVETID40  => '40 år - Efterisolering af bygningsdele',
  ];
}
