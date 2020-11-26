<?php

namespace AppBundle\Form\Type\RapportSektion;

use AppBundle\DBAL\Types\RapportSectionType as DBALRapportSectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpsummeringRapportSektionType extends RapportSektionType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options['showAfterPages'] = array(
            'page1' => 'Efter side 1',
        );
        parent::buildForm($builder, $options);
        $builder->add('extras', OpsummeringRapportSektionExtrasType::class, array('label' => FALSE));
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\RapportSektioner\OpsummeringRapportSektion'
            )
        );
        $resolver->setRequired('entity_manager');
    }

    public function getName() {
        return 'appbundle_rapportsektion_opsummering';
    }
}
