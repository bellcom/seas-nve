<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class KlimaskaermTiltagDetailType
 * @package AppBundle\Form
 */
class KlimaskaermTiltagDetailType extends TiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    $builder
      ->add('laastAfEnergiraadgiver', null, array(
        'required' => false,
      ))
      ->add('klimaskaerm', 'entity', array(
        'class' => 'AppBundle:Klimaskaerm',
        'choices' => $this->getKlimaskaerme(),
      ))
      ->add('orientering', NULL, array(
        'required' => TRUE,
      ))
      ->add('typePlaceringJfPlantegning')
      ->add('hoejdeElLaengdeM')
      ->add('breddeM')
      ->add('antalStk')
      ->add('andelAfArealDerEfterisoleres', 'percent', array('scale' => 2))
      ->add('uEksWM2K')
      ->add('uNyWM2K')
      ->add('tIndeC')
      ->add('tUdeC')
      ->add('tOpvarmningTimerAar')
      ->add('yderligereBesparelserPct', 'percent', array('scale' => 2))
      ->add('prisfaktor')
      ->add('noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet', null, array(
        'required' => false,
      ))
      ->add('levetidAar')
      ;
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\KlimaskaermTiltagDetail'
    ));
  }

  public function getName() {
    return 'appbundle_klimaskaermtiltagdetail';
  }

  private function getKlimaskaerme() {
    $repository = $this->container->get('doctrine')->getRepository('AppBundle:Klimaskaerm');

    $result = $repository->findByType($this instanceof VindueTiltagDetailType ? 'vindue' : 'klimaskaerm');

    return $result;
  }
}
