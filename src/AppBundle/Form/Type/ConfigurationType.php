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
        ->add('kalkulationsrente');
    }

    $builder
      ->add('inflation')
      ->add('lobetid')

      ->add('procentAfInvestering', 'percent', array('scale' => 2))

      ->add('nominelEnergiprisstigning')

      ->add('varmeledningsevneEksistLamelmaatter')
      ->add('varmeledningsevneNyIsolering');
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
