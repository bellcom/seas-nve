<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\RegistryInterface;
use AppBundle\DBAL\Types\BygningStatusType;
use Symfony\Component\Form\FormInterface;

/**
 * Class BygningType
 * @package AppBundle\Form
 */
class BygningRapportType extends AbstractType {

  private $doctrine;

  protected $authorizationChecker;

  public function __construct(RegistryInterface $doctrine, $authorizationChecker) {
    $this->doctrine = $doctrine;
    $this->authorizationChecker = $authorizationChecker;
  }

  /**
   * {@inheritDoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('rapport', new RapportEmbedType($this->authorizationChecker), array(
          'by_reference' => TRUE,
          'data_class' => 'AppBundle\Entity\Rapport'
        )
      );
  }

  /**
   * {@inheritDoc}
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Bygning',
    ));
  }

  /**
   * {@inheritDoc}
   */
  public function getName() {
    return 'appbundle_bygning';
  }
}
