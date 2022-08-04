<?php

namespace Robusta\Magento\Command\Developer\Module\Create\SubCommand;

use Robusta\Magento\Command\SubCommand\AbstractSubCommand;

/**
 * Class CreateModuleFolders
 * @package Robusta\Magento\Command\Developer\Module\Create\SubCommand
 */
class CreateModuleFolders extends AbstractSubCommand
{
    /**
     * @return void
     */
    public function execute()
    {
        $config = $this->config;

        $moduleDir = $config->getString('magentoRootFolder')
            . '/app/code'
            . '/' . $config->getString('vendorNamespace')
            . '/' . $config->getString('moduleName');
        if (file_exists($moduleDir)) {
            throw new \RuntimeException('Module already exists. Stop.');
        }

        $config->setString('moduleDirectory', $moduleDir);

        mkdir($moduleDir, 0777, true);
        $this->output->writeln('<info>Created directory: <comment>' . $moduleDir . '<comment></info>');

        // Add etc folder
        mkdir($moduleDir . '/etc');
        $this->output->writeln('<info>Created directory: <comment>' . $moduleDir . '/etc<comment></info>');

        // Add gitlab issues & MRs templates folder
        mkdir($moduleDir . '/.gitlab');
        $this->output->writeln('<info>Created directory: <comment>' . $moduleDir . '/.gitlab<comment></info>');
        mkdir($moduleDir . '/.gitlab/issue_templates');
        $this->output->writeln('<info>Created directory: <comment>' . $moduleDir . '/.gitlab<comment></info>');
        mkdir($moduleDir . '/.gitlab/merge_request_templates');
        $this->output->writeln('<info>Created directory: <comment>' . $moduleDir . '/.gitlab<comment></info>');
    }
}
