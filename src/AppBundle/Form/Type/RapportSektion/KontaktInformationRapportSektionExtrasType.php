<?php

namespace AppBundle\Form\Type\RapportSektion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class KontaktInformationRapportSektionExtrasType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('gennemgangDato', 'date', array(
                'widget' => 'single_text',
                'required' => FALSE,
                'attr' => array(
                    'help_text' => 'Hvis feltværdien er tom, vises Screeningsdato fra rapporten.',
                ),
            ))
            ->add('kvalitetSikringTekst', 'ckeditor', [
              'attr' => [
                'maxlength' => 10000,
                'help_text' => 'Lad teksten være tom for at skjule den',
              ],
              'required' => FALSE,
            ])
            ->add('underskrivelseTekst', 'ckeditor', [
                'attr' => [
                    'maxlength' => 10000,
                    'class' => 'js-default-value-target js-default-value-target',
                    'data-default-value-source' => 'underskrivelseTekst',
                ],
                'required' => FALSE,
            ])
        ;
    }
}
