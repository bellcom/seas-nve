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
 * Class ForsyningsvaerkType
 * @package AppBundle\Form
 */
class ForsyningsvaerkType extends AbstractType {
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
      ->add('energiform')
      ->add('noter');

    $startYear = intval(date('Y'));
    $endYear = min($startYear + 30, 2075);

    for ($year = $startYear; $year <= $endYear; $year++) {
      $builder->add('pris' . $year);
    }

    $builder
      ->add('co2noter');

    $startYear = intval(date('Y'));
    $endYear = min($startYear + 25, 2075);

    for ($year = $startYear; $year <= $endYear; $year++) {
      $builder->add('co2y' . $year);
    }
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolver $resolver
   *   @TODO: Missing description.
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Forsyningsvaerk'
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_forsyningsvaerk';
  }
}
