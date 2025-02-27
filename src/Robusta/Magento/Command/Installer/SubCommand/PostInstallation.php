<?php

namespace Robusta\Magento\Command\Installer\SubCommand;

use Robusta\Magento\Command\SubCommand\AbstractSubCommand;
use Symfony\Component\Console\Input\ArrayInput;

class PostInstallation extends AbstractSubCommand
{
    /**
     * @return void
     * @throws \Exception
     */
    public function execute()
    {
        $this->getCommand()->getApplication()->setAutoExit(false);

        \chdir($this->config->getString('installationFolder'));
        $this->getCommand()->getApplication()->reinit();

        $this->output->writeln('<info>Reindex all after installation</info>');
        $this->getCommand()->getApplication()->run(
            new ArrayInput(['command' => 'indexer:reindex']),
            $this->output
        );

        /**
         * @TODO enable this after implementation of sys:check command
         */
        //$this->getCommand()->getApplication()->run(new StringInput('sys:check'), $this->output);
    }
}
