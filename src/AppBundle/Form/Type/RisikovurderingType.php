<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\DBAL\Types\RisikovurderingType as RisikovurderingEnumType;

class RisikovurderingType extends AbstractType {
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'choices' => RisikovurderingEnumType::getChoices(),
      'expanded' => TRUE,
      'required' => FALSE,
      'placeholder' => NULL,
    ));
  }

  public function getParent() {
    return 'choice';
  }

  public function getName() {
    return "app_risikovurdering";
  }
}