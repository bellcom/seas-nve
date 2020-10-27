<?php

namespace AppBundle\Form\Type\RapportSektion;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnbefalingRapportSektionType extends RapportSektionType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('filepath', 'file', array(
            'label' => 'Billede',
            'data_class' => NULL,
            'attachment_path' => 'filepath',
            'required' => FALSE,
        ))
        ->add('extras', AnbefalingRapportSektionExtrasType::class, array(
            'label' => FALSE,
            'entity_manager' => $options['entity_manager'],
        ))
        ;
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\RapportSektioner\AnbefalingRapportSektion'
            )
        );
        $resolver->setRequired('entity_manager');
    }

    public function getName() {
        return 'appbundle_anbefaling_rapport_sektion';
    }
}
