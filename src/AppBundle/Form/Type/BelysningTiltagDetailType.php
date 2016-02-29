<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\DependencyInjection\Container;
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

  private $doctrine;

  public function __construct(Container $container) {
    $this->doctrine = $container->get('doctrine');
  }

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
      ->add('nyStyring', 'entity', array(
        'class' => 'AppBundle:BelysningTiltagDetail\NyStyring',
        'choices' => $this->getAktuelNyStyring(),
        'required' => FALSE,
        'empty_value' => 'common.none',
      ))
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

  private function getAktuelNyStyring() {
    $em = $this->doctrine->getRepository('AppBundle:BelysningTiltagDetail\NyStyring');

    return $em->findNotDeleted();
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
