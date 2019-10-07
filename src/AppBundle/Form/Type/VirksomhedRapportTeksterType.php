<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\VirksomhedRapport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class VirksomhedRapportTeksterType
 * @package AppBundle\Form
 */
class VirksomhedRapportTeksterType extends AbstractType
{
    protected $authorizationChecker;
    protected $rapport;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, VirksomhedRapport $rapport)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->rapport = $rapport;
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kortlaegningKonklusionTekst', 'ckeditor', array('attr' => array('maxlength' => 10000), 'required' => FALSE))
            ->add('kortlaegningVirksomhedBeskrivelse', 'ckeditor', array('attr' => array('maxlength' => 10000), 'required' => FALSE));
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\VirksomhedRapport'
        ));
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'appbundle_virksomhed_rapport';
    }
}
