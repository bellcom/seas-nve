<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\Tiltag;
use AppBundle\Entity\PumpeTiltag;
use AppBundle\Entity\SolcelleTiltag;
use AppBundle\Entity\TekniskIsoleringTiltag;
use AppBundle\Entity\KlimaskaermTiltag;
use AppBundle\Entity\SpecialTiltag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TiltagType
 * @package AppBundle\Form
 */
class TiltagTilvalgtType extends AbstractType {
  protected $tiltag;

  public function __construct(Tiltag $tiltag) {
    $this->tiltag = $tiltag;
  }

  /**
   * @TODO: Missing description.
   *
   * @param FormBuilderInterface $builder
   *   @TODO: Missing description.
   * @param array $options
   *   @TODO: Missing description.
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('tilvalgtAfAaPlus', 'choice', array(
        'choices'  => array('' => '', '1' => 'Tilvalgt', '0' => 'Fravalgt'),
        'required' => true,
      ))
      ->add('tilvalgtbegrundelse', null, array('attr' => array('required' => true)))
      ->add('tilvalgtAfMagistrat', 'choice', array(
        'choices'  => array('1' => 'Tilvalgt', '0' => 'Fravalgt'),
        'required' => false,
      ))
      ->add('tilvalgtBegrundelseMagistrat', null, array('attr' => array('required' => false)));
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolver $resolver
   *   @TODO: Missing description.
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Tiltag'
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_tiltagtilvalgt';
  }
}
