<?php

$container->loadFromExtension('framework', call_user_func(function ()   {
    ##
    $frameworkConfig = [
        'secret' => '%env(APP_SECRET)%',
        'default_locale' => 'en',
        'csrf_protection' => true,
        //'http_method_override' => true,

        'trusted_hosts' => '%env(TRUSTED_HOSTS)%',

        //'esi' => true,
        //'fragments' => true,
        'php_errors' => [
            'log' => true,
        ],

    ] ;

    /**
     * Enables session support. Note that the session will ONLY be started if you read or write from it.
     * Remove or comment this section to explicitly disable session support.
     */
    $frameworkConfig['session'] = [
        'enabled' => true ,
        'cookie_secure' => 'auto',
        'cookie_samesite' => 'lax',
        'handler_id' => 'session.handler.native_file',
        'save_path' => '%kernel.project_dir%/var/sessions/%kernel.environment%',
    ];

    /**
     * section for cache
     */
    $frameworkConfig['cache'] = [
            ##
            'app' => 'cache.adapter.filesystem' ,
                    'system' => 'cache.adapter.system' ,
                    'directory' => '%kernel.cache_dir%/pools' ,
                    'prefix_seed' => PROJECT_NAME ,
                    ##
                    'default_redis_provider' => '%env(REDIS_DSN)%',

                    /**
                     * cache stacks
                     */
                    'pools' => [
                'cache.default' => [
                    'adapter' => 'cache.adapter.filesystem',
                    'default_lifetime' => 3600,
                    'public' => true,
                    #'provider' => 'service_name'
                ],

                'cache.redis.default' => [
                    'adapter' => 'cache.adapter.redis',
                    'default_lifetime' => 3600,
                    'public' => true
                ],
            ]
    ];

    /**
     * section for router
     */
    $frameworkConfig['router'] = [
            #'resource' => '%kernel.project_dir%/config/routing.yml' ,
            #'type' => '.php' ,
            #'http_port' => 8000,
            'strict_requirements' => true ,
            'utf8' => true
    ] ;

    /**
     * section for validator

    $frameworkConfig['validation'] = [
            'email_validation_mode' => 'strict' ,
            'mapping' => ['paths' => [
                dirname(dirname(__DIR__)) . '/src/core-source/src/Validator',
                dirname(dirname(__DIR__)) . '/src/shared-utilities/src/Validator'
            ]]
    ] ;
    */

    /**
     * section for validator

    $frameworkConfig['templating'] = [
        'engines' => ['twig' , 'php'] ,
    ] ;*/

    ##
    return $frameworkConfig ;
}));