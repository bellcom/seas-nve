<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TiltagType
 * @package AppBundle\Form
 */
class TiltagType extends AbstractType {
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
      ->add('faktorForReinvesteringer')
      ->add('primaerEnterprise', 'choice',
        array(
          'choices'   => array(
            'el'   => 'El',
            't/i'  => 'Tømrer/Isolatør',
            've'   =>  'VE',
            'vvs'  => 'VVS',
            'hh'   => 'Hårde hvidevarer',
            'a'    =>  'Automatik',
            'ia'   => 'Interne i AAK'
          )
      ))
      ->add('tiltagskategori', 'choice',
        array(
          'choices'   => array(
            'el'   => 'El',
            't/i'  => 'Tømrer/Isolatør',
            've'   =>  'VE',
            'vvs'  => 'VVS',
            'hh'   => 'Hårde hvidevarer',
            'a'    =>  'Automatik',
            'ia'   => 'Interne i AAK'
          )
        )
      )
      ->add('forsyningVarme')
      ->add('forsyningEl')
      ->add('beskrivelseNuvaerende')
      ->add('beskrivelseForslag')
      ->add('beskrivelseOevrige')
      ->add('risikovurdering')
      ->add('placering')
      ->add('beskrivelseBV')
      ->add('indeklima');
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolverInterface $resolver
   *   @TODO: Missing description.
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
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
    return 'appbundle_tiltag';
  }
}
