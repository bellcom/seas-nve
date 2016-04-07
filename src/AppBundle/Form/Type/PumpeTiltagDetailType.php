<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PumpeTiltagDetailType
 * @package AppBundle\Form
 */
class PumpeTiltagDetailType extends TiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    $builder
      ->add('pumpe')
      ->add('pumpeID')
      ->add('forsyningsomraade')
      ->add('placering')
      ->add('applikation')
      ->add('isoleringskappe', null, array('required' => false))
      ->add('nyttiggjortVarme', null, array(
        'required' => true,
      ))
      ->add('noter', null, array('required' => false))
      ->add('eksisterendeDrifttid')
      ->add('nyDrifttid')
      ->add('prisfaktor');

    // @FIXME: Workaround for the field "B-Faktor" being deprecated.
    if (!$this->detail->getNyttiggjortVarme()) {
      $builder
        ->remove('nyttiggjortVarme')
        ->add('nyttiggjortVarme', null, array(
          'required' => true,
          'empty_value' => '*** Gammel B-Faktor: ' . number_format($this->detail->getBFaktor(), 2, ',', '.') . ' ***',
          'attr' => array(
            'help_text' => 'Bemærk: Feltet "B-Faktor" er blevet erstattet af "Nyttiggjort varme". Vælg venligst "Nyttiggjort varme" ovenfor.',
            'class' => 'aaplus-deprecated',
          ),
        ));
    }
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\PumpeTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_pumpetiltagdetail';
  }
}
