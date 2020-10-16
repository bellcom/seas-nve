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
 * Class ReportImageMarkStandardType
 * @package AppBundle\Form
 */
class ReportImageMarkStandardType extends AbstractType {
  protected $reportImage;

  public function __construct(ReportImage $reportImage) {
    $this->reportImage = $reportImage;
  }

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('mark_standard', 'submit');
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
