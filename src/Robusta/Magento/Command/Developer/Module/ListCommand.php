<?php

namespace Robusta\Magento\Command\Developer\Module;

use Robusta\Magento\Command\AbstractMagentoCommand;
use Robusta\Util\Console\Helper\Table\Renderer\RendererFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListCommand
 * @package Robusta\Magento\Command\Developer\Module
 */
class ListCommand extends AbstractMagentoCommand
{
    /**
     * @var array
     */
    protected $moduleList;

    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    protected $moduleListObject;

    public function getModuleList()
    {
        return $this->moduleList;
    }

    /**
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     */
    public function inject(\Magento\Framework\Module\ModuleListInterface $moduleList)
    {
        $this->moduleListObject = $moduleList;
    }

    protected function configure()
    {
        $this
            ->setName('dev:module:list')
            ->addOption(
                'vendor',
                null,
                InputOption::VALUE_OPTIONAL,
                'Show modules of a specific vendor (case insensitive)'
            )
            ->setDescription('List all installed modules')
            ->addOption(
                'format',
                null,
                InputOption::VALUE_OPTIONAL,
                'Output Format. One of [' . implode(',', RendererFactory::getFormats()) . ']'
            );
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

        if ($input->getOption('format') == null) {
            $this->writeSection($output, 'Magento Modules');
        }

        $this->initMagento();
        $this->prepareModuleList($input->getOption('vendor'));

        $this->getHelper('table')
            ->setHeaders(['Name', '(Schema) Version'])
            ->renderByFormat($output, $this->moduleList, $input->getOption('format'));
    }

    protected function prepareModuleList($vendor)
    {
        $this->moduleList = [];

        foreach ($this->moduleListObject->getAll() as $moduleName => $info) {
            // First index is (probably always) vendor
            $moduleNameData = explode('_', $moduleName);

            if ($vendor !== null && strtolower($moduleNameData[0]) !== strtolower($vendor)) {
                continue;
            }

            $this->moduleList[] = [$info['name'], $info['setup_version']];
        }
    }
}
