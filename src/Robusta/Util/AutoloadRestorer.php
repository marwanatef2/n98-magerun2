<?php
/*
 * @author Tom Klingenberg <mot@fsfe.org>
 */

namespace Robusta\Util;

/**
 * Utility class to snapshot a set of autoloaders and restore any of the snapshot if removed.
 *
 * Based on SPL autoloader.
 *
 * @package Robusta\Util
 */
class AutoloadRestorer
{
    /**
     * @var array
     */
    private $snapshot;

    public function __construct()
    {
        $this->snapshot = spl_autoload_functions();
    }

    /**
     * restore all autoload callbacks that have been unregistered
     */
    public function restore()
    {
        $unregisteredLoaders = $this->getUnregisteredLoaders();

        foreach ($unregisteredLoaders as $callback) {
            spl_autoload_register($callback);
        }
    }

    /**
     * @return array
     */
    private function getUnregisteredLoaders()
    {
        $unregistered = [];
        $current = spl_autoload_functions();
        foreach ($this->snapshot as $callback) {
            if (in_array($callback, $current, true)) {
                continue;
            }
            $unregistered[] = $callback;
        }

        return $unregistered;
    }
}
