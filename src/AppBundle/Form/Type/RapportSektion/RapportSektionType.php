<?php

namespace AppBundle\Form\Type\RapportSektion;

use AppBundle\DBAL\Types\RapportSectionType as DBALRapportSectionType;
use AppBundle\Entity\RapportSektioner\RapportSektion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportSektionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'attr' => array(
                    'help_text' => 'Lad titlen være tom for at skjule den. Bruges, hvis titlen kommer fra WYSIWYG teksten.',
                ),
                'required' => FALSE,
            ))
            ->add('text', 'ckeditor', array(
                'attr' => array(
                    'maxlength' => 10000,
                    'class' => 'js-default-value-target js-default-value-target',
                    'data-default-value-source' => 'text',
                    'help_text' => 'Lad teksten være tom for at skjule den',
                ),
                'required' => FALSE,
            ))
            ->add('textPages', 'bootstrap_collection', array(
                'property_path' => 'textPages',
                'type' => new RapportSektionTextPageType(),
                'options' => array(
                    'showAfterPages' => empty($options['showAfterPages']) ? array() : $options['showAfterPages'],
                ),
                'label' => FALSE,
                'required' => FALSE,
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'add_button_text'    => 'Add',
                'delete_button_text' => 'Delete',
                'sub_widget_col'     => 10,
                'button_col'         => 2,
            ))
        ;
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\RapportSektioner\RapportSektion'
            )
        );
        $resolver->setRequired('entity_manager');
    }

    public function getName() {
        return 'appbundle_rapportsektion';
    }
}
