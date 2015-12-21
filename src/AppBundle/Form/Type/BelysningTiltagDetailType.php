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
      // ->add('elforbrugWM2', null, array( 'disabled' => true, ))
      ->add('placering')
      ->add('styring')
      ->add('noter')
      ->add('belysningstiltag')
      ->add('nyeSensorerStkLokale')
      ->add('standardinvestSensorKrStk')
      ->add('reduktionAfDrifttid', 'percent', array('scale' => 2))
      // ->add('nyDriftstid', null, array( 'disabled' => true ))
      ->add('standardinvestArmaturKrStk')
      ->add('standardinvestLyskildeKrStk')
      ->add('nyLyskilde')
      ->add('nyLyskildeStkArmatur')
      ->add('nyLyskildeWLyskilde')
      ->add('nyForkoblingStkArmatur')
      // ->add('nyArmatureffektWStk', null, array( 'disabled' => true, ))
      ->add('nyeArmaturerStkLokale')
      ->add('nyttiggjortVarmeAfElBesparelse', 'percent', array('scale' => 2))
      ->add('prisfaktor')
      // ->add('prisfaktorTillaegKrLokale', null, array( 'disabled' => true, ))
      // ->add('investeringAlleLokalerKr', null, array( 'disabled' => true, ))
      // ->add('nytElforbrugWM2', null, array( 'disabled' => true, ))
      // ->add('driftsbesparelseTilLyskilderKrAar', null, array( 'disabled' => true, ))
      // ->add('simpelTilbagebetalingstidAar', null, array( 'disabled' => true, ))
      // ->add('vaegtetLevetidAar', null, array( 'disabled' => true, ))
      // ->add('nutidsvaerdiSetOver15AarKr', null, array( 'disabled' => true, ))
      // ->add('kwhBesparelseEl', null, array( 'disabled' => true, ))
      // ->add('kwhBesparelseVarmeFraVarmevaerket', null, array( 'disabled' => true, ))
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
