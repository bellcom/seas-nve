<?php
namespace AppBundle\DBAL\Types\TrykluftTiltagDetail;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class ElReduktionType extends AbstractEnumType
{
  const NONE = '';
  const TRYK = 'tryk';
  const TEMPERATUR = 'temperatur';
  const LAEKAGETAB = 'laekagetab';
  const STOP = 'stop';
  const FREKVENSSTYRING = 'frekvensstyring';

  protected static $choices = [
    self::NONE => 'None',
    self::TRYK => 'Reduktion af tryk. 6% besparelse for hver bar trykket sænkes',
    self::TEMPERATUR => 'Red. af temperatur luftindsugning, 1% el-besparelse ved red. af temp. 40 -> 35 °C',
    self::LAEKAGETAB => 'Lækagetab. Afhænger også af afgangstryk på luftkompressor',
    self::STOP => 'Stop af anlæg uden for arbejdstid => mindsket lækagetab => stop andel',
    self::FREKVENSSTYRING => 'Reduktion af aflastet elforbrug ved frekvensstyring (Maks 90%)',
  ];
}
