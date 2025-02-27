<?php

namespace Robusta\Magento\Command\System\Store\Config;

use Robusta\Magento\Command\AbstractMagentoCommand;
use Robusta\Util\Console\Helper\Table\Renderer\RendererFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class BaseUrlListCommand
 * @package Robusta\Magento\Command\System\Store\Config
 */
class BaseUrlListCommand extends AbstractMagentoCommand
{
    /**
     * @var \Magento\Framework\Store\StoreManagerInterface
     */
    protected $storeManager;

    protected function configure()
    {
        $this
            ->setName('sys:store:config:base-url:list')
            ->setDescription('Lists all base urls')
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
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->detectMagento($output, true);

        if (!$input->getOption('format')) {
            $this->writeSection($output, 'Magento Stores - Base URLs');
        }
        $this->initMagento();

        foreach ($this->storeManager->getStores() as $store) {
            $table[$store->getId()] = [
                $store->getId(),
                $store->getCode(),
                $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB),
                $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB, true),
            ];
        }

        ksort($table);
        $this->getHelper('table')
            ->setHeaders(['id', 'code', 'unsecure_baseurl', 'secure_baseurl'])
            ->renderByFormat($output, $table, $input->getOption('format'));
    }
}
