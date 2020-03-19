<?php
/**
 * @file
 * GrundventilationMatrixType form.
 */

namespace AppBundle\Form\Type;

use AppBundle\DBAL\Types\VentilationTiltagDetail\ForureningType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GrundventilationMatrixType
 * @package AppBundle\Form
 */
class GrundventilationMatrixType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $foruneringTypes = array_filter(array_keys(ForureningType::getChoices()));
        foreach ($foruneringTypes as $type) {
            $builder->add($type, VentilationKvalitetType::class);
        }
    }

    public function getName() {
        return 'appbundle_ventilation_grundventilation_matrix';
    }
}
