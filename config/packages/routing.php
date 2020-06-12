<?php

if(! isset($container))    {
    ##
    trigger_error('Container Object is required here to rewire all necessary Doctrine configurations');
    die;
}

$container->loadFromExtension('framework', call_user_func(function () {
    ##
    $config['router'] = [
        'utf8' => true
    ] ;

    return $config;
})) ;
