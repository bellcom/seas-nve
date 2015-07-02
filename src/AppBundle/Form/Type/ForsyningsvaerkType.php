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

      ->add('noter')
      ->add('pris2015')
      ->add('pris2016')
      ->add('pris2017')
      ->add('pris2018')
      ->add('pris2019')
      ->add('pris2020')
      ->add('pris2021')
      ->add('pris2022')
      ->add('pris2023')
      ->add('pris2024')
      ->add('pris2025')
      ->add('pris2026')
      ->add('pris2027')
      ->add('pris2028')
      ->add('pris2029')
      ->add('pris2030')
      ->add('pris2031')
      ->add('pris2032')
      ->add('pris2033')
      ->add('pris2034')
      ->add('pris2035')
      ->add('pris2036')
      ->add('pris2037')
      ->add('pris2038')
      ->add('pris2039')
      ->add('pris2040')
      ->add('pris2041')
      ->add('pris2042')
      ->add('pris2043')
      ->add('pris2044')
      ->add('pris2045')

      ->add('co2noter')
      ->add('co2y2015')
      ->add('co2y2016')
      ->add('co2y2017')
      ->add('co2y2018')
      ->add('co2y2019')
      ->add('co2y2020')
      ->add('co2y2021')
      ->add('co2y2022')
      ->add('co2y2023')
      ->add('co2y2024')
      ->add('co2y2025')
      ->add('co2y2026')
      ->add('co2y2027')
      ->add('co2y2028')
      ->add('co2y2029')
      ->add('co2y2030')
      ->add('co2y2031')
      ->add('co2y2032')
      ->add('co2y2033')
      ->add('co2y2034')
      ->add('co2y2035')
      ->add('co2y2036')
      ->add('co2y2037')
      ->add('co2y2038')
      ->add('co2y2039');
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolverInterface $resolver
   *   @TODO: Missing description.
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
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
