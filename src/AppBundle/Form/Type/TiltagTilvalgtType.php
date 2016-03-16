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
    $builder->add('tilvalgtAfAaPlus', 'choice', array(
      'choices' => array(
        '0' => 'Fravalgt',
        '1' => 'Tilvalgt',
      ),
      'empty_value' => '--',
      'required' => FALSE
    ));
    $builder->add('tilvalgtbegrundelse', null, array('required' => false));

    $builder->add('tilvalgtAfMagistrat', 'choice', array(
      'choices' => array(
        '0' => 'Fravalgt',
        '1' => 'Tilvalgt',
      ),
      'empty_value' => '--',
      'required' => FALSE
    ));
    $builder->add('tilvalgtBegrundelseMagistrat', null, array('required' => false));

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
