<?php
/**
 * @file
 * KoeleanlaegTiltagDetail object
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\KoeleanlaegTiltagDetail;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class KoeleanlaegTiltagDetailType
 * @package AppBundle\Form
 */
class KoeleanlaegTiltagDetailType extends TiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    $builder
      ->add('tilstandDataFoer', KoeleanlaegTiltagDetailIndDataType::class, array(
          'fields' => KoeleanlaegTiltagDetail::getTilstandDataFoerInputKeys(),
        ))
      ->add('tilstandDataEfter', KoeleanlaegTiltagDetailIndDataType::class, array(
          'fields' => KoeleanlaegTiltagDetail::getTilstandDataEfterInputKeys(),
      ))
    ;
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\KoeleanlaegTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_koeleanlaegtiltagdetail';
  }
}
