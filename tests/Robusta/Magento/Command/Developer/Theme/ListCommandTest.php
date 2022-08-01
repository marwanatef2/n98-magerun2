<?php

namespace Robusta\Magento\Command\Developer\Theme;

use Robusta\Magento\Command\TestCase;

class ListCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains('dev:theme:list', 'Magento/blank');
    }
}
