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
 * Class VirksomhedRapportSearchType
 * @package AppBundle\Form
 */
class VirksomhedRapportSearchType extends AbstractType {
  protected $authorizationChecker;

  public function __construct(AuthorizationCheckerInterface $authorizationChecker)
  {
    $this->authorizationChecker = $authorizationChecker;
  }

  /**
   * @inheritDoc.
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('virksomhed', new VirksomhedRapportSearchVirksomhedEmbedType(), array('label' => false))
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
   * @inheritDoc
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\VirksomhedRapport'
    ));
  }

  /**
   * @inheritDoc
   */
  public function getName() {
    return 'appbundle_virksomhed_rapport';
  }
}
