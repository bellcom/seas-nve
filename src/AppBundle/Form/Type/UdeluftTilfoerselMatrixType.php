<?php
/**
 * @file
 * UdeluftTilfoerselMatrixType form.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

/**
 * Class UdeluftTilfoerselMatrixType
 * @package AppBundle\Form
 */
class UdeluftTilfoerselMatrixType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('del_utilfredse_personer', VentilationKvalitetType::class);
        $builder->add('lps_per_person', VentilationKvalitetType::class);
    }

    public function getName() {
        return 'appbundle_ventilation_udeluftTilfoersel_matrix_matrix';
    }
}
