<?php

namespace Robusta\Magento\Command;

/**
 * Class DummyCommand
 * @package Robusta\Magento\Command
 */
class DummyCommand extends AbstractMagentoCommand
{
    protected function configure()
    {
        $this->setName('dummy');
    }
}
