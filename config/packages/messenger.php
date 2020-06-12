<?php

if(! isset($container))    {
    ##
    trigger_error('Container Object is required here to rewire all necessary Doctrine configurations');
    die;
}

$container->loadFromExtension('framework', call_user_func(function () {
    ##
    $config['messenger'] = [
        'transports' => [],
            # https://symfony.com/doc/current/messenger.html#transport-configuration
            # async: '%env(MESSENGER_TRANSPORT_DSN)%'
            # failed: 'doctrine://default?queue_name=failed'
            # sync: 'sync://'

        'routing' => []
            # Route your messages to the transports
            # 'App\Message\YourMessage': async
    ] ;

    return $config;
}));
