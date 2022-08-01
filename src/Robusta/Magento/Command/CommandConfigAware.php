<?php

namespace Robusta\Magento\Command;

/**
 * Interface CommandConfigAware
 * @package Robusta\Magento\Command
 */
interface CommandConfigAware
{
    /**
     * @param array $commandConfig
     * @return void
     */
    public function setCommandConfig(array $commandConfig);
}
