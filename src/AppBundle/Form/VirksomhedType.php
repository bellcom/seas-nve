<?php

namespace AppBundle\Form;

use AppBundle\Entity\Bygning;
use AppBundle\Entity\Virksomhed;
use AppBundle\Entity\VirksomhedRepository;
use AppBundle\Form\Type\ContactPersonEmbedType;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
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
            $virksomheder = $em->getRepository('AppBundle:Virksomhed')->getDatterSelskabReferenceList($options['data']);
            $eanNumbers = $em->getRepository('AppBundle:Bygning')->getEanNumberReferenceList();
            $pNumbers = $em->getRepository('AppBundle:Bygning')->getPNumberReferenceList();
        }
        $builder
            ->add('name')
            ->add('cvrNumber')
            ->add('eanNumbers','collection', array(
                'type' => 'choice',
                'options'      => array(
                    'placeholder' => 'appbundle.virksomhed.eanNumbers.placeholder',
                    'choices' => $eanNumbers,
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
                        return $virksomhed->getCvrReferenceLabel();
                    },
                    'choice_value' => function (Virksomhed $entity = null) {
                      return $entity ? $entity->getId() : '';
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
            ->add('subsidySize')
            ->add('aarsVaerk')
            ->add('forbrug')
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
            ->add('forsyningsvaerkVarme', 'entity', array(
                'class' => 'AppBundle:Forsyningsvaerk',
                'required' => FALSE,
                'empty_value' => 'common.none',
            ))
            ->add('forsyningsvaerkEl', 'entity', array(
                'class' => 'AppBundle:Forsyningsvaerk',
                'required' => FALSE,
                'empty_value' => 'common.none',
            ))
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
