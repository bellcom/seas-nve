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
 * Class BaselineKorrektionEmbeddedType
 * @package AppBundle\Form
 */
class BaselineKorrektionEmbeddedType extends AbstractType {


  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('indvirkning', 'checkbox', array('label' => FALSE, 'required' => FALSE));
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(
      array(
        'data_class' => 'AppBundle\Entity\BaselineKorrektion'
      )
    );
  }

  public function getName() {
    return 'appbundle_baselinekorrektion';
  }
}
