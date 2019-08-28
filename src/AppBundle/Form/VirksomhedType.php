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
                $eanNumbers[$bygning->getEanNumber() . ' (' . $bygning . ')'] = $bygning->getEanNumber();
            }
            foreach ($em->getRepository('AppBundle:Bygning')->getAllUniqueValues('pNumber') as $bygning) {
                $pNumbers[$bygning->getPNumber() . ' (' . $bygning . ')'] = $bygning->getPNumber();
            }
        }
        $builder
            ->add('name')
            ->add('cvrNumber')
            ->add('eanNumbers','collection', array(
                'type' => 'choice',
                'options'      => array(
                    'placeholder' => 'appbundle.virksomhed.eanNumbers.placeholder',
                    'choices' => $eanNumbers,
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
                    'placeholder' => 'appbundle.virksomhed.pNumbers.placeholder',
                    'choices' => $pNumbers,
                    'choices_as_values' => TRUE,
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
                    'placeholder' => 'appbundle.virksomhed.datterSelskaber.placeholder',
                    'choices' => $virksomheder,
                    'choice_label' => function($virksomhed, $key, $index) {
                        /** @var Virksomhed $virksomhed */
                        return $virksomhed->getCvrNumber() . ' (' . $virksomhed . ')';
                    },
                    'choices_as_values' => TRUE,
                    'label' => FALSE
                ),
                'allow_add' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'required' => FALSE,
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
                'required' => TRUE,
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
            ->add('kalkulationsrente', 'percent', array(
                'scale' => 2,
                'required' => FALSE,
            ))
            ->add('inflation', 'percent', array(
                'scale' => 2,
                'required' => FALSE,
            ))
            ->add('lobetid')
        ;

        // Allow select customer user only for existing companies.
        if (!empty($options['data']->getId())) {
            $builder->add('user', 'entity', array(
                'class' => 'AppBundle:User',
                'required' => FALSE,
                'empty_value' => 'common.none',
            ));
        }
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
