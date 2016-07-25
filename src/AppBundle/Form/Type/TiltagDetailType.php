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
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

/**
 * Class TiltagDetailType
 * @package AppBundle\Form
 */
class TiltagDetailType extends AbstractType {
  protected $container;
  protected $authorizationChecker;
  protected $detail;
  protected $isBatchEdit;
  protected $doctrine;

  public function __construct(ContainerInterface $container, TiltagDetail $detail, $isBatchEdit = false)
  {
    $this->container = $container;
    $this->doctrine = $this->container->get('doctrine');
    $this->authorizationChecker = $this->container->get('security.context');
    $this->detail = $detail;
    $this->isBatchEdit = $isBatchEdit;
  }

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('tilvalgt');
    $builder->add('ikkeElenaBerettiget');

    $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'modifyForBatchEdit'));
  }

  public function modifyForBatchEdit(FormEvent $event) {
    if($this->isBatchEdit) {
      $form = $event->getForm();
      foreach ($event->getForm()->all() as $child) {
        $config = $child->getConfig();
        $options = $config->getOptions();
        $type = $config->getType()->getName();
        $name = $config->getName();

        // Alter checkbox to dropdown
        if($type === 'checkbox') {
          $options['choice_value'] = null;
          unset($options['value']);
          $form->add(
          // Replace original field...
            $name,
            'choice',
            // while keeping the original options...
            array_replace(
              $options,
              [
                // replacing specific ones
                'required' => false,
                'choices' => array(
                  '0' => 'Nej',
                  '1' => 'Ja',
                ),
                'empty_data'  => null,
                'empty_value' => '--'
              ]
            )
          );
        } else {
          // Set all as "Not required"
          $form->add(
          // Replace original field...
            $name,
            $type,
            // while keeping the original options...
            array_replace(
              $options,
              [
                // replacing specific ones
                'required' => false,
              ]
            )
          );
        }
      }
    }
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
