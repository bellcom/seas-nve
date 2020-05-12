<?php

namespace AppBundle\Form;

use AppBundle\Entity\Bygning;
use AppBundle\Entity\BygningRepository;
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
        $bygningerByCvrNumber = array();
        $bygningerByEanNumber = array();
        $bygningerByPNumber = array();
        $em = $options['entityManager'];
        $bygningRepository = $em->getRepository('AppBundle:Bygning');
        if (!empty($em)) {
            /** @var BygningRepository $bygningRepository */
            $bygningRepository = $em->getRepository('AppBundle:Bygning');
            $virksomheder = $em->getRepository('AppBundle:Virksomhed')->getDatterSelskabReferenceList($options['data']);
            $bygningerByCvrNumber = $bygningRepository->getCvrNumberReferenceList($options['data']->getId());
            $bygningerByPNumber = $bygningRepository->getPNumberReferenceList($options['data']->getId());
            $bygningerByEanNumber = $bygningRepository->getEanNumberReferenceList($options['data']->getId());
        }
        $bygningerByCvrNumberChoicesAttr = array();
        /** @var Bygning $bygning */
        foreach ($bygningerByCvrNumber as $bygning_id => $bygning_value) {
            $bygningerByCvrNumberChoicesAttr[] = array('data-cvrnumber' => $bygningRepository->find($bygning_id)->getCvrNumber());
        }
        $builder
            ->add('name')
            ->add('cvrNumber')
            ->add('bygningerByCvrNumber','collection', array(
                'type' => 'choice',
                'options'      => array(
                    'placeholder' => 'appbundle.virksomhed.bygningerByCvrNumber.placeholder',
                    'choices' => $bygningerByCvrNumber,
//                    'choice_attr' => $bygningerByCvrNumberChoicesAttr,
                    'label' => FALSE,
                    'attr' => array(
                        'class' => 'bygningerByCvrNumber'
                    ),
                ),
                'allow_add' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'required' => FALSE,
            ))
            ->add('bygningerByEanNumber','collection', array(
                'type' => 'choice',
                'options'      => array(
                    'placeholder' => 'appbundle.virksomhed.bygningerByEanNumber.placeholder',
                    'choices' => $bygningerByEanNumber,
                    'label' => FALSE,
                ),
                'allow_add' => TRUE,
                'allow_delete' => TRUE,
                'by_reference' => FALSE,
                'required' => FALSE,
            ))
            ->add('bygningerByPNumber','collection', array(
                'type' => 'choice',
                'options'      => array(
                    'placeholder' => 'appbundle.virksomhed.bygningerByPNumber.placeholder',
                    'choices' => $bygningerByPNumber,
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
            ->add('dsmCode', 'choice', array(
              'choices' => array(
                'Handel og service' => 'Handel og service',
                'Husholdninger' => 'Husholdninger',
                'Offentlig sektor' => 'Offentlig sektor',
                'Produktionserhverv' => 'Produktionserhverv',
              ),
              'required' => TRUE,
            ))
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
