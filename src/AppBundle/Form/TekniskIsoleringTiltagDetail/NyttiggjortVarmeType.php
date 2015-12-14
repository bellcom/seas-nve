<?php

namespace AppBundle\Form\TekniskIsoleringTiltagDetail;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NyttiggjortVarmeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('faktor')
            ->add('titel')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_tekniskisoleringtiltagdetail_nyttiggjortvarme';
    }
}
