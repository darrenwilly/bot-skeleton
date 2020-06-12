<?php

if(! isset($container))    {
    ##
    trigger_error('Container Object is required here to rewire all necessary Doctrine configurations');
    die;
}

$container->loadFromExtension('sensio_framework_extra', call_user_func(function () {
    ##
    $config['router'] = [
        'annotations' => false
    ] ;

    return $config;
})) ;