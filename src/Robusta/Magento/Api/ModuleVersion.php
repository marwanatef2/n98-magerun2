<?php
/*
 * @author Tom Klingenberg <t.klingenberg@netz98.de>
 * @copyright Copyright (c) 2016 netz98 new media GmbH (http://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

namespace Robusta\Magento\Api;

use BadMethodCallException;
use Magento\Framework\Module\ResourceInterface as ModuleResourceInterface;

/**
 * Class ModuleVersion
 *
 * @package Robusta\Magento\Api
 */
class ModuleVersion implements ModuleInterface, ModuleVersionInterface
{
    /**
     * @var Module
     */
    private $module;

    /**
     * @var ModuleResourceInterface
     */
    private $resource;

    public function __construct(Module $module, ModuleResourceInterface $resource)
    {
        $this->module = $module;
        $this->resource = $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->module->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
        return $this->module->getVersion();
    }

    /**
     * {@inheritdoc}
     */
    public function getDataVersion()
    {
        $name = $this->getName();
        $version = $this->resource->getDataVersion($name);
        if ($version === false) {
            throw new BadMethodCallException(sprintf("Module '%s' data-version is not available.", $name));
        }

        return $version;
    }

    /**
     * {@inheritdoc}
     */
    public function getDbVersion()
    {
        $name = $this->getName();
        $version = $this->resource->getDbVersion($name);
        if ($version === false) {
            throw new BadMethodCallException(sprintf("Module '%s' db-version is not available.", $name));
        }

        return $version;
    }

    /**
     * {@inheritdoc}
     */
    public function setDataVersion($version)
    {
        $this->resource->setDataVersion($this->getName(), $version);
    }

    /**
     * {@inheritdoc}
     */
    public function setDbVersion($version)
    {
        $this->resource->setDbVersion($this->getName(), $version);
    }
}
