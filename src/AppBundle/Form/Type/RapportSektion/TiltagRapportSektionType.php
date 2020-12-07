<?php

namespace AppBundle\Form\Type\RapportSektion;

use AppBundle\DBAL\Types\RapportSectionType as DBALRapportSectionType;
use AppBundle\Entity\RapportSektioner\ForsideRapportSektion;
use AppBundle\Entity\RapportSektioner\TiltagRapportSektion;
use AppBundle\Entity\ReportImage;
use AppBundle\Entity\ReportText;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TiltagRapportSektionType extends RapportSektionType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var TiltagRapportSektion $reportSection */
        $reportSection = $builder->getData();
        $usingCustomImage = TRUE;
        $selectedStandardImage = NULL;

        $em = $options['entity_manager'];
        $standardImages = $em->getRepository('AppBundle:ReportImage')->findBy(array('type' => $reportSection->getTiltagType()));

        /** @var ReportImage $image */
        foreach ($standardImages as $image) {
            if ($image->getFilepath() == $reportSection->getFilepath()) {
                $usingCustomImage = FALSE;
                $selectedStandardImage = $image;
            }
        }

        $builder
            ->add('title', 'text',[
                'attr' => [
                    'help_text' => 'Lad titlen være tom for at bruge titlen fra Forslag',
                ],
                'required' => FALSE,
            ])
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
                'empty_value' => 'Brugerdefineret',
                'data' => $usingCustomImage ? NULL : $selectedStandardImage,
                'required' => FALSE,
                'mapped' => FALSE
            ));
        $helpText = 'Tilladte filtyper er jpg, jpeg, png.';
        $sizeHelpText = ReportImage::getImageTypeSizesHelpText($reportSection->getTiltagType());
        $builder
            ->add('filepath', FileType::class, array(
                'data_class' => NULL,
                'attachment_path' => $usingCustomImage ? 'filepath' : NULL,
                'required' => FALSE,
                'attr' => array(
                    'help_text' => $helpText . ($sizeHelpText ? sprintf(' Ønskede billidestørelse: %s', $sizeHelpText) : ''),
                ),
            ))
            ->add('text', 'ckeditor', [
                'attr' => [
                    'maxlength' => 10000,
                    'class' => 'js-default-value-target js-default-value-target',
                    'data-default-value-source' => 'text',
                ],
                'required' => FALSE,
            ])
            ->add('textPages', 'bootstrap_collection', array(
            'property_path' => 'textPages',
            'type' => new RapportSektionTextPageType(),
            'options' => array(
                'showAfterPages' => array(
                    'page1' => 'Efter side 1',
                    'page2' => 'Efter side 2',
                    'page3' => 'Efter side 3',
                ),
            ),
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

    public function getName() {
        return 'appbundle_rapportsektion_tiltag';
    }
}
