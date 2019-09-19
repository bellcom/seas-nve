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
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * Class BygningType
 * @package AppBundle\Form
 */
class VirksomhedBaselineEmbedType extends AbstractType {

  /**
   * @inheritDoc
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('erhvervsareal', null, array('disabled' => 'disabled'));
  }

  /**
   * @inheritDoc
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Virksomhed',
    ));
  }

  /**
   * @inheritDoc
   */
  public function getName() {
    return 'appbundle_bygning_embed';
  }
}
