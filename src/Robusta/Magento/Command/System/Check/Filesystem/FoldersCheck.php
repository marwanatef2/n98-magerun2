<?php

namespace Robusta\Magento\Command\System\Check\Filesystem;

use Robusta\Magento\Command\CommandAware;
use Robusta\Magento\Command\CommandConfigAware;
use Robusta\Magento\Command\System\Check\Result;
use Robusta\Magento\Command\System\Check\ResultCollection;
use Robusta\Magento\Command\System\Check\SimpleCheck;
use Robusta\Magento\Command\System\CheckCommand;
use Symfony\Component\Console\Command\Command;

/**
 * Class FoldersCheck
 * @package Robusta\Magento\Command\System\Check\Filesystem
 */
class FoldersCheck implements SimpleCheck, CommandAware, CommandConfigAware
{
    /**
     * @var array
     */
    protected $_commandConfig;

    /**
     * @var CheckCommand
     */
    protected $_checkCommand;

    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results)
    {
        $folders = $this->_commandConfig['filesystem']['folders'];
        $magentoRoot = $this->_checkCommand->getApplication()->getMagentoRootFolder();

        foreach ($folders as $folder => $comment) {
            $result = $results->createResult();
            if (file_exists($magentoRoot . '/' . $folder)) {
                $result->setStatus(Result::STATUS_OK);
                $result->setMessage('<info>Folder <comment>' . $folder . '</comment> found.</info>');
                if (!is_writeable($magentoRoot . '/' . $folder)) {
                    $result->setStatus(Result::STATUS_ERROR);
                    $result->setMessage(
                        '<error>Folder ' . $folder . ' is not writeable!</error><comment> Usage: ' . $comment .
                        '</comment>'
                    );
                }
            } else {
                $result->setStatus(Result::STATUS_ERROR);
                $result->setMessage(
                    '<error>Folder ' . $folder . ' not found!</error><comment> Usage: ' . $comment . '</comment>'
                );
            }
        }
    }

    /**
     * @param array $commandConfig
     */
    public function setCommandConfig(array $commandConfig)
    {
        $this->_commandConfig = $commandConfig;
    }

    /**
     * @param Command $command
     */
    public function setCommand(Command $command)
    {
        $this->_checkCommand = $command;
    }
}
