<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

declare(strict_types=1);

namespace Robusta\Magento\Command\System\Check;

use Robusta\Util\ProjectComposer;

trait ProjectComposerTrait
{
    /**
     * @param \Robusta\Magento\Command\System\Check\ResultCollection $results
     * @param string $magentoRootFolder
     * @return array
     * @throws \JsonException
     */
    public function getProjectComposerPackages(ResultCollection $results, $magentoRootFolder)
    {
        if ($results->hasRegistryKey('project_composer_packages')) {
            $projectComposerPackages = $results->getRegistryValue('project_composer_packages');
        } else {
            $composerUtil = new ProjectComposer($magentoRootFolder);
            $projectComposerPackages = $composerUtil->getComposerLockPackages();
        }

        return $projectComposerPackages;
    }
}
