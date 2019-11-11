<?php

namespace AppBundle\Form\BelysningTiltagDetail;

use AppBundle\DBAL\Types\BelysningTiltagDetail\LykilderUdgiftForkobling;
use AppBundle\DBAL\Types\BelysningTiltagDetail\LykilderUdgiftType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LyskildeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('navn')
          ->add('type', 'choice', array(
              'choices' => LykilderUdgiftType::getChoices(),
          ))
          ->add('forkobling', 'choice', array(
              'choices' => LykilderUdgiftForkobling::getChoices(),
          ))
          ->add('udgift')
          ->add('levetid');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BelysningTiltagDetail\Lyskilde'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_belysningtiltagdetail_lyskilde';
    }
}
