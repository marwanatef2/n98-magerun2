<?php

namespace Robusta\Magento\Command\Developer\Module;

use Robusta\Magento\Command\AbstractMagentoCommand;
use Robusta\Magento\Command\SubCommand\ConfigBag;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Create a magento module skeleton
 *
 * @package Robusta\Magento\Command\Developer\Module
 */
class CreateCommand extends AbstractMagentoCommand
{
    public const ROBUSTA_NAMESPACE = 'Robusta';

    protected function configure()
    {
        $this
            ->setName('module:create')
            ->addArgument('moduleName', InputArgument::REQUIRED, 'Name of your module.')
            ->addOption('enable', 'e', InputOption::VALUE_NONE, 'Enable module after creation')
            ->addOption('add-strict-types', null, InputOption::VALUE_NONE, 'Add strict_types declaration to generated PHP files')
            ->addOption('description', null, InputOption::VALUE_OPTIONAL, 'Description for readme.md or composer.json')
            ->setDescription('Create and register a new magento module under Robusta\'s namespace.');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $subCommandFactory = $this->createSubCommandFactory(
            $input,
            $output,
            'Robusta\Magento\Command\Developer\Module\Create\SubCommand' // sub-command namespace
        );

        $configBag = $subCommandFactory->getConfig();
        $this->detectMagento($output);
        
        $moduleName = ucfirst($input->getArgument('moduleName'));
        if (strpos($moduleName, 'Robusta_') !== false) {
            $moduleName = explode('Robusta_', $moduleName)[1];
        }
        $packageName = ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '-$0', $moduleName)), '-');
        
        $configBag->setString('magentoRootFolder', $this->_magentoRootFolder);
        $configBag->setString('baseFolder', __DIR__ . '/../../../../../../res/module/create');
        $configBag->setString('vendorNamespace', self::ROBUSTA_NAMESPACE);
        $configBag->setString('moduleName', $moduleName);
        $configBag->setString('packageName', $packageName);

        $this->initView($input, $configBag);

        $subCommandFactory->create('CreateModuleFolders')->execute();
        $subCommandFactory->create('CreateModuleRegistrationFiles')->execute();
        $subCommandFactory->create('CreateReadmeFile')->execute();
        $subCommandFactory->create('CreateChangelogFile')->execute();
        $subCommandFactory->create('CreateComposerFile')->execute();
        $subCommandFactory->create('CreateSonarProjectFile')->execute();
        $subCommandFactory->create('CreateGitlabCIFile')->execute();
        $subCommandFactory->create('CreateGitlabIssuesAndMRsTemplatesFiles')->execute();

        return 0;
    }

    private function initView(InputInterface $input, ConfigBag $configBag)
    {
        $configBag->setArray('twigVars', [
            'vendorNamespace' => $configBag->getString('vendorNamespace'),
            'moduleName'      => $configBag->getString('moduleName'),
            'packageName'      => $configBag->getString('packageName'),
            'description'     => $input->getOption('description'),
            'addStrictTypes'  => $input->getOption('add-strict-types'),
        ]);
    }
}
