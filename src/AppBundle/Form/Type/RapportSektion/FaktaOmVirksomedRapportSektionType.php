<?php

namespace AppBundle\Form\Type\RapportSektion;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FaktaOmVirksomedRapportSektionType extends RapportSektionType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('extras', FaktaOmVirksomedRapportSektionExtrasType::class, array('label' => FALSE));
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\RapportSektioner\FaktaOmVirksomhedRapportSektion'
            )
        );
        $resolver->setRequired('entity_manager');
    }

    public function getName() {
        return 'appbundle_rapportsektion_faktavirksom';
    }
}
