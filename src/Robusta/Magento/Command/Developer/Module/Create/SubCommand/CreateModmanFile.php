<?php

namespace Robusta\Magento\Command\Developer\Module\Create\SubCommand;

use Robusta\Magento\Command\SubCommand\AbstractSubCommand;

/**
 * Class CreateModmanFile
 * @package Robusta\Magento\Command\Developer\Module\Create\SubCommand
 */
class CreateModmanFile extends AbstractSubCommand
{
    /**
     * @return void
     */
    public function execute()
    {
        $outFile = $this->config->getString('modmanRootFolder') . '/modman';

        \file_put_contents(
            $outFile,
            $this->getCommand()->getHelper('twig')->render(
                'dev/module/create/modman.twig',
                $this->config->getArray('twigVars')
            )
        );

        $this->output->writeln('<info>Created file: <comment>' . $outFile . '<comment></info>');
    }
}
