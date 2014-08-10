<?php

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;

App::uses('SymfonyRouter', 'SymfonyRouter.Lib');

class SymfonyRouterHelper extends AppHelper
{
    /**
     * @var UrlGeneratorInterface
     */
    private $generator;

    public function __construct()
    {
        $this->generator = $this->createUrlGenerator();
    }

    public function path($routeName, $parameters = array())
    {
        $route = SymfonyRouter::getInstance()->getRoute($routeName);
//        $defaults = $route->getDefaults();

        $keys = array_keys($parameters);
        foreach ($keys as &$row) {
            $row = '{' . $row . '}';
        }

        return str_replace($keys, $parameters, $route->getPath());
    }

    public function getPath($name, $parameters = array(), $relative = false)
    {
        return $this->generator->generate($name, $parameters, $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    public function getUrl($name, $parameters = array(), $schemeRelative = false)
    {
        return $this->generator->generate($name, $parameters, $schemeRelative ? UrlGeneratorInterface::NETWORK_PATH : UrlGeneratorInterface::ABSOLUTE_URL);
    }

    protected function createUrlGenerator()
    {
        $context = new RequestContext();

        return new UrlGenerator(SymfonyRouter::getInstance()->getRouteCollection(), $context);
    }
}