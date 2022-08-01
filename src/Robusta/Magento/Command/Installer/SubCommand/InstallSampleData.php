<?php

namespace Robusta\Magento\Command\Installer\SubCommand;

use Robusta\Magento\Command\SubCommand\AbstractSubCommand;
use Robusta\Util\OperatingSystem;
use Symfony\Component\Process\Process;

/**
 * Class InstallSampleData
 * @package Robusta\Magento\Command\Installer\SubCommand
 */
class InstallSampleData extends AbstractSubCommand
{
    /**
     * @return void
     */
    public function execute()
    {
        if ($this->input->getOption('noDownload')) {
            return;
        }

        $installationFolder = $this->config->getString('installationFolder');
        chdir($installationFolder);

        $flag = $this->getOptionalBooleanOption(
            'installSampleData',
            'Install sample data?',
            $this->commandConfig['installation']['sample-data']
        );

        if ($flag) {
            $this->runSampleDataInstaller();
        }
    }

    protected function runSampleDataInstaller()
    {
        $this->runMagentoCommand('sampledata:deploy');
        $this->runMagentoCommand('setup:upgrade');
    }

    /**
     * @return void
     */
    private function runMagentoCommand($command)
    {
        $arguments = [];

        if (!OperatingSystem::isWindows()) {
            $arguments[] = '/usr/bin/env';
        }

        $arguments[] = 'php';
        $arguments[] = 'bin/magento';
        $arguments[] = $command;

        $process = new Process($arguments);

        $process->setTimeout(86400);
        $process->start();
        $process->wait(function ($type, $buffer) {
            $this->output->write('bin/magento > ' . $buffer, false);
        });
    }
}
