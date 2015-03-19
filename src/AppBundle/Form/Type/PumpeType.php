<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class PumpeType
 * @package AppBundle\Form
 */
class PumpeType extends AbstractType {
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
      ->add('nuvaerendeType')
      ->add('byggemaal')
      ->add('tilslutning')
      ->add('indst')
      ->add('forbrug')
      ->add('q')
      ->add('h')
      ->add('aarsforbrug')
      ->add('nyPumpe')
      ->add('nyByggemaal')
      ->add('nyTilslutning')
      ->add('vvsnr')
      ->add('nytAarsforbrug')
      ->add('elbesparelse')
      ->add('udligningssaet')
      ->add('kommentarer')
      ->add('standInvestering')
      ->add('fabrikant')
      ->add('roerlaengde')
      ->add('roerstoerrelse')
      ;
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolverInterface $resolver
   *   @TODO: Missing description.
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Pumpe'
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_pumpe';
  }
}
