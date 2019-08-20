<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\DBAL\Types\BygningStatusType;
/**
 * Class BygningType
 * @package AppBundle\Form
 */
class VirksomhedRapportSearchVirksomhedEmbedType extends AbstractType {
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
      ->add('name', null, array('label' => false))
      ->add('address', null, array('label' => false))
      ->add('cvrNumber', null, array('label' => false));
  }

  /**
   * @inheritDoc
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Virksomhed',
      'validation_groups' => false
    ));
  }

  /**
   * @inheritDoc
   */
  public function getName() {
    return 'virksomhed';
  }
}
