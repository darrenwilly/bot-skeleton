<?php
declare(strict_types=1) ;

/**
 * Logic that create a loadable PSR array dataset include file for autoloader base on available modular folder
 *
 * @param $psrTypeFile
 */
function _generate_psr_file($dirToGenerate=__DIR__)   {

    /**
     * Please note that before this __FILE__ is called, master autoload must have been called or loaded
     * Also, this class \Laminas\Code\Generator\FileGenerator() must be available
     */
    if(! class_exists('\Laminas\Code\Generator\FileGenerator'))    {
        trigger_error('Laminas Code Generator Class is required to generated Autoloader script files'); die;
    }

    ## load all the extra lib in this directory
    $dirIterator = new \DirectoryIterator($dirToGenerate) ;
    ##
    $lib_autoloader_list = [] ;

    ##
    $psrbody = function ($lib_autoloader_list) {
        ##
        $return = vsprintf('
    $rootDir = __DIR__ ;
                                                    
    $config = %s ;
                                                    
    ##
    return $config ;
    ', var_export($lib_autoloader_list, true));
        ##
        return $return;
    } ;

    $psr4_template_filename = 'autoload_psr4.php' ;
    $psr0_template_filename = 'autoload_psr0.php' ;

    $lib_autoloader_list = [] ;
    $lib_autoloader_list0 = [] ;

    ## iterate it
    foreach ($dirIterator as $dirItem)      {
        ##
        if($dirItem->isFile() || $dirItem->isDot())    {
            ## skip all files
            continue ;
        }

        ## check and make sure they are not dot
        if ($dirItem->isDir()) {
            ## create the composer.json file
            $composerJsonFile = $dirItem->getRealPath() . '/composer.json';

            ## check if the composer json file exist
            if (file_exists($composerJsonFile)) {
                ## fetch the json content
                $jsonContent = file_get_contents($composerJsonFile);
                ## decode the composer.json sir
                $composerJsonObject = json_decode($jsonContent , true);

                ## check and make sure that psr4 is set
                if(isset($composerJsonObject['autoload']['psr-4']))    {
                    ## bcos autoload/psr4 is always array, so iterate
                    foreach ($composerJsonObject['autoload']['psr-4'] as $psr4Namespace => $psr4NamespaceDir)     {
                        ## add the psr dir to the project autoloader
                        #$autoloader->addPsr4($psr4Namespace , $dir->getRealPath().DIRECTORY_SEPARATOR.$psr4NamespaceDir);
                        $lib_autoloader_list[$psr4Namespace][] = realpath($dirItem->getRealPath().DIRECTORY_SEPARATOR.$psr4NamespaceDir) ;
                    }

                }
                elseif(isset($composerJsonObject['autoload']['psr-0']))    {
                    /**
                     * add the psr0 dir variant
                     */
                    foreach ($composerJsonObject['autoload']['psr-0'] as $psr0Namespace => $psr0NamespaceDir)     {
                        ##
                        $lib_autoloader_list0[$psr0Namespace][] = __DIR__.DIRECTORY_SEPARATOR.$dirItem->getBasename().DIRECTORY_SEPARATOR.$psr0NamespaceDir;
                    }

                }
            }
            ## what happends when the director to load does not have a composer.json file, I think we needto be able to create sample composer.json file

        }
    }

    ## initialize the code generator
    $Laminas_code_generator = new \Laminas\Code\Generator\FileGenerator() ;

    /**
     * Now it is time to generate the PSR4 file autoloader
     */
    if(0 < count($lib_autoloader_list))    {
        ## set the body template and pass the value to generate
        $Laminas_code_generator->setBody($psrbody($lib_autoloader_list)) ;

        file_put_contents(sprintf('%s/%s' , $dirToGenerate ,$psr4_template_filename) , $Laminas_code_generator->generate()) ;
    }

    /**
     * Now it is time to generate the PSR0 file autoloader
     */
    if(0 < count($lib_autoloader_list0))    {
        ## set the body template and pass the value to generate
        $Laminas_code_generator->setBody($psrbody($lib_autoloader_list0)) ;
        ##
        file_put_contents(sprintf('%s/%s' , $dirToGenerate , $psr0_template_filename) , $Laminas_code_generator->generate()) ;
    }

} ;

##
function _load_global_lib(array $project)
{
    $projectName  = key($project) ;
    $projectDir = $project[$projectName] ;

    ## check for existence of vendor folder in the project
    if(! is_dir($projectDir . '/vendor'))    {
        ##
        return false ;
    }

    ##
    $autoloaderFile =  $projectDir . '/vendor/autoload.php';

    if(! file_exists($autoloaderFile))    {
        return false ;
    }


    ## autoload the project autoloader generator in vendor
    $autoloader = include $autoloaderFile ;

    /**
     * We always want the LIB to be load bcos in situation where a library is having dependencies issues or some requireemnt are not meant,
     * we can manually download the library and load it ourselves
     */
    require __DIR__.'/_external_autoloader.php' ;
    ##
    __autoload_external_modules_namespace($autoloader);


    /**
     * Bcos this application is a modular one, we are going to make it load other modular folder in the SRC too
     * Therefore, we need to create a logic that check the PSR4 for his own set of autoloader file
     */
    if(defined('ENABLE_PLUGGABLE_MODULE'))    {
        ##
        require PLUGGABLE_MODULE_AUTOLOAD_FILE ;
        ##
        __autoload_pluggable_modules_namespace($autoloader) ;
    }

    ##
    return $autoloader ;
}

## set a value that show that global autoload has been called
if(! defined('GLOBAL_AUTOLOAD_ALREADY_CALLED'))    {
    ##
    define('GLOBAL_AUTOLOAD_ALREADY_CALLED' , 1) ;

    ## load the current project and add the extra library to his dependency
    return _load_global_lib(CURRENT_PROJECT_TO_AUTOLOAD) ;
}

