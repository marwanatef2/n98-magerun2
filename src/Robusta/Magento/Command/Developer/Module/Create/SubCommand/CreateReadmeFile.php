<?php

namespace Robusta\Magento\Command\Developer\Module\Create\SubCommand;

use Robusta\Magento\Command\SubCommand\AbstractSubCommand;

/**
 * Class CreateReadmeFile
 * @package Robusta\Magento\Command\Developer\Module\Create\SubCommand
 */
class CreateReadmeFile extends AbstractSubCommand
{
    /**
     * @see https://raw.github.com/sprankhub/Magento-Extension-Sample-Readme/master/readme.markdown
     *
     * @return void
     */
    public function execute()
    {
        $outFile = $this->config->getString('moduleDirectory') . '/README.md';

        \file_put_contents(
            $outFile,
            $this->getCommand()->getHelper('twig')->render(
                'dev/module/create/app/code/module/readme.md.twig',
                $this->config->getArray('twigVars')
            )
        );

        $this->output->writeln('<info>Created file: <comment>' . $outFile . '<comment></info>');
    }
}
