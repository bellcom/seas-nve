<?php
/**
 * @file
 * VarmePumpeTiltagType object.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class VarmePumpeTiltagType
 * @package AppBundle\Form
 */
class VarmePumpeTiltagType extends TiltagType
{
    /**
     * @{inheritdoc}
     */
    public function getName()
    {
        return 'appbundle_varmepumpetiltag';
    }
}
