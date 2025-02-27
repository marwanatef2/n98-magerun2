<?php

namespace Robusta\Magento\Command\System\Website;

use Robusta\Magento\Command\AbstractMagentoCommand;
use Robusta\Util\Console\Helper\Table\Renderer\RendererFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListCommand
 * @package Robusta\Magento\Command\System\Website
 */
class ListCommand extends AbstractMagentoCommand
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    protected function configure()
    {
        $this
            ->setName('sys:website:list')
            ->setDescription('Lists all websites')
            ->addOption(
                'format',
                null,
                InputOption::VALUE_OPTIONAL,
                'Output Format. One of [' . implode(',', RendererFactory::getFormats()) . ']'
            );
    }

    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function inject(\Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('format') === null) {
            $this->writeSection($output, 'Magento Websites');
        }

        foreach ($this->storeManager->getWebsites() as $website) {
            $table[$website->getId()] = [
                $website->getId(),
                $website->getCode(),
            ];
        }

        ksort($table);
        $this->getHelper('table')
            ->setHeaders(['id', 'code'])
            ->renderByFormat($output, $table, $input->getOption('format'));
    }
}
