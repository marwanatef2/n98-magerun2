<?php

namespace Robusta\Magento\Application;

use Robusta\Util\Console\Helper\MagentoHelper;
use Robusta\Util\OperatingSystem;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MagentoDetector
 * @package Robusta\Magento\Application
 */
class MagentoDetector
{
    /**
     * @param \Symfony\Component\Console\Input\InputInterface|null $input
     * @param \Symfony\Component\Console\Output\OutputInterface|null $output
     * @param \Robusta\Magento\Application\Config $config
     * @param \Symfony\Component\Console\Helper\HelperSet $helperSet
     * @param string $magentoRootDirectory
     * @return \Robusta\Magento\Application\DetectionResult
     */
    public function detect(
        InputInterface $input,
        OutputInterface $output,
        Config $config,
        HelperSet $helperSet,
        $magentoRootDirectory = null
    ) {
        $input = $input ?: new ArgvInput();
        $output = $output ?: new ConsoleOutput();

        $folder = OperatingSystem::getCwd();
        $subFolders = [];

        $directRootDirectory = $this->getDirectRootDirectory($input);

        if (is_string($directRootDirectory)) {
            $folder = $this->resolveRootDirOption($directRootDirectory);
        } elseif ($magentoRootDirectory !== null) {
            $subFolders = [$magentoRootDirectory];
        } else {
            $subFolders = $config->getDetectSubFolders();
        }

        $helperSet->set(new MagentoHelper($input, $output), 'magento');
        /* @var $magentoHelper MagentoHelper */
        $magentoHelper = $helperSet->get('magento');

        return new DetectionResult($magentoHelper, $folder, $subFolders); // @TODO must be refactored
    }

    /**
     * @param InputInterface $input
     * @return string
     */
    protected function getDirectRootDirectory(InputInterface $input)
    {
        return $input->getParameterOption('--root-dir');
    }

    /**
     * Set root dir (chdir()) of magento directory
     *
     * @param string $path to Magento directory
     * @return string
     */
    private function resolveRootDirOption($path)
    {
        $path = trim($path);

        if (strpos($path, '~') === 0) {
            $path = OperatingSystem::getHomeDir() . substr($path, 1);
        }

        $path = realpath($path);

        if (is_dir($path)) {
            chdir($path);
        }

        return $path;
    }
}
