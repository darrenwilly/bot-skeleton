<?php

define('INITIALIZE_GLOBAL_CONSTANT' , 1) ;
define('INITIALIZE_CONSTANT' , 1) ;
define('PROJECT_NAME' , 'emVAS') ;
define('REQUEST_MICROTIME', microtime(true));
define('PROJECT_DESCRIPTION' , 'EmVAS BOT-Automation Platform') ;
define('PROJECT_CLIENT' , 'Emplug Limited') ;
define('PROJECT_DEVELOPER_FRONT' , 'Emplug Limited') ;
define('PRODUCTION', 'production');
define('DEVELOPMENT', 'development');

define('EMPLUG', 'emplug');

define('GLOBAL_ROOT' , __DIR__) ;
define('GLOBAL_CONFIG_PATH' , GLOBAL_ROOT .'/config') ;
define('GLOBAL_DATA_PATH' , GLOBAL_ROOT .'/data') ;
define('GLOBAL_LIB_PATH' , GLOBAL_ROOT .'/lib') ;
define('GLOBAL_BIN_PATH' , GLOBAL_ROOT .'/bin') ;
define('GLOBAL_ETC_PATH' , GLOBAL_ROOT .'/etc') ;
define('GLOBAL_OPENSSL_CONF_FILE', GLOBAL_DATA_PATH.'/sslConf/openssl.cnf');
## hold value for global autoload file which will load vendor, add extra-lib folder and return the autoloader
define('GLOBAL_AUTOLOAD_FILE', GLOBAL_LIB_PATH.'/global-autoload.php');

define('GLOBAL_APP_NAME' , ['2waySMS']) ;

define('ROUTE_REQUIREMENT_RESPONSE_SCHEMA' , '[/:responseSchema]') ;
define('ROUTE_REQUIREMENT_API_TOKEN' , '[/:apiToken]') ;

## check for integrity of data subfolders
function _verify_folder(array $check_folder_list) : bool   {
    ##
    if(null == $check_folder_list)    {
        return false ;
    }

    ##
    foreach ($check_folder_list as $list)   {
        ##
        if(! is_dir($list))    {
            ##
            mkdir($list , 0775 , true) ;
        }
    }
    return true ;
}

_verify_folder([GLOBAL_CONFIG_PATH , GLOBAL_DATA_PATH , GLOBAL_LIB_PATH , GLOBAL_BIN_PATH]) ;

