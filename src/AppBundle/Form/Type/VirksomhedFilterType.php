<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

class VirksomhedFilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'filter_text', array('condition_pattern' => FilterOperands::STRING_BOTH, 'label' => false))
            ->add('cvrNumber', 'filter_text', array('condition_pattern' => FilterOperands::STRING_BOTH, 'label' => false))
            ->add('crmNumber', 'filter_text', array('condition_pattern' => FilterOperands::STRING_BOTH, 'label' => false))
            ->add('customerNumber', 'filter_text', array('condition_pattern' => FilterOperands::STRING_BOTH, 'label' => false))
            ->add('typeName', null, array('label' => false, 'required' => false, 'data' => null))
            ->add('Søg', 'submit');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
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
        return 'appbundle_virksomhed_filter';
    }
}
