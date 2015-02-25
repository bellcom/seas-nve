<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PumpeDetailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tilvalgt')
            ->add('pumpeID')
            ->add('forsyningsomraade')
            ->add('placering')
            ->add('applikation')
            ->add('isoleringskappe')
            ->add('b_faktor')
            ->add('noter')
            ->add('eksisterendeDrifttid')
            ->add('nyDrifttid')
            ->add('prisfaktor')
            ->add('pumpetiltag')
            ->add('pumpe')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PumpeDetail'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_pumpedetail';
    }
}
