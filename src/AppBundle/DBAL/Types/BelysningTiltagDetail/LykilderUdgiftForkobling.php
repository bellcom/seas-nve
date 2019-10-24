<?php

namespace AppBundle\DBAL\Types\BelysningTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class LykilderUdgiftForkobling extends AbstractEnumType
{
    const NONE = '';
    const KONV = 'konv.';
    const HF = 'hf';

    protected static $choices = [
        self::NONE => self::NONE,
        self::KONV => self::KONV,
        self::HF => self::HF,
    ];
}
