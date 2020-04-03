<?php
/**
 * @file
 * EnergiForbrugType form.
 */

namespace AppBundle\Form\Type\VarmeTiltagDetail;

use AppBundle\Entity\VarmePumpeTiltagDetail;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

/**
 * Class EnergiForbrugType
 * @package AppBundle\Form
 */
class EnergiForbrugType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $elementOptions) {
        foreach (VarmePumpeTiltagDetail::getEnergiForbrugTypeInputKeys() as $key) {
            $builder->add($key, 'number',  array(
                'required' => FALSE,
            ));
        }
    }

    public function getName() {
        return 'appbundle_varme_tiltag_detail_energiforbrud';
    }
}
