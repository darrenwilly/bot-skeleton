<?php

if(! isset($container))    {
    ##
    trigger_error('Container Object is required here to rewire all necessary Doctrine configurations');
    die;
}

$container->loadFromExtension('framework', call_user_func(function () {
    ##
    $config['cache'] = [
        'prefix_seed' => 'darviews/efiletrack' ,
        #'app'=> 'cache.adapter.redis' ,
        # app cache from client config as default adapter/provider
        #'default_redis_provider' => 'snc_redis.default'
    ];

   /* $config['pools'] = [
        'default-pool.cache' => [
            'adapter' => 'cache.adapter.redis' ,
            # a specific provider, e.g. if you have a snc_redis.clients.cache
            'provider' => 'snc_redis.cache'
        ]
    ] ;*/

    return $config;
}));