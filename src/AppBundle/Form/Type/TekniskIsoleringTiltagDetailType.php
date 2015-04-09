<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TekniskIsoleringTiltagDetailType
 * @package AppBundle\Form
 */
class TekniskIsoleringTiltagDetailType extends TiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    $builder
      ->add('laastAfEnergiraadgiver', null, array(
        'required' => false,
      ))
      ->add('beskrivelseType')
      ->add('type', 'choice', array(
        'choices' => array(
          'Rør' => 'Rør',
          'Beholder' => 'Beholder'
        ),
      ))
      ->add('driftstidTAar')
      ->add('udvDiameterMm')
      ->add('eksistIsolMm')
      ->add('roerstoerrelseMmAekvivalent')
      ->add('tankVolL')
      ->add('tempOmgivelC')
      ->add('tempMedieC')
      ->add('roerlaengdeEllerHoejdeAfVvbM')
      ->add('nyttiggjortVarme')
      ->add('nyIsolMm')
      ->add('standardinvestKrM2EllerKrM')
      ->add('prisfaktor');
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\TekniskIsoleringTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_tekniskisoleringtiltagdetail';
  }
}
