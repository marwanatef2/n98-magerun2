<?php
/**
 * @copyright Copyright (c) 1999-2017 netz98 GmbH (http://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace Robusta\Magento\Application;

use Composer\Autoload\ClassLoader;
use Magento\Framework\Autoload\AutoloaderInterface;

class AutoloaderDecorator implements AutoloaderInterface
{
    /**
     * @var \Composer\Autoload\ClassLoader
     */
    private $robustaMagerunAutoloader;

    /**
     * @var \Magento\Framework\Autoload\AutoloaderInterface
     */
    private $magentoAutoloader;

    /**
     * AutoloaderDecorator constructor.
     *
     * @param \Magento\Framework\Autoload\AutoloaderInterface $magentoAutoloader
     * @param \Composer\Autoload\ClassLoader $robustaMagerunAutoloader
     */
    public function __construct(AutoloaderInterface $magentoAutoloader, ClassLoader $robustaMagerunAutoloader)
    {
        $this->robustaMagerunAutoloader = $robustaMagerunAutoloader;
        $this->magentoAutoloader = $magentoAutoloader;

        $this->mirrorAutoloader($robustaMagerunAutoloader);
    }

    /**
     * Attempts to load a class and returns true if successful.
     *
     * @param string $className
     * @return bool
     */
    public function loadClass($className)
    {
        if ($this->robustaMagerunAutoloader->loadClass($className)) {
            return true;
        }

        return $this->magentoAutoloader->loadClass($className);
    }

    /**
     * Adds a PSR-4 mapping from a namespace prefix to directories to search in for the corresponding class
     *
     * @param string $nsPrefix The namespace prefix of the PSR-4 mapping
     * @param string|array $paths The path or paths to look in for the given prefix
     * @param bool $prepend Whether to append the given path or paths to the paths already associated with the prefix
     * @return void
     */
    public function addPsr4($nsPrefix, $paths, $prepend = false)
    {
        $this->magentoAutoloader->addPsr4($nsPrefix, $paths, $prepend);
    }

    /**
     * Adds a PSR-0 mapping from a namespace prefix to directories to search in for the corresponding class
     *
     * @param string $nsPrefix The namespace prefix of the PSR-0 mapping
     * @param string|array $paths The path or paths to look in for the given prefix
     * @param bool $prepend Whether to append the given path or paths to the paths already associated with the prefix
     * @return void
     */
    public function addPsr0($nsPrefix, $paths, $prepend = false)
    {
        $this->magentoAutoloader->addPsr0($nsPrefix, $paths, $prepend);
    }

    /**
     * Creates new PSR-0 mappings from the given prefix to the given set of paths, eliminating previous mappings
     *
     * @param string $nsPrefix The namespace prefix of the PSR-0 mapping
     * @param string|array $paths The path or paths to look in for the given prefix
     * @return void
     */
    public function setPsr0($nsPrefix, $paths)
    {
        $this->magentoAutoloader->setPsr0($nsPrefix, $paths);
    }

    /**
     * Creates new PSR-4 mappings from the given prefix to the given set of paths, eliminating previous mappings
     *
     * @param string $nsPrefix The namespace prefix of the PSR-0 mapping
     * @param string|array $paths The path or paths to look in for the given prefix
     * @return void
     */
    public function setPsr4($nsPrefix, $paths)
    {
        $this->magentoAutoloader->setPsr4($nsPrefix, $paths);
    }

    /**
     * Get filepath of class on system or false if it does not exist
     *
     * @param string $className
     * @return string|bool
     */
    public function findFile($className)
    {
        $filename = $this->robustaMagerunAutoloader->findFile($className);

        if ($filename !== false) {
            return $filename;
        }

        // Fallback to original Magento autoloader

        return $this->magentoAutoloader->findFile($className);
    }

    /**
     * @param \Composer\Autoload\ClassLoader $robustaMagerunAutoloader
     */
    private function mirrorAutoloader(ClassLoader $robustaMagerunAutoloader)
    {
        $this->mirrorPsr0Pathes($robustaMagerunAutoloader);
        $this->mirrorPsr4Pathes($robustaMagerunAutoloader);
        $this->mirrorClassMaps($robustaMagerunAutoloader);
    }

    /**
     * @param \Composer\Autoload\ClassLoader $robustaMagerunAutoloader
     * @return void
     */
    private function mirrorPsr4Pathes(ClassLoader $robustaMagerunAutoloader)
    {
        foreach ($robustaMagerunAutoloader->getPrefixesPsr4() as $prefixPsr4 => $pathes) {

            /**
             * Do not use robusta-magerun2 bundled composer for Magento autoloader.
             * Magento could have a different Composer version bundled.
             *
             * @see https://github.com/netz98/robusta-magerun2/issues/789
             */
            if (in_array($prefixPsr4, ['Composer\\', 'Composer\\Semver\\'])) {
                continue;
            }

            $this->magentoAutoloader->addPsr4($prefixPsr4, $pathes, true);
        }
    }

    /**
     * @param \Composer\Autoload\ClassLoader $robustaMagerunAutoloader
     */
    private function mirrorPsr0Pathes(ClassLoader $robustaMagerunAutoloader)
    {
        foreach ($robustaMagerunAutoloader->getPrefixes() as $prefixPsr0 => $pathes) {
            $this->magentoAutoloader->addPsr0($prefixPsr0, $pathes, true);
        }
    }

    /**
     * Mirror class maps from one autoloader to another
     *
     * We make use of reflection, because the AutloaderInterface does not contain
     * a method for class maps.
     *
     * @param \Composer\Autoload\ClassLoader $robustaMagerunAutoloader
     */
    private function mirrorClassMaps(ClassLoader $robustaMagerunAutoloader)
    {
        try {
            $autoloaderReflection = new \ReflectionObject($this->magentoAutoloader);
            $autoloaderProperty = $autoloaderReflection->getProperty('autoloader');
            $autoloaderProperty->setAccessible(true);

            /** @var ClassLoader $magentoComposerAutoloader */
            $magentoComposerAutoloader = $autoloaderProperty->getValue($this->magentoAutoloader);
            $magentoComposerAutoloader->addClassMap($robustaMagerunAutoloader->getClassMap());
        } catch (\Exception $e) {
            // ignore not existing autoloader
        }
    }
}
