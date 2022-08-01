<?php

namespace Robusta\Magento\Command\Script\Repository;

use Robusta\Magento\Application;
use Robusta\Magento\Command\AbstractMagentoCommand;

/**
 * Class AbstractRepositoryCommand
 * @package Robusta\Magento\Command\Script\Repository
 */
class AbstractRepositoryCommand extends AbstractMagentoCommand
{
    /**
     * Extension of robusta-magerun scripts
     */
    const MAGERUN_EXTENSION = '.magerun';

    /**
     * @return array
     */
    protected function getScripts()
    {
        /** @var $application Application */
        $application = $this->getApplication();

        $config = $application->getConfig();
        $configScriptFolders = $config['script']['folders'];
        $excludedFolders = $config['script']['excluded-folders'];

        $baseName = $application::APP_NAME;
        $magentoRootFolder = $application->getMagentoRootFolder();

        $loader = new ScriptLoader(
            $configScriptFolders,
            $excludedFolders,
            $baseName,
            $magentoRootFolder
        );

        return $loader->getFiles();
    }
}
