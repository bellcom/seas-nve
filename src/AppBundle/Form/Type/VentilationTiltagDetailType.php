<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\DBAL\Types\VentilationTiltagDetail\ForureningType;
use AppBundle\DBAL\Types\VentilationTiltagDetail\KvalitetType;
use AppBundle\Entity\VentilationTiltagDetail;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class VentilationTiltagDetailType
 * @package AppBundle\Form
 */
class VentilationTiltagDetailType extends TiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    $builder
      ->add('laengdeVentileretRum')
      ->add('breddeVentileretRum')
      ->add('hoejdeVentileterRum')
      ->add('antalPersoner')
      ->add('udeluftTilfoersel')
      ->add('forurening', 'choice', array(
          'choices' => ForureningType::getChoices(),
      ))
      ->add('kvalitet', 'choice', array(
          'choices' => KvalitetType::getChoices(),
      ))
      ->add('indDataFoer', VentilationTiltagDetailIndDataType::class, array(
          'fields' => VentilationTiltagDetail::getIndDataFoerInputKeys(),
        ))
      ->add('indDataEfter', VentilationTiltagDetailIndDataType::class, array(
          'fields' => VentilationTiltagDetail::getIndDataEfterInputKeys(),
      ))
    ;
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\VentilationTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_ventilationtiltagdetail';
  }
}
