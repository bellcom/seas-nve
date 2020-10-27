<?php

namespace AppBundle\Form\Type\RapportSektion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ForsideRapportSektionExtrasType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('rapportTypeNavn')
            ->add('underTekst')
        ;
    }

    public function getName() {
        return 'appbundle_rapportsektion_forside_extras';
    }
}
