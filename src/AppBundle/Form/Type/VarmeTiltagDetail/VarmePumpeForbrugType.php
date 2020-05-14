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
            if ($key == 'brugsvandsandel') {
                $builder->add($key, 'percent');
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
