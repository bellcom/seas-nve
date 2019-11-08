<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\DBAL\Types\KlimaskaermType;

use AppBundle\Entity\Configuration;
use AppBundle\Entity\GraddageFordeling;
use AppBundle\Entity\NyKlimaskaermTiltagDetail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class NyKlimaskaermTiltagDetailType
 * @package AppBundle\Form
 */
class NyKlimaskaermTiltagDetailType extends TiltagDetailType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $nyKlimaskaermTiltagDetail = $options['data'];
        $tOpwaarmingAttr = array();
        if ($nyKlimaskaermTiltagDetail instanceof NyKlimaskaermTiltagDetail && !empty($nyKlimaskaermTiltagDetail->getGraddageFordeling())) {
            $tOpwaarmingAttr['disabled'] = 'disabled';
            $tOpwaarmingAttr['help_text'] = 'Beregnet fra graddøgn.';
        }
        /** @var Configuration $configuration */
        $configuration = $this->container->get('doctrine')->getRepository('AppBundle:Configuration')->getConfiguration();
        /** @var TranslatorInterface $translator */
        $translator = $this->container->get('translator');
        $builder
            ->add('titel')
            ->add('beskrivelse', 'textarea', array('attr' => array('maxlength' => 10000), 'required' => FALSE))
            ->add('hoejdeElLaengdeM')
            ->add('breddeM')
            ->add('fradragM')
            ->add('antalStk')
            ->add('uEksWM2K')
            ->add('uNyWM2K')
            ->add('tIndeC')
            ->add('tIndeDetailed', 'checkbox', array(
                'label' => $translator->trans('appbundle.nyklimaskaermtiltagdetail.tIndeDetailed'),
                'required' => FALSE,
            ))
            ->add('tIndeMonthly','collection', array(
                'type' => 'number',
                'options' => array(
                    'precision' => 1,
                    'attr' => array(
                        'class' => 'tindemonthly'
                    ),
                ),
                'label' => FALSE,
                'required' => FALSE,
            ))
            ->add('tUdeC')
            ->add('tUdeDetailed', 'checkbox', array(
                'label' => $translator->trans('appbundle.nyklimaskaermtiltagdetail.tUdeDetailed'),
                'required' => FALSE,
            ))
            ->add('tUdeMonthly','collection', array(
                'type' => 'number',
                'options' => array(
                    'precision' => 1,
                    'attr' => array(
                        'class' => 'tudemonthly'
                    ),
                ),
                'label' => FALSE,
                'required' => FALSE,
                'attr' => array(
                    'data-tjord' => json_encode($configuration->getTJordMonthly()),
                    'data-tudemonthly' => json_encode($configuration->getTUdeMonthly())
                ),
            ))
            ->add('graddageFordeling', 'entity', array(
                'class' => GraddageFordeling::class,
                'empty_value' => 'Indtaste timer',
                'required' => FALSE,
            ))
            ->add('tOpvarmningTimerAarMonthly','collection', array(
                'type' => 'number',
                'label' => FALSE,
                'required' => FALSE,
                'attr' => array('data-topvarmningtimeraarMonthly' => json_encode($configuration->getTOpvarmningTimerAarMonthly())),
            ))
            ->add('samletInvesteringKr')
            ->add('levetidAar');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\NyKlimaskaermTiltagDetail',
    ));
    }

    public function getName()
    {
        return 'appbundle_nyklimaskaermtiltagdetail';
    }

    private function getKlimaskaerme()
    {
        $repository = $this->container->get('doctrine')->getRepository('AppBundle:Klimaskaerm');

        $result = $repository->findByType($this instanceof VindueTiltagDetailType ? KlimaskaermType::VINDUE : KlimaskaermType::KLIMASKAERM);

        return $result;
    }
}
