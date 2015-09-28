<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class VindueTiltagDetailType
 * @package AppBundle\Form
 */
class VindueTiltagDetailType extends KlimaskaermTiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    $builder
      ->add('orientering', 'choice', array(
        'choices' => array(
          'Nord' => 'Nord',
          'Syd' => 'Syd',
          'Øst' => 'Øst',
          'Vest' => 'Vest',
        ),
        'choices_as_values' => true,
      ))
      ->add('solenergitransmittansEks', 'percent')
      ->add('solenergitransmittansNy', 'percent')
      ;
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\VindueTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_vinduetiltagdetail';
  }
}
