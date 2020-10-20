<?php
/**
 * @file
 * Bilag form.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\ReportImage;
use AppBundle\Entity\ReportText;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

/**
 * Class ReportTextType
 * @package AppBundle\Form
 */
class ReportTextType extends AbstractType {
  protected $reportText;

  public function __construct(ReportText $reportText) {
    $this->reportText = $reportText;
  }

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('title', 'text', array(
        'required' => TRUE,
      ))
      ->add('body', 'ckeditor', array('attr' => array('maxlength' => 10000), 'required' => FALSE));
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\ReportText'
    ));
  }

  public function getName() {
    return 'appbundle_reporttext';
  }
}
