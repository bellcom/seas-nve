<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\TiltagDetail;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class TiltagDetailType
 * @package AppBundle\Form
 */
class TiltagDetailType extends AbstractType {
  protected $container;
  protected $authorizationChecker;
  protected $detail;

  public function __construct(ContainerInterface $container, TiltagDetail $detail)
  {
    $this->container = $container;
    $this->authorizationChecker = $this->container->get('security.context');
    $this->detail = $detail;
  }

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('tilvalgt')
            ->add('ikkeElenaBerettiget');

  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(
      array(
        'data_class' => 'AppBundle\Entity\TiltagDetail'
      )
    );
  }

  public function getName() {
    return 'appbundle_tiltagdetail';
  }

  /**
   * Insert form field after a specific field.
   *
   * @param FormBuilderInterface $builder
   *   The form builder.
   * @param string|FormBuilderInterface $reference
   *   The field to insert after.
   * @param array $newFields
   *   The list of fields to insert.
   *   Each field must be an array with
   *   arguments suitable for calling FormBuilderInterface::create or a field
   *   created by FormBuilderInterface::create
   *
   * @return FormBuilderInterface
   *   The form builder.
   */
  protected function insertAfter(FormBuilderInterface $builder, $reference, array $newFields) {
    $allFields = $builder->all();
    foreach ($allFields as $name => $field) {
      $builder->remove($name);
    }

    $inserted = false;
    foreach ($allFields as $name => $field) {
      $builder->add($field);
      if ($name == $reference || $field == $reference) {
        $this->addFields($builder, $newFields);
        $inserted = true;
      }
    }

    if (!$inserted) {
      $this->addFields($builder, $newFields);
    }

    return $builder;
  }

  /**
   * Add fields to a form builder.
   *
   * @param FormBuilderInterface $builder
   *   The form builder.
   * @param array $fields
   *   The list of fields to add.
   *   Each field must be an array with
   *   arguments suitable for calling FormBuilderInterface::create or a field
   *   created by FormBuilderInterface::create
   *
   * @return FormBuilderInterface
   *   The form builder.
   */
  private function addFields(FormBuilderInterface $builder, array $fields) {
    foreach ($fields as $field) {
      if (is_array($field)) {
        $builder->add(call_user_func_array(array($builder, 'create'), $field));
      } elseif ($field instanceof FormBuilderInterface) {
        $builder->add($field);
      }
    }

    return $builder;
  }
}
