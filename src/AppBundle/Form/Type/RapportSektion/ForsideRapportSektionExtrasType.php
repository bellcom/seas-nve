<?php

namespace AppBundle\Form\Type\RapportSektion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ForsideRapportSektionExtrasType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('rapportTypeNavn', 'text', array('required' => FALSE))
            ->add('skjuleKort', 'checkbox', array('label' => 'Skjule kort', 'required' => FALSE))
            ->add('erstatningAdresse', 'text', array('required' => FALSE))
            ->add('underTekst', 'text', array('required' => FALSE))
        ;
    }

    public function getName() {
        return 'appbundle_rapportsektion_forside_extras';
    }
}
