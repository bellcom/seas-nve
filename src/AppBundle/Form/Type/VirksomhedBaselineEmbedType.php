<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class VirksomhedBaselineEmbedType
 * @package AppBundle\Form
 */
class VirksomhedBaselineEmbedType extends AbstractType {

  /**
   * @inheritDoc
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('erhvervsareal', null, array('disabled' => 'disabled'));
  }

  /**
   * @inheritDoc
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Virksomhed',
    ));
  }

  /**
   * @inheritDoc
   */
  public function getName() {
    return 'appbundle_virksomhed_embed';
  }
}
