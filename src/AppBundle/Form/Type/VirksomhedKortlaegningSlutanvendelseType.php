<?php
/**
 * @file
 * Bilag form.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

/**
 * Class VirksomhedKortlaegningSlutanvendelseType
 * @package AppBundle\Form
 */
class VirksomhedKortlaegningSlutanvendelseType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('procent', 'text', array('required' => FALSE))
            ->add('forbrug', 'text', array('required' => FALSE));
    }

    public function getName() {
        return 'appbundle_virksomhed_kortlaegning_slutanvendelse';
    }
}
