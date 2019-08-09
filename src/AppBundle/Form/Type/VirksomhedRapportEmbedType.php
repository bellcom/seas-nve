<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class VirksomhedRapportEmbedType
 * @package AppBundle\Form
 */
class VirksomhedRapportEmbedType extends AbstractType {

  /**
   * @inheritDoc
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('datering', 'date', array(
          // render as a single HTML5 text box
          'widget' => 'single_text')
      )
    ;
  }

  /**
   * @inheritDoc
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\VirksomhedRapport'
    ));
  }

  /**
   * @inheritDoc
   */
  public function getName() {
    return 'appbundle_virksomhed_rapport_embed';
  }
}
