<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Twig\Extension;

use Symfony\Bridge\Twig\Extension\RoutingExtension;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\TwigFunction;

/**
 * Extended Routing component with Twig with user Token access.
 */
class RoutingTokenAccessExtension extends RoutingExtension
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(UrlGeneratorInterface $generator, RequestStack $requestStack)
    {
        parent::__construct($generator);
        $this->requestStack = $requestStack;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('url_with_access_token', array($this, 'getUrlWithAccessToken'), array('is_safe_callback' => array($this, 'isUrlGenerationSafe'))),
            new TwigFunction('path_with_access_token', array($this, 'getPathWithAccessToken'), array('is_safe_callback' => array($this, 'isUrlGenerationSafe'))),
        );
    }

    /**
     * @param string $name
     * @param array  $parameters
     * @param bool   $relative
     *
     * @return string
     */
    public function getUrlWithAccessToken($name, $parameters = array(), $relative = false)
    {
        if (empty($parameters['token'])) {
            $this->fetchToken($parameters);
        }
        return $this->getUrl($name, $parameters, $relative);
    }

    /**
     * @param string $name
     * @param array  $parameters
     * @param bool   $schemeRelative
     *
     * @return string
     */
    public function getPathWithAccessToken($name, $parameters = array(), $schemeRelative = false)
    {
        if (empty($parameters['token'])) {
            $this->fetchToken($parameters);
        }
        return $this->getPath($name, $parameters, $schemeRelative);
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'routing_token_access_extension';
    }

    /**
     * Tries to setup token parameter from environment context.
     */
    public function fetchToken(&$parameters) {
        $request = $this->requestStack->getCurrentRequest();
        if (!empty($request->query->get('token'))) {
            $parameters['token'] = $request->query->get('token');
            return;
        }
    }
}
