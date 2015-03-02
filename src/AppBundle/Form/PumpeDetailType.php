<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class PumpeDetailType
 * @package AppBundle\Form
 */
class PumpeDetailType extends AbstractType {
  /**
   * @TODO: Missing description.
   *
   * @param FormBuilderInterface $builder
   *   @TODO: Missing description.
   * @param array $options
   *   @TODO: Missing description.
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('tilvalgt')
      ->add('pumpeID')
      ->add('forsyningsomraade')
      ->add('placering')
      ->add('applikation')
      ->add('isoleringskappe')
      ->add('b_faktor')
      ->add('noter')
      ->add('eksisterendeDrifttid')
      ->add('nyDrifttid')
      ->add('prisfaktor')
      ->add('pumpetiltag')
      ->add('pumpe');
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolverInterface $resolver
   *   @TODO: Missing description.
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\PumpeDetail'
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_pumpedetail';
  }
}
