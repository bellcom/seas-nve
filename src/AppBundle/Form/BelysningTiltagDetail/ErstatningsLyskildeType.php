<?php

namespace AppBundle\Form\BelysningTiltagDetail;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ErstatningsLyskildeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('arbejdeOmfang')
            ->add('antal')
            ->add('wattage')
            ->add('nyeForkoblinger')
            ->add('pris')
            ->add('noter')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BelysningTiltagDetail\ErstatningsLyskilde'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_belysningtiltagdetail_erstatningslyskilde';
    }
}
