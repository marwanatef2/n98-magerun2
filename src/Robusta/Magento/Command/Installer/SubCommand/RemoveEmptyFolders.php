<?php

namespace Robusta\Magento\Command\Installer\SubCommand;

use Robusta\Magento\Command\SubCommand\AbstractSubCommand;
use Robusta\Util\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Class RemoveEmptyFolders
 * @package Robusta\Magento\Command\Installer\SubCommand
 */
class RemoveEmptyFolders extends AbstractSubCommand
{
    /**
     * @return void
     */
    public function execute()
    {
        if (is_dir(getcwd() . '/vendor')) {
            $finder = new Finder();
            $finder->files()->depth(3)->in(getcwd() . '/vendor');
            if ($finder->count() == 0) {
                $filesystem = new Filesystem();
                $filesystem->recursiveRemoveDirectory(getcwd() . '/vendor');
            }
        }
    }
}
