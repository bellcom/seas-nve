<?php
/**
 * @file
 * PrisOverrideType form.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Co2OverrideType
 * @package AppBundle\Form
 */
class Co2OverrideType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        if (in_array(str_replace(array('[', ']'), array('', ''), $options['property_path']), $options['overriden_checkbox'])) {
            $builder->add('overriden', 'checkbox', array('label' => FALSE));
        }
        $builder->add('value', 'number', array('label' => FALSE));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'overriden_checkbox' => TRUE,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'appbundle_co2_override';
    }
}
