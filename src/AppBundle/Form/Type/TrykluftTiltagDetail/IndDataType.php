<?php
/**
 * @file
 * IndDataType form.
 */

namespace AppBundle\Form\Type\TrykluftTiltagDetail;

use AppBundle\DBAL\Types\TrykluftTiltagDetail\CalculationType;
use AppBundle\DBAL\Types\TrykluftTiltagDetail\ElForbrugBeregningType;
use AppBundle\Entity\TrykluftTiltagDetail;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

/**
 * Class IndDataType
 * @package AppBundle\Form
 */
class IndDataType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        foreach (TrykluftTiltagDetail::getIndDataInputKeys() as $key) {
            $elementOptions = array(
                'attr' => array('class' => ''),
                'required' => FALSE,
            );
            switch ($key) {
                case 'type':
                    $elementType = 'choice';
                    $elementOptions['choices'] = CalculationType::getChoices();
                    $elementOptions['required'] = TRUE;
                    $elementOptions['expanded'] = TRUE;
                    $elementOptions['attr']['class'] .= 'trykluft-calculation-type';
                    break;

                case 'elForbrugBeregning':
                    $elementType = 'choice';
                    $elementOptions['choices'] = ElForbrugBeregningType::getChoices();
                    $elementOptions['required'] = TRUE;
                    $elementOptions['expanded'] = TRUE;
                    $elementOptions['attr']['class'] .= 'trykluft-elforbrug-beregning-type';
                    break;

                case 'kompressorNavn':
                    $elementType = 'text';
                    break;

                case 'tidsmaalingBelastet':
                case 'tidsmaalingAflastet':
                    $elementOptions['attr']['class'] .= 'conditinal frekvensstyret-hidden fixed-hidden';
                    break;

                case 'gennemsnitligBelastning':
                    $elementOptions['attr']['class'] .= 'conditinal on_off-hidden fixed-hidden';
                    break;

                case 'paastempelEffekt':
                case 'driftstimerDag':
                case 'driftsdageUge':
                case 'driftsUgeAar':
                    $elementType = 'number';
                    $elementOptions['attr']['class'] .= 'conditinal fixed-hidden';
                    break;

                default:
                    $elementType = 'number';;
            }
            $builder->add($key, $elementType, $elementOptions);
        }
    }

    public function getName() {
        return 'appbundle_trykluft_tiltag_detail_inddata';
    }
}
