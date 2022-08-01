<?php

namespace Robusta\Magento\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Shell;

/**
 * Class ShellCommand
 * @package Robusta\Magento\Command
 */
class ShellCommand extends AbstractMagentoCommand
{
    protected function configure()
    {
        $this
            ->setName('shell')
            ->setDescription('Runs robusta-magerun as shell');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $shell = new Shell($this->getApplication());
        $shell->run();
    }
}
