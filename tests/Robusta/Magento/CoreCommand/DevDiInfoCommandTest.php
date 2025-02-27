<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

declare(strict_types=1);

namespace Robusta\Magento\CoreCommand;

class DevDiInfoCommandTest extends AbstractMagentoCoreCommandTestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains(
            [
                'command' => 'dev:di:info',
                'class' => 'Magento\\Catalog\\Api\\Data\\ProductInterface',
            ],
            'DI configuration for the class Magento\Catalog\Api\Data\ProductInterface in the GLOBAL area'
        );
    }
}
