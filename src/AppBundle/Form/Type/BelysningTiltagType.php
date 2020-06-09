<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BelysningTiltagType
 * @package AppBundle\Form
 */
class BelysningTiltagType extends TiltagType
{

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BelysningTiltag'
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'appbundle_pumpetiltag';
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('forbrugFoer', 'text', array(
                'attr' => ['disabled' => 'disabled'],
                'required' => FALSE,
                ))
            ->add('forbrugEfter', 'text', array(
                'attr' => ['disabled' => 'disabled'],
                'required' => FALSE,
            ));

    }
}
