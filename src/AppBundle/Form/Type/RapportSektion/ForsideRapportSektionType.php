<?php

namespace AppBundle\Form\Type\RapportSektion;

use AppBundle\DBAL\Types\RapportSectionType as DBALRapportSectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForsideRapportSektionType extends RapportSektionType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filepath', 'file', array(
                'label' => 'Billede',
                'data_class' => NULL,
                'attachment_path' => 'filepath',
            ))
            ->add('title')
            ->add('extras', ForsideRapportSektionExtrasType::class, array('label' => FALSE))
        ;

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function(FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

                // Remove filepath field if not submitted
                if (!isset($data['filepath']) || $data['filepath'] === null) {
                    $form->remove('filepath');
                }
            });

    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\RapportSektioner\ForsideRapportSektion'
            )
        );
    }

    public function getName() {
        return 'appbundle_forside_rapport_sektion';
    }
}
