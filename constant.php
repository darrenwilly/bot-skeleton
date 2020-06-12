<?php

/**
 * look for the global constant
 */
$global_constant_file = __DIR__ . '/global-constant.php' ;
##
if(file_exists($global_constant_file))    {
    include $global_constant_file ;
}

define('PROJECT_SUB_NAME' , '2WaySMS') ;
define('PROJECT_SUB_FOLDER_NAME' , '2waysms') ;
define('APPLICATION_ROOT' , __DIR__) ;
define('APPLICATION_ENV' , DEVELOPMENT) ;
define('APPLICATION_PATH' , APPLICATION_ROOT .'/src') ;
define('APPLICATION_DATA_PATH' , APPLICATION_ROOT .'/var') ;
define('APPLICATION_CONFIG_PATH' , APPLICATION_ROOT .'/config') ;
define('APPLICATION_LIB_PATH' , APPLICATION_ROOT .'/lib') ;
define('APPLICATION_BIN_PATH' , APPLICATION_ROOT .'/bin') ;

define('PHP_EXTENSION', 'php');

/**
 * Setting for Document in the Data path
 */
define('APPLICATION_DOCUMENT_DIR', APPLICATION_DATA_PATH .'/document');
define('APPLICATION_CACHE_DIR', APPLICATION_DATA_PATH .'/cache');
define('APPLICATION_LOG_DIR', APPLICATION_DATA_PATH .'/log');
define('APPLICATION_LUCENE_DIR', APPLICATION_DATA_PATH .'/lucene');
define('APPLICATION_RSA_DIR', APPLICATION_DATA_PATH .'/rsa');
define('APPLICATION_SESSION_DIR', APPLICATION_DATA_PATH .'/sessions');
define('APPLICATION_MIGRATION_DIR', APPLICATION_DATA_PATH .'/migration');
define('APPLICATION_PUBLIC', __DIR__.'/frontctl');
define('APPLICATION_VENDOR', APPLICATION_ROOT . '/vendor');
define('APPLICATION_ETC', APPLICATION_DATA_PATH.'/etc');


define('API_VERSION', 'v2');
define('ARCHITECTURE', 'symfony'); ## e.g expressive, Laminas_mvc2, Laminas_mvc3, laravel, slim

/**
 * Setting to know whelther the GLOBAL constant file should be included in the project or not
 */
define('USE_GLOBAL_LIBRARY', 1); ## tell the application to use the global LIB folder which might be outside the project folder
define('CURRENT_PROJECT_TO_AUTOLOAD', [PROJECT_SUB_FOLDER_NAME => APPLICATION_ROOT]); ## tell the application to use the global LIB folder which might be outside the project folder
/**
 * Setting to handle if a CLI application will be created in the project.
 * This settings is only useful when using a Framework that doesn't support CLI-Command Implementation
 */
#define('PROCESS_MANAGER_INTEGRATION_MODE', 'embeded');
#define('PROCESS_MANAGER_PATH_EMBEDDED', APPLICATION_ROOT.'/pm');

/**
 * Setting for DOCTRINE READ & WRITE ORM SETTINGs
 */
if(! defined('DOCTRINE_ORM_READ'))    {
    define('DOCTRINE_ORM_READ' , 'orm_read') ;
}

if(! defined('DOCTRINE_ORM_WRITE'))    {
    define('DOCTRINE_ORM_WRITE' , 'orm_read') ;
}

/**
 * This are logic that control the PLUGGABLE MODULE IN THIS PROJECT
 */
if(! defined('ENABLE_PLUGGABLE_MODULE'))    {
    define('ENABLE_PLUGGABLE_MODULE' , 1) ;
}
##
if(! defined('PLUGGABLE_MODULE_DIR'))    {
    define('PLUGGABLE_MODULE_DIR' , (__DIR__.'/src') ) ;
    define('PLUGGABLE_MODULE_AUTOLOAD_FILE' , PLUGGABLE_MODULE_DIR.'/_pluggable_module_autoloader.php' ) ;
}
if(! defined('PLUGGABLE_MODULE_EXCLUSION_DIR'))    {
    ## note this is only allowed in PHP 7.2
    define('PLUGGABLE_MODULE_EXCLUSION_DIR' , ['core-source']) ;
}


_verify_folder([APPLICATION_DOCUMENT_DIR , APPLICATION_CACHE_DIR , APPLICATION_LOG_DIR , APPLICATION_LUCENE_DIR , APPLICATION_RSA_DIR , APPLICATION_SESSION_DIR , APPLICATION_MIGRATION_DIR]) ;
