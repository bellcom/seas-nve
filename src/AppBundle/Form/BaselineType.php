<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BaselineType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('arealdataPrimaerKilde')
            ->add('arealdataPrimaerAreal')
            ->add('arealdataPrimaerNoter')
            ->add('arealdataSekundaerKilde')
            ->add('arealdataSekundaerAreal')
            ->add('arealdataSekundaerNoter')
            ->add('arealTilNoegletalsanalyse')
            ->add('elForbrugsdataPrimaerKilde')
            ->add('elForbrugsdataPrimaer1Aarstal')
            ->add('elForbrugsdataPrimaer1Forbrug')
            ->add('elForbrugsdataPrimaer2Aarstal')
            ->add('elForbrugsdataPrimaer2Forbrug')
            ->add('elForbrugsdataPrimaer3Aarstal')
            ->add('elForbrugsdataPrimaer3Forbrug')
            ->add('elForbrugsdataPrimaerGennemsnit')
            ->add('elForbrugsdataPrimaerNoegetal')
            ->add('elForbrugsdataPrimaerNoter')
            ->add('elForbrugsdataSekundaerKilde')
            ->add('elForbrugsdataSekundaer1Aarstal')
            ->add('elForbrugsdataSekundaer1Forbrug')
            ->add('elForbrugsdataSekundaer2Aarstal')
            ->add('elForbrugsdataSekundaer2Forbrug')
            ->add('elForbrugsdataSekundaer3Aarstal')
            ->add('elForbrugsdataSekundaer3Forbrug')
            ->add('elForbrugsdataSekundaerGennemsnit')
            ->add('elForbrugsdataSekundaerNoegetal')
            ->add('elForbrugsdataSekundaerNoter')
            ->add('elBaselineFastsatForEjendom')
            ->add('elBaselineNoegletalForEjendom')
            ->add('elBaselineNoter')
            ->add('varmeForbrugsdataPrimaerKilde')
            ->add('varmeForbrugsdataPrimaer1Aarstal')
            ->add('varmeForbrugsdataPrimaer1Forbrug')
            ->add('varmeForbrugsdataPrimaer2Aarstal')
            ->add('varmeForbrugsdataPrimaer2Forbrug')
            ->add('varmeForbrugsdataPrimaer3Aarstal')
            ->add('varmeForbrugsdataPrimaer3Forbrug')
            ->add('varmeForbrudsdataPrimaerGUFForbrugFastsaettesEfter')
            ->add('varmeForbrugsdataPrimaer1SamletVarmeforbrugJuniJuliAugust')
            ->add('varmeForbrugsdataPrimaer2SamletVarmeforbrugJuniJuliAugust')
            ->add('varmeForbrugsdataPrimaer3SamletVarmeforbrugJuniJuliAugust')
            ->add('varmeForbrugsdataPrimaer1GUFRegAar')
            ->add('varmeForbrugsdataPrimaer2GUFRegAar')
            ->add('varmeForbrugsdataPrimaer3GUFRegAar')
            ->add('varmeForbrugsdataPrimaer1GAFRegAar')
            ->add('varmeForbrugsdataPrimaer2GAFRegAar')
            ->add('varmeForbrugsdataPrimaer3GAFRegAar')
            ->add('varmeForbrugsdataPrimaer1GDPeriode')
            ->add('varmeForbrugsdataPrimaer2GDPeriode')
            ->add('varmeForbrugsdataPrimaer3GDPeriode')
            ->add('varmeForbrugsdataPrimaer1GAFnormal')
            ->add('varmeForbrugsdataPrimaer2GAFnormal')
            ->add('varmeForbrugsdataPrimaer3GAFnormal')
            ->add('varmeForbrugsdataPrimaer1ForbrugKlimakorrigeret')
            ->add('varmeForbrugsdataPrimaer2ForbrugKlimakorrigeret')
            ->add('varmeForbrugsdataPrimaer3ForbrugKlimakorrigeret')
            ->add('varmeForbrugsdataPrimaerGAFGennemsnit')
            ->add('varmeForbrugsdataPrimaerGUFGennemsnit')
            ->add('varmeForbrugsdataPrimaerGennemsnitKlimakorrigeret')
            ->add('varmeForbrugsdataPrimaerNoegletal')
            ->add('varmeForbrugsdataPrimaerNoter')
            ->add('varmeForbrugsdataSekundaerKilde')
            ->add('varmeForbrugsdataSekundaer1Aarstal')
            ->add('varmeForbrugsdataSekundaer1Forbrug')
            ->add('varmeForbrugsdataSekundaer2Aarstal')
            ->add('varmeForbrugsdataSekundaer2Forbrug')
            ->add('varmeForbrugsdataSekundaer3Aarstal')
            ->add('varmeForbrugsdataSekundaer3Forbrug')
            ->add('varmeForbrudsdataSekundaerGUFForbrugFastsaettesEfter')
            ->add('varmeForbrugsdataSekundaer1SamletVarmeforbrugJuniJuliAugust')
            ->add('varmeForbrugsdataSekundaer2SamletVarmeforbrugJuniJuliAugust')
            ->add('varmeForbrugsdataSekundaer3SamletVarmeforbrugJuniJuliAugust')
            ->add('varmeForbrugsdataSekundaer1GUFRegAar')
            ->add('varmeForbrugsdataSekundaer2GUFRegAar')
            ->add('varmeForbrugsdataSekundaer3GUFRegAar')
            ->add('varmeForbrugsdataSekundaer1GAFRegAar')
            ->add('varmeForbrugsdataSekundaer2GAFRegAar')
            ->add('varmeForbrugsdataSekundaer3GAFRegAar')
            ->add('varmeForbrugsdataSekundaer1GDPeriode')
            ->add('varmeForbrugsdataSekundaer2GDPeriode')
            ->add('varmeForbrugsdataSekundaer3GDPeriode')
            ->add('varmeForbrugsdataSekundaer1GAFnormal')
            ->add('varmeForbrugsdataSekundaer2GAFnormal')
            ->add('varmeForbrugsdataSekundaer3GAFnormal')
            ->add('varmeForbrugsdataSekundaer1ForbrugKlimakorrigeret')
            ->add('varmeForbrugsdataSekundaer2ForbrugKlimakorrigeret')
            ->add('varmeForbrugsdataSekundaer3ForbrugKlimakorrigeret')
            ->add('varmeForbrugsdataSekundaerGAFGennemsnit')
            ->add('varmeForbrugsdataSekundaerGUFGennemsnit')
            ->add('varmeForbrugsdataSekundaerGennemsnitKlimakorrigeret')
            ->add('varmeForbrugsdataSekundaerNoegletal')
            ->add('varmeForbrugsdataSekundaerNoter')
            ->add('varmeGAFForbrug')
            ->add('varmeGUFForbrug')
            ->add('varmeBaselineFastsatForEjendom')
            ->add('varmeBaselineNoegletalForEjendom')
            ->add('varmeStrafafkoelingsafgift')
            ->add('varmeBaselineNoter')
            ->add('createdBy')
            ->add('updatedBy')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('bygning')
            ->add('eloKategori')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Baseline'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_baseline';
    }
}
