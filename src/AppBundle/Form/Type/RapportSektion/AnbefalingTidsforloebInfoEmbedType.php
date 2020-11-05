<?php

namespace AppBundle\Form\Type\RapportSektion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AnbefalingTidsforloebInfoEmbedType
 * @package AppBundle\Form
 */
class AnbefalingTidsforloebInfoEmbedType extends AbstractType {

  /**
   * @inheritDoc
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('title')
      ->add('startuge')
      ->add('slutuge')
      ->add('omraadeansvar', ChoiceType::class, array(
        'choices' => [
            'provider' => 'SEAS-NVE',
            'company' => 'Virksomhed',
            'both' => 'Begge',
        ]
    ));
  }

}
