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

class MissingGraphQLPackagesCheck implements SimpleCheck, CommandAware, CommandConfigAware
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
        $result->setMessage('Required GraphQL Packages');

        $magentoRootFolder = $this->command->getApplication()->getMagentoRootFolder();
        $projectComposerPackages = $this->getProjectComposerPackages($results, $magentoRootFolder);

        if (!$this->isHyvaAvailable($projectComposerPackages, $this->commandConfig)) {
            $result->setStatus(Result::STATUS_SKIPPED);

            return $result;
        }

        $requiredGraphQlPackages = $this->commandConfig['hyva']['installation-required-graphql-packages'];

        $missingPackages = [];
        foreach ($requiredGraphQlPackages as $packageToCheck) {
            $isInstalled = isset($projectComposerPackages[$packageToCheck]);

            if (!$isInstalled) {
                $missingPackages[] = $packageToCheck;
            }
        }

        if (count($missingPackages) > 0) {
            $result->setStatus(Result::STATUS_WARNING);
            $result->setMessage(
                sprintf(
                    '<warning>Required GraphQL Packages are missing!</warning> Packages: <comment>%s</comment>',
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
