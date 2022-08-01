<?php

namespace Robusta\Magento\Command\Cache;

use Robusta\Magento\Command\TestCase;

class ViewCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains(
            [
                'command' => 'cache:view',
                'id'      => 'NON_EXISTING_ID',
                '--fpc'   => true,
            ],
            "Cache id NON_EXISTING_ID does not exist (anymore)"
        );
    }
}
