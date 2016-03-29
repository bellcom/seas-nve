<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EnergiforsyningType
 * @package AppBundle\Form
 */
class EnergiforsyningType extends AbstractType {
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
      ->add('navn', NULL, array(
        'required' => TRUE,
      ))
      ->add('beskrivelse')
      ->add('forsyningsvaerk', NULL, array('disabled' => TRUE))
      ->add('enhedspris', 'number', array('disabled' => TRUE))
      ->add('prisfaktor')
      ->add('nyEnhedspris', 'number', array('disabled' => TRUE))
      ->add('internProduktioner', 'bootstrap_collection', array(
        'property_path' => 'internProduktions',
        'type' => new InternProduktionType(),
        'allow_add' => true,
        'by_reference' => false,
        'allow_delete' => true,
        'add_button_text'    => 'Add',
        'delete_button_text' => 'Delete',
        'sub_widget_col'     => 10,
        'button_col'         => 2
      ));
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolver $resolver
   *   @TODO: Missing description.
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Energiforsyning'
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_energiforsyning';
  }
}
