<?php

if(! isset($container))    {
    ##
    trigger_error('Container Object is required here to rewire all necessary Doctrine configurations');
    die;
}
return;
$container->loadFromExtension('security', call_user_func(function () {

    $securityConfig = [
        ##
        'providers' => [ #'in_memory' => true
            'users' => [
                'entity' => [
                    // the class of the entity that represents users
                    #'class'    => \Veiw\Domain\Entity\TblWwwadminUser::class,
                    // the property to query by - e.g. username, email, etc
                    'property' => 'username',
                    // optional: if you're using multiple Doctrine entity
                    // managers, this option defines which one to use
                    // 'manager_name' => 'customer',
                ],
            ],
        ],

       /* 'encoders' => [
            \Veiw\Domain\Entity\TblWwwadminUser::class => [
                'algorithm' => 'bcrypt',
                'cost' => 12,
            ] ,
        ],*/

        'firewalls' => [
            'dev' => [
                'pattern' => '^/(_(profiler|wdt)|css|images|js)/' ,
                'security' => false
            ] ,

            'main' => [
                'pattern' => '^/' ,
                'user_checker' => 'login.auth.listener' ,
                'anonymous' => true ,
                'provider'   => 'users',
                'logout'  =>    [
                    'path' => 'logout' ,
                    # The name of the route to redirect to after logging out
                    'target' => 'login' ,
                    'handlers' => ['logout.auth.listener']
                ] ,
                'form_login' => [
                    # The route name that the login form submits to
                    'check_path' => 'login' ,
                    # The name of the route where the login form lives
                    # When the user tries to access a protected page, they are redirected here
                    'login_path' => 'login' ,
                    # Secure the login form against CSRF
                    # Reference: https://symfony.com/doc/current/security/csrf.html#csrf-protection-in-login-forms
                    #'csrf_token_generator' => 'security.csrf.token_manager' ,
                    #'csrf_parameter' => '_csrf_security_token',
                    #'csrf_token_id'     => 'login' ,
                    # The page users are redirect to when there is no previous page stored in the
                    # session (for example when the users access directly to the login page).
                    'default_target_path' =>  'login'
                ],
                'guard' => [
                    ## when multiple authentication feature are required e.g Form & API, then you need to provide an entry point for authentication
                    'entry_point' => \Shared\Core\Security\LoginFormAuthenticator::class ,
                    'authenticators' => [
                        \Shared\Core\Security\LoginFormAuthenticator::class ,
                        \Shared\Core\Security\ApiTokenAuthenticator::class
                    ]
                ] ,
                'remember_me' => [
                    'secret' => '%kernel.secret%' ,
                    'lifetime' => 2592000 # 30 days in seconds
                ]
            ],

        ],

    ];


    $securityConfig['access_control'] = [
        ['path' => '^/' , 'roles' => ['IS_AUTHENTICATED_ANONYMOUSLY']],
    ] ;

    ##
    return $securityConfig ;

}));