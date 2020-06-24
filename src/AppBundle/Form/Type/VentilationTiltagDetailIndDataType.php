<?php
/**
 * @file
 * Bilag form.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class VentilationTiltagDetailIndDataType
 * @package AppBundle\Form
 */
class VentilationTiltagDetailIndDataType extends AbstractType {
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'fields' => array(),
        ));
    }
    public function buildForm(FormBuilderInterface $builder, array $options) {
        if (empty($options['fields'])) {
            return;
        }
        foreach ($options['fields'] as $key) {
            switch ($key) {
                case 'virkningsgradVentilator':
                case 'genvindings':
                    $builder->add($key, 'percent', array(
                        'scale' => 0,
                        'required' => FALSE,
                    ));
                    break;

                case 'trykabAnlaeg':
                    $options = array(
                       'required' => FALSE,
                    );
                    if ($builder->getName() == 'indDataEfter') {
                        $options['disabled'] = TRUE;
                    }
                    $builder->add($key, 'number', $options);
                    break;

                default:
                    $builder->add($key, 'number', array(
                        'required' => FALSE,
                    ));
            }
        }
    }

    public function getName() {
        return 'appbundle_ventilation_tiltag_detail_inddata';
    }
}
