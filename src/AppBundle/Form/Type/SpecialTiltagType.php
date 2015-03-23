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
 * Class SpecialTiltagType
 * @package AppBundle\Form
 */
class SpecialTiltagType extends TiltagType /*AbstractType*/ {
  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolverInterface $resolver
   *   @TODO: Missing description.
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\SpecialTiltag'
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_specialtiltag';
  }

  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    //$builder->add('kommentar');
  }
}
