<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EmbeddedFilterTypeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class RapportType
 * @package AppBundle\Form
 */
class RapportFilterType extends AbstractType implements EmbeddedFilterTypeInterface {


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
//      ->add('version')
//      ->add('datering')
      ->add('BaselineEl', 'filter_number')
      ->add('BaselineVarmeGUF', 'filter_number')
      ->add('BaselineVarmeGAF', 'filter_number')
      ->add('BaselineVand', 'filter_number')
      ->add('BaselineStrafAfkoeling', 'filter_number')
      ->add('faktorPaaVarmebesparelse', 'filter_number')
      ->add('Energiscreening', 'filter_number');
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
