<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


/**
 * Class TiltagDetailEmbeddedType
 * @package AppBundle\Form
 */
class TiltagDetailEmbeddedType extends AbstractType {


  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('tilvalgt', 'checkbox', array('label' => FALSE, 'required' => FALSE, 'attr' => array(
      'class' => 'tilvalgt'
    )));
    $builder->add('batchEdit', 'checkbox', array('label' => 'common.choose', 'required' => FALSE, 'mapped' => true, 'attr' => array(
      'class' => 'js-batch-edit'
    )));
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(
      array(
        'data_class' => 'AppBundle\Entity\TiltagDetail'
      )
    );
  }

  public function getName() {
    return 'appbundle_tiltagdetail';
  }
}
