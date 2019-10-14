<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\AppBundle;
use AppBundle\DBAL\Types\BygningStatusType;
use AppBundle\Form\Type\RisikovurderingType;
use AppBundle\Entity\Tiltag;
use AppBundle\Entity\PumpeTiltag;
use AppBundle\Entity\SolcelleTiltag;
use AppBundle\Entity\TekniskIsoleringTiltag;
use AppBundle\Entity\KlimaskaermTiltag;
use AppBundle\Entity\SpecialTiltag;
use AppBundle\Entity\VindueTiltag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Constraints\False;
use AppBundle\DBAL\Types\SlutanvendelseType;

/**
 * Class TiltagType
 * @package AppBundle\Form
 */
class TiltagType extends AbstractType {
  protected $tiltag;
  protected $authorizationChecker;

  public function __construct(Tiltag $tiltag, AuthorizationCheckerInterface $authorizationChecker) {
    $this->tiltag = $tiltag;
    $this->authorizationChecker = $authorizationChecker;
  }

  /**
   * @TODO: Missing description.
   *
   * @param FormBuilderInterface $builder
   * @TODO: Missing description.
   * @param array $options
   * @TODO: Missing description.
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    if ($this->authorizationChecker && !$this->authorizationChecker->isGranted('ROLE_ADMIN')) {
      $builder->add('tilvalgtAfRaadgiver');
    }
    else {
      $builder->add('tilvalgtAfAaPlus', 'choice', array(
        'choices' => array(
          '0' => 'Fravalgt',
          '1' => 'Tilvalgt',
        ),
        'empty_value' => '--',
        'required' => FALSE
      ));
      $builder->add('tilvalgtAfMagistrat', 'choice', array(
        'choices' => array(
          '0' => 'Fravalgt',
          '1' => 'Tilvalgt',
        ),
        'empty_value' => '--',
        'required' => FALSE
      ));
      $builder->add('tilvalgtbegrundelse', NULL, array('required' => FALSE));
      $builder->add('tilvalgtBegrundelseMagistrat', NULL, array('required' => FALSE));

      $status = $this->tiltag->getRapport()->getBygning()->getStatus();

      // Dato for drift
      if($status === BygningStatusType::UNDER_UDFOERSEL || $status === BygningStatusType::DRIFT) {
        $builder->add('datoForDrift', 'date', array(
          // render as a single text box
          'widget' => 'single_text',
          'required' => false
        ));
      }

      // Energiledelse faktor/noter
      if($status === BygningStatusType::DRIFT) {
        $builder->add('energiledelseAendringIBesparelseFaktor', 'percent', array('required' => FALSE));
        $builder->add('energiledelseNoter');
      }

    }
    $builder->add('title')
            ->add('faktorForReinvesteringer')
            ->add('opstartsomkostninger');

    $builder
      ->add('forbrugFoer')
      ->add('forbrugEfter')
      ->add('prioriteringsfaktor', 'choice', array(
        'choices' => array(
          '0.5' => '0,5',
          '1' => '1,0',
          '1.5' => '1,5',
        ),
        'required' => TRUE
      ))
      ->add('konverteringsfaktorFoer', 'choice', array(
        'choices' => array(
          '0.8' => '0,8',
          '1' => '1,0',
          '1.8' => '1,8',
        ),
        'required' => TRUE
      ))
      ->add('konverteringsfaktorEfter', 'choice', array(
        'choices' => array(
          '0.8' => '0,8',
          '1' => '1,0',
          '1.8' => '1,8',
        ),
        'required' => TRUE
      ));

    $builder
      ->add('genopretning')
      ->add('genopretningForImplementeringsomkostninger')
      ->add('modernisering')
      ->add('reelAnlaegsinvestering');

    $builder->add('tilskudsstoerrelse', NULL);
    $builder->add('reelAnlaegsinvestering')
      ->add('forsyningVarme', 'entity', array(
        'class' => 'AppBundle:Energiforsyning',
        'choices' => $this->tiltag->getRapport()->getEnergiforsyninger(),
        'empty_value' => '--',
        'required' => FALSE,
      ))
      ->add('forsyningEl', 'entity', array(
        'class' => 'AppBundle:Energiforsyning',
        'choices' => $this->tiltag->getRapport()->getEnergiforsyninger(),
        'empty_value' => '--',
        'required' => FALSE,
      ))
      ->add('beskrivelseNuvaerende', 'textarea', array('attr' => array('maxlength' => 10000), 'required' => FALSE))
      ->add('beskrivelseForslag', 'textarea', array('attr' => array('maxlength' => 10000), 'required' => FALSE))
      ->add('beskrivelseOevrige', 'textarea', array('attr' => array('maxlength' => 10000), 'required' => FALSE))
      ->add('risikovurdering', 'textarea', array('attr' => array('maxlength' => 10000), 'required' => FALSE))
      ->add('placering', 'textarea', array('attr' => array('maxlength' => 10000), 'required' => FALSE))
      ->add('beskrivelseDriftOgVedligeholdelse', 'textarea', array('attr' => array('maxlength' => 10000), 'required' => FALSE))
      ->add('indeklima', 'textarea', array('attr' => array('maxlength' => 10000), 'required' => false));

    $builder->add('risikovurderingTeknisk', new RisikovurderingType(), array());
    $builder->add('risikovurderingBrugsmoenster', new RisikovurderingType(), array());
    $builder->add('risikovurderingDatagrundlag', new RisikovurderingType(), array());
    $builder->add('risikovurderingDiverse', new RisikovurderingType(), array());
    $builder->add('risikovurderingAendringIBesparelseFaktor', 'percent', array('required' => FALSE));
    $builder->add('risikovurderingOekonomiskKompenseringIftInvesteringFaktor', 'percent', array('required' => FALSE));
    $builder->add('slutanvendelse', 'choice', array(
        'choices' => SlutanvendelseType::getChoices(),
//        'choices_as_values' => TRUE,
        'empty_value' => '--',
        'required' => TRUE,
        'attr' => isset(SlutanvendelseType::$detaultValues[get_class($this->tiltag)]) ? array('disabled' => 'disabled'): array()
    ));

    if ($this->tiltag instanceof TekniskIsoleringTiltag) {
      $builder
        ->add('besparelseDriftOgVedligeholdelse')
        ->add('besparelseStrafafkoelingsafgift')
        ->add('levetid');
    }
    if ($this->tiltag instanceof PumpeTiltag) {
      $builder
        ->add('besparelseDriftOgVedligeholdelse')
        ->add('levetid');
    }
    if ($this->tiltag instanceof VindueTiltag) {
      $builder
        ->add('besparelseDriftOgVedligeholdelse');
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
        ->add('besparelseDriftOgVedligeholdelse')
        ->add('besparelseStrafafkoelingsafgift')
        ->add('anlaegsinvesteringExRisiko')
        ->add('besparelseGUF')
        ->add('besparelseGAF')
        ->add('besparelseEl')
        ->add('besparelseCo2Braendstof', 'percent')
        ->add('besparelseCo2BraendstofITon')
        ->add('besparelseBraendstof')
        ->add('yderligereBesparelse')
        ->add('levetid');

      $builder->add('primaerEnterprise')
        ->add('tiltagskategori');
    }
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolver $resolver
   * @TODO: Missing description.
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
   * @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_tiltag';
  }
}
