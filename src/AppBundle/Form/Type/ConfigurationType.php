<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\GraddageFordeling;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class ConfigurationType
 * @package AppBundle\Form
 */
class ConfigurationType extends AbstractType
{
    protected $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->authorizationChecker && $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $builder
                ->add('rapportKalkulationsrente', 'percent', array('scale' => 2));
        }

        $builder
            ->add('rapportDriftomkostningerfaktor')
            ->add('rapportInflation', 'percent', array('scale' => 2))
            ->add('rapportLobetid')
            ->add('rapportProcentAfInvestering', 'percent', array('scale' => 2))
            ->add('rapportNominelEnergiprisstigning')
            ->add('tekniskisoleringVarmeledningsevneEksistLamelmaatter')
            ->add('tekniskisoleringVarmeledningsevneNyIsolering')
            ->add('solcelletiltagdetailEnergiprisstigningPctPrAar', 'percent', array('scale' => 2))
            ->add('solcelletiltagdetailSalgsprisFoerste10AarKrKWh')
            ->add('solcelletiltagdetailSalgsprisEfter10AarKrKWh')
            ->add('mtmFaellesomkostningerGrundpris')
            ->add('mtmFaellesomkostningerPrisPrM2')
            ->add('mtmFaellesomkostningerNulHvisArealMindreEnd')
            ->add('mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd')
            ->add('tJordMonthly', 'collection', array(
                'type' => 'number',
                'options' => array(
                    'precision' => 1,
                ),
                'required' => FALSE,
            ))
            ->add('tUdeMonthly', 'collection', array(
                'type' => 'number',
                'options' => array(
                    'precision' => 1,
                ),
                'required' => FALSE,
            ))
            ->add('tOpvarmningTimerAarMonthly', 'collection', array(
                'type' => 'number',
                'required' => FALSE,
            ))
            ->add('grundventilationMatrix', GrundventilationMatrixType::class)
            ->add('udeluftTilfoerselMatrix', UdeluftTilfoerselMatrixType::class)
            ->add('varmeEnergiFaktor', 'collection', array(
                'type' => 'number',
                'required' => FALSE,
            ))
            ->add('varmePumpeFaktor', 'collection', array(
                'type' => 'number',
                'required' => FALSE,
            ))
        ;
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Configuration'
        ));
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'appbundle_configuration';
    }
}
