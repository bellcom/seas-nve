<?php
/**
 * @file
 * PrisOverrideType form.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

/**
 * Class PrisOverrideType
 * @package AppBundle\Form
 */
class PrisOverrideType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
         $builder->add('overriden', 'checkbox', array('label' => FALSE));
         $builder->add('pris', 'number', array('label' => FALSE));
    }

    public function getName() {
        return 'appbundle_pris_override';
    }
}
