<?php

if(! isset($container))    {
    ##
    trigger_error('Container Object is required here to rewire all necessary Doctrine configurations');
    die;
}

$container->loadFromExtension('swiftmailer', call_user_func(function () {
    ##
    $config['url'] = '%env(MAILER_URL)%' ;
    $config['spool'] = [
        'type' => 'memory'
    ] ;

    return $config;
})) ;