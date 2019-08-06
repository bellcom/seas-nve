<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VirksomhedType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('cvrNumber')
            ->add('branchCode')
            ->add('contactPerson')
            ->add('customerNumber')
            ->add('phoneNumber')
            ->add('subsidyLevel')
            ->add('kalkulationsrente')
            ->add('inflation')
            ->add('lobetid')
            ->add('evtPNumber')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Virksomhed'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_virksomhed';
    }

}
