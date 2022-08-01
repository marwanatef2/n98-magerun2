<?php

namespace RobustaMagerunTest;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestDummyCommand extends \Robusta\Magento\Command\AbstractMagentoCommand
{
    protected function configure()
    {
        $this
            ->setName('robustamageruntest:test:dummy')
            ->setDescription('Dummy command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->detectMagento($output);
        if (!$this->initMagento()) {
            return;
        }

        $output->writeln('dummy');
    }
}
