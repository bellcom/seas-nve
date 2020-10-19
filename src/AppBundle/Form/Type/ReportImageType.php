<?php
/**
 * @file
 * Bilag form.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\ReportImage;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
      ->add('title', 'text', array(
        'required' => TRUE,
      ))
      ->add('filepath', 'file', array(
        'data_class' => NULL,
        'attachment_path' => 'filepath',
      ));
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
