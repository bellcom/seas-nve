<?php
/**
 * @file
 * Bilag form.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\RapportSektioner\RapportSektion;
use AppBundle\Entity\ReportImage;
use AppBundle\Entity\ReportText;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Trsteel\CkeditorBundle\Form\Type\CkeditorType;

/**
 * Class ReportTextType
 * @package AppBundle\Form
 */
class ReportTextType extends AbstractType {
    protected $type;
    protected $reportText;

    public function __construct($type, ReportText $reportText)
    {
        $this->type = $type;
        $this->reportText = $reportText;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'required' => TRUE,
            ))
            ->add('body', CkeditorType::class, array('attr' => array('maxlength' => 10000), 'required' => FALSE))
            ->add('type', ChoiceType::class, array(
                'choices' => $options['report_text_types'],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ReportText'
        ));
        $resolver->setRequired('report_text_types');
    }

    public function getName()
    {
        return 'appbundle_reporttext';
    }
}
