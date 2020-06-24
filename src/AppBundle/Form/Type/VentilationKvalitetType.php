<?php
/**
 * @file
 * VentilationKvalitetType form.
 */

namespace AppBundle\Form\Type;

use AppBundle\DBAL\Types\VentilationTiltagDetail\KvalitetType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

/**
 * Class VentilationKvalitetType
 * @package AppBundle\Form
 */
class VentilationKvalitetType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $kvalitetTypes = array_filter(array_keys(KvalitetType::getChoices()));
        foreach ($kvalitetTypes as $type) {
            if (in_array($builder->getName(), array('del_utilfredse_personer'))) {
              $builder->add($type, 'percent', array('scale' => 0));
            }
            else {
              $builder->add($type, 'number');
            }
        }
    }

    public function getName() {
        return 'appbundle_ventilation_kvalitet';
    }
}
