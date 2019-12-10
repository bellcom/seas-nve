<?php

namespace AppBundle\DBAL\Types\BelysningTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class LykilderUdgiftType extends AbstractEnumType
{
    const NONE = '';
    const LER_ROER = 'LED-rør';
    const LED_PAERE = 'LEDpære';
    const Gl = 'Gl';
    const SP = 'Sp.';
    const LED_ARM = 'LED-arm.';
    const KOM_K = 'Kom. K';
    const HAL = 'Hal.';

    protected static $choices = [
        self::NONE => '--',
        self::LER_ROER => self::LER_ROER,
        self::LED_PAERE => self::LED_PAERE,
        self::Gl => self::Gl,
        self::SP => self::SP,
        self::LED_ARM => self::LED_ARM,
        self::KOM_K => self::KOM_K,
        self::HAL => self::HAL,
    ];
}
