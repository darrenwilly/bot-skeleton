<?php

namespace Root;

use DV\ContainerService\ServiceLocatorFactory;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private $requestStackSize = 0;
    private $resetServices = false;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function registerBundles(): iterable
    {
        /**
         *
         */
        foreach ($this->_callBundlesConfig() as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    private function _callBundlesConfig(): array
    {
        /**
         * load the initial bundle file
         */
        $contents = require $this->getProjectDir().'/config/bundles.php';
        /**
         * Load the current micro-service extra bundle
         */
        $extra_bundle_file = sprintf('%s/extra.bundles.php' , APPLICATION_LIB_PATH ) ;

        ##
        if(file_exists($extra_bundle_file))    {
            ##
            $contents = array_merge($contents , require $extra_bundle_file) ;
        }
        ##
        return $contents;
    }

    public function getProjectDir(): string
    {
        return (\dirname(__DIR__));
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        /**
         * this is where the bundles configuration are called initially
         */
        $container->addResource(new FileResource($this->getProjectDir().'/config/bundles.php'));
        $container->addResource(new FileResource(sprintf('%s/extra.bundles.php' , APPLICATION_LIB_PATH ) ));

        /**
         * Set the global parameters here
         */
        $container->setParameter('container.dumper.inline_class_loader', true);
        $container->setParameter('container.dumper.inline_factories', true);

        /**
         * Instruction to load the master config files
         */
        $confDir = $this->getProjectDir().'/config';

        $loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{packages}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}_'.$this->environment.self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getProjectDir().'/config';

        $routes->import($confDir.'/{routes}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}'.self::CONFIG_EXTS, '/', 'glob');

        /*
         * I need logic that iterate through the module folder and load their respective router files
         */
        #$routes->import('.', 'advanced_extra');
    }


    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, int $type = HttpKernelInterface::MASTER_REQUEST, bool $catch = true)
    {
        $this->boot();
        ++$this->requestStackSize;
        $this->resetServices = true;

        try {
            /**
             *
             */
            ServiceLocatorFactory::setInstance($this->container);
            ServiceLocatorFactory::setMvcEvent($this);
            /**
             *
             */
            return $this->getHttpKernel()->handle($request, $type, $catch);
        }
        finally {
            --$this->requestStackSize;
        }
    }

    public static function getLocator($name=null)
    {
        if(null == $name)    {
            ##
            return ServiceLocatorFactory::getInstance() ;
        }
        ##
        return ServiceLocatorFactory::getLocator() ;
    }

}
