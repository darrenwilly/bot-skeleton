<?php

    if(! defined('PSR4_PLUGGABLE_AUTOLOAD_FILE'))    {
        ##
        define('PSR4_PLUGGABLE_AUTOLOAD_FILE' , __DIR__ . '/autoload_psr4.php') ;
    }

    function __autoload_pluggable_modules_namespace(Composer\Autoload\ClassLoader $autoloader)
    {
        ##
        /**
         * look for a composer psr4 compliant file first, if not available, generate it
         */

        if(! file_exists(PSR4_PLUGGABLE_AUTOLOAD_FILE)) {
            ##
            _generate_psr_file(dirname(PSR4_PLUGGABLE_AUTOLOAD_FILE)) ;
        }
        else{
            /**
             * When the file is also found, we need to know when it was created .
             * I think it is better to delete the autoloader file for pluggable folder in every 24hours
             * so that it can scan the folder for new Pluggable and load them
             */
             $existing_autoload_file = new SplFileInfo(PSR4_PLUGGABLE_AUTOLOAD_FILE);
             ##
        }

        /**
         * we still need to ensure that the file exist
         */
        if(file_exists(PSR4_PLUGGABLE_AUTOLOAD_FILE)) {
            ##
            $lib_list = (array) require PSR4_PLUGGABLE_AUTOLOAD_FILE;

            foreach ($lib_list as $namespace => $dir)   {
                /**
                 * Becaos the main module core-source, is default and would have been added  in the main Composer.json and by Composer itself
                 * so we need to skit it
                 */
                if(false !== strpos($namespace , 'Veiw\\BotLogic'))    {
                    ## skip adding it to autoloader
                    continue ;
                }
                ##
                $autoloader->setPsr4($namespace , $dir) ;
            }
            unset($lib_list);
        }

        return $autoloader;
    }

    /**
     * We need to create a logic that can autoload the symfony bundle into the app bcos they can be installed using an automated mode too
     *
     * @param $config
     * @return mixed
     */
    function __autoload_custom_modules_as_symfony_bundle(&$external_config)
    {
        /**
         * I have to create an internal variable to pass the external becos a bug was auto adding the files
         * include in the script as value for the external_config variable
         */
        $internal_config  = $external_config ;
        /**
         * we still need to ensure that the file exist
         */
        if(file_exists(PSR4_PLUGGABLE_AUTOLOAD_FILE))   {
            ##
            $lib_list = require PSR4_PLUGGABLE_AUTOLOAD_FILE;

            foreach ($lib_list as $namespace => $dir)   {
                /**
                 * Becaos the main module core-source, is default and would have been added  in the main Composer.json and by Composer itself
                 * so we need to skit it
                 */
                if(false !== strpos($namespace , 'Veiw\\BotLogic'))    {
                    ## skip adding it to autoloader
                    continue ;
                }

                /**
                 * load the composer.json file and locate the key extra->symfony-bundle->name key path
                 */
                $composerJsonFile = sprintf('%s/composer.json' , ( (is_array($dir)) ? current($dir) : $dir) );

                ##
                $jsonContent = file_get_contents($composerJsonFile);
                ## decode the composer.json sir
                $composerJsonObject = json_decode($jsonContent , true);

                ##
                if(! isset($composerJsonObject['extra']['symfony-bundle']['name']))    {
                    ##
                    trigger_error('Each pluggable bundle requires a name defined for the Bundle to Autoload it') ; die;
                }

                ## construct a BundleName
                $construct_a_bundle_name = sprintf('%s\%s' , $namespace , $composerJsonObject['extra']['symfony-bundle']['name']) ;

                /**
                 * A bug in Symfony DebugClassLoader is making this function given an error that the BundleClass is not available, perhaps the problem can be fixed later

                if(! class_exists($construct_a_bundle_name , true))    {
                    ##
                    trigger_error(sprintf('%s not valid as a Bundle for Pluggable Module %s' , $construct_a_bundle_name , $namespace) ) ; die;
                }*/

                ## ad it as part of bundle
                $internal_config[$construct_a_bundle_name] = ['all' => true] ;
            }
            ## merge both at this point
           $external_config = array_merge($external_config , $internal_config);
        }
        ##
        return $external_config ;
    }

/**
 * Make sure that necessary function has been created and callable
 */
if(! function_exists('__autoload_pluggable_modules_namespace'))    {
    ##
    trigger_error('This application uses pluggable module structure but cannot load necessary modular settings');
    die;
}