<?php

namespace AppBundle\Form\TekniskIsoleringTiltagDetail;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KomponentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titel')
            ->add('roerlaengde')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TekniskIsoleringTiltagDetail\Komponent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_tekniskisoleringtiltagdetail_komponent';
    }
}
