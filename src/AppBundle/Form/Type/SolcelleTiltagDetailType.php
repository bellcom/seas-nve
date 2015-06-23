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
      ->add('inverterskift1Aar')
      ->add('inverterskift2Aar')
      ->add('investeringKr')
      ->add('screeningOgProjekteringKr')
      ->add('omkostningTilMaalerKr');

    if ($this->context && $this->context->isGranted('ROLE_ADMIN')) {
      $builder
        ->add('forringetYdeevnePrAar')
        ->add('energiprisstigningPctPrAar')
        ->add('salgsprisFoerste10AarKrKWh')
        ->add('salgsprisEfter10AarKrKWh');
    }
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
