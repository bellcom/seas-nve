<?php
/**
 * @file
 * VarmeReduktionType form.
 */

namespace AppBundle\Form\Type\TrykluftTiltagDetail;

use AppBundle\Entity\TrykluftTiltagDetail;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use AppBundle\DBAL\Types\TrykluftTiltagDetail\VarmeReduktionType as DBALVarmeReduktionType;

/**
 * Class class VarmeReduktionType extends AbstractType {

 * @package AppBundle\Form
 */
class VarmeReduktionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $elementOptions) {
        foreach (TrykluftTiltagDetail::getVarmeReduktionInputKeys() as $key) {
            $elementOptions = array(
                'required' => FALSE,
            );
            switch ($key) {
                case 'type':
                    $type = 'choice';
                    $elementOptions['choices'] = DBALVarmeReduktionType::getChoices();
                    $elementOptions['expanded'] = TRUE;
                    $elementOptions['required'] = TRUE;
                    break;

                case 'reduktion':
                    $type = 'percent';
                    $elementOptions['scale'] = 2;
                    break;

                default:
                    $type = 'number';
            }
            $builder->add($key, $type, $elementOptions);
        }
    }

    public function getName() {
        return 'appbundle_trykluft_tiltag_detail_varmereduktion';
    }
}
