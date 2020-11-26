<?php

namespace AppBundle\Form\Type\RapportSektion;

use AppBundle\DBAL\Types\RapportSectionType as DBALRapportSectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportSektionTextPageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('noPagebreak', 'checkbox', array('label' => 'Vis uden sideskift'));
        if ($options['showAfterPages']) {
            $builder->add('showAfter', ChoiceType::class, array(
                'choices' => empty($options['showAfterPages']) ? array() : $options['showAfterPages'],
                'empty_value' => 'I slutningen',
            ));
        }
        $builder->add('text', 'ckeditor', array(
                'attr' => array(
                    'maxlength' => 10000,
                ),
                'required' => FALSE,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setRequired('showAfterPages');
    }

    public function getName() {
        return 'appbundle_rapportsektion_textpage';
    }
}
