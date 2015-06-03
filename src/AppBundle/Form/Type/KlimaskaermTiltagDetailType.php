<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class KlimaskaermTiltagDetailType
 * @package AppBundle\Form
 */
class KlimaskaermTiltagDetailType extends TiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    $builder
      ->add('laastAfEnergiraadgiver', null, array(
        'required' => false,
      ))
      ->add('tiltagsnr', null, array(
        'required' => false,
      ))
      ->add('tiltagsnrDelpriser', null, array(
        'required' => false,
      ))
      ->add('typePlaceringJfPlantegning')
      ->add('hoejdeElLaengdeM')
      ->add('breddeM')
      ->add('antalStk')
      ->add('andelAfArealDerEfterisoleres')
      ->add('uEksWM2K')
      ->add('uNyWM2K')
      ->add('tIndeC')
      ->add('tUdeC')
      ->add('tOpvarmningTimerAar')
      ->add('yderligereBesparelserPct')
      ->add('prisfaktor')
      ->add('noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet', null, array(
        'required' => false,
      ))
      ->add('levetidAar')
      ;
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\KlimaskaermTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_klimaskaermtiltagdetail';
  }
}