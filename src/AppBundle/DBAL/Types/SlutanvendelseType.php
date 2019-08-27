<?php
namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class SlutanvendelseType extends AbstractEnumType
{
  const BELYSNING = 'belysning';
  const VENTILATION = 'ventilation';
  const PUMPER = 'pumper';
  const KOELING = 'koeling';
  const TRYKLUFT = 'trykluft';
  const PROCESUDSTYR = 'procesudstyr';
  const VARMEANLAEG = 'varmeanlaeg';
  const KLIMASKAERM = 'klimaskaerm';
  const VINDUER = 'vinduer';
  const ELVARME_RUMVARME = 'elvarme_rumvarme';
  const ELMOTORER_INTERN_TRANSPORT = 'elmotorer_intern_transport';
  const ENERGIFORBRUGENDE_APPARATER = 'energiforbrugende_apparater';
  const OEVRIGE = 'oevrige';
  const KEDLER_UDSKIFTNING = 'kedler_udskiftning';
  const KEDLER_SERVICEEFTERSYN = 'kedler_serviceeftersyn';

  protected static $choices = [
    self::BELYSNING  => 'Belysning',
    self::VENTILATION  => 'Ventilation',
    self::PUMPER  => 'Pumper',
    self::KOELING  => 'Køling',
    self::TRYKLUFT  => 'Trykluft',
    self::PROCESUDSTYR  => 'Procesudstyr',
    self::VARMEANLAEG  => 'Varmeanlæg',
    self::KLIMASKAERM  => 'Klimaskærm',
    self::VINDUER  => 'Vinduer',
    self::ELVARME_RUMVARME  => 'Elvarme - Rumvarme',
    self::ELMOTORER_INTERN_TRANSPORT  => 'Elmotorer- og transmission til intern transport',
    self::ENERGIFORBRUGENDE_APPARATER  => 'Mindre energiforbrugende apparater',
    self::OEVRIGE  => 'Øvrige',
    self::KEDLER_UDSKIFTNING  => 'Kedler - udskiftning',
    self::KEDLER_SERVICEEFTERSYN  => 'Kedler - serviceeftersyn',
  ];
}
