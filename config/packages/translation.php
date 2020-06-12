<?php

if(! isset($container))    {
    ##
    trigger_error('Container Object is required here to rewire all necessary Doctrine configurations');
    die;
}

$container->loadFromExtension('framework', call_user_func(function () {
    ##
    $config['default_locale'] = 'en';

    $config['translator'] = [
        'default_path' => '%kernel.project_dir%/translations' ,
        'fallbacks' => 'en'
    ] ;

    return $config;
})) ;