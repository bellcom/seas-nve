<?php
/**
 * @file
 * ElForbrugType form.
 */

namespace AppBundle\Form\Type\TrykluftTiltagDetail;

use AppBundle\Entity\TrykluftTiltagDetail;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use AppBundle\DBAL\Types\TrykluftTiltagDetail\ElReduktionType as DBALElReduktionType;

/**
 * Class class ElForbrugType extends AbstractType {

 * @package AppBundle\Form
 */
class ElForbrugType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        foreach (TrykluftTiltagDetail::getElForbrugInputKeys() as $key) {
            $elementOptions = array(
                'required' => FALSE,
                'attr' => array(
                    'class' => 'onditinal calculated-hidden'
                ),
            );
            $type = 'number';
            switch ($key) {
                case 'herafAflastet':
                    $elementOptions['attr']['class'] .= ' frekvensstyret-hidden';
                    break;
            }
            $builder->add($key, $type, $elementOptions);
        }
    }

    public function getName() {
        return 'appbundle_trykluft_tiltag_detail_elforbrug';
    }
}
