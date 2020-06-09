<?php

namespace AppBundle\DBAL\Types\BelysningTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class LykilderBenyttelsesFaktor extends AbstractEnumType
{
    const _05 = '0.5';
    const _07 = '0.7';
    const _08 = '0.8';
    const _09 = '0.9';
    const _10 = '1';

    protected static $choices = [
        self::_05 => self::_05,
        self::_07 => self::_07,
        self::_08 => self::_08,
        self::_09 => self::_09,
        self::_10 => '1.0',
    ];
}
