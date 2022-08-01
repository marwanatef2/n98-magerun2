<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

declare(strict_types=1);

namespace Robusta\Magento\Command\System\Check\Hyva;

use Robusta\Magento\Command\CommandAware;
use Robusta\Magento\Command\CommandConfigAware;
use Robusta\Magento\Command\System\Check\ProjectComposerTrait;
use Robusta\Magento\Command\System\Check\Result;
use Robusta\Magento\Command\System\Check\ResultCollection;
use Robusta\Magento\Command\System\Check\SimpleCheck;
use Symfony\Component\Console\Command\Command;

class InstallationBasicComposerPackagesCheck implements SimpleCheck, CommandAware, CommandConfigAware
{
    use HyvaTrait;
    use ProjectComposerTrait;

    /**
     * @var array
     */
    protected $commandConfig;

    /**
     * @var \Robusta\Magento\Command\System\CheckCommand
     */
    protected $command;

    /**
     * @param \Robusta\Magento\Command\System\Check\ResultCollection $results
     * @return \Robusta\Magento\Command\System\Check\Result
     * @throws \JsonException
     */
    public function check(ResultCollection $results)
    {
        $result = $results->createResult();
        $magentoRootFolder = $this->command->getApplication()->getMagentoRootFolder();
        $projectComposerPackages = $this->getProjectComposerPackages($results, $magentoRootFolder);

        if (!$this->isHyvaAvailable($projectComposerPackages, $this->commandConfig)) {
            $result->setMessage('Hyvä Composer Packages');
            $result->setStatus(Result::STATUS_SKIPPED);

            return $result;
        }

        $requiredBasicPackages = $this->commandConfig['hyva']['installation-required-basic-packages'];

        $missingPackages = [];
        foreach ($requiredBasicPackages as $packageToCheck) {
            $isInstalled = isset($projectComposerPackages[$packageToCheck]);

            if (!$isInstalled) {
                $missingPackages[] = $packageToCheck;
            }
        }

        $result->setMessage('Hyvä Composer Packages');

        if (count($missingPackages) > 0) {
            $result->setStatus(Result::STATUS_ERROR);
            $result->setMessage(
                sprintf(
                    '<error>Hyvä Composer Packages are missing!</error> Packages: <comment>%s</comment>',
                    implode(',', $missingPackages)
                )
            );
        }

        return $result;
    }

    /**
     * @param array $commandConfig
     */
    public function setCommandConfig(array $commandConfig)
    {
        $this->commandConfig = $commandConfig;
    }

    /**
     * @param \Symfony\Component\Console\Command\Command $command
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;
    }
}
