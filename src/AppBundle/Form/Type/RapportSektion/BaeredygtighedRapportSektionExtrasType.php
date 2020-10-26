<?php

namespace AppBundle\Form\Type\RapportSektion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BaeredygtighedRapportSektionExtrasType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('besparelseeffekt', 'ckeditor', [
                'attr' => [
                    'maxlength' => 10000,
                    'class' => 'js-default-value-target js-default-value-target',
                    'data-default-value-source' => 'besparelseeffekt',
                ],
                'required' => FALSE,
            ])
        ;
    }
}
