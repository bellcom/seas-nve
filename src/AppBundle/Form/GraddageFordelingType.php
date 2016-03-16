<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GraddageFordelingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titel')
            ->add('januar')
            ->add('februar')
            ->add('marts')
            ->add('april')
            ->add('maj')
            ->add('juni')
            ->add('juli')
            ->add('august')
            ->add('september')
            ->add('oktober')
            ->add('november')
            ->add('december')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\GraddageFordeling'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_graddagefordeling';
    }
}
