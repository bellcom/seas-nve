<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\Rapport;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class RapportType
 * @package AppBundle\Form
 */
class RapportType extends AbstractType
{
  /** @var AuthorizationCheckerInterface $authorizationChecker */
  protected $authorizationChecker;

  /** @var Rapport $rapport */
  protected $rapport;

  /** @var TranslatorInterface $translator */
  protected $translator;

  /** @var PropertyAccessor $accessor */
  protected $accessor;

  public function __construct(ContainerInterface $container, Rapport $rapport)
  {
    $this->authorizationChecker = $container->get('security.context');
    $this->translator = $container->get('translator');
    $this->rapport = $rapport;
    $this->accessor = PropertyAccess::createPropertyAccessor();
  }

  /**
   * @inheritDoc
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $disabled_options = array(
      'disabled' => 'disabled',
      'attr' => array(
        'help_text' => $this->translator->trans('bygning_rapporter.messages.baseline_value_disabled'),

      ),
    );
    $builder
      ->add('datering', 'date', array(
        // render as a single HTML5 text box
        'widget' => 'single_text')
      )
      ->add('BaselineEl', null, ($this->isAllowed('BaselineEl') ? array() : $disabled_options))
      ->add('BaselineVarmeGUF', null, ($this->isAllowed('BaselineVarmeGUF') ? array() : $disabled_options))
      ->add('BaselineVarmeGAF', null, ($this->isAllowed('BaselineVarmeGAF') ? array() : $disabled_options))
      ->add('BaselineBraendstof', null, ($this->isAllowed('BaselineBraendstof') ? array() : $disabled_options))
      ->add('BaselineStrafAfkoeling', null, ($this->isAllowed('BaselineStrafAfkoeling') ? array() : $disabled_options))
      ->add('bygning', new BygningBaselineEmbedType(), array('label' => false))
      ->add('faktorPaaVarmebesparelse')
      ->add('energiscreening');

    if ($this->authorizationChecker && $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
      $builder->add('elena');
    }

    if ($this->authorizationChecker && $this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
      $builder->add('ava');
    }
  }

  /**
   * @inheritDoc
   */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Rapport',
    ));
  }

  /**
   * @inheritDoc
   */
  public function getName()
  {
    return 'appbundle_rapport';
  }

  /**
   * @inheritDoc
   */
  public function isAllowed($fieldName)
  {
    if (!empty($this->rapport->getBygning()->getBaseline())) {
      return FALSE;
    }

    if (!empty($this->rapport->getBygning()->getVirksomhed())
      && !empty($this->rapport->getBygning()->getVirksomhed()->getRapport())
      && !empty((integer) $this->accessor->getValue($this->rapport->getBygning()->getVirksomhed()->getRapport(), $fieldName))) {
      return FALSE;
    }

    return TRUE;
  }

}
