<?php

namespace Robusta\Magento\Command\Developer\Module\Create\SubCommand;

use Robusta\Magento\Command\SubCommand\AbstractSubCommand;

/**
 * Class CreateComposerFile
 * @package Robusta\Magento\Command\Developer\Module\Create\SubCommand
 */
class CreateComposerFile extends AbstractSubCommand
{
    /**
     * @return void
     */
    public function execute()
    {
        $outFile = $this->config->getString('moduleDirectory') . '/composer.json';

        \file_put_contents(
            $outFile,
            $this->getCommand()->getHelper('twig')->render(
                'dev/module/create/composer.json.twig',
                $this->config->getArray('twigVars')
            )
        );

        $this->output->writeln('<info>Created file: <comment>' . $outFile . '<comment></info>');
    }
}
