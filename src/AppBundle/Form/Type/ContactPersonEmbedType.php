<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactPersonEmbedType
 * @package AppBundle\Form
 */
class ContactPersonEmbedType extends AbstractType {

  /**
   * @inheritDoc
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('name')
      ->add('mail', null, array('required' => true))
      ->add('phoneNumber');
  }

  /**
   * @inheritDoc
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\ContactPerson'
    ));
  }

  /**
   * @inheritDoc
   */
  public function getName() {
    return 'appbundle_contact_person_embed';
  }
}
