<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\DBAL\Types\BygningStatusType;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;

/**
 * Class BygningType
 * @package AppBundle\Form
 */
class BygningFilterType extends AbstractType {
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
      ->add('bygId', 'filter_number')
      ->add('navn', 'filter_text', array('condition_pattern' => FilterOperands::STRING_BOTH))
      ->add('adresse', 'filter_text', array('condition_pattern' => FilterOperands::STRING_BOTH))
      ->add('postnummer', 'filter_text', array('condition_pattern' => FilterOperands::STRING_STARTS))
      ->add('postBy', 'filter_text', array('condition_pattern' => FilterOperands::STRING_BOTH))
      ->add('segment', 'filter_entity', array('class' => 'AppBundle\Entity\Segment', 'required' => false))
      ->add('status', null, array('required' => false));

//    $builder->add('rapport', new RapportFilterType());

    $builder->add('rapport', new RapportFilterType(), array(
      'add_shared' => function (FilterBuilderExecuterInterface $qbe) {
        $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
          $filterBuilder->leftJoin($alias . '.rapport', $joinAlias);
        };

        $qbe->addOnce($qbe->getAlias().'.rapport', 'r', $closure);
      }
    ));

    $builder
      ->add('Excel', 'submit', array('label' => 'Hent som excel'))
      ->add('Søg', 'submit');
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolver $resolver
   *   @TODO: Missing description.
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Bygning',
      'csrf_protection'   => false,
      'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'bygning_filter';
  }
}
