<?php
/**
 * @file
 * VarmePumpeForbrugType form.
 */

namespace AppBundle\Form\Type\VarmeTiltagDetail;

use AppBundle\DBAL\Types\VarmeanlaegTiltag\VarmePumpeType;
use AppBundle\Entity\Configuration;
use AppBundle\Entity\VarmeanlaegTiltagDetail;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

/**
 * Class VarmePumpeForbrugType
 * @package AppBundle\Form
 */
class VarmePumpeForbrugType extends AbstractType {

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * VarmePumpeForbrugType constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $elementOptions) {
        foreach (VarmeanlaegTiltagDetail::getForbrugBeregningKontrolInputKeys() as $key) {
            if ($key == 'type') {
                /** @var Configuration $configuration */
                $configuration = $this->container->get('doctrine')->getRepository('AppBundle:Configuration')->getConfiguration();
                $varmePumpeFaktorAttr = array();
                foreach ($configuration->getVarmePumpeFaktor() as $varmePumpeFaktor) {
                    $varmePumpeFaktorAttr[] = array('data-faktor' => $varmePumpeFaktor);
                }
                $builder->add($key, 'choice',  array(
                    'choices' => VarmePumpeType::getChoices(),
                    'choice_attr' => $varmePumpeFaktorAttr,
                    'empty_value' => 'common.none',
                    'required' => TRUE,
                ));
                continue;
            }
            $builder->add($key, 'number',  array(
                'required' => FALSE,
            ));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getName() {
        return 'appbundle_varmepumpeforbrud';
    }
}
