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
 * Class KlimaskaermType
 * @package AppBundle\Form
 */
class KlimaskaermType extends AbstractType {
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
      ->add('post')
      ->add('klimaskaerm')
      ->add('arbejdeOmfang')
      ->add('enhedsprisEksklMoms')
      ->add('enhed')
      ->add('noter');
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolverInterface $resolver
   *   @TODO: Missing description.
   *
   * @TODO: OptionsResolverInterface er deprecated?
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Klimaskaerm'
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_klimaskaerm';
  }

}
