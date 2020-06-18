<?php
/**
 * @file
 * ForsyningsvaerkSearchType object.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ForsyningsvaerkType
 * @package AppBundle\Form\ForsyningsvaerkSearchType
 */

class ForsyningsvaerkSearchType extends AbstractType {

  /**
   * {@inheritDoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('navn', null, array('label' => false))
      ->add('energiform', null, array('label' => false))
      ->add('Søg', 'submit');
  }

  /**
   * {@inheritDoc}
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Forsyningsvaerk',
      'csrf_protection'   => false,
    ));
  }

  /**
   * {@inheritDoc}
   */
  public function getName() {
    return 'forsyningvaerk_search';
  }
}
