<?php

namespace Robusta\Magento\Command\System\Check\PHP;

use Robusta\Magento\Command\CommandConfigAware;
use Robusta\Magento\Command\System\Check\Result;
use Robusta\Magento\Command\System\Check\ResultCollection;
use Robusta\Magento\Command\System\Check\SimpleCheck;

/**
 * Class ExtensionsCheck
 * @package Robusta\Magento\Command\System\Check\PHP
 */
class ExtensionsCheck implements SimpleCheck, CommandConfigAware
{
    /**
     * @var array
     */
    protected $_commandConfig;

    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results)
    {
        $requiredExtensions = $this->_commandConfig['php']['required-extensions'];

        foreach ($requiredExtensions as $ext) {
            $result = $results->createResult();
            $result->setStatus(extension_loaded($ext) ? Result::STATUS_OK : Result::STATUS_ERROR);
            if ($result->isValid()) {
                $result->setMessage("<info>Required PHP Module <comment>$ext</comment> found.</info>");
            } else {
                $result->setMessage("<error>Required PHP Module $ext not found!</error>");
            }
        }
    }

    /**
     * @param array $commandConfig
     */
    public function setCommandConfig(array $commandConfig)
    {
        $this->_commandConfig = $commandConfig;
    }
}
