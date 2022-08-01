<?php

namespace Robusta\Magento\Command\Developer\Module\Create\SubCommand;

use Robusta\Magento\Command\SubCommand\AbstractSubCommand;

/**
 * Class CreateModuleDiFile
 * @package Robusta\Magento\Command\Developer\Module\Create\SubCommand
 */
class CreateModuleDiFile extends AbstractSubCommand
{
    /**
     * @return void
     */
    public function execute()
    {
        $outFile = $this->config->getString('moduleDirectory') . '/etc/di.xml';

        \file_put_contents(
            $outFile,
            $this->getCommand()->getHelper('twig')->render(
                'dev/module/create/app/code/module/etc/di.xml.twig',
                $this->config->getArray('twigVars')
            )
        );

        $this->output->writeln('<info>Created file: <comment>' . $outFile . '<comment></info>');
    }
}
