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
        ;
    }
}
