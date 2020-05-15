<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\DBAL\Types\BelysningTiltagDetail\LykilderBenyttelsesFaktor;
use AppBundle\Entity\BelysningTiltagDetail;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Entity\BelysningTiltagDetail\PlaceringRepository;
use AppBundle\Entity\BelysningTiltagDetail\StyringRepository;
use AppBundle\Entity\BelysningTiltagDetail\TiltagRepository;

/**
 * Class BelysningTiltagDetailType
 * @package AppBundle\Form
 */
class BelysningTiltagDetailType extends TiltagDetailType
{

    public function __construct(Container $container, BelysningTiltagDetail $detail, $isBatchEdit = false)
    {
        parent::__construct($container, $detail, $isBatchEdit);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        parent::buildForm($builder, $options);
        $builder
            //->add('tilvalgt')
            ->add('lokale_navn')
            ->add('lokale_type')
            ->add('armaturhoejdeM')
            ->add('rumstoerrelseM2')
            ->add('lokale_antal')
            ->add('drifttidTAar')
            ->add('lyskilde')
            ->add('lyskildeStk')
            ->add('lyskildeWLyskilde')
            ->add('benyttelsesFaktor','choice', array(
                'choices' => LykilderBenyttelsesFaktor::getChoices(),
                'empty_value' => 'common.none',
                'required' => TRUE,
            ))
            ->add('lyskildeStkArmatur')
            ->add('armaturerStkLokale')
            ->add('placering')
            ->add('styring')
            ->add('nyStyring', 'entity', array(
                'class' => 'AppBundle:BelysningTiltagDetail\NyStyring',
                'choices' => $this->getAktuelNyStyring(),
                'required' => FALSE,
                'empty_value' => 'common.none',
            ))
            ->add('nytArmatur')
            ->add('noter')
            ->add('noterForNyBelysning')
            ->add('nyeSensorerStkLokale')
            ->add('standardinvestSensorKrStk')
            ->add('standardinvestArmaturKrStk')
            ->add('standardinvestLyskildeKrStk')
            ->add('belysningstiltag')
            ->add('nyLyskilde')
            ->add('nyLyskildeStk')
            ->add('nyLyskildeWLyskilde')
            ->add('nyBenyttelsesFaktor','choice', array(
                'choices' => LykilderBenyttelsesFaktor::getChoices(),
                'empty_value' => 'common.none',
                'required' => FALSE,
            ))
            ->add('nyLyskildeStkArmatur')
            ->add('nyeArmaturerStkLokale')
            ->add('nyDriftstid');

    }

    private function getAktuelNyStyring()
    {
        $em = $this->doctrine->getRepository('AppBundle:BelysningTiltagDetail\NyStyring');

        return $em->findActive();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BelysningTiltagDetail'
        ));
    }

    public function getName()
    {
        return 'appbundle_belysningtiltagdetail';
    }
}
