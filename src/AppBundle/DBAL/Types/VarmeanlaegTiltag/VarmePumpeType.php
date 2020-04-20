<?php
namespace AppBundle\DBAL\Types\VarmeanlaegTiltag;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class VarmePumpeType extends AbstractEnumType
{
    const JORD_MED_GULV = 'jord_med_gulv';
    const JORD_MED_RADIATOR = 'jord_med_radiator';
    const LUFTVAND_MED_JORD = 'luftvand_med_gulv';
    const LUFTVAND_MED_RADIATOR = 'luftvand_med_radiator';

    protected static $choices = [
        self::JORD_MED_GULV => 'appbundle.varmetiltagdetail.varmePumpeType.' . self::JORD_MED_GULV,
        self::JORD_MED_RADIATOR => 'appbundle.varmetiltagdetail.varmePumpeType.' . self::JORD_MED_RADIATOR,
        self::LUFTVAND_MED_JORD => 'appbundle.varmetiltagdetail.varmePumpeType.' . self::LUFTVAND_MED_JORD,
        self::LUFTVAND_MED_RADIATOR => 'appbundle.varmetiltagdetail.varmePumpeType.' . self::LUFTVAND_MED_RADIATOR,
    ];
}
