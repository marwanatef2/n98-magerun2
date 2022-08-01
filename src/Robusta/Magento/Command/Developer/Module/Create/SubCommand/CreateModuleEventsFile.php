<?php

namespace Robusta\Magento\Command\Developer\Module\Create\SubCommand;

use Robusta\Magento\Command\SubCommand\AbstractSubCommand;

/**
 * Class CreateModuleEventsFile
 * @package Robusta\Magento\Command\Developer\Module\Create\SubCommand
 */
class CreateModuleEventsFile extends AbstractSubCommand
{
    /**
     * @return void
     */
    public function execute()
    {
        $outFile = $this->config->getString('moduleDirectory') . '/etc/events.xml';

        \file_put_contents(
            $outFile,
            $this->getCommand()->getHelper('twig')->render(
                'dev/module/create/app/code/module/etc/events.xml.twig',
                $this->config->getArray('twigVars')
            )
        );

        $this->output->writeln('<info>Created file: <comment>' . $outFile . '<comment></info>');
    }
}
