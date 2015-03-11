<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class PumpeTiltagDetailType
 * @package AppBundle\Form
 */
class PumpeTiltagDetailType extends TiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    $builder
      ->add('pumpeID')
      ->add('forsyningsomraade')
      ->add('placering')
      ->add('applikation')
      ->add('isoleringskappe')
      ->add('b_faktor')
      ->add('noter')
      ->add('eksisterendeDrifttid')
      ->add('nyDrifttid')
      ->add('prisfaktor');
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\PumpeTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_pumpetiltagdetail';
  }
}
