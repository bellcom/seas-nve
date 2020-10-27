<?php

namespace AppBundle\Form\Type\RapportSektion;

use AppBundle\DBAL\Types\RapportSectionType as DBALRapportSectionType;
use AppBundle\Entity\ReportText;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TiltagRapportSektionType extends RapportSektionType {
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
            ->add('text', 'ckeditor', [
                'attr' => [
                    'maxlength' => 10000,
                    'class' => 'js-default-value-target js-default-value-target',
                    'data-default-value-source' => 'text',
                ],
                'required' => FALSE,
            ])
        ;
    }

    public function getName() {
        return 'appbundle_rapportsektion_tiltag';
    }
}
