<?php

namespace AppBundle\Form\Type\RapportSektion;

use AppBundle\DBAL\Types\RapportSectionType as DBALRapportSectionType;
use AppBundle\Entity\RapportSektioner\ForsideRapportSektion;
use AppBundle\Entity\ReportImage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForsideRapportSektionType extends RapportSektionType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var ForsideRapportSektion $reportSection */
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
                'choice_label' => function(ReportImage $image, $key) {
                    $title = $image->getTitle();
                    if ($image->isStandard()) {
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
        $sizeHelpText = ReportImage::getImageTypeSizesHelpText('forside');
        $builder
            ->add('filepath', FileType::class, array(
                'data_class' => NULL,
                'attachment_path' => $usingCustomImage ? 'filepath' : NULL,
                'required' => FALSE,
                'mapped' => FALSE,
                'attr' => array(
                    'help_text' => $helpText . ($sizeHelpText ? sprintf(' Ønskede billidestørelse: %s', $sizeHelpText) : ''),
                ),
            ))
            ->add('title')
            ->add('extras', ForsideRapportSektionExtrasType::class, array('label' => FALSE))
        ;
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\RapportSektioner\ForsideRapportSektion'
            )
        );
        $resolver->setRequired('entity_manager');
    }

    public function getName() {
        return 'appbundle_rapportsektion_forside';
    }
}
