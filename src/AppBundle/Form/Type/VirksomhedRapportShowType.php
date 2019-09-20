<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\VirksomhedRapport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class VirksomhedRapportType
 * @package AppBundle\Form
 */
class VirksomhedRapportShowType extends AbstractType
{
  protected $authorizationChecker;
  protected $rapport;

  public function __construct(AuthorizationCheckerInterface $authorizationChecker, VirksomhedRapport $rapport)
  {
    $this->authorizationChecker = $authorizationChecker;
    $this->rapport = $rapport;
  }

  /**
   * @inheritDoc
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {

    $builder
      ->add('datering', 'date', array(
        'disabled' => 'disabled',
        // render as a single HTML5 text box
        'widget' => 'single_text')
      )
      ->add('BaselineEl', null, array('disabled' => 'disabled'))
      ->add('BaselineVarmeGUF', null, array('disabled' => 'disabled'))
      ->add('BaselineVarmeGAF', null, array('disabled' => 'disabled'))
      ->add('BaselineBraendstof', null, array('disabled' => 'disabled'))
      ->add('BaselineStrafAfkoeling', null, array('disabled' => 'disabled'))
      ->add('faktorPaaVarmebesparelse', null, array('disabled' => 'disabled'))
      ->add('energiscreening', null, array('disabled' => 'disabled'));
  }

  /**
   * @inheritDoc
   */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\VirksomhedRapport'
    ));
  }

  /**
   * @inheritDoc
   */
  public function getName()
  {
    return 'appbundle_virksomhed_rapport';
  }
}
