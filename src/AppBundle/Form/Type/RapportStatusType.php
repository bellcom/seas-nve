<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\DBAL\Types\BygningStatusType;
use AppBundle\Entity\Rapport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class RapportType
 * @package AppBundle\Form
 */
class RapportStatusType extends AbstractType {
  protected $authorizationChecker;
  protected $status;

  public function __construct(AuthorizationCheckerInterface $authorizationChecker, $status)
  {
    $this->authorizationChecker = $authorizationChecker;
    $this->status = $status;
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
    /**
     * @deprecated  Status property is hidden from rendering.
     */
    if($this->status === BygningStatusType::UNDER_UDFOERSEL && $this->authorizationChecker && $this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
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
   * @TODO: Missing description.
   *
   * @param OptionsResolver $resolver
   *   @TODO: Missing description.
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Rapport'
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_rapport_status';
  }
}
