<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
      ->add('armaturhoejdeM', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'm'
          )
        )
      ))
      ->add('rumstoerrelseM2', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'm²'
          )
        )
      ))
      ->add('lokale_antal')
      ->add('drifttidTAar', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 't/år'
          )
        )
      ))
      ->add('lyskilde')
      ->add('lyskildeStkArmatur', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/armatur'
          )
        )
      ))
      ->add('lyskildeWLyskilde', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'W/lyskilde'
          )
        )
      ))
      ->add('forkoblingStkArmatur', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/armatur'
          )
        )
      ))
      ->add('armaturerStkLokale', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/lokale'
          )
        )
      ))
      // ->add('elforbrugWM2', null, array( 'disabled' => true, ))
      ->add('placering_id', 'choice', array(
        'choices' => (new PlaceringRepository())->loadChoiceList(),
        'choices_as_values' => true,
      ))
      ->add('styring_id', 'choice', array(
        'choices' => (new StyringRepository())->loadChoiceList(),
        'choices_as_values' => true,
      ))
      ->add('noter')
      ->add('belysningstiltag_id', 'choice', array(
        'choices' => (new TiltagRepository())->loadChoiceList(),
        'choices_as_values' => true,
      ))
      ->add('nyeSensorerStkLokale', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/lokale'
          )
        )
      ))
      ->add('standardinvestSensorKrStk', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'kr/stk'
          )
        )
      ))
      ->add('reduktionAfDrifttid', 'percent')
      // ->add('nyDriftstid', null, array( 'disabled' => true ))
      ->add('standardinvestArmaturElLyskildeKrStk', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'kr/stk'
          )
        )
      ))
      ->add('nyLyskilde')
      ->add('nyLyskildeStkArmatur', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/armatur'
          )
        )
      ))
      ->add('nyLyskildeWLyskilde', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'w/lyskilde'
          )
        )
      ))
      ->add('nyForkoblingStkArmatur', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/armatur'
          )
        )
      ))
      // ->add('nyArmatureffektWStk', null, array( 'disabled' => true, ))
      ->add('nyeArmaturerStkLokale', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/lokale'
          )
        )
      ))
      ->add('nyttiggjortVarmeAfElBesparelse', 'percent')
      // ->add('prisfaktor', null, array( 'disabled' => true, ))
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

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\BelysningTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_belysningtiltagdetail';
  }
}
