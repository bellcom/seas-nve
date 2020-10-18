<?php
namespace AppBundle\PdfExport;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * PdfExportTrait class.
 *
 * Contain shared functionality for PDF exporters.
 */
trait PdfExportTrait {

    private $container;
    private $templating;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->templating = $this->container->get('templating');
        $this->router = $this->container->get('router');
    }

    private function renderView($view, array $parameters = array()) {
        return $this->templating->render($view, $parameters);
    }

    /**
     * Sorts tiltags array collection.
     *
     * @param ArrayCollection $tiltags
     *
     * @return ArrayCollection
     */
    protected function sortTiltags($tiltags) {
        $iterator = $tiltags->getIterator();
        $iterator->uasort(function ($a, $b) {
            return ($a->getSimpelTilbagebetalingstidAar() < $b->getSimpelTilbagebetalingstidAar()) ? -1 : 1;
        });

        return new ArrayCollection(iterator_to_array($iterator));
    }

}
