<?php

if(! isset($container))    {
    ##
    trigger_error('Container Object is required here to rewire all necessary Doctrine configurations');
    die;
}

$container->loadFromExtension('snc_redis', call_user_func(function () {
    ##
    $config['client'] = [
        'type' => 'phpredis',
        'alias' => 'default',
        'dsn' => '%env(REDIS_DSN)%',
        'logging' => '%kernel.debug%'
    ];

    $config['session'] = [
        'client' => 'default' ,
        'prefix' => 'efiletrack',
        'ttl' => (60*60*24)
    ] ;

    /*$config['doctrine'] = [
        'metadata_cache' => [
            'client' => 'default' ,
            'entity_manager' => [ 'default', 'orm_read' , 'orm_write' ],         # the name of your entity_manager connection
            'document_manager' => 'default'        # the name of your document_manager connection
        ] ,

        'result_cache' => [
            'client' => 'default' ,
            'entity_manager' => [ 'default', 'orm_read' , 'orm_write' ]
        ] ,

        'query_cache' => [
            'client' => 'default' ,
            'entity_manager' => [ 'default', 'orm_read' , 'orm_write' ]
        ] ,

        'second_level_cache' => [
            'client' => 'default' ,
            'entity_manager' => [ 'default', 'orm_read' , 'orm_write' ]
        ]
    ] ;*/

    return $config;
})) ;
