<?php

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
  /**
   * @var RegistryInterface
   */
  private $doctrine;

  public function __construct(RegistryInterface $doctrine) {
    $this->doctrine = $doctrine;
  }

  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $em = $this->doctrine->getRepository('AppBundle:Group');
    $groups = array();
    foreach ($em->findAll() as $group) {
      $groups[$group->getName()] = $group->getId();
    }

    $builder
      ->add('enabled', null, array('label' => 'user.enabled'))
      ->add('email')
      ->add('plainpassword')
      ->add('firstname')
      ->add('lastname')
      ->add('phone')
      ->add('segmenter', null, array('by_reference' => false, 'expanded' => true , 'multiple' => true))
      ->add('groups', null, array('by_reference' => false, 'expanded' => true , 'multiple' => true))
    ;
  }

  /**
   * @param OptionsResolver $resolver
   */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\User'
    ));
  }

  /**
   * @return string
   */
  public function getName()
  {
    return 'appbundle_user';
  }
}
