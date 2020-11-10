<?php

namespace AppBundle\Form\Type\RapportSektion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FaktaOmVirksomedRapportSektionExtrasType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('elForbrug', 'text', array('required' => FALSE))
            ->add('varmeForbrug', 'text', array('required' => FALSE))
            ->add('braendstofForbrug', 'text', array('required' => FALSE))
            ->add('afgifterForbrug', 'text', array('required' => FALSE))
            ->add('co2Forbrug', 'text', array('required' => FALSE))
            ->add('anvendteTekst', 'textarea', array(
                'attr' => array(
                    'maxlength' => 300,
                    'help_text' => 'Maks 300 tegn',
                    'rows' => 5,
                ),
                'required' => FALSE,
            ))
            ->add('anvendteCo2Tekst', 'textarea', array(
                'attr' => array(
                    'maxlength' => 300,
                    'help_text' => 'Maks 300 tegn',
                    'rows' => 5,
                ),
                'required' => FALSE,
            ))
            ->add('energiForbrugTekst', 'ckeditor', [
                'attr' => [
                    'maxlength' => 10000,
                    'class' => 'js-default-value-target js-default-value-target',
                    'data-default-value-source' => 'energiForbrugTekst',
                ],
                'required' => FALSE,
            ])
        ;
    }
}
