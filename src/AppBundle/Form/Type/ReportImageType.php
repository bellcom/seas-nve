<?php
/**
 * @file
 * Bilag form.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\ReportImage;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Bilag;
use Symfony\Component\Form\AbstractType;

/**
 * Class ReportImageType
 * @package AppBundle\Form
 */
class ReportImageType extends AbstractType {
  protected $reportImage;

  public function __construct(ReportImage $reportImage) {
    $this->reportImage = $reportImage;
  }

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('title')
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

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\ReportImage'
    ));
  }

  public function getName() {
    return 'appbundle_reportimage';
  }
}
