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
class RapportType extends AbstractType {
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
      ->add('version')
      ->add('version')
      ->add('datering')
      ->add('BaselineEl', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'kwh/år'
          )
        )
      ))
      ->add('BaselineVarmeGUF', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'kwh/år'
          )
        )
      ))
      ->add('BaselineVarmeGAF', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'kwh/år'
          )
        )
      ))
      ->add('BaselineVand', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'm3/år'
          )
        )
      ))
      ->add('BaselineStrafAfkoeling', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'kr./år'
          )
        )
      ))
      ->add('faktorPaaVarmebesparelse', 'percent')
      ->add('Energiscreening', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'kr.'
          )
        )
      ))
      ->add('elena');

    if ($this->authorizationChecker && $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
      $builder->add('laanLoebetid', null, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'år'
          )
        )
      ));
    }
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
