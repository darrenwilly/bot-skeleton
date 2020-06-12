<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator ;


return function(ContainerConfigurator $configurator)   {
    // default configuration for services in *this* file
    $services = $configurator->services()
        ->defaults()
        ->autowire()      // Automatically injects dependencies in your services.
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
        ->public();

    $configurator->parameters()->set('project.name' , PROJECT_NAME) ;

    /**
     * Load the autoload directory which might have any extra config
     */
    $dirLoader = new \GlobIterator(__DIR__.'/autoload/*.php') ;
    ##
    if(0 < $dirLoader->count())    {
        foreach ($dirLoader as $item_in_files)   {
            ##
            $fileReturns = require $item_in_files ;
            ##
            if(is_array($fileReturns))    {
                ##
                foreach ($fileReturns as $returnKey => $returns)    {
                    ##
                    $configurator->parameters()->set($returnKey , $returns) ;
                }
            }
        }
    }

    /**
     *
     */
    $configurator->parameters()->set('locale', 'en');
    $configurator->parameters()->set('PUBLIC_DIR', 'frontctl');

    /**
     *
     */
    return $services;
};