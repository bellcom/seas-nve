<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\AppBundle;
use AppBundle\DBAL\Types\BygningStatusType;
use AppBundle\DBAL\Types\LevetidType;
use AppBundle\Entity\NyKlimaskaermTiltag;
use AppBundle\Entity\TrykluftTiltag;
use AppBundle\Entity\VarmeAnlaegTiltag;
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
      $builder->add('tilvalgtAfMagistrat');
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
            ->add('opstartsomkostninger');

    $attr = array();
    if ($this->tiltag instanceof SpecialTiltag) {
      $attr = array(
        'help_text' => 'Besparelse varme GAF + Besparelse varme GUF',
        'disabled' => 'disabled',
      );
    }

    $builder
      ->add('forbrugFoer')
      ->add('forbrugEfter', 'text', array('attr' => $attr));

    $builder
      ->add('genopretning')
      ->add('genopretningForImplementeringsomkostninger')
      ->add('modernisering')
      ->add('reelAnlaegsinvestering');

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
      ->add('placering', 'textarea', array('attr' => array('maxlength' => 10000), 'required' => FALSE))
      ->add('beskrivelseDriftOgVedligeholdelse', 'textarea', array('attr' => array('maxlength' => 10000), 'required' => FALSE))
      ->add('indeklima', 'textarea', array('attr' => array('maxlength' => 10000), 'required' => false));

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
        ->add('levetid', 'choice', array(
          'choices' => LevetidType::getChoices(),
          'empty_value' => '--',
          'required' => TRUE,
        ));
    }
    if ($this->tiltag instanceof PumpeTiltag) {
      $builder
        ->add('besparelseDriftOgVedligeholdelse')
        ->add('levetid', 'choice', array(
          'choices' => LevetidType::getChoices(),
          'empty_value' => '--',
          'required' => TRUE,
        ));
    }
    if ($this->tiltag instanceof VindueTiltag) {
      $builder
        ->add('besparelseDriftOgVedligeholdelse');
    }
    if ($this->tiltag instanceof TrykluftTiltag) {
      $builder
        ->add('priserOverride', 'collection', array(
            'type' => PrisOverrideType::class,
            'label' => FALSE,
            'required' => FALSE,
        ));
    }
    if ($this->tiltag instanceof VarmeAnlaegTiltag) {
      $builder
        ->add('priserOverride', 'collection', array(
          'type' => PrisOverrideType::class,
          'options' => array(
            'overriden_checkbox' => FALSE,
          ),
          'label' => FALSE,
          'required' => FALSE,
        ));
    }
    elseif ($this->tiltag instanceof SolcelleTiltag) {
      $builder
        ->add('levetid', 'choice', array(
          'choices' => LevetidType::getChoices(),
          'empty_value' => '--',
          'required' => TRUE,
        ));
    }
    elseif ($this->tiltag instanceof KlimaskaermTiltag || $this->tiltag instanceof NyKlimaskaermTiltag) {
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
        ->add('levetid', 'choice', array(
          'choices' => LevetidType::getChoices(),
          'empty_value' => '--',
          'required' => TRUE,
        ));

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
