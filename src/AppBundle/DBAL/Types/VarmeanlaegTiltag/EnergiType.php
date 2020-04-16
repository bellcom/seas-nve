<?php
namespace AppBundle\DBAL\Types\VarmeanlaegTiltag;

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
        self::OLIE => 'appbundle.varmeanlaegtiltagdetail.energiType.' . self::OLIE,
        self::NATURGAS => 'appbundle.varmeanlaegtiltagdetail.energiType.' . self::NATURGAS,
        self::FJERMVARME => 'appbundle.varmeanlaegtiltagdetail.energiType.' . self::FJERMVARME,
        self::TRAEPILLER => 'appbundle.varmeanlaegtiltagdetail.energiType.' . self::TRAEPILLER,
        self::ELVARME => 'appbundle.varmeanlaegtiltagdetail.energiType.' . self::ELVARME,
        self::VARMEPUMPE => 'appbundle.varmeanlaegtiltagdetail.energiType.' . self::VARMEPUMPE,
    ];
}
