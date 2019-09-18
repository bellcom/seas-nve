<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;

/**
 * Class PumpeImportType
 * @package AppBundle\Form
 */
class PumpeImportType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('filepath', 'file', array(
        'data_class' => null,
        'attachment_path' => 'filepath',
      ));

    $builder->addEventListener(
      FormEvents::PRE_SUBMIT,
      function(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        // Remove filepath field if not submitted
        if (!isset($data['filepath']) || $data['filepath'] === null) {
          $form->remove('filepath');
        }
      });
  }

  public function getName() {
    return 'appbundle_pumpe_import';
  }
}
