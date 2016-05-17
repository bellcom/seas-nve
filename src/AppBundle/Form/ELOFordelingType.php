<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ELOFordelingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('eloKategoriFordelingVarmeGUF')
            ->add('eloKategoriFordelingVarmeGAF')
            ->add('eloKategoriFordelingEl')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ELOFordeling'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_elofordeling';
    }
}
