<?php

if (!defined('ROOT')) {
    define('ROOT', dirname(__FILE__));
}

include_once(ROOT . '/vendor/autoload.php');

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

App::uses('RouterYmlConfiguration', 'SymfonyRouter.Lib');

class SymfonyRouter
{

    /**
     * @var array
     */
    protected $routerConfiguration;

    /**
     * @var RouteCollection;
     */
    protected $routes;

    /**
     * @var SymfonyRouter
     */
    protected static $instance;

    public function __construct($fileName)
    {
        $routerYmlConfiguration = new RouterYmlConfiguration();
        $this->routerConfiguration = $routerYmlConfiguration->loadConfiguration($fileName);
        $this->registerRoutes();
        self::$instance = $this;
    }

    public static function getInstance() {
        if(null === self::$instance) {
            throw new Exception('First, you need to declate this class once.');
        }
        return self::$instance;
    }

    public function registerRoutes()
    {
        $routes = new RouteCollection();

        foreach ($this->routerConfiguration as $routeName => $singleRoute) {
            $routes->add($routeName, new Route($singleRoute['path'], $singleRoute['defaults']));

            $singleRouteCakePath = preg_replace("/(\{)(\w+)(\})/", ":$2", $singleRoute['path']);
            Router::connect($singleRouteCakePath,  $singleRoute['defaults']);
        }

        $this->routes = $routes;
    }

    /**
     * @param $routeName
     *
     * @return Route
     */
    public function getRoute($routeName)
    {
        $route = $this->routes->get($routeName);

        if (null == $route) {
            throw new Exception(sprintf("The %s does not exist", $routeName));
        }

        return $route;
    }

    /**
     * @return RouteCollection
     */
    public function getRouteCollection()
    {
        return $this->routes;
    }

    /**
     * @return array|bool
     */
    public function matchCurrentRoute()
    {
        $context = new RequestContext();
        $matcher = new UrlMatcher($this->routes, $context);
        $request = new CakeRequest();

        try {
            return $matcher->match($request->here());
        } catch (Exception $e) {
            //route is not registered in yml file
            return false;
        }
    }

}