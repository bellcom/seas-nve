<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SpecialTiltagDetailType
 * @package AppBundle\Form
 */
class SpecialTiltagDetailType extends TiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    $builder
      ->add('kommentar')
      ->add('filepath_display', 'url', array(
        'property_path' => 'filepath',
        'read_only' => true,
      ))
      ->add('filepath', 'file', array(
        'data_class' => null,
        // 'required' => false,
      ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\SpecialTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_specialtiltagdetail';
  }
}
