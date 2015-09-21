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
class TiltagType extends AbstractType {
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
      ->add('tilvalgt')
      ->add('title')
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
      ->add('forsyningVarme', 'entity', array(
        'class' => 'AppBundle:Energiforsyning',
        'choices' => $this->tiltag->getRapport()->getEnergiforsyninger(),
        'required' => false,
      ))
      ->add('forsyningEl', 'entity', array(
        'class' => 'AppBundle:Energiforsyning',
        'choices' => $this->tiltag->getRapport()->getEnergiforsyninger(),
        'required' => false,
      ))
      ->add('beskrivelseNuvaerende')
      ->add('beskrivelseForslag')
      ->add('beskrivelseOevrige')
      ->add('risikovurdering')
      ->add('placering')
      ->add('beskrivelseDriftOgVedligeholdelse')
      ->add('indeklima')
      ->add('reelAnlaegsinvestering');

    if ($this->tiltag instanceof TekniskIsoleringTiltag || $this->tiltag instanceof PumpeTiltag) {
      $builder
        ->add('besparelseDriftOgVedligeholdelse')
        ->add('besparelseStrafafkoelingsafgift')
        ->add('levetid');
    }
    elseif ($this->tiltag instanceof SolcelleTiltag) {
      $builder
        ->add('levetid');
    }
    elseif ($this->tiltag instanceof KlimaskaermTiltag) {
      $builder
        ->add('besparelseDriftOgVedligeholdelse');
    }
    elseif ($this->tiltag instanceof SpecialTiltag) {
      $builder
        ->add('besparelseGUF')
        ->add('besparelseGAF')
        ->add('besparelseEl');
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
