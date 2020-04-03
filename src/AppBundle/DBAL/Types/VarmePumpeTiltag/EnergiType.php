<?php
namespace AppBundle\DBAL\Types\VarmePumpeTiltag;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class EnergiType extends AbstractEnumType
{
    const OLIE = 'olie';
    const NATURGAS = 'naturgas';
    const FJERMVARME = 'fjernvarme';
    const TRAEPILLER = 'traepiller';
    const ELVARME = 'elvarme';
    const VARMEPUMPE = 'varmepumpe';

    protected static $choices = [
        self::OLIE => 'appbundle.varmetiltagdetail.energiType.' . self::OLIE,
        self::NATURGAS => 'appbundle.varmetiltagdetail.energiType.' . self::NATURGAS,
        self::FJERMVARME => 'appbundle.varmetiltagdetail.energiType.' . self::FJERMVARME,
        self::TRAEPILLER => 'appbundle.varmetiltagdetail.energiType.' . self::TRAEPILLER,
        self::ELVARME => 'appbundle.varmetiltagdetail.energiType.' . self::ELVARME,
        self::VARMEPUMPE => 'appbundle.varmetiltagdetail.energiType.' . self::VARMEPUMPE,
    ];
}
