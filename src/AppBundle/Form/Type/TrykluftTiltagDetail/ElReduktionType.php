<?php
/**
 * @file
 * ElReduktionType form.
 */

namespace AppBundle\Form\Type\TrykluftTiltagDetail;

use AppBundle\Entity\TrykluftTiltagDetail;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use AppBundle\DBAL\Types\TrykluftTiltagDetail\ElReduktionType as DBALElReduktionType;

/**
 * Class class ElReduktionType extends AbstractType {

 * @package AppBundle\Form
 */
class ElReduktionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $elReduktionChoices = DBALElReduktionType::getChoices();
        foreach (TrykluftTiltagDetail::getElReduktionInputKeys() as $key) {
            $elementOptions = array(
                'required' => FALSE,
            );
            switch ($key) {
                case 'enabled':
                    $type = 'checkbox';
                    $elementOptions['label'] = $elReduktionChoices[str_replace(array('[', ']'), '', $options['property_path'])];
                    break;

                default:
                    $type = 'number';
            }
            $builder->add($key, $type, $elementOptions);
        }
    }

    public function getName() {
        return 'appbundle_trykluft_tiltag_detail_elreduktion';
    }
}
