<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class TiltagDetailType
 * @package AppBundle\Form
 */
class TiltagDetailType extends AbstractType {
  protected $context;

  public function __construct(SecurityContext $context)
  {
    $this->context = $context;
  }

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('tilvalgt');
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
