<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

declare(strict_types=1);

namespace Robusta\Magento\Command\System\Check\Hyva;

trait HyvaTrait
{
    /**
     * Check if Hyva main package is installed
     *
     * @param array $projectComposerPackages
     * @param array $commandConfig
     * @return bool
     */
    public function isHyvaAvailable(array $projectComposerPackages, array $commandConfig): bool
    {
        $mainPackage = $commandConfig['hyva']['main-package'];
        return isset($projectComposerPackages[$mainPackage]);
    }
}
