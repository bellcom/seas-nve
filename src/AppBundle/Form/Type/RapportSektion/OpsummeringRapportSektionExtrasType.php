<?php

namespace AppBundle\Form\Type\RapportSektion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OpsummeringRapportSektionExtrasType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('seasAnbefalerUnderTekst', 'textarea', array(
                'attr' => array(
                    'maxlength' => 100,
                    'help_text' => 'Maks 100 tegn',
                ),
                'required' => FALSE,
            ))
        ;
    }
}
