<?php
/**
 * @file
 * KoelingTiltagDetail object
 */


namespace AppBundle\Form\Type;

use AppBundle\Entity\KoelingTiltagDetail;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class KoelingTiltagDetailType
 * @package AppBundle\Form
 */
class KoelingTiltagDetailType extends TiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    $builder
      ->add('tilstandDataFoer', VentilationTiltagDetailIndDataType::class, array(
          'fields' => KoelingTiltagDetail::getTilstandDataFoerInputKeys(),
        ))
      ->add('tilstandDataEfter', VentilationTiltagDetailIndDataType::class, array(
          'fields' => KoelingTiltagDetail::getTilstandDataEfterInputKeys(),
      ))
    ;
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\KoelingTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_koelingtiltagdetail';
  }
}
