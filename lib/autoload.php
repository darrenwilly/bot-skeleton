<?php

/**
 * The workflow of this script is simply the following
 * -   Call the current project root constant
 * -   call the global constant.php on the global folder right inside the current root folder
 * -   call the global autoload file to initalize all global settings
 */
if(! defined('INITIALIZE_CONSTANT'))    {
    ##
    require dirname(__DIR__).DIRECTORY_SEPARATOR.'constant.php' ;
}

## check if the project should use the GLOBAL LIBRARY
if(defined('USE_GLOBAL_LIBRARY'))    {
    /**
     * call the GLOBAL Constant to be loaded at runtime
     */
    if(! defined('INITIALIZE_GLOBAL_CONSTANT'))    {
        ## include the global constant by calling the project constant itself
        include dirname(__DIR__).'/global-constant.php';
    }

    /**
     * The GLOBAL_AUTOLOAD_ALREADY_CALLED only get loaded when the global-autoload script is loaded
     */
    if(! defined('GLOBAL_AUTOLOAD_ALREADY_CALLED'))    {
        ## load the global constant which has the global bin in place
        $autoloader = include GLOBAL_AUTOLOAD_FILE ;
    }

}

## when the actual integrated loader cannot be found
else{
    ##
    $autoloader = include APPLICATION_VENDOR . '/autoload.php' ;
}

/**
 * manually add the job-queue
 */
#$autoloader->addPsr4('Enqueue\\JobQueue\\' , __DIR__ . '/job-queue') ;

return $autoloader ;