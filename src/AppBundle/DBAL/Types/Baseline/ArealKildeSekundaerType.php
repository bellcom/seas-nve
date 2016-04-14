<?php
namespace AppBundle\DBAL\Types\Baseline;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class ArealKildeSekundaerType extends AbstractEnumType {
  const INGEN_SEKUNDAER_KILDE_VURDERES_NOEDVENDIG = 'ingen_sekundaer_kilde_vurderes_noedvendig';
  const CARETAKER = 'caretaker';
  const TEGNINGSFILER_I_KONTAINER = 'tegningsfiler_i_kontainer';
  const BBR_MEDDELELSE = 'bbr_meddelelse';
  const BYGNINGSKONSULENT_VED_AAK = 'bygningskonsulent_ved_aak';
  const MARK_KONTROL = 'mark_kontrol';

  protected static $choices = [
    self::INGEN_SEKUNDAER_KILDE_VURDERES_NOEDVENDIG => 'Ingen sekundær kilde vurderes nødvendig',
    self::CARETAKER => 'Caretaker',
    self::TEGNINGSFILER_I_KONTAINER => 'Tegningsfiler i KONTAINER',
    self::BBR_MEDDELELSE => 'BBR-meddelelse',
    self::BYGNINGSKONSULENT_VED_AAK => 'Bygningskonsulent ved AaK',
    self::MARK_KONTROL => 'Mark-kontrol',
  ];
}