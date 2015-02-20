<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TiltagType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('varmebsparelseGUF')
            ->add('varmebesparelseGAF')
            ->add('elbesparelse')
            ->add('vandbesparelse')
            ->add('energibesparelseAarEt')
            ->add('co2besparelseAarEt')
            ->add('antalReinvesteringer')
            ->add('faktor')
            ->add('primaerEnterprise')
            ->add('tilbudskategori')
            ->add('anlaegsInvestering')
            ->add('dVBesparelse')
            ->add('levetid')
            ->add('forsyningVarme')
            ->add('el')
            ->add('beskrivelseNevaerende')
            ->add('beskrivelseForslag')
            ->add('beskrivelseOevrige')
            ->add('risikovurdering')
            ->add('placering')
            ->add('beskrivelseBV')
            ->add('indeklima')
            ->add('rapport')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tiltag'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_tiltag';
    }
}
