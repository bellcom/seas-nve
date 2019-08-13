<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class VirksomhedCreateRapportType
 * @package AppBundle\Form
 */
class VirksomhedCreateRapportType extends AbstractType
{

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rapport', new VirksomhedRapportEmbedType(), array(
                    'by_reference' => TRUE,
                    'data_class' => 'AppBundle\Entity\VirksomhedRapport',
                    'label' => FALSE,
                )
            );
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Virksomhed',
        ));
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'appbundle_virksomhed_create_rapport';
    }
}
