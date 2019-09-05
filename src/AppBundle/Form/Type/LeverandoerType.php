<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeverandoerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('regninger', 'bootstrap_collection', array(
                'property_path' => 'Regninger',
                'type' => 'entity',
                'options' => array(
                    'class' => 'AppBundle:Regning',
                    'required' => FALSE,
                    'empty_value' => '--',
                ),
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'add_button_text'    => 'Add',
                'delete_button_text' => 'Delete',
                'sub_widget_col'     => 10,
                'button_col'         => 2
            ));
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Leverandoer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_leverandoer';
    }
}
