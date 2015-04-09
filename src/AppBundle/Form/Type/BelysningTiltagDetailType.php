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
      ->add('armaturhoejde_m', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'm'
          )
        )
      ))
      ->add('rumstoerrelse_m2', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'm²'
          )
        )
      ))
      ->add('lokale_antal')
      ->add('drifttid_t_aar', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 't/år'
          )
        )
      ))
      ->add('lyskilde')
      ->add('lyskilde_stk_armatur', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/armatur'
          )
        )
      ))
      ->add('lyskilde_w_lyskilde', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'W/lyskilde'
          )
        )
      ))
      ->add('forkobling_stk_armatur', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/armatur'
          )
        )
      ))
      ->add('armaturer_stk_lokale', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/lokale'
          )
        )
      ))
      // ->add('elforbrug_w_m2', null, array( 'disabled' => true, ))
      ->add('placering_id', 'choice', array(
        'choice_list' => new PlaceringRepository(),
      ))
      ->add('styring_id', 'choice', array(
        'choice_list' => new StyringRepository(),
      ))
      ->add('noter')
      ->add('belysningstiltag_id', 'choice', array(
        'choice_list' => new TiltagRepository(),
      ))
      ->add('nye_sensorer_stk_lokale', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/lokale'
          )
        )
      ))
      ->add('standardinvest_sensor_kr_stk', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'kr/stk'
          )
        )
      ))
      ->add('reduktion_af_drifttid', 'percent')
      // ->add('ny_driftstid', null, array( 'disabled' => true ))
      ->add('standardinvest_armatur_el_lyskilde_kr_stk', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'kr/stk'
          )
        )
      ))
      ->add('ny_lyskilde')
      ->add('ny_lyskilde_stk_armatur', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/armatur'
          )
        )
      ))
      ->add('ny_lyskilde_w_lyskilde', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'w/lyskilde'
          )
        )
      ))
      ->add('ny_forkobling_stk_armatur', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/armatur'
          )
        )
      ))
      // ->add('ny_armatureffekt_w_stk', null, array( 'disabled' => true, ))
      ->add('nye_armaturer_stk_lokale', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'stk/lokale'
          )
        )
      ))
      ->add('nyttiggjort_varme_af_el_besparelse', 'percent')
      // ->add('prisfaktor', null, array( 'disabled' => true, ))
      // ->add('prisfaktor_tillaeg_kr_lokale', null, array( 'disabled' => true, ))
      // ->add('investering_alle_lokaler_kr', null, array( 'disabled' => true, ))
      // ->add('nyt_elforbrug_w_m2', null, array( 'disabled' => true, ))
      // ->add('driftsbesparelse_til_lyskilder_kr_aar', null, array( 'disabled' => true, ))
      // ->add('simpel_tilbagebetalingstid_aar', null, array( 'disabled' => true, ))
      // ->add('vaegtet_levetid_aar', null, array( 'disabled' => true, ))
      // ->add('nutidsvaerdi_set_over_15_aar_kr', null, array( 'disabled' => true, ))
      // ->add('kwh_besparelse_el', null, array( 'disabled' => true, ))
      // ->add('kwh_besparelse_varme_fra_varmevaerket', null, array( 'disabled' => true, ))
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
