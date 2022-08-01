<?php

namespace Robusta\Magento\Command;

use Symfony\Component\Console\Command\Command;

/**
 * Interface CommandAware
 * @package Robusta\Magento\Command
 */
interface CommandAware
{
    /**
     * @param Command $command
     * @return void
     */
    public function setCommand(Command $command);
}
