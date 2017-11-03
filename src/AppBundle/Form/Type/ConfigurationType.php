<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class ConfigurationType
 * @package AppBundle\Form
 */
class ConfigurationType extends AbstractType {
  protected $authorizationChecker;

  public function __construct(AuthorizationCheckerInterface $authorizationChecker)
  {
    $this->authorizationChecker = $authorizationChecker;
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
    if ($this->authorizationChecker && $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
      $builder
        ->add('rapportKalkulationsrente', 'percent', array('scale' => 2));
    }

    $builder
      ->add('rapportDriftomkostningerfaktor')
      ->add('rapportInflation')
      ->add('rapportLobetid')
      ->add('rapportProcentAfInvestering', 'percent', array('scale' => 2))
      ->add('rapportNominelEnergiprisstigning')

      ->add('tekniskisoleringVarmeledningsevneEksistLamelmaatter')
      ->add('tekniskisoleringVarmeledningsevneNyIsolering')

      ->add('solcelletiltagdetailEnergiprisstigningPctPrAar', 'percent', array('scale' => 2))
      ->add('solcelletiltagdetailSalgsprisFoerste10AarKrKWh')
      ->add('solcelletiltagdetailSalgsprisEfter10AarKrKWh')

      ->add('mtmFaellesomkostningerGrundpris')
      ->add('mtmFaellesomkostningerPrisPrM2')
      ->add('mtmFaellesomkostningerNulHvisArealMindreEnd')
      ->add('mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd');
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolver $resolver
   *   @TODO: Missing description.
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Configuration'
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_configuration';
  }
}
