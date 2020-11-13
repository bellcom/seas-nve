<?php

namespace AppBundle\Form\Type\RapportSektion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FinansieringRapportSektionExtrasType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('noegletal', 'ckeditor', [
                'attr' => [
                    'maxlength' => 10000,
                    'class' => 'js-default-value-target js-default-value-target',
                    'data-default-value-source' => 'noegletal',
                ],
                'required' => FALSE,
            ])
            ->add('tilbagebetalingstid')
            ->add('tekniskelevetid')
            ->add('finansieringTekst', 'ckeditor', [
                'attr' => [
                    'maxlength' => 10000,
                    'class' => 'js-default-value-target js-default-value-target',
                    'data-default-value-source' => 'produktivitet_beskrivelse',
                ],
                'required' => FALSE,
            ])
        ;
    }
}
