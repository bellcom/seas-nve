<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\DBAL\Types\KlimaskaermType;

use AppBundle\Entity\GraddageFordeling;
use AppBundle\Entity\NyKlimaskaermTiltagDetail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
        $builder
            ->add('titel')
            ->add('beskrivelse', 'textarea', array('attr' => array('maxlength' => 10000), 'required' => FALSE))
            ->add('hoejdeElLaengdeM')
            ->add('breddeM')
            ->add('antalStk')
            ->add('uEksWM2K')
            ->add('uNyWM2K')
            ->add('tIndeC')
            ->add('tUdeC')
            ->add('graddageFordeling', 'entity', array(
                'class' => GraddageFordeling::class,
                'empty_value' => '--',
                'required' => FALSE,
            ))
            ->add('tOpvarmningTimerAar', 'number', array(
                'precision' => 1,
                'attr' => $tOpwaarmingAttr
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
