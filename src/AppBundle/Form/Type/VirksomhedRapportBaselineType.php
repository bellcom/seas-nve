<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\VirksomhedRapport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class VirksomhedRapportBaselineType
 * @package AppBundle\Form
 */
class VirksomhedRapportBaselineType extends AbstractType
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
    $baseline = $this->rapport->getVirksomhed()->getBaseline();
    $builder
      ->add('datering', 'date', array(
        'disabled' => 'disabled',
        // render as a single HTML5 text box
        'widget' => 'single_text')
      )
      ->add('BaselineEl', null, empty($baseline) ? array() : array('disabled' => 'disabled'))
      ->add('BaselineVarmeGUF', null, empty($baseline) ? array() : array('disabled' => 'disabled'))
      ->add('BaselineVarmeGAF', null, empty($baseline) ? array() : array('disabled' => 'disabled'))
      ->add('BaselineBraendstof', null, empty($baseline) ? array() : array('disabled' => 'disabled'))
      ->add('BaselineStrafAfkoeling', null, empty($baseline) ? array() : array('disabled' => 'disabled'))
      ->add('faktorPaaVarmebesparelse', null, empty($baseline) ? array() : array('disabled' => 'disabled'))
      ->add('energiscreening', null, empty($baseline) ? array() : array('disabled' => 'disabled'));
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
