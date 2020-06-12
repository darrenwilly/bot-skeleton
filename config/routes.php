<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\RouteCollection;

$routesCallback =  function (RoutingConfigurator $routes)  {

    // loads routes from the PHP annotations of the controllers found in that directory
    #$routes->import(APPLICATION_PATH.'/root-source/src/Controller/', 'annotation');
    /**
     * This is reference the router that was register using the Event Manager for Service Manager to use it
     */
    $routes->import('.', 'advanced_extra');

    // loads routes from the YAML or XML files found in that directory
    #$routes->import('../legacy/routing/', 'directory');

    // loads routes from the YAML or XML files found in some bundle directory
    #$routes->import('@AcmeOtherBundle/Resources/config/routing/', 'directory');

    return $routes ;
};

return $routesCallback ;