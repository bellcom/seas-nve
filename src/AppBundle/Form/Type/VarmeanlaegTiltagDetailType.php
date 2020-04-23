<?php
/**
 * @file
 * VarmeanlaegTiltagDetailType object
 */

namespace AppBundle\Form\Type;

use AppBundle\DBAL\Types\VarmeanlaegTiltag\EnergiType;
use AppBundle\Form\Type\VarmeTiltagDetail\EnergiForbrugType;
use AppBundle\Form\Type\VarmeTiltagDetail\VarmePumpeForbrugType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class VarmeanlaegTiltagDetailType
 * @package AppBundle\Form
 */
class VarmeanlaegTiltagDetailType extends TiltagDetailType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('title', 'text', array(
                'required' => FALSE,
            ))
            ->add('energiTypePrimaerFoer', 'choice', array(
                'choices' => EnergiType::getChoices(),
                'required' => FALSE,
                'empty_value' => 'common.none',
            ))
            ->add('energiForbrugPrimaerFoer', 'collection', array(
                'type' => EnergiForbrugType::class,
                'options' => array(
                    'label' => FALSE,
                    'field_name' => 'energiForbrugPrimaerFoer',
                ),
                'label' => FALSE,
                'required' => FALSE,
            ))
            ->add('energiTypeSekundaerFoer', 'choice', array(
                'choices' => EnergiType::getChoices(),
                'required' => FALSE,
                'empty_value' => 'common.none',
            ))
            ->add('energiForbrugSekundaerFoer', 'collection', array(
                'type' => EnergiForbrugType::class,
                'options' => array(
                    'label' => FALSE,
                    'field_name' => 'energiForbrugSekundaerFoer',
                ),
                'label' => FALSE,
                'required' => FALSE,
            ))
            ->add('energiTypePrimaerEfter', 'choice', array(
                'choices' => EnergiType::getChoices(),
                'required' => TRUE,
                'empty_value' => 'common.none',
            ))
            ->add('nyVarmeKildePrimaerAndel', 'percent', array(
                'scale' => 0,
            ))
            ->add('nyVarmeKildeSekundaerAndel', 'percent', array(
                'scale' => 0,
                'disabled' => TRUE,
            ))
            ->add('energiForbrugPrimaerEfter', 'collection', array(
                'type' => EnergiForbrugType::class,
                'options' => array(
                    'label' => FALSE,
                    'field_name' => 'energiForbrugPrimaerEfter',
                ),
                'label' => FALSE,
                'required' => FALSE,
            ))
            ->add('energiTypeSekundaerEfter', 'choice', array(
                'choices' => EnergiType::getChoices(),
                'required' => FALSE,
                'empty_value' => 'common.none',
            ))
            ->add('energiForbrugSekundaerEfter', 'collection', array(
                'type' => EnergiForbrugType::class,
                'options' => array(
                    'label' => FALSE,
                    'field_name' => 'energiForbrugSekundaerEfter',
                ),
                'label' => FALSE,
                'required' => FALSE,
            ))
            ->add('forbrugBeregningKontrol', new VarmePumpeForbrugType($this->container), array(
                'label' => FALSE,
                'required' => FALSE,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\VarmeanlaegTiltagDetail'
        ));
    }

    public function getName()
    {
        return 'appbundle_varmeanlaegtiltagdetail';
    }
}
