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
 * Class VirksomhedRapportType
 * @package AppBundle\Form
 */
class VirksomhedRapportType extends AbstractType
{
  protected $authorizationChecker;
  protected $rapport;

  public function __construct(AuthorizationCheckerInterface $authorizationChecker, VirksomhedRapport $rapport)
  {
    $this->authorizationChecker = $authorizationChecker;
    $this->rapport = $rapport;
  }

  /**
   * @inheritDoc.
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {

    $builder
      ->add('datering', 'date', array(
        'widget' => 'single_text')
      )
    ;

    if ($this->authorizationChecker && $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
      $builder->add('elena');
    }

    if ($this->authorizationChecker && $this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
      $builder->add('ava');
    }
  }

  /**
   * @inheritDoc.
   */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\VirksomhedRapport'
    ));
  }

  /**
   * @inheritDoc.
   */
  public function getName()
  {
    return 'appbundle_rapport';
  }
}
