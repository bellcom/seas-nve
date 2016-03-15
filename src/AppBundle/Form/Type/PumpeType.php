<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PumpeType extends AbstractType {
  /**
   * @param FormBuilderInterface $builder
   * @param array $options
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
      ->add('roerstoerrelse');
  }

  /**
   * @param OptionsResolverInterface $resolver
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Pumpe'
    ));
  }

  /**
   * @return string
   */
  public function getName() {
    return 'appbundle_pumpe';
  }
}
