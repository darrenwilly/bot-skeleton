<?php

/**
 * Please note that an External LIBRARY does not need to tbe autoload as Symfony bundle  bcos they are not premium modules and not pluggable
 *
 * Configure Constant that autoload PSR4 and PSR0 file
 */
    if(! defined('PSR4_LIB_AUTOLOAD_FILE'))    {
        ##
        define('PSR4_LIB_AUTOLOAD_FILE' , __DIR__ . '/autoload_psr4.php') ;
    }
    ##
    if(! defined('PSR0_LIB_AUTOLOAD_FILE'))    {
        ##
        define('PSR0_LIB_AUTOLOAD_FILE' , __DIR__ . '/autoload_psr0.php') ;
    }

    function __autoload_external_modules_namespace(Composer\Autoload\ClassLoader $autoloader)
    {
        ##
        /**
         * look for a composer psr4 compliant file first, if not available, generate it
         */
        if(! file_exists(PSR4_LIB_AUTOLOAD_FILE)) {
            ##
            _generate_psr_file(dirname(PSR4_LIB_AUTOLOAD_FILE)) ;
        }

        if(! file_exists(PSR0_LIB_AUTOLOAD_FILE)) {
            ##
            _generate_psr_file(dirname(PSR0_LIB_AUTOLOAD_FILE)) ;
        }

        /**
         * we still need to ensure that the file exist
         */
        if(file_exists(PSR4_LIB_AUTOLOAD_FILE)) {
            ##
            $lib_list = (array) require_once PSR4_LIB_AUTOLOAD_FILE;

            foreach ($lib_list as $namespace => $dir)   {
                ##
                $autoloader->setPsr4($namespace , $dir) ;
            }
            ##
            unset($lib_list);
        }

        /**
         * we still need to ensure that the file exist
         */
        if(file_exists(PSR0_LIB_AUTOLOAD_FILE)) {
            ##
            $lib_list = require_once PSR0_LIB_AUTOLOAD_FILE;
            ##
            foreach ($lib_list as $namespace => $dir)   {
                ##
                $autoloader->set($namespace , $dir) ;
            }
            ##
            unset($lib_list);
        }
        ##
        return $autoloader ;
    }

