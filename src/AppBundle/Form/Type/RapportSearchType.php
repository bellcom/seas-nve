<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class RapportType
 * @package AppBundle\Form
 */
class RapportSearchType extends AbstractType {
  protected $authorizationChecker;

  public function __construct(AuthorizationCheckerInterface $authorizationChecker)
  {
    $this->authorizationChecker = $authorizationChecker;
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
    $builder
      ->add('bygning', new RapportSearchBygningEmbedType(), array('label' => false))
      ->add('version', 'text' , array('label' => false))
      ->add('datering', 'text' , array('label' => false));


    if ($this->authorizationChecker && $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
      $builder->add('elena', 'choice', array(
        'choices' => array(
          '0' => 'Nej',
          '1' => 'Ja',
        ),
        'empty_value' => '--',
        'required' => FALSE,
        'label' => FALSE
      ));
      $builder->add('ava', 'choice', array(
        'choices' => array(
          '0' => 'Nej',
          '1' => 'Ja',
        ),
        'empty_value' => '--',
        'required' => FALSE,
        'label' => FALSE
      ));
    }

    $builder->add('Søg', 'submit');
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
    return 'appbundle_rapport';
  }
}
