<?php

namespace AppBundle\Form;

use AppBundle\Entity\Bygning;
use AppBundle\Entity\Virksomhed;
use AppBundle\Form\Type\ContactPersonEmbedType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VirksomhedType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $virksomheder = array();
        $eanNumbers = array();
        $pNumbers = array();
        $em = $options['entityManager'];
        if (!empty($em)) {
            $virksomheder = $em->getRepository('AppBundle:Virksomhed')->findAll();
            if ($options['data'] instanceof Virksomhed) {
                foreach ($virksomheder as $key => $virksomhed) {
                    if ($virksomhed->getId() == $options['data']->getId()) {
                        unset($virksomheder[$key]);
                    }
                }
            }
            foreach ($em->getRepository('AppBundle:Bygning')->getAllUniqueValues('eanNumber') as $bygning) {
                $eanNumbers[] = $bygning['eanNumber'];
            }
            foreach ($em->getRepository('AppBundle:Bygning')->getAllUniqueValues('pNumber') as $bygning) {
                $pNumbers[] = $bygning['pNumber'];
            }
        }
        $builder
            ->add('name')
            ->add('cvrNumber')
            ->add('eanNumbers','collection', array(
                'type' => 'choice',
                'options'      => array(
                    'placeholder' => 'None',
                    'choices' => $eanNumbers,
                    'choice_label' => function($value, $key, $index) {
                        return $value;
                    },
                    'choices_as_values' => TRUE,
                    'label' => FALSE,
                ),
                'allow_add' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'required' => FALSE,
            ))
            ->add('pNumbers','collection', array(
                'type' => 'choice',
                'options'      => array(
                    'placeholder' => 'None',
                    'choices' => $pNumbers,
                    'choices_as_values' => TRUE,
                    'choice_label' => function($value, $key, $index) {
                        return $value;
                    },
                    'label' => FALSE,
                ),
                'allow_add' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'required' => FALSE,
            ))
            ->add('crmNumber')
            ->add('projectNumber')
            ->add('customerNumber')
            ->add('aftagerNumber')
            ->add('typeName')
            ->add('datterSelskaber','collection', array(
                'type' => 'choice',
                'options'      => array(
                    'placeholder' => 'None',
                    'choices' => $virksomheder,
                    'choice_label' => function($virksomhed, $key, $index) {
                        /** @var Virksomhed $virksomhed */
                        return $virksomhed->getCvrNumber();
                    },
                    'choices_as_values' => TRUE,
                    'label' => FALSE
                ),
                'allow_add' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
            ))
            ->add('kommune')
            ->add('region')
            ->add('byNavn')
            ->add('address')
            ->add('postnummer')
            ->add('contactPersons', 'collection', array(
                'type' => new ContactPersonEmbedType(),
                'options'      => array('label' => FALSE),
                'allow_add' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
            ))
            ->add('naceCode')
            ->add('dsmCode')
            ->add('energyPrice')
            ->add('subsidySize')

            ->add('erhvervsAreal')
            ->add('opvarmetAreal')
            ->add('aarsVaerk')
            ->add('forbrug')
            ->add('er')
            ->add('kam')

            ->add('kalkulationsrente')
            ->add('inflation')
            ->add('lobetid')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Virksomhed',
            'entityManager' => null,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_virksomhed';
    }

}
