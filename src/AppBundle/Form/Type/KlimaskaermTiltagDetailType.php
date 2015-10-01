<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
      ->add('orientering', 'choice', array(
        'choices' => array(
          'orientation.north' => 'north',
          'orientation.south' => 'south',
          'orientation.east' => 'east',
          'orientation.west' => 'west',
        ),
        'choices_as_values' => true,
      ))
      ->add('klimaskaerm')
      ->add('typePlaceringJfPlantegning')
      ->add('hoejdeElLaengdeM')
      ->add('breddeM')
      ->add('antalStk')
      ->add('andelAfArealDerEfterisoleres', 'percent')
      ->add('uEksWM2K')
      ->add('uNyWM2K')
      ->add('tIndeC')
      ->add('tUdeC')
      ->add('tOpvarmningTimerAar')
      ->add('yderligereBesparelserPct', 'percent')
      ->add('prisfaktor')
      ->add('noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet', null, array(
        'required' => false,
      ))
      ->add('levetidAar')
      ;
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\KlimaskaermTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_klimaskaermtiltagdetail';
  }
}
