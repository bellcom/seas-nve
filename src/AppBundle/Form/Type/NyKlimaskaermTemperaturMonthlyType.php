<?php
/**
 * @file
 * Bilag form.
 */

namespace AppBundle\Form\Type;

use AppBundle\DBAL\Types\MonthType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

/**
 * Class NyKlimaskaermTemperaturMonthlyType
 * @package AppBundle\Form
 */
class NyKlimaskaermTemperaturMonthlyType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        foreach (MonthType::getChoices() as $key => $value) {
            if (empty($key)) {
                continue;
            }
            $builder->add($key, 'text', array('required' => FALSE));
        }
    }

    public function getName() {
        return 'appbundle_nyklimaskaermtemperaturmonthly';
    }
}
