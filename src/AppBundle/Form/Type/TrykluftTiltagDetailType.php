<?php
/**
 * @file
 * TrykluftTiltagDetailType form class
 */

namespace AppBundle\Form\Type;

use AppBundle\Form\Type\TrykluftTiltagDetail\ElReduktionType;
use AppBundle\Form\Type\TrykluftTiltagDetail\IndDataType;
use AppBundle\Form\Type\TrykluftTiltagDetail\VarmeReduktionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TrykluftTiltagDetailType
 * @package AppBundle\Form
 */
class TrykluftTiltagDetailType extends TiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    $builder
      ->add('noter', null, array('required' => false))
      ->add('indData', IndDataType::class, array('label' => FALSE))
      ->add('elReduktion', 'collection', array(
          'type' => ElReduktionType::class,
          'label' => FALSE,
      ))
      ->add('varmeReduktion', VarmeReduktionType::class, array('label' => FALSE))
    ;
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\TrykluftTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_tryklufttiltagdetail';
  }
}
