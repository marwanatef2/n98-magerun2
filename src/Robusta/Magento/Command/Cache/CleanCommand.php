<?php

namespace Robusta\Magento\Command\Cache;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CleanCommand extends AbstractModifierCommand
{
    protected function configure()
    {
        $this
            ->setName('cache:clean')
            ->addArgument('type', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Cache type code like "config"')
            ->setDescription('Clean magento cache');

        $help = <<<HELP
Cleans expired cache entries.

If you would like to clean only one cache type use like:

   $ robusta-magerun2.phar cache:clean full_page

If you would like to clean multiple cache types at once use like:

   $ robusta-magerun2.phar cache:clean full_page block_html

If you would like to remove all cache entries use `cache:flush`

HELP;
        $this->setHelp($help);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->detectMagento($output, true);
        if (!$this->initMagento()) {
            return;
        }

        $cacheManager = $this->getCacheManager();
        $eventManager = $this->getObjectManager()->get('\Magento\Framework\Event\ManagerInterface');
        $availableTypes = $cacheManager->getAvailableTypes();

        $typesToClean = $input->getArgument('type');

        if (!empty($typesToClean)) {
            $validTypesToClean = [];
            foreach ($typesToClean as $index => $type) {
                if (in_array($type, $availableTypes)) {
                    $validTypesToClean[] = $type;
                } else {
                    unset($typesToClean[$index]);
                    $output->writeln('<info><comment>"' . $type . '"</comment> skipped (unknown cache type)</info>');
                }
            }
            if (empty($validTypesToClean)) {
                $output->writeln('<error>Aborting clean</error>');
                return;
            }
        }

        foreach ($availableTypes as $type) {
            if (count($typesToClean) == 0 || in_array($type, $typesToClean)) {
                $cacheManager->clean([$type]);
                $eventManager->dispatch('adminhtml_cache_refresh_type', ['type' => $type]);
                $output->writeln('<info><comment>' . $type . '</comment> cache cleaned</info>');
            }
        }
    }
}
