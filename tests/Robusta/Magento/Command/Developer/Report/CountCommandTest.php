<?php

namespace Robusta\Magento\Command\Developer\Report;

use Robusta\Magento\Command\TestCase;

class CountCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayRegExp('dev:report:count', '~^\d+\s+$~');
    }
}
