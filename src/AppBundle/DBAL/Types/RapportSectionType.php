<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class RapportSectionType extends AbstractEnumType {
    const SIMPLE_TEXT = 'simple_text';
    const FRONT_PAGE = 'frontpage';

    protected static $choices = [
        self::SIMPLE_TEXT => 'Simple text',
        self::FRONT_PAGE => 'Frontpage',
    ];
}
