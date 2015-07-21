<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\Rapport;
use AppBundle\Entity\PumpeTiltag;
use AppBundle\Entity\SolcelleTiltag;
use AppBundle\Entity\TekniskIsoleringTiltag;
use AppBundle\Entity\KlimaskaermTiltag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TiltagType
 * @package AppBundle\Form
 */
class TiltagType extends AbstractType {
  protected $rapport;

  public function __construct(Rapport $rapport) {
    $this->rapport = $rapport;
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
    $forsyninger = array();
    if ($this->rapport) {
      $items = $this->rapport->getEnergiforsyninger()->toArray();
      $forsyninger = array_combine($items, array_map(function($item) {
        return $item->getId();
      }, $items));
    }

    $builder
      ->add('tilvalgt')
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
      ->add('forsyningVarme', 'choice', array(
        'choices' => $forsyninger,
        'choices_as_values' => true,
      ))
      ->add('forsyningEl', 'choice', array(
        'choices' => $forsyninger,
        'choices_as_values' => true,
      ))
      ->add('beskrivelseNuvaerende')
      ->add('beskrivelseForslag')
      ->add('beskrivelseOevrige')
      ->add('risikovurdering')
      ->add('placering')
      ->add('beskrivelseDriftOgVedligeholdelse')
      ->add('indeklima')
      ->add('reelAnlaegsinvestering');

    if ($this instanceof TekniskIsoleringTiltag || $this instanceof PumpeTiltag) {
      $builder
        ->add('besparelseDriftOgVedligeholdelse')
        ->add('besparelseStrafafkoelingsafgift')
        ->add('levetid');
    }
    elseif ($this instanceof SolcelleTiltag) {
      $builder
        ->add('levetid');
    }
    elseif ($this instanceof KlimaskaermTiltag) {
      $builder
        ->add('besparelseDriftOgVedligeholdelse');
    }
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
    return 'appbundle_tiltag';
  }
}
