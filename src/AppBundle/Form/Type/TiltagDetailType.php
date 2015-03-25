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
 * Class TiltagDetailType
 * @package AppBundle\Form
 */
class TiltagDetailType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {

  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(
      array(
        'data_class' => 'AppBundle\Entity\TiltagDetail'
      )
    );
  }

  public function getName() {
    return 'appbundle_tiltagdetail';
  }
}
