<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
      ->add('tilNettetPct', 'percent')
      ->add('inverterskift1Aar')
      ->add('inverterskift2Aar')
      ->add('investeringKr')
      ->add('screeningOgProjekteringKr')
      ->add('omkostningTilMaalerKr');

    if ($this->authorizationChecker && $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
      $builder
        ->add('forringetYdeevnePrAar')
        ->add('energiprisstigningPctPrAar', 'percent')
        ->add('salgsprisFoerste10AarKrKWh')
        ->add('salgsprisEfter10AarKrKWh');
    }
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\SolcelleTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_solcelletiltagdetail';
  }
}
