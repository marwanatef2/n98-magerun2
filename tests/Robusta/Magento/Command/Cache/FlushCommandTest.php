<?php

namespace Robusta\Magento\Command\Cache;

use Robusta\Magento\Command\TestCase;

class FlushCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains('cache:flush', 'cache flushed');
    }
}
