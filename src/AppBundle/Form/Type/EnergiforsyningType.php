<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
      ->add('navn')
      ->add('beskrivelse')
      ->add('internProduktioner', 'collection', array(
        'type' => new InternProduktionType(),
        'allow_add' => TRUE,
      ))
      // ->add('samletVarmeeffektivitet', NULL, array(
      //   'read_only' => TRUE,
      //   // 'mapped' => FALSE,
      // ))
      // ->add('samletEleffektivitet', NULL, array(
      //   'read_only' => TRUE,
      //   // 'mapped' => FALSE,
      // ))
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
