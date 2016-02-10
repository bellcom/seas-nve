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
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

/**
 * Class RapportType
 * @package AppBundle\Form
 */
class SegmentUdtraekType extends AbstractType implements EmbeddedFilterTypeInterface {


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
      ->add('forkortelse', 'filter_choice', array('label' => false, 'choices' => array(
        'MBU' => 'MBU - Børn og Unge',
        'MKB' => 'MKB - Kultur og borgerservice',
        'MSO' => 'MSO - Sundhed og omsorg',
        'MSB' => 'MSB - Social og beskæftigelse',
        'MTM' => 'MTM - Teknik og Miljø'
      )));
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolver $resolver
   *   @TODO: Missing description.
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Segment'
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
    return 'filter_segment';
  }
}
