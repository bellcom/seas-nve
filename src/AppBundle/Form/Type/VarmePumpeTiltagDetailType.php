<?php
/**
 * @file
 * VarmePumpeTiltagDetail object
 */

namespace AppBundle\Form\Type;

use AppBundle\DBAL\Types\VarmePumpeTiltag\EnergiType;
use AppBundle\Form\Type\VarmeTiltagDetail\EnergiForbrugType;
use AppBundle\Form\Type\VarmeTiltagDetail\VarmePumpeForbrugType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class VarmePumpeTiltagDetailType
 * @package AppBundle\Form
 */
class VarmePumpeTiltagDetailType extends TiltagDetailType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('energiTypePrimaerFoer', 'choice', array(
                'choices' => EnergiType::getChoices(),
                'required' => TRUE,
                'empty_value' => 'common.none',
            ))
            ->add('energiForbrugPrimaerFoer', 'collection', array(
                'type' => EnergiForbrugType::class,
                'options' => array(
                    'label' => FALSE,
                ),
                'label' => FALSE,
                'required' => FALSE,
            ))
            ->add('varmePumpeForbrug', new VarmePumpeForbrugType($this->container), array(
                'label' => FALSE,
                'required' => FALSE,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\VarmePumpeTiltagDetail'
        ));
    }

    public function getName()
    {
        return 'appbundle_varmepumpetiltagdetail';
    }
}
