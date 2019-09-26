<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VirksomhedKortlaegningType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titel')
            ->add('totalForbrug')
            ->add('slutanvendelser','collection', array(
                'type' => new VirksomhedKortlaegningSlutanvendelseType(),
                'label' => FALSE,
            ))
            ->add('aar')
        ;


    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\VirksomhedKortlaegning'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_virksomhedkortlaegning';
    }
}
