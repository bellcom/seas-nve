<?php

namespace AppBundle\Form\Type\RapportSektion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
      ->add('startuge',  IntegerType::class, array(
          'attr' => array('step' => 1, 'min' => 1, 'max' => 52, 'required' => 'required'),
      ))
      ->add('slutuge',  IntegerType::class, array(
          'required' => TRUE,
          'attr' => array('step' => 1, 'min' => 1, 'max' => 52)
      ))
      ->add('omraadeansvar', ChoiceType::class, array(
        'choices' => [
            'provider' => 'SEAS-NVE',
            'company' => 'Virksomhed',
            'both' => 'Begge',
        ]
    ));
  }

}
