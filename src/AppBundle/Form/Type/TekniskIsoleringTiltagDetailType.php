<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
      ->add('komponent', null, array(
        'required' => false,
      ))
      ->add('driftstidTAar')
      ->add('udvDiameterMm')
      ->add('eksistIsolMm')
      ->add('tempOmgivelC')
      ->add('tempMedieC')
      ->add('roerlaengdeEllerHoejdeAfVvbM')
      ->add('nyIsolMm')
      ->add('standardinvestKrM2EllerKrM')
      ->add('overskrevetPris')
      ->add('prisfaktor');

    if($this->isBatchEdit) {
      $builder->add('nyttiggjortVarme', null, array(
        'required' => false,
        'placeholder' => '--',
        'empty_data'  => null
      ));
      $builder->add('type', 'choice', array(
        'choices' => array(
          'Rør' => 'Rør',
          'Komponenter' => 'Komponenter',
        ),
        'placeholder' => '--',
        'empty_data'  => null
      ));
    } else {
      $builder->add('nyttiggjortVarme', null, array(
        'required' => true,
      ));
      $builder->add('type', 'choice', array(
        'choices' => array(
          'Rør' => 'Rør',
          'Komponenter' => 'Komponenter',
        ),
      ));
    }
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\TekniskIsoleringTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_tekniskisoleringtiltagdetail';
  }
}
