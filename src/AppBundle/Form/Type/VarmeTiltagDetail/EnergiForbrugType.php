<?php
/**
 * @file
 * EnergiForbrugType form.
 */

namespace AppBundle\Form\Type\VarmeTiltagDetail;

use AppBundle\Entity\VarmeanlaegTiltagDetail;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EnergiForbrugType
 * @package AppBundle\Form
 */
class EnergiForbrugType extends AbstractType {

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $elementOptions) {
        foreach (VarmeanlaegTiltagDetail::getEnergiForbrugTypeInputKeys() as $key) {
            $options = array(
                'required' => FALSE,
            );

            if ($key == 'faktor' && in_array($elementOptions['property_path'], array('[fjernvarme]', '[elvarme]'))) {
                $options['disabled'] = TRUE;
            }

            if ($key == 'faktor' && $elementOptions['property_path'] != '[varmepumpe]') {
                $builder->add($key, 'percent',  $options);
                continue;
            }

            if ($key == 'forbrug' &&
                in_array($elementOptions['field_name'], array('energiForbrugPrimaerEfter', 'energiForbrugSekundaerEfter'))) {
                $options['disabled'] = TRUE;
                $options['scale'] = 0;
            }
            $builder->add($key, 'number', $options);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'field_name' => NULL,
        ));
    }

    public function getName() {
        return 'appbundle_varme_tiltag_detail_energiforbrud';
    }
}
