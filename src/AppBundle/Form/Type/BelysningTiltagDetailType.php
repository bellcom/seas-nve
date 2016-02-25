<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Entity\BelysningTiltagDetail\PlaceringRepository;
use AppBundle\Entity\BelysningTiltagDetail\StyringRepository;
use AppBundle\Entity\BelysningTiltagDetail\TiltagRepository;

/**
 * Class BelysningTiltagDetailType
 * @package AppBundle\Form
 */
class BelysningTiltagDetailType extends TiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    $builder
      //->add('tilvalgt')
      ->add('lokale_navn')
      ->add('lokale_type')
      ->add('armaturhoejdeM')
      ->add('rumstoerrelseM2')
      ->add('lokale_antal')
      ->add('drifttidTAar')
      ->add('lyskilde')
      ->add('lyskildeStkArmatur')
      ->add('lyskildeWLyskilde')
      ->add('forkoblingStkArmatur')
      ->add('armaturerStkLokale')
      ->add('placering')
      ->add('styring')
      ->add('nyStyring')
      ->add('nytArmatur')
      ->add('noter')
      ->add('noterForNyBelysning')
      ->add('belysningstiltag')
      ->add('nyeSensorerStkLokale')
      ->add('standardinvestSensorKrStk')
      ->add('reduktionAfDrifttid', 'percent', array('scale' => 2, 'required' => false))
      ->add('standardinvestArmaturKrStk')
      ->add('standardinvestLyskildeKrStk')
      ->add('nyLyskilde')
      ->add('nyLyskildeStkArmatur')
      ->add('nyLyskildeWLyskilde')
      ->add('nyForkoblingStkArmatur')
      ->add('nyeArmaturerStkLokale')
      ->add('nyttiggjortVarmeAfElBesparelse', 'percent', array('scale' => 2, 'required' => false))
      ->add('prisfaktor')
      ;
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\BelysningTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_belysningtiltagdetail';
  }
}
