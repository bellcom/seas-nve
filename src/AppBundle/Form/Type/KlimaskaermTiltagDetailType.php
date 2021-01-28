<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\DBAL\Types\KlimaskaermType;

use AppBundle\DBAL\Types\LevetidType;
use AppBundle\Entity\KlimaskaermTiltag;
use AppBundle\Entity\KlimaskaermTiltagDetail;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class KlimaskaermTiltagDetailType
 * @package AppBundle\Form
 */
class KlimaskaermTiltagDetailType extends TiltagDetailType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    parent::buildForm($builder, $options);
    /** @var TranslatorInterface $translator */
    $translator = $this->container->get('translator');
    $builder
      ->add('laastAfEnergiraadgiver', null, array(
        'required' => false,
      ))
      ->add('klimaskaerm', 'entity', array(
        'class' => 'AppBundle:Klimaskaerm',
        'choices' => $this->getKlimaskaerme(),
        'required' => FALSE,
        'empty_data' => null,
      ))
      ->add('klimaskaermOverskrevetPris')
      ->add('type')
      ->add('placering')
      ->add('hoejdeElLaengdeM')
      ->add('breddeM')
      ->add('antalStk')
      ->add('andelAfArealDerEfterisoleres', 'percent', array('scale' => 2, 'required' => false))
      ->add('uEksWM2K')
      ->add('uNyWM2K')
      ->add('tIndeC')
      ->add('tUdeC')
      ->add('tOpvarmningTimerAar')
      ->add('yderligereBesparelserPct', 'percent', array('scale' => 2, 'required' => false))
      ->add('noterTilPrisfaktorValgteLoesningTiltagSpecielleForholdPaaStedet', 'textarea', array(
        'attr' => array('maxlength' => 360), 'required' => false,
      ))
      ->add('levetidAar','choice', array(
        'choices' => LevetidType::getChoices(),
        'empty_value' => 'common.none',
        'required' => FALSE,
        'attr' => array(
          'help_text' => $translator->trans('appbundle.vinduetiltagdetail.levetidAar.description')
        ),
      ))
      ->add('noteGenerelt', 'textarea', array('attr' => array('maxlength' => 360), 'required' => FALSE))
      ;
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\KlimaskaermTiltagDetail',
        'validation_groups' => function (FormInterface $form) {
            $data = $form->getData();
            if ($data instanceof KlimaskaermTiltagDetail) {
                return array('Default', 'klimaskaerm');
            }
            return array('Default');
        },
    ));
  }

  public function getName() {
    return 'appbundle_klimaskaermtiltagdetail';
  }

  private function getKlimaskaerme() {
    $repository = $this->container->get('doctrine')->getRepository('AppBundle:Klimaskaerm');

    $result = $repository->findByType($this instanceof VindueTiltagDetailType ? KlimaskaermType::VINDUE : KlimaskaermType::KLIMASKAERM);

    return $result;
  }
}
