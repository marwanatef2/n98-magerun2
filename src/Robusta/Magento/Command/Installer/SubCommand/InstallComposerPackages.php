<?php

namespace Robusta\Magento\Command\Installer\SubCommand;

use Robusta\Magento\Command\SubCommand\AbstractSubCommand;
use Symfony\Component\Process\Process;

/**
 * Class InstallComposerPackages
 * @package Robusta\Magento\Command\Installer\SubCommand
 */
class InstallComposerPackages extends AbstractSubCommand
{
    /**
     * Check PHP environment agains minimal required settings modules
     *
     * @return void
     *
     * @throws \Exception
     */
    public function execute()
    {
        $this->output->writeln('<comment>Install composer packages</comment>');
        $process = new Process(array_merge($this->config['composer_bin'], ['install']));
        $process->setTimeout(86400);

        $process->start();
        $process->wait(function ($type, $buffer) {
            $this->output->write('composer > ' . $buffer, false);
        });
    }
}
