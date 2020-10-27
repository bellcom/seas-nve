<?php

namespace AppBundle\Form\Type\RapportSektion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FaktaOmVirksomedRapportSektionExtrasType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('elForbrug')
            ->add('varmeForbrug')
            ->add('braendstofForbrug')
            ->add('afgifterForbrug')
            ->add('co2Forbrug')
        ;
    }
}
