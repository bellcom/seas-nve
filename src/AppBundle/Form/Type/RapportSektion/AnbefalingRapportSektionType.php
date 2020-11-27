<?php

namespace AppBundle\Form\Type\RapportSektion;

use AppBundle\Entity\RapportSektioner\AnbefalingRapportSektion;
use AppBundle\Entity\ReportImage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnbefalingRapportSektionType extends RapportSektionType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text',[
                'attr' => [
                    'help_text' => 'Lad titlen være tom for at bruge etiketten fra Anbefaling type felt',
                ],
                'required' => FALSE,
            ])
            ->add('text', 'ckeditor', [
                'attr' => [
                    'maxlength' => 10000,
                    'class' => 'js-default-value-target js-default-value-target',
                    'data-default-value-source' => 'text',
                    ],
                    'required' => FALSE,
            ])
       ;

        /** @var AnbefalingRapportSektion $reportSection */
        $reportSection = $builder->getData();
        $usingCustomImage = TRUE;
        $selectedStandardImage = NULL;

        $em = $options['entity_manager'];
        $standardImages = $em->getRepository('AppBundle:ReportImage')->findBy(array('type' => $reportSection->getType()));

        /** @var ReportImage $image */
        foreach ($standardImages as $image) {
            if ($image->getFilepath() == $reportSection->getFilepath()) {
                $usingCustomImage = FALSE;
                $selectedStandardImage = $image;
            }
        }

        $builder
            ->add('imagestandard', EntityType::class, array(
                'class' => 'AppBundle:ReportImage',
                'choices' => $standardImages,
                'expanded' => TRUE,
                'choice_label' => function(ReportImage $image, $key) use ($reportSection) {
                    $title = $image->getTitle();
                    if ($image->isStandardByType($reportSection->getRapportType())) {
                        $title .= ' <b>(standard)</b>';
                    }

                    return sprintf('%s<img src="/%s" class="image-swatch">', $title, $image->getFilepath());
                },
                'attr' => array('class' => 'image-picker'),
                'empty_value' => 'Brugerdefinerede',
                'data' => $usingCustomImage ? NULL : $selectedStandardImage,
                'required' => FALSE,
                'mapped' => FALSE
            ));
        $helpText = 'Tilladte filtyper er jpg, jpeg, png.';
        $sizeHelpText = ReportImage::getImageTypeSizesHelpText('anbefaling');
        $builder
            ->add('filepath', FileType::class, array(
                'label' => 'Billede',
                'data_class' => NULL,
                'attachment_path' => $usingCustomImage ? 'filepath' : NULL,
                'required' => FALSE,
                'mapped' => FALSE,
                'attr' => array(
                    'help_text' => $helpText . ($sizeHelpText ? sprintf(' Ønskede billidestørelse: %s', $sizeHelpText) : ''),
                ),
            ))
            ->add('extras', AnbefalingRapportSektionExtrasType::class, array(
                'label' => FALSE,
                'entity_manager' => $options['entity_manager'],
            ));
        $builder->add('textPages', 'bootstrap_collection', array(
            'property_path' => 'textPages',
            'type' => new RapportSektionTextPageType(),
            'label' => FALSE,
            'required' => FALSE,
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
            'add_button_text'    => 'Add',
            'delete_button_text' => 'Delete',
            'sub_widget_col'     => 10,
            'button_col'         => 2,
        ));
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\RapportSektioner\AnbefalingRapportSektion'
            )
        );
        $resolver->setRequired('entity_manager');
    }

    public function getName() {
        return 'appbundle_rapportsektion_anbefaling';
    }
}
