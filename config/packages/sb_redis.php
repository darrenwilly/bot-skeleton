<?php


$container->loadFromExtension('sb_redis', call_user_func(function () {
    ##
    $config['clients'] = [
        'default' => [
            '$options' => [] ,
            '$parameters' => ['%env(REDIS_URL)%']
        ]
    ];


    return $config;
})) ;
