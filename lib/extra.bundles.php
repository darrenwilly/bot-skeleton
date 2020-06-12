<?php

/**
 * Manually load all the external library manually
 */
$extra_config = [
    /**
     * All the modules here will be converted to Pluggable module later when I can fix the bug in the DebugClassLoader that restrict the BundleFile to be found
     */
] ;

if(class_exists(\DV\DVBundle::class))    {
    $extra_config[\DV\DVBundle::class] = ['all' => true] ;
}

if(class_exists(\Veiw\BotLogic\BACBundle::class))    {
    $extra_config[\Veiw\BotLogic\BACBundle::class] = ['all' => true] ;
}

if(class_exists(\Veiw\BotVAS\GTSInfoTel\BotGTSInfoTelBundle::class))    {
    $extra_config[\Veiw\BotVAS\GTSInfoTel\BotGTSInfoTelBundle::class] = ['all' => true] ;
}

if(class_exists(\Emplug\Keyword\BAKBundle::class))    {
    $extra_config[\Emplug\Keyword\BAKBundle::class] = ['all' => true] ;
}

if(class_exists(\Emplug\Keyword\Tap\TAPKeywordBundle::class))    {
    $extra_config[\Emplug\Keyword\Tap\TAPKeywordBundle::class] = ['all' => true] ;
}

/**
 * Dynamically load the PLUGGABLE Modules
 * Because we assumed at the point that _pluggable_module_autoloader.php script must have been loaded in global.autoload.php
 * which is always called in the begining of CLI/WEB FrontController file, so we can check for Dyloamic function that load the Plugable module
 */
if(function_exists('__autoload_custom_modules_as_symfony_bundle'))    {
    /**
     * I have to commend the pluggable module function call out for now bcos of a bug that keep denying the script to file
     * the bundleClass object even when the file can be loaded successfully
     */
    #__autoload_custom_modules_as_symfony_bundle($extra_config) ;
}
else{
    ## what to do when symfony bundle cannot be loaded

}

return $extra_config ;
