<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\DBAL\Types\BygningStatusType;
/**
 * Class BygningType
 * @package AppBundle\Form
 */
class BygningSearchType extends AbstractType {
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
      ->add('bygId', 'text', array('label' => false, 'max_length' => 4, 'attr' => array('size' => '4')))
      ->add('navn', null, array('label' => false))
      ->add('adresse', null, array('label' => false))
      ->add('postnummer', null, array('label' => false, 'max_length' => 4, 'attr' => array('size' => '4')))
      ->add('postBy', null, array('label' => false))
      ->add('virksomhed', null, array('label' => false, 'required' => false, 'data' => null))
      ->add('segment', null, array('label' => false, 'required' => false))
      ->add('status', null, array('label' => false, 'required' => false, 'data' => null))
      ->add('Søg', 'submit');
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolver $resolver
   *   @TODO: Missing description.
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Bygning',
      'validation_groups' => false
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'bygning';
  }
}
