<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type\BygningUdtraekType;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EmbeddedFilterTypeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class RapportType
 * @package AppBundle\Form
 */
class RapportUdtraekType extends AbstractType implements EmbeddedFilterTypeInterface {


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
      ->add('datering', 'filter_date_range', array('label' => false))
      ->add('elena', 'filter_checkbox', array('label' => false))
      ->add('ava', 'filter_checkbox', array('label' => false));
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolver $resolver
   *   @TODO: Missing description.
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Rapport'
    ));
  }

  public function getParent()
  {
    return 'filter_sharedable'; // this allow us to use the "add_shared" option
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'filter_rapport';
  }
}
