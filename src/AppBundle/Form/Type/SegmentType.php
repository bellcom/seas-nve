<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SegmentType extends AbstractType
{
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
    $builder
      ->add('navn')
      ->add('forkortelse')
      ->add('magistrat')
      ->add('segmentAnsvarlig', 'entity', array(
        'class' => 'AppBundle:User',
        'choices' => $this->getUsersFromGroup("Aa+"),
        'required' => false,
        'empty_value'  => 'common.none',
      ))
    ;
  }

  private function getUsersFromGroup($groupname) {
    $em = $this->doctrine->getRepository('AppBundle:Group');

    $group = $em->findOneByName($groupname);

    return $group->getUsers();
  }

  /**
   * @param OptionsResolverInterface $resolver
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Segment'
    ));
  }

  /**
   * @return string
   */
  public function getName()
  {
    return 'appbundle_segment';
  }
}
