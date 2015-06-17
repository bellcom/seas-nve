<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SolcelleTiltagDetailType
 * @package AppBundle\Form
 */
class SolcelleTiltagDetailType extends TiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    $builder
      ->add('anlaegsstoerrelseKWp')
      ->add('produktionKWh')
      ->add('tilNettetPct')
      ->add('tilEgetForbrugPct', null, array( 'read_only' => true ))
      ->add('egetForbrugAfProduktionenKWh', null, array( 'read_only' => true ))
      ->add('produktionTilNettetKWh', null, array( 'read_only' => true ))
      ->add('forringetYdeevnePrAar')
      ->add('inverterskift1Aar')
      ->add('inverterskift2Aar')
      ->add('prisForNyInverterKr', null, array( 'read_only' => true ))
      ->add('salgsprisFoerste10AarKrKWh')
      ->add('salgsprisEfter10AarKrKWh')
      ->add('energiprisstigningPctPrAar')
      ->add('investeringKr')
      ->add('screeningOgProjekteringKr')
      ->add('driftPrAarKr', null, array( 'read_only' => true ))
      ->add('omkostningTilMaalerKr')
      ->add('raadighedstarifKr', null, array( 'read_only' => true ))
      ->add('totalDriftomkostningerPrAar', null, array( 'read_only' => true ));
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\SolcelleTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_solcelletiltagdetail';
  }
}
