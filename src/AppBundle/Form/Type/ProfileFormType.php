<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    // add your custom field
    $builder->add('firstname');
    $builder->add('lastname');
    $builder->add('phone');
  }

  public function getParent()
  {
    return 'fos_user_profile';
  }

  public function getName()
  {
    return 'appbundle_user_profile';
  }
}