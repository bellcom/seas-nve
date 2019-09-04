<?php
namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class ContactPersonReferenceType extends AbstractEnumType
{
    const VIRKSOMHED = 'virksomhed';
    const BYGNING = 'bygning';

    protected static $choices = [
        self::VIRKSOMHED  => 'virksomhed',
        self::BYGNING  => 'bygning',
    ];
}
