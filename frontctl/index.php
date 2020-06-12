<?php

use Root\Kernel;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

#set_time_limit(0);
date_default_timezone_set('Africa/Lagos') ;

/**
 * The logic of application is like following
 * Index -> Project Autoload -> Global Autoload -> Load LIB modules -> Load Pluggable Modules -> Load Pluggable Bundles
 */

## load the internal autoloadeer
$in_app_autoloader = dirname(__DIR__).'/lib/autoload.php' ;
##

if(file_exists($in_app_autoloader))    {
    $loader = require $in_app_autoloader;
}
else{
    ## load the global vendeor
    require dirname(__DIR__).'/vendor/autoload.php';
}

/**
 * In Conclusion to the above, Load Bootstrap for Parameter mergeing
 * Boostrap -> Merge Config -> Initiate Request -> Initiate Kernel -> Handle Request -> Return Response -> Terminate
 *
 */
require dirname(__DIR__).'/config/bootstrap.php';

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? $_ENV['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? $_ENV['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts([$trustedHosts]);
}

/**
 * Initialize the Kernel and pass the ENV and DEBUG status
 */
$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
/**
 * Prepare the incoming request into an object
 */
$request = Request::createFromGlobals();
/**
 * assign the kernel to handle the request
 */
$response = $kernel->handle($request);
/**
 * returned response from the handled request and send response to request client
 */
$response->send();
/**
 * Kernel to terminate the request
 */
$kernel->terminate($request, $response);
