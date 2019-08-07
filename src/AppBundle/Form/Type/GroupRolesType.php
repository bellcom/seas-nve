<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Group;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupRolesType extends AbstractType {

    /** @var ContainerInterface $container */
    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $roles = Group::getAllRoles();
    $builder->add('roles', 'choice', array(
        'choices' => array_reverse(array_keys($roles)),
        'choices_as_values' => TRUE,
        'expanded' => TRUE,
        'multiple' => TRUE,
        'choice_label' => function ($value, $key, $index) {
            return $this->getRoleLabel($value, $key, $index);
        }
    ));
  }

  /**
   * @param OptionsResolverInterface $resolver
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Group'
    ));
  }

  /**
   * @return string
   */
  public function getName() {
    return 'appbundle_group_roles';
  }

  /**
   * @return string
   */
  public function getRoleLabel($value, $key, $index) {
    return $index;
  }

}
