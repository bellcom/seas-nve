<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\VirksomhedRapport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class VirksomhedRapportStatusType
 * @package AppBundle\Form
 */
class VirksomhedRapportStatusType extends AbstractType {
  protected $authorizationChecker;
  protected $status;

  public function __construct(AuthorizationCheckerInterface $authorizationChecker)
  {
    $this->authorizationChecker = $authorizationChecker;
  }

  /**
   * @inheritDoc.
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    if($this->authorizationChecker && $this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
      $builder->add('ava', 'choice', array(
        'choices' => array(
          '0' => 'Ikke ansøgt AVA-støtte',
          '1' => 'Ansøgt om AVA-støtte ',
        ),
        'empty_value' => '--',
        'required' => TRUE
      ));
    }
  }

  /**
   * @inheritDoc
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\VirksomhedRapport'
    ));
  }

  /**
   * @inheritDoc
   */
  public function getName() {
    return 'appbundle_virksomhed_rapport_status';
  }
}
