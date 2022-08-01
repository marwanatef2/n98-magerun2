<?php

namespace Robusta\Magento\Application;

use Composer\Autoload\ClassLoader;
use Magento\Framework\App\Bootstrap;
use Magento\Framework\Autoload\AutoloaderRegistry;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManager;
use Robusta\Magento\Framework\App\Magerun;
use Robusta\Util\PharWrapper;

/**
 * Class Magento2Initializer
 * @package Robusta\Magento\Application
 */
class Magento2Initializer
{
    /**
     * @var \Composer\Autoload\ClassLoader
     */
    private $autoloader;

    /**
     * Magento2Initializer constructor.
     * @param \Composer\Autoload\ClassLoader $autoloader
     */
    public function __construct(ClassLoader $autoloader)
    {
        $this->autoloader = $autoloader;
    }

    /**
     * @param string $magentoRootFolder
     * @return \Robusta\Magento\Framework\App\Magerun
     * @throws \Exception
     */
    public function init($magentoRootFolder)
    {
        self::loadMagentoBootstrap($magentoRootFolder);

        $magentoAutoloader = AutoloaderRegistry::getAutoloader();

        // Prevent an infinite loop of autoloaders
        if (!$magentoAutoloader instanceof AutoloaderDecorator) {
            AutoloaderRegistry::registerAutoloader(
                new AutoloaderDecorator(
                    $magentoAutoloader,
                    $this->autoloader
                )
            );
        }

        $params = $_SERVER;
        $params[StoreManager::PARAM_RUN_CODE] = 'admin';
        $params[Store::CUSTOM_ENTRY_POINT_PARAM] = true;
        $params['entryPoint'] = basename(__FILE__);

        $bootstrap = Bootstrap::create(BP, $params);
        /** @var \Magento\Framework\App\Cron $app */
        $app = $bootstrap->createApplication(Magerun::class, []);
        /* @var $app \Robusta\Magento\Framework\App\Magerun */
        $app->launch();

        return $app;
    }

    public static function loadMagentoBootstrap($magentoRootFolder)
    {
        static $loaded;

        if (!$loaded) {
            PharWrapper::init();
            $oldErrorHandler = set_error_handler(function () {
                return true;
            }, E_WARNING);
            require_once $magentoRootFolder . '/app/bootstrap.php';
            set_error_handler($oldErrorHandler, E_WARNING);
            PharWrapper::ensurePharWrapperIsRegistered();
            $loaded = true;
        }
    }
}
